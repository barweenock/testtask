<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Controller\Adminhtml\SmsIntegration;

use SoftLoft\SmsIntegration\Api\Data\IntegrationInterface;
use SoftLoft\SmsIntegration\Api\Data\IntegrationInterfaceFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use SoftLoft\SmsIntegration\Api\IntegrationRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    private DataPersistorInterface $dataPersistor;

    /**
     * @var IntegrationRepositoryInterface
     */
    private IntegrationRepositoryInterface $integrationRepository;

    /**
     * @var IntegrationInterfaceFactory
     */
    private IntegrationInterfaceFactory $integrationInterfaceFactory;

    /**
     * @var DataObjectHelper
     */
    private DataObjectHelper $dataObjectHelper;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param IntegrationRepositoryInterface $integrationRepository
     * @param IntegrationInterfaceFactory $integrationInterfaceFactory
     * @param DataObjectHelper $dataObjectHelper
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        IntegrationRepositoryInterface $integrationRepository,
        IntegrationInterfaceFactory $integrationInterfaceFactory,
        DataObjectHelper $dataObjectHelper
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
        $this->integrationRepository = $integrationRepository;
        $this->integrationInterfaceFactory = $integrationInterfaceFactory;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * Save action
     *
     * @return ResultInterface
     * @throws LocalizedException
     */
    public function execute(): ResultInterface
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $id = $this->getRequest()->getParam('entity_id');

            if($id){
                $model = $this->integrationRepository->get($id);
                if (!$model->getEntityId()) {
                    $this->messageManager->addErrorMessage(__('This Entity no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }else {
                $model = $this->integrationInterfaceFactory->create();
            }

            $this->dataObjectHelper->populateWithArray(
                $model,
                $data,
                IntegrationInterface::class
            );

            try {
                $this->integrationRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the entity.'));

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['entity_id' => $model->getEntityId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the entity.'));
            }

            $this->dataPersistor->set('softloft_smsintegration', $data);

            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
