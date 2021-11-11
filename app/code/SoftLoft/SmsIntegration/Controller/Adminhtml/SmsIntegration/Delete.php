<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Controller\Adminhtml\SmsIntegration;

use SoftLoft\SmsIntegration\Controller\Adminhtml\SmsIntegration;
use SoftLoft\SmsIntegration\Model\IntegrationRepository as Repository;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;

class Delete extends Banner
{
    /**
     * @var Repository
     */
    private Repository $banner;

    /**
     * @param Context $context
     * @param Repository $banner
     */
    public function __construct(
        Context $context,
        Repository $banner
    ) {
        parent::__construct($context);

        $this->banner = $banner;
    }

    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('banner_id');

        if ($id) {
            try {
                $this->banner->deleteById($id);
                $this->messageManager->addSuccessMessage(__('You deleted the Entity.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a Entity to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}
