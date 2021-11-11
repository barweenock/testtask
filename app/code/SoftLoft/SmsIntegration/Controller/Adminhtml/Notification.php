<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Controller\Adminhtml;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;

abstract class Notification extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'SoftLoft_SmsIntegration::top_level';

    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param Page $resultPage
     * @return Page
     */
    public function initPage(Page $resultPage): Page
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('SoftLoft'), __('SoftLoft'))
            ->addBreadcrumb(__('SmsIntegration'), __('SmsIntegration'));
        return $resultPage;
    }
}

