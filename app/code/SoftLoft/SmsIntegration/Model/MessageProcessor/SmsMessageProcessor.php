<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Model\MessageProcessor;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\ScopeInterface;
use SoftLoft\SmsIntegration\Api\SmsClientProviderInterface;
use SoftLoft\SmsIntegration\Api\SmsMessageProcessorInterface;
use SoftLoft\SmsIntegration\Model\NotificationRepository;
use Magento\Framework\App\Config\ScopeConfigInterface;

class SmsMessageProcessor implements SmsMessageProcessorInterface
{
    private ResourceConnection $resourceConnection;
    private NotificationRepository $notificationRepository;
    private SmsClientProviderInterface $smsClientProvider;
    private ScopeConfigInterface $scopeConfig;
    private Json $json;

    /**
     * @param ResourceConnection $resourceConnection
     * @param NotificationRepository $notificationRepository
     * @param SmsClientProviderInterface $smsClientProvider
     * @param ScopeConfigInterface $scopeConfig
     * @param Json $json
     */
    public function __construct(
        ResourceConnection $resourceConnection,
        NotificationRepository $notificationRepository,
        SmsClientProviderInterface $smsClientProvider,
        ScopeConfigInterface $scopeConfig,
        Json $json
    ) {
        $this->resourceConnection = $resourceConnection;
        $this->notificationRepository = $notificationRepository;
        $this->smsClientProvider = $smsClientProvider;
        $this->scopeConfig = $scopeConfig;
        $this->json = $json;
    }

    /**
     * @return array
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function process(): array
    {
        $isEnabled = $this->scopeConfig->getValue(
            self::IS_SENDING_ENABLE,
            ScopeInterface::SCOPE_STORE
        );
        $maxMessageLength = $this->scopeConfig->getValue(
            self::MAX_MESSAGE_LENGTH,
            ScopeInterface::SCOPE_STORE
        );
        $maxCountAttempts = $this->scopeConfig->getValue(
            self::MAX_COUNT_ATTEMPTS,
            ScopeInterface::SCOPE_STORE
        );
        $messages = [];

        if ($isEnabled) {
            $connection = $this->resourceConnection->getConnection();
            $select = $connection->select()
                ->from('sms_messages')
                ->where('status IN(?)', ['pending', 'failed']);
            $page = 0;
            $select->limitPage($page++, self::BATCH_SIZE);

            while ($rows = $connection->fetchAll($select)) {
                foreach ($rows as $row) {
                    if ($row['count_attempts'] > $maxCountAttempts) {
                        continue;
                    }
                    $message = $this->notificationRepository->getByEventCode($row['event_type_code'], $row['store_id']);

                    foreach ($this->json->unserialize($row['notification_data']) as $key => $value) {
                        $message = mb_substr(str_replace('%' . $key . '%', $value, $message), 0, (int)$maxMessageLength ?? 0);
                    }

                    $messages[] = [
                        'message' => $message,
                        'phone_number' => $row['customer_phone']
                    ];
                    //$this->smsClientProvider->send($row['phone_number'], $message);
                    $notification = $this->notificationRepository->get($row['entity_id']);
                    $countAttempts = (int)$notification->getCountAttempts();
                    $countAttempts = ++$countAttempts;
                    $notification->setStatus('complete');
                    $notification->setCountAttempts((int)$countAttempts);
                    $this->notificationRepository->save(
                        $notification->setEntityId((int)$row['entity_id'])
                    );
                }

                $select->limitPage($page++, self::BATCH_SIZE);
            }
        }

        return $messages;
    }
}
