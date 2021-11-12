<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Model\Client;

use SoftLoft\SmsIntegration\Api\SmsClientProviderInterface;

class DefaultSmsClient implements SmsClientProviderInterface
{
    /**
     * @param string $phone
     * @param string $message
     */
    public function send(string $phone, string $message): void
    {
        //To be implemented
        //example:
        //$data = ['message' => $message, 'phone' => $phone];
        //$this->guzzleHttp->post($data);
    }
}
