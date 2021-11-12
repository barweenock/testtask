<?php
declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Model;

use Magento\Framework\Api\DataObjectHelper;
use SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface;
use SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterfaceFactory;

class SmsTemplates extends \Magento\Framework\Model\AbstractModel
{

    protected $dataObjectHelper;

    protected $smstemplatesDataFactory;

    protected $_eventPrefix = 'softloft_smsintegration_smstemplates';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param SmsTemplatesInterfaceFactory $smstemplatesDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \SoftLoft\SmsIntegration\Model\ResourceModel\SmsTemplates $resource
     * @param \SoftLoft\SmsIntegration\Model\ResourceModel\SmsTemplates\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        SmsTemplatesInterfaceFactory $smstemplatesDataFactory,
        DataObjectHelper $dataObjectHelper,
        \SoftLoft\SmsIntegration\Model\ResourceModel\SmsTemplates $resource,
        \SoftLoft\SmsIntegration\Model\ResourceModel\SmsTemplates\Collection $resourceCollection,
        array $data = []
    ) {
        $this->smstemplatesDataFactory = $smstemplatesDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve smstemplates model with smstemplates data
     * @return SmsTemplatesInterface
     */
    public function getDataModel()
    {
        $smstemplatesData = $this->getData();
        
        $smstemplatesDataObject = $this->smstemplatesDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $smstemplatesDataObject,
            $smstemplatesData,
            SmsTemplatesInterface::class
        );
        
        return $smstemplatesDataObject;
    }
}

