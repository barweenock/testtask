<?php
declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterfaceFactory;
use SoftLoft\SmsIntegration\Api\Data\SmsTemplatesSearchResultsInterfaceFactory;
use SoftLoft\SmsIntegration\Api\SmsTemplatesRepositoryInterface;
use SoftLoft\SmsIntegration\Model\ResourceModel\SmsTemplates as ResourceSmsTemplates;
use SoftLoft\SmsIntegration\Model\ResourceModel\SmsTemplates\CollectionFactory as SmsTemplatesCollectionFactory;

class SmsTemplatesRepository implements SmsTemplatesRepositoryInterface
{

    protected $dataObjectHelper;

    protected $extensionAttributesJoinProcessor;

    protected $dataSmsTemplatesFactory;

    protected $extensibleDataObjectConverter;
    protected $resource;

    protected $dataObjectProcessor;

    private $collectionProcessor;

    private $storeManager;

    protected $smsTemplatesCollectionFactory;

    protected $searchResultsFactory;

    protected $smsTemplatesFactory;


    /**
     * @param ResourceSmsTemplates $resource
     * @param SmsTemplatesFactory $smsTemplatesFactory
     * @param SmsTemplatesInterfaceFactory $dataSmsTemplatesFactory
     * @param SmsTemplatesCollectionFactory $smsTemplatesCollectionFactory
     * @param SmsTemplatesSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceSmsTemplates $resource,
        SmsTemplatesFactory $smsTemplatesFactory,
        SmsTemplatesInterfaceFactory $dataSmsTemplatesFactory,
        SmsTemplatesCollectionFactory $smsTemplatesCollectionFactory,
        SmsTemplatesSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->smsTemplatesFactory = $smsTemplatesFactory;
        $this->smsTemplatesCollectionFactory = $smsTemplatesCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataSmsTemplatesFactory = $dataSmsTemplatesFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface $smsTemplates
    ) {
        /* if (empty($smsTemplates->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $smsTemplates->setStoreId($storeId);
        } */
        
        $smsTemplatesData = $this->extensibleDataObjectConverter->toNestedArray(
            $smsTemplates,
            [],
            \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface::class
        );
        
        $smsTemplatesModel = $this->smsTemplatesFactory->create()->setData($smsTemplatesData);
        
        try {
            $this->resource->save($smsTemplatesModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the smsTemplates: %1',
                $exception->getMessage()
            ));
        }
        return $smsTemplatesModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($smsTemplatesId)
    {
        $smsTemplates = $this->smsTemplatesFactory->create();
        $this->resource->load($smsTemplates, $smsTemplatesId);
        if (!$smsTemplates->getId()) {
            throw new NoSuchEntityException(__('SmsTemplates with id "%1" does not exist.', $smsTemplatesId));
        }
        return $smsTemplates->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->smsTemplatesCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface::class
        );
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface $smsTemplates
    ) {
        try {
            $smsTemplatesModel = $this->smsTemplatesFactory->create();
            $this->resource->load($smsTemplatesModel, $smsTemplates->getSmstemplatesId());
            $this->resource->delete($smsTemplatesModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the SmsTemplates: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($smsTemplatesId)
    {
        return $this->delete($this->get($smsTemplatesId));
    }
}

