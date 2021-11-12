<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Api;

interface SmsMessageProcessorInterface
{
    const BATCH_SIZE = 1000;
    const IS_SENDING_ENABLE = 'SmsIntegration/configurable_cron/enabled_sms';
    const MAX_MESSAGE_LENGTH = 'SmsIntegration/configurable_cron/max_message_length';
    const MAX_COUNT_ATTEMPTS = 'SmsIntegration/configurable_cron/max_count_attempts';

    public function process(): array;
}