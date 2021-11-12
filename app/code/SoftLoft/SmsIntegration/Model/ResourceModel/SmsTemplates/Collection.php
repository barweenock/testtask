<?php
declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Model\ResourceModel\SmsTemplates;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use SoftLoft\SmsIntegration\Model\ResourceModel\SmsTemplates as ResourceModel;
use SoftLoft\SmsIntegration\Model\SmsTemplates;

class Collection extends AbstractCollection
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
            SmsTemplates::class,
            ResourceModel::class
        );
    }
}

