<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Controller\Adminhtml\SmsIntegration;

use SoftLoft\SmsIntegration\Model\IntegrationRepository;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\PageFactory;

class Edit extends \SoftLoft\SmsIntegration\Controller\Adminhtml\SmsIntegration
{
    /**
     * @var PageFactory
     */
    private PageFactory $resultPageFactory;

    /**
     * @var IntegrationRepository
     */
    private IntegrationRepository $integrationRepository;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param IntegrationRepository $integrationRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        IntegrationRepository $integrationRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
        $this->integrationRepository = $integrationRepository;

    }

    /**
     * Edit action
     *
     * @return ResultInterface
     * @throws LocalizedException
     */
    public function execute(): ResultInterface
    {
        $id = $this->getRequest()->getParam('entity_id');

        if ($id) {
            $model = $this->integrationRepository->get($id);
            if (!$model->getBannerId()) {
                $this->messageManager->addErrorMessage(__('This Entity no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/', ['entity_id', $id]);
            }
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Entity') : __('New Entity'),
            $id ? __('Edit Entity') : __('New Entity')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Entity'));
        $resultPage->getConfig()->getTitle()->prepend($id ?
            __('Edit Entity %1', $model->getEntityId()) :
            __('New Entity'));

        return $resultPage;
    }
}
