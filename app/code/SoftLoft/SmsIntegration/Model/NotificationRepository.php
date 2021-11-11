<?php

declare(strict_types=1);
/**
 * @category    DBI
 * @package     DBI_BannerGraphQl
 * @author      Anton Stukalo <anton.s@bilberrry.com>
 */

namespace SoftLoft\SmsIntegration\Model;

use SoftLoft\SmsIntegration\Api\NotificationRepositoryInterface;
use SoftLoft\SmsIntegration\Api\Data\NotificationInterface;
use SoftLoft\SmsIntegration\Api\Data\NotificationInterfaceFactory;
use SoftLoft\SmsIntegration\Model\ResourceModel\SmsIntegration as ResourceIntegration;
use SoftLoft\SmsIntegration\Model\ResourceModel\SmsIntegration\CollectionFactory as IntegrationCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class NotificationRepository implements NotificationRepositoryInterface
{
    /**
     * @var SearchResultsInterfaceFactory
     */
    private SearchResultsInterfaceFactory $searchResultsFactory;

    /**
     * @var IntegrationFactory
     */
    private IntegrationFactory $integrationFactory;

    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * @var DataObjectProcessor
     */
    private DataObjectProcessor $dataObjectProcessor;

    /**
     * @var JoinProcessorInterface
     */
    private JoinProcessorInterface $extensionAttributesJoinProcessor;

    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;

    /**
     * @var DataObjectHelper
     */
    private DataObjectHelper $dataObjectHelper;

    /**
     * @var ExtensibleDataObjectConverter
     */
    private ExtensibleDataObjectConverter $extensibleDataObjectConverter;

    /**
     * @var ResourceIntegration
     */
    private ResourceIntegration $resource;

    /**
     * @var IntegrationCollectionFactory
     */
    private IntegrationInterfaceFactory $dataIntegrationFactory;

    /**
     * @var IntegrationCollectionFactory
     */
    private IntegrationCollectionFactory $integrationCollectionFactory;

    /**
     * @param ResourceIntegration $resource
     * @param IntegrationFactory $integrationFactory
     * @param IntegrationInterfaceFactory $dataintegrationFactory
     * @param IntegrationCollectionFactory $integrationCollectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceIntegration $resource,
        IntegrationFactory $integrationFactory,
        IntegrationInterfaceFactory $dataIntegrationFactory,
        IntegrationCollectionFactory $integrationCollectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->integrationFactory = $integrationFactory;
        $this->integrationCollectionFactory = $integrationCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataIntegrationFactory = $integrationFactory;
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
        NotificationInterface $integration
    ) {
        $integrationData = $this->extensibleDataObjectConverter->toNestedArray(
            $integration,
            [],
            NotificationInterface::class
        );
        $integrationModel = $this->integrationFactory->create()->setData($integrationData);

        try {
            $this->resource->save($integrationModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the entity: %1',
                $exception->getMessage()
            ));
        }

        return $integrationModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($integrationId): NotificationInterface
    {
        $integration = $this->integrationFactory->create();
        $this->resource->load($integration, $integrationId);

        if (!$integration->getId()) {
            throw new NoSuchEntityException(__('integration with id "%1" does not exist.', $integrationId));
        }

        return $integration->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    ): SearchResultsInterface{
        $collection = $this->integrationCollectionFactory->create();
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            NotificationInterface::class
        );
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
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
        NotificationInterface $integration
    ): bool {
        try {
            $integrationModel = $this->integrationFactory->create();
            $this->resource->load($integrationModel, $integration->getBannerId());
            $this->resource->delete($integrationModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Banner: %1',
                $exception->getMessage()
            ));
        }

        return true;
    }

}
