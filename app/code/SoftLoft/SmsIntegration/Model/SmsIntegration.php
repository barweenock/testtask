<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Model;

use SoftLoft\SmsIntegration\Api\Data\NotificationInterface;
use SoftLoft\SmsIntegration\Api\Data\NotificationInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

class SmsIntegration extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @var NotificationInterfaceFactory
     */
    private NotificationInterfaceFactory $notificationDataFactory;

    /**
     * @var DataObjectHelper
     */
    private DataObjectHelper $dataObjectHelper;

    /**
     * @var string
     */
    protected $_eventPrefix = 'softloft_smsintegration';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param NotificationInterfaceFactory $notificationDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \SoftLoft\SmsIntegration\Model\ResourceModel\SmsIntegration $resource
     * @param \SoftLoft\SmsIntegration\Model\ResourceModel\SmsIntegration\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        NotificationInterfaceFactory $notificationDataFactory,
        DataObjectHelper $dataObjectHelper,
        \SoftLoft\SmsIntegration\Model\ResourceModel\SmsIntegration $resource,
        \SoftLoft\SmsIntegration\Model\ResourceModel\SmsIntegration\Collection $resourceCollection,
        array $data = []
    ) {
        $this->notificationDataFactory = $notificationDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve entity model with entity data
     *
     * @return NotificationInterface
     */
    public function getDataModel(): NotificationInterface
    {
        $notificationData = $this->getData();
        $notificationDataObject = $this->notificationDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $notificationDataObject,
            $notificationData,
            NotificationInterface::class
        );

        return $notificationDataObject;
    }
}

