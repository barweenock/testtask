<?php
declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Block\Adminhtml\Form\Field;

class Cards extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
    /**
     * @inheritDoc
     */
    protected function _prepareToRender()
    {
        $this->addColumn(
            'message',
            ['label' => __('Message'), 'class' => 'required-entry' ]
        );

        $this->addColumn(
            'link_text',
            ['label' => __('Link text'), 'class' => 'required-entry']
        );
        $this->addColumn(
            'link_url',
            ['label' => __('Link url'), 'class' => 'required-entry']
        );

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Card');
    }
}
