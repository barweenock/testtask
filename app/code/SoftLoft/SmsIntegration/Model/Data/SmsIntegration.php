<?php
declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use SoftLoft\SmsIntegration\Api\Data\NotificationInterface;

class SmsIntegration extends AbstractExtensibleObject implements NotificationInterface
{
    /**
     * @var int
     */
    private $entity_id;

    /**
     * @var string
     */
    private string $eventTypeCode;
    private string $customerPhone;
    private int $countAttempts;
    private string $status;
    private int $storeId;
    private string $notificationData;

    /**
     * @inheritdoc
     */
    public function getEntityId(): ?int
    {
        return $this->entity_id;
    }

    /**
     * @inheritdoc
     */
    public function setEntityId(int $entity_id): NotificationInterface
    {
        $this->entity_id = $entity_id;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getEventTypeCode(): ?string
    {
        return $this->eventTypeCode;
    }

    /**
     * @inheritdoc
     */
    public function setEventTypeCode(string $eventTypeCode): NotificationInterface
    {
        $this->eventTypeCode = $eventTypeCode;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getNotificationData(): ?string
    {
        return $this->notificationData;
    }

    /**
     * @inheritdoc
     */
    public function setNotificationData(string $notificationData): NotificationInterface
    {
        $this->notificationData = $notificationData;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCustomerPhone(): ?string
    {
        return $this->customerPhone;
    }

    /**
     * @inheritdoc
     */
    public function setCustomerPhone(string $customerPhone): NotificationInterface
    {
        $this->customerPhone = $customerPhone;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCountAttempts(): ?int
    {
        return $this->countAttempts;
    }

    /**
     * @inheritdoc
     */
    public function setStatus(string $status): NotificationInterface
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setCountAttempts(int $countAttempts): NotificationInterface
    {
        $this->countAttempts = $countAttempts;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @inheritdoc
     */
    public function setStoreId(int $storeId): NotificationInterface
    {
        $this->storeId = $storeId;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getStoreId(): int
    {
        return $this->storeId;
    }
}
