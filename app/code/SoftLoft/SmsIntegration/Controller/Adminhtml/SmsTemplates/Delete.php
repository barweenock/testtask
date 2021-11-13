<?php
declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Controller\Adminhtml\SmsTemplates;

use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use SoftLoft\SmsIntegration\Controller\Adminhtml\SmsTemplates;

class Delete extends SmsTemplates
{
    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('smstemplates_id');
        if ($id) {
            try {
                $model = $this->_objectManager->create(\SoftLoft\SmsIntegration\Model\SmsTemplates::class);
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('You deleted the Smstemplates.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', ['smstemplates_id' => $id]);
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a Smstemplates to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}

