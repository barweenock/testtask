<?php
declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Api\Data;

interface SmsTemplatesSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get SmsTemplates list.
     * @return \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface[]
     */
    public function getItems();

    /**
     * Set store_id list.
     * @param \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

