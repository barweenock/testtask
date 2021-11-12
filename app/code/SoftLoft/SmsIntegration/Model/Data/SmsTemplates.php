<?php
declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Model\Data;

use SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface;

class SmsTemplates extends \Magento\Framework\Api\AbstractExtensibleObject implements SmsTemplatesInterface
{

    /**
     * Get smstemplates_id
     * @return string|null
     */
    public function getSmstemplatesId()
    {
        return $this->_get(self::SMSTEMPLATES_ID);
    }

    /**
     * Set smstemplates_id
     * @param string $smstemplatesId
     * @return \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface
     */
    public function setSmstemplatesId($smstemplatesId)
    {
        return $this->setData(self::SMSTEMPLATES_ID, $smstemplatesId);
    }

    /**
     * Get store_id
     * @return string|null
     */
    public function getStoreId()
    {
        return $this->_get(self::STORE_ID);
    }

    /**
     * Set store_id
     * @param string $storeId
     * @return \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface
     */
    public function setStoreId($storeId)
    {
        return $this->setData(self::STORE_ID, $storeId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get event_type_code
     * @return string|null
     */
    public function getEventTypeCode()
    {
        return $this->_get(self::EVENT_TYPE_CODE);
    }

    /**
     * Set event_type_code
     * @param string $eventTypeCode
     * @return \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface
     */
    public function setEventTypeCode($eventTypeCode)
    {
        return $this->setData(self::EVENT_TYPE_CODE, $eventTypeCode);
    }

    /**
     * Get message_template
     * @return string|null
     */
    public function getMessageTemplate()
    {
        return $this->_get(self::MESSAGE_TEMPLATE);
    }

    /**
     * Set message_template
     * @param string $messageTemplate
     * @return \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface
     */
    public function setMessageTemplate($messageTemplate)
    {
        return $this->setData(self::MESSAGE_TEMPLATE, $messageTemplate);
    }
}

