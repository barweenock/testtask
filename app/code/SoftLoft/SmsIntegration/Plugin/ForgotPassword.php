<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Plugin;

use Magento\Customer\Model\AccountManagement;

class ForgotPassword
{
    public const EVENT_TYPE_CODE = 'forgot_password';
    public const EVENT_STATUS_CODE = 'pending';

    /**
     * @param AccountManagement $subject
     * @param $result
     * @return bool
     */
    public function afterResetPassword(AccountManagement $subject, $result): bool
    {
        // TODO Under construction

        return $result;
    }
}
