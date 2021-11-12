<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface NotificationInterface extends ExtensibleDataInterface
{
    const EVENT_TYPE_CODE = 'event_type_code';
    const STORE_ID = 'store_id';
    const STATUS = 'status';
    const CONTENT = 'content';
    const ENTITY_ID = 'entity_id';
    const SORT_ORDER = 'sort_order';
    const BANNER_ID = 'banner_id';
    const COUNT_ATTEMPTS = 'count_attempts';
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
     * Get content
     * @return string|null
     */
    public function getNotificationData(): ?string;

    /**
     * Set content
     * @param string $notificationData
     * @return NotificationInterface
     */
    public function setNotificationData(string $notificationData): NotificationInterface;

    /**
     * Get EventTypeCode
     * @return string|null
     */
    public function getEventTypeCode(): ?string;

    /**
     * Set link
     * @param string $eventTypeCode
     * @return NotificationInterface
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
     * @return NotificationInterface
     */
    public function setCustomerPhone(string $customerPhone): NotificationInterface;

    /**
     * Get is_active
     *
     * @return int|null
     */
    public function getCountAttempts(): ?int;

    /**
     * Set is_active
     * @param int $countAttempts
     * @return NotificationInterface
     */
    public function setCountAttempts(int $countAttempts): NotificationInterface;

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
     * @return NotificationInterface
     */
    public function setStatus(string $status): NotificationInterface;

    /**
     * @param int $storeId
     * @return NotificationInterface
     */
    public function setStoreId(int $storeId): NotificationInterface;

    /**
     * @return int
     */
    public function getStoreId(): int;
}

