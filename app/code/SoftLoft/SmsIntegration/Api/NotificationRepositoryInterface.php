<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Api;

use Magento\Framework\Api\SearchResultsInterface;
use SoftLoft\SmsIntegration\Api\Data\NotificationInterface;

interface NotificationRepositoryInterface
{

    /**
     * Save Entity
     * @param \SoftLoft\SmsIntegration\Api\Data\NotificationInterface $notification
     * @return \SoftLoft\SmsIntegration\Api\Data\NotificationInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \SoftLoft\SmsIntegration\Api\Data\NotificationInterface $notification
    );

    /**
     * Retrieve Entity
     * @param string $notificationId
     * @return \SoftLoft\SmsIntegration\Api\Data\NotificationInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($notificationId): \SoftLoft\SmsIntegration\Api\Data\NotificationInterface;

    /**
     * Retrieve Entity matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchSearchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchSearchCriteria
    ): SearchResultsInterface;

    /**
     * @param $ventTypeCode
     * @param $storeId
     * @return string
     */
    public function getByEventCode($ventTypeCode, $storeId): string;

    /**
     * Delete Entity
     * @param \SoftLoft\SmsIntegration\Api\Data\NotificationInterface $notification
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \SoftLoft\SmsIntegration\Api\Data\NotificationInterface $notification
    );

}
