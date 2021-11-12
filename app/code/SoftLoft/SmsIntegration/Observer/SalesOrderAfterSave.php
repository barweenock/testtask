<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Api\Data\OrderInterface;
use SoftLoft\SmsIntegration\Api\EventLoggerInterface;
use Magento\Framework\Serialize\Serializer\Json;

class SalesOrderAfterSave implements ObserverInterface
{
    public const EVENT_TYPE_CODE = 'order_status';
    public const EVENT_STATUS_CODE = 'pending';

    private EventLoggerInterface $eventLogger;
    private Json $json;

    /**
     * @param EventLoggerInterface $eventLogger
     * @param Json $json
     */
    public function __construct(
        EventLoggerInterface $eventLogger,
        Json $json
    ) {
        $this->eventLogger = $eventLogger;
        $this->json = $json;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $this->eventLogger->saveNotificationData(
            self::EVENT_TYPE_CODE,
            $this->serializeData($order),
            $order->getShippingAddress()->getTelephone(),
            $order->getStoreId(),
            self::EVENT_STATUS_CODE
        );
    }

    /**
     * @param OrderInterface $order
     * @return string
     */
    private function serializeData(OrderInterface $order): string
    {
        return $this->json->serialize([
            'status:' => $order->getState(),
            'store_id' => $order->getStoreId()
        ]);
    }
}
