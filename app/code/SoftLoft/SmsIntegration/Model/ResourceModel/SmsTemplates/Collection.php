<?php
declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Model\ResourceModel\SmsTemplates;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'smstemplates_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \SoftLoft\SmsIntegration\Model\SmsTemplates::class,
            \SoftLoft\SmsIntegration\Model\ResourceModel\SmsTemplates::class
        );
    }
}

