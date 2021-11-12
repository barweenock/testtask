<?php
declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Cron;

use Psr\Log\LoggerInterface;

class SmsIntegration
{

    protected LoggerInterface $logger;

    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {
        $this->logger->addInfo("Cronjob smsintegration is executed.");
    }
}