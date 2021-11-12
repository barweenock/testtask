<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Api;

interface SmsClientProviderInterface
{
    /**
     * @param string $phone
     * @param string $message
     */
    public function send(string $phone, string $message): void;
}
