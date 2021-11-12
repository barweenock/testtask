<?php
declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Api\Data;

interface SmsTemplatesInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const EVENT_TYPE_CODE = 'event_type_code';
    const SMSTEMPLATES_ID = 'smstemplates_id';
    const STORE_ID = 'store_id';
    const MESSAGE_TEMPLATE = 'message_template';

    /**
     * Get smstemplates_id
     * @return string|null
     */
    public function getSmstemplatesId();

    /**
     * Set smstemplates_id
     * @param string $smstemplatesId
     * @return \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface
     */
    public function setSmstemplatesId($smstemplatesId);

    /**
     * Get store_id
     * @return string|null
     */
    public function getStoreId();

    /**
     * Set store_id
     * @param string $storeId
     * @return \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface
     */
    public function setStoreId($storeId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesExtensionInterface $extensionAttributes
    );

    /**
     * Get event_type_code
     * @return string|null
     */
    public function getEventTypeCode();

    /**
     * Set event_type_code
     * @param string $eventTypeCode
     * @return \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface
     */
    public function setEventTypeCode($eventTypeCode);

    /**
     * Get message_template
     * @return string|null
     */
    public function getMessageTemplate();

    /**
     * Set message_template
     * @param string $messageTemplate
     * @return \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface
     */
    public function setMessageTemplate($messageTemplate);
}

