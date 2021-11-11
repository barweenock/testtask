<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Controller\Adminhtml\SmsIntegration;

use SoftLoft\SmsIntegration\Api\Data\IntegrationInterface;
use SoftLoft\SmsIntegration\Model\IntegrationRepository;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;

class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * @var JsonFactory
     */
    private JsonFactory $jsonFactory;
    /**
     * @var IntegrationRepository
     */
    private IntegrationRepository $integrationRepository;
    /**
     * @var DataObjectHelper
     */
    private DataObjectHelper $dataObjectHelper;

    /**
     * InlineEdit constructor.
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param IntegrationRepository $integrationRepository
     * @param DataObjectHelper $dataObjectHelper
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        IntegrationRepository $integrationRepository,
        DataObjectHelper $dataObjectHelper
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->integrationRepository = $integrationRepository;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * Inline edit action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $modelId) {

                    try {
                        $model = $this->integrationRepository->get($modelId);
                        $this->dataObjectHelper->populateWithArray(
                            $model,
                            $postItems[$modelId],
                            IntegrationInterface::class
                        );
                        $this->integrationRepository->save($model);
                    } catch (\Exception $e) {
                        $messages[] = "[Entity ID: {$modelId}]  {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
