<?php
declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Registry;

abstract class SmsTemplates extends Action
{

    protected $_coreRegistry;
    const ADMIN_RESOURCE = 'SoftLoft_SmsIntegration::top_level';

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry
    ) {
        $this->_coreRegistry = $coreRegistry;
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
            ->addBreadcrumb(__('Smstemplates'), __('Smstemplates'));
        return $resultPage;
    }
}

