<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Model\MessageProcessor;

use Magento\Framework\App\ResourceConnection;
use SoftLoft\SmsIntegration\Api\SmsClientProviderInterface;
use SoftLoft\SmsIntegration\Model\NotificationRepository;
use Magento\Framework\App\Config\ScopeConfigInterface;

class SmsMessageProcessor
{
    const BATCH_SIZE = 1000;
    const IS_SENDING_ENABLE = 'SmsIntegration/configurable_cron/enabled_sms';
    const MAX_MESSAGE_LENGTH = 'SmsIntegration/configurable_cron/max_message_length';
    const MAX_COUNT_ATTEMPTS = 'SmsIntegration/configurable_cron/max_count_attempts';

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @var NotificationRepository
     */
    private $notificationRepository;

    /**
     * @var SmsClientProviderInterface
     */
    private $smsClientProvider;

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @param ResourceConnection $resourceConnection
     * @param NotificationRepository $notificationRepository
     * @param SmsClientProviderInterface $smsClientProvider
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ResourceConnection $resourceConnection,
                                NotificationRepository $notificationRepository,
                                SmsClientProviderInterface $smsClientProvider,
                                ScopeConfigInterface $scopeConfig
    )
    {
        $this->resourceConnection = $resourceConnection;
        $this->notificationRepository = $notificationRepository;
        $this->smsClientProvider = $smsClientProvider;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function process(): array
    {
        $isEnabled = $this->scopeConfig->getValue(
            self::IS_SENDING_ENABLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $maxMessageLength = $this->scopeConfig->getValue(
            self::MAX_MESSAGE_LENGTH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $maxCountAttempts = $this->scopeConfig->getValue(
            self::MAX_COUNT_ATTEMPTS,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

       if ($isEnabled) {
           $messages = [];
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

                   foreach (json_decode($row['data']) as $key => $value) {
                       $message = mb_substr(str_replace('%' . $key . '%', $value, $message), 0, $maxMessageLength ?? 0);
                   }

                   $messages[] = [
                       'message' => $message,
                       'phone_number' => $row['customer_phone']
                   ];
                   $this->smsClientProvider->send($row['phone_number'], $message);
                   $notification = $this->notificationRepository->get($row['entity_id']);
                   $countAttempts = (int)$notification->getCountAttempts();
                   $countAttempts = ++$countAttempts;
                   $notification->setStatus('complete');
                   $notification->setCountAttempts((string)$countAttempts);
                   $this->notificationRepository->save($notification);
               }

               $select->limitPage($page++, self::BATCH_SIZE);
           }

           return $messages;
       }
    }
}
