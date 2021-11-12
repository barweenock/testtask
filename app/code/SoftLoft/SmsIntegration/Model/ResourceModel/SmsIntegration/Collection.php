<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Model\ResourceModel\SmsIntegration;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \SoftLoft\SmsIntegration\Model\SmsIntegration::class,
            \SoftLoft\SmsIntegration\Model\ResourceModel\SmsIntegration::class
        );
    }
}

