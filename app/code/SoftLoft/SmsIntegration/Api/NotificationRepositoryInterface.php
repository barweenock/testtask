<?php

declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\LocalizedException;
use SoftLoft\SmsIntegration\Api\Data\NotificationInterface;

interface NotificationRepositoryInterface
{

    /**
     * Save Entity
     * @param NotificationInterface $notification
     * @return NotificationInterface
     * @throws LocalizedException
     */
    public function save(
        NotificationInterface $notification
    ): NotificationInterface;

    /**
     * Retrieve Entity
     * @param string $notificationId
     * @return NotificationInterface
     * @throws LocalizedException
     */
    public function get($notificationId): NotificationInterface;

    /**
     * Retrieve Entity matching the specified criteria.
     * @param SearchCriteriaInterface $searchSearchSearchSearchCriteria
     * @return SearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchSearchSearchSearchCriteria
    ): SearchResultsInterface;

    /**
     * @param $ventTypeCode
     * @param $storeId
     * @return string
     */
    public function getByEventCode($ventTypeCode, $storeId): string;

    /**
     * Delete Entity
     * @param NotificationInterface $notification
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(
        NotificationInterface $notification
    ): bool;
}
