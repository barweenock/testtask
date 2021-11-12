<?php
declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Model\ResourceModel;

class SmsTemplates extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('softloft_smsintegration_smstemplates', 'smstemplates_id');
    }
}

