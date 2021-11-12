<?php
declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use SoftLoft\SmsIntegration\Api\Data\SmsTemplatesExtensionInterface;
use SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface;

class SmsTemplates extends AbstractExtensibleObject implements SmsTemplatesInterface
{
    /**
     * Get smstemplates_id
     * @return string|null
     */
    public function getSmstemplatesId(): ?string
    {
        return $this->_get(self::SMSTEMPLATES_ID);
    }

    /**
     * Set smstemplates_id
     * @param string $smstemplatesId
     * @return SmsTemplatesInterface
     */
    public function setSmstemplatesId(string $smstemplatesId): SmsTemplatesInterface
    {
        return $this->setData(self::SMSTEMPLATES_ID, $smstemplatesId);
    }

    /**
     * @return mixed|string|null
     */
    public function getStoreId(): ?int
    {
        return $this->_get(self::STORE_ID);
    }

    /**
     * Set store_id
     * @param int $storeId
     * @return SmsTemplatesInterface
     */
    public function setStoreId(int $storeId): SmsTemplatesInterface
    {
        return $this->setData(self::STORE_ID, $storeId);
    }

    /**
     * Get event_type_code
     * @return string|null
     */
    public function getEventTypeCode(): ?string
    {
        return $this->_get(self::EVENT_TYPE_CODE);
    }

    /**
     * Set event_type_code
     * @param string $eventTypeCode
     * @return SmsTemplatesInterface
     */
    public function setEventTypeCode(string $eventTypeCode): SmsTemplatesInterface
    {
        return $this->setData(self::EVENT_TYPE_CODE, $eventTypeCode);
    }

    /**
     * Get message_template
     * @return string|null
     */
    public function getMessageTemplate(): ?string
    {
        return $this->_get(self::MESSAGE_TEMPLATE);
    }

    /**
     * Set message_template
     * @param string $messageTemplate
     * @return SmsTemplatesInterface
     */
    public function setMessageTemplate(string $messageTemplate): SmsTemplatesInterface
    {
        return $this->setData(self::MESSAGE_TEMPLATE, $messageTemplate);
    }
}

