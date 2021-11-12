<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $result = [];
        foreach ($this->getOptions() as $value => $label) {
            $result[] = [
                'value' => $value,
                'label' => $label,
            ];
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return [
            '1' => __('Active'),
            '0' => __('Inactive')
        ];
    }
}
