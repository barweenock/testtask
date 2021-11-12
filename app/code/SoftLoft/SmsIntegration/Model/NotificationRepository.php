<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Model;

use SoftLoft\SmsIntegration\Api\NotificationRepositoryInterface;
use SoftLoft\SmsIntegration\Api\Data\NotificationInterface;
use SoftLoft\SmsIntegration\Api\NotificationInterfaceFactory;
use SoftLoft\SmsIntegration\Model\ResourceModel\SmsIntegration as ResourceIntegration;
use SoftLoft\SmsIntegration\Model\ResourceModel\SmsIntegration\CollectionFactory as IntegrationCollectionFactory;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\App\ResourceConnection;
use SoftLoft\SmsIntegration\Model\ResourceModel\SmsTemplates;

class NotificationRepository implements NotificationRepositoryInterface
{
    /**
     * @var array
     */
    private array $notifications = [];
    private SearchResultsInterfaceFactory $searchResultsFactory;
    private SmsIntegrationFactory $integrationFactory;
    private JoinProcessorInterface $extensionAttributesJoinProcessor;
    private CollectionProcessorInterface $collectionProcessor;
    private ExtensibleDataObjectConverter $extensibleDataObjectConverter;
    private ResourceIntegration $resource;
    private IntegrationCollectionFactory $integrationCollectionFactory;
    private ResourceConnection $resourceConnection;
    private SmsTemplates $smsTemplates;

    /**
     * @param ResourceIntegration $resource
     * @param SmsIntegrationFactory $integrationFactory
     * @param IntegrationCollectionFactory $integrationCollectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param ResourceConnection $resourceConnection
     * @param SmsTemplates $smsTemplates
     */
    public function __construct(
        ResourceIntegration           $resource,
        SmsIntegrationFactory         $integrationFactory,
        IntegrationCollectionFactory  $integrationCollectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface  $collectionProcessor,
        JoinProcessorInterface        $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        ResourceConnection            $resourceConnection,
        SmsTemplates                  $smsTemplates
    ) {
        $this->resource = $resource;
        $this->integrationFactory = $integrationFactory;
        $this->integrationCollectionFactory = $integrationCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
        $this->resourceConnection = $resourceConnection;
        $this->smsTemplates = $smsTemplates;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        NotificationInterface $notification
    ): NotificationInterface {
        $integrationData = $this->extensibleDataObjectConverter->toNestedArray(
            $notification,
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
    public function getByEventCode($ventTypeCode, $storeId): string
    {
        if (isset($this->notifications[$ventTypeCode][$storeId])) {
            return $this->notifications[$ventTypeCode][$storeId];
        }

        $connection = $this->resourceConnection->getConnection();

        $record = $this->smsTemplates->getSmsTemplate($connection, $storeId, $ventTypeCode);
        if (!$record) {
            throw new NoSuchEntityException(__('message_template for entity_type_code "%1" does not exist.', $ventTypeCode));
        }

        $this->notifications[$ventTypeCode][$storeId] = $record;
        return $record;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        SearchCriteriaInterface $searchSearchSearchCriteria
    ): SearchResultsInterface
    {
        $collection = $this->integrationCollectionFactory->create();
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            NotificationInterface::class
        );
        $this->collectionProcessor->process($searchSearchSearchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchSearchSearchCriteria);
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
            $this->resource->load($integrationModel, $integration->getEntityId());
            $this->resource->delete($integrationModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Entity: %1',
                $exception->getMessage()
            ));
        }

        return true;
    }

    public function get($notificationId): NotificationInterface
    {
        $smsTemplates = $this->integrationFactory->create();
        $this->resource->load($smsTemplates, $notificationId);

        if (!$smsTemplates->getId()) {
            throw new NoSuchEntityException(__('SmsTemplates with id "%1" does not exist.', $notificationId));
        }

        return $smsTemplates->getDataModel();
    }
}
