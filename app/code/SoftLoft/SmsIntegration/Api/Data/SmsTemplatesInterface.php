<?php
declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface SmsTemplatesInterface extends ExtensibleDataInterface
{

    const EVENT_TYPE_CODE = 'event_type_code';
    const SMSTEMPLATES_ID = 'smstemplates_id';
    const STORE_ID = 'store_id';
    const MESSAGE_TEMPLATE = 'message_template';

    /**
     * Get smstemplates_id
     * @return string|null
     */
    public function getSmstemplatesId(): ?string;

    /**
     * Set smstemplates_id
     * @param string $smstemplatesId
     * @return SmsTemplatesInterface
     */
    public function setSmstemplatesId(string $smstemplatesId): SmsTemplatesInterface;

    /**
     * Get store_id
     * @return int|null
     */
    public function getStoreId(): ?int;

    /**
     * Set store_id
     * @param int $storeId
     * @return SmsTemplatesInterface
     */
    public function setStoreId(int $storeId): SmsTemplatesInterface;

    /**
     * Get event_type_code
     * @return string|null
     */
    public function getEventTypeCode(): ?string;

    /**
     * Set event_type_code
     * @param string $eventTypeCode
     * @return SmsTemplatesInterface
     */
    public function setEventTypeCode(string $eventTypeCode): SmsTemplatesInterface;

    /**
     * Get message_template
     * @return string|null
     */
    public function getMessageTemplate(): ?string;

    /**
     * Set message_template
     * @param string $messageTemplate
     * @return SmsTemplatesInterface
     */
    public function setMessageTemplate(string $messageTemplate): SmsTemplatesInterface;
}

