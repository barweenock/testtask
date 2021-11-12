<?php

declare(strict_types=1);


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
use Magento\Framework\App\ResourceConnection;

class NotificationRepository implements NotificationRepositoryInterface
{
    /**
     * @var array
     */
    private array $notifications = [];

    /**
     * @var SearchResultsInterfaceFactory
     */
    private SearchResultsInterfaceFactory $searchResultsFactory;

    /**
     * @var NotificationInterfaceFactory
     */
    private NotificationInterfaceFactory $integrationFactory;

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
    private IntegrationCollectionFactory $integrationCollectionFactory;
    private ResourceConnection $resourceConnection;

    /**
     * @param ResourceIntegration $resource
     * @param NotificationInterfaceFactory $integrationFactory
     * @param IntegrationCollectionFactory $integrationCollectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        ResourceIntegration $resource,
        NotificationInterfaceFactory $integrationFactory,
        IntegrationCollectionFactory $integrationCollectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        ResourceConnection $resourceConnection
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
        $this->resourceConnection = $resourceConnection;
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
    public function getByEventCode($entTypeCode, $storeId): string
    {
        if (isset($this->notifications[$entTypeCode][$storeId])) {
            return $this->notifications[$entTypeCode][$storeId];
        }

        $connection = $this->resourceConnection->getConnection();
        $select = $connection->select()
            ->from(
                'sms_templates',
                      'message_template'
            )
            ->where('event_type_code = ?', $entTypeCode)
            ->where('store_id = ?', $storeId);
        $record = $connection->fetchOne($select);

        if (!$record) {
            throw new NoSuchEntityException(__('message_template for entity_type_code "%1" does not exist.', $entTypeCode));
        }

        $this->notifications[$entTypeCode][$storeId] = $record;
        return $record;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    ): SearchResultsInterface
    {
        /**
         * event_type_code=forgot_password store_id=1 message=You have been reseted your password on email: %customer_email%
         *
         *
         */

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

    public function get($notificationId): \SoftLoft\SmsIntegration\Api\Data\NotificationInterface
    {
        // TODO: Implement get() method.
        return \SoftLoft\SmsIntegration\Api\Data\NotificationInterface;
    }
}
