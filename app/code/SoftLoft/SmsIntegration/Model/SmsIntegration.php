<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use SoftLoft\SmsIntegration\Api\Data\NotificationInterface;
use SoftLoft\SmsIntegration\Api\Data\NotificationInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use SoftLoft\SmsIntegration\Model\ResourceModel\SmsIntegration\Collection;

class SmsIntegration extends AbstractModel
{
    private NotificationInterfaceFactory $notificationDataFactory;

    /**
     * @var DataObjectHelper
     */
    private DataObjectHelper $dataObjectHelper;

    /**
     * @var string
     */
    protected $_eventPrefix = 'sms_messages';

    /**
     * @param Context $context
     * @param \Magento\Framework\Registry $registry
     * @param NotificationInterfaceFactory $notificationDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param ResourceModel\SmsIntegration $resource
     * @param Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry      $registry,
        NotificationInterfaceFactory     $notificationDataFactory,
        DataObjectHelper                 $dataObjectHelper,
        ResourceModel\SmsIntegration     $resource,
        Collection                       $resourceCollection,
        array                            $data = []
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

