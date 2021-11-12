<?php
declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Cron;

use SoftLoft\SmsIntegration\Api\SmsMessageProcessorInterface;

class SmsIntegration
{
    private SmsMessageProcessorInterface $messageProcessor;

    /**
     * Constructor
     *
     * @param SmsMessageProcessorInterface $messageProcessor
     */
    public function __construct(
        SmsMessageProcessorInterface $messageProcessor
    ) {
        $this->messageProcessor = $messageProcessor;
    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {
        $this->messageProcessor->process();
    }
}