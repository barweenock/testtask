<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Api\Data;

interface NotificationInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const LINK = 'link';
    const CONTENT = 'content';
    const ENTITY_ID = 'entity_id';
    const SORT_ORDER = 'sort_order';
    const BANNER_ID = 'banner_id';
    const ICON = 'icon';
    const ICON_POSITION = 'icon_position';
    const IS_ACTIVE = 'is_active';
    const HTML = 'html';
    const STATUS_ACTIVE = 1;

    /**
     * Get banner_id
     * @return int|null
     */
    public function getEntityId(): ?int;

    /**
     * Set entity_id
     * @param int $entityId
     * @return \Magento\Framework\Api\ExtensibleDataInterface
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Magento\Framework\Api\ExtensibleDataInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Magento\Framework\Api\ExtensibleDataInterface $extensionAttributes
    );

    /**
     * Get content
     * @return string|null
     */
    public function getData(): ?string;

    /**
     * Set content
     * @param string $content
     * @return \SoftLoft\SmsIntegration\Api\Data\NotificationInterface
     */
    public function setData(string $content): NotificationInterface;

    /**
     * Get EventTypeCode
     * @return string|null
     */
    public function getEventTypeCode(): ?string;

    /**
     * Set link
     * @param string $eventTypeCode
     * @return \SoftLoft\SmsIntegration\Api\Data\NotificationInterface
     */
    public function setEventTypeCode(string $eventTypeCode): NotificationInterface;

    /**
     * Get customerPhone
     * @return string|null
     */
    public function getCustomerPhone(): ?string;

    /**
     * Set customerPhone
     * @param string $customerPhone
     * @return \SoftLoft\SmsIntegration\Api\Data\NotificationInterface
     */
    public function setCustomerPhone(string $customerPhone): NotificationInterface;

    /**
     * Get is_active
     *
     * @return string|null
     */
    public function getCountAttempts(): ?string;

    /**
     * Set is_active
     * @param string $countAttempts
     * @return \SoftLoft\SmsIntegration\Api\Data\NotificationInterface
     */
    public function setCountAttempts(string $countAttempts): NotificationInterface;

    /**
     * Get status
     *
     * @return string|null
     */
    public function getStatus(): ?string;

    /**
     * Set status
     *
     * @param string $status
     * @return \SoftLoft\SmsIntegration\Api\Data\NotificationInterface
     */
    public function setStatus(string $status): NotificationInterface;
}

