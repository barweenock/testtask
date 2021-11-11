<?php
declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Model\Data;

use SoftLoft\SmsIntegration\Api\Data\NotificationInterface;

class SmsIntegration extends \Magento\Framework\Api\AbstractExtensibleObject implements NotificationInterface
{
    /**
     * @var int
     */
    private $entity_id;

    /**
     * @var string
     */
    private string $eventTypeCode;


    /**
     * @var string
     */
    private string $data;

    /**
     * @var string
     */
    private string $customerPhone;

    /**
     * @var string
     */
    private string $countAttempts;

    /**
     * @var string
     */
    private string $status;


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
    public function setEntityId(int $entityId): NotificationInterface
    {
        $this->entityId = $entityId;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @inheritdoc
     */
    public function setExtensionAttributes(
        \Magento\Framework\Api\ExtensibleDataInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
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
    public function getData(): ?string
    {
        return $this->data;
    }

    /**
     * @inheritdoc
     */
    public function setData(string $data): NotificationInterface
    {
        $this->data = $data;
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
    public function getCountAttempts(): ?string
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


    public function setCountAttempts(string $countAttempts): NotificationInterface
    {
        $this->countAttempts = $countAttempts;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }
}
