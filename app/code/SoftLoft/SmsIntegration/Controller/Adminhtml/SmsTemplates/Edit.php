<?php
declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Controller\Adminhtml\SmsTemplates;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use SoftLoft\SmsIntegration\Controller\Adminhtml\SmsTemplates;

class Edit extends SmsTemplates
{
    protected PageFactory $resultPageFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('smstemplates_id');
        $model = $this->_objectManager->create(\SoftLoft\SmsIntegration\Model\SmsTemplates::class);

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Smstemplates no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('softloft_smsintegration_smstemplates', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Smstemplates') : __('New Smstemplates'),
            $id ? __('Edit Smstemplates') : __('New Smstemplates')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Smstemplatess'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Smstemplates %1', $model->getId()) : __('New Smstemplates'));
        return $resultPage;
    }
}

