<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Model\SmsIntegration;

use SoftLoft\SmsIntegration\Api\IntegrationRepositoryInterface;
use SoftLoft\SmsIntegration\Api\Data\IntegrationInterface;
use SoftLoft\SmsIntegration\Model\ResourceModel\SmsIntegration\Collection;
use SoftLoft\SmsIntegration\Model\ResourceModel\SmsIntegration\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\Api\DataObjectHelper;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var array
     */
    private $loadedData;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var IntegrationRepositoryInterface
     */
    private IntegrationRepositoryInterface $integrationRepository;

    /**
     * @var DataObjectHelper
     */
    private DataObjectHelper $dataObjectHelper;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param RequestInterface $request
     * @param IntegrationRepositoryInterface $integrationRepository
     * @param DataObjectHelper $dataObjectHelper
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        RequestInterface $request,
        IntegrationRepositoryInterface $integrationRepository,
        DataObjectHelper $dataObjectHelper,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->request = $request;
        $this->integrationRepository = $integrationRepository;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * Get data
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getData(): ?array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getEntityId()] = $model->getData();
        }

        $entityId = $this->request->getParam('entity_id');

        if ($entityId) {
            $data = $this->integrationRepository->get($entityId);
        }

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $this->dataObjectHelper->populateWithArray(
                $model,
                $data->__toArray(),
                IntegrationInterface::class
            );
            $this->loadedData[$model->getEntityId()] = $model->getData();
        }

        return $this->loadedData;
    }
}
