<?php
declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class SmsTemplates extends AbstractDb
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

    /**
     * @param $connection
     * @param $storeId
     * @param $entTypeCode
     * @return mixed
     */
    public function getSmsTemplate($connection, $storeId, $entTypeCode)
    {
        $select = $connection->select()
            ->from(
                'softloft_smsintegration_smstemplates',
                'message_template'
            )
            ->where('event_type_code = ?', $entTypeCode)
            ->where('store_id = ?', $storeId);

        return $connection->fetchOne($select);
    }
}

