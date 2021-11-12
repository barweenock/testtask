<?php
declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Controller\Adminhtml\SmsTemplates;

class Delete extends \SoftLoft\SmsIntegration\Controller\Adminhtml\SmsTemplates
{

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('smstemplates_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(\SoftLoft\SmsIntegration\Model\SmsTemplates::class);
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Smstemplates.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['smstemplates_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Smstemplates to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}

