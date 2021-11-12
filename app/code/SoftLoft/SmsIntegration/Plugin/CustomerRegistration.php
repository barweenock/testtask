<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Plugin;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\AccountManagement;

class CustomerRegistration
{
    public const EVENT_TYPE_CODE = 'customer_registration';
    public const EVENT_STATUS_CODE = 'pending';

    /**
     * @param AccountManagement $subject
     * @param CustomerInterface $customer
     * @return CustomerInterface
     */
    public function afterCreateAccount(AccountManagement $subject, CustomerInterface $customer): CustomerInterface
    {
        // TODO Under construction

        return $customer;
    }
}
