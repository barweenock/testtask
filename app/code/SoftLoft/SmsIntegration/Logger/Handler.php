<?php

namespace SoftLoft\SmsIntegration\Logger;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

class Handler extends Base
{
    public const PATH_TO_LOG_FILE = '/var/log/';
    public const FILE_NAME = 'sms-integration.log';

    /**
     * Logging level
     * @var int
     */
    protected $loggerType = Logger::INFO;

    /**
     * File name
     * @var string
     */
    protected $fileName = self::PATH_TO_LOG_FILE . self::FILE_NAME;
}
