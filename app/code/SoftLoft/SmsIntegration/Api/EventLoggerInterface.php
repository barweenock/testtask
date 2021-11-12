<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Api;

interface EventLoggerInterface
{
    public const ENABLE_LOGGER_PATH = 'SmsIntegration/configurable_cron/enabled_logger';

    /**
     * @param string $eventTypeCode
     * @param string $data
     * @param string $customerPhone
     * @param string $status
     */
    public function saveNotificationData(
        string $eventTypeCode,
        string $data,
        string $customerPhone,
        string $status
    ): void;

    /**
     * @param string $eventTypeCode
     * @param string $data
     * @param string $customerPhone
     * @param string $status
     */
    public function saveNotificationLog(
        string $eventTypeCode,
        string $data,
        string $customerPhone,
        string $status
    ): void;
}
