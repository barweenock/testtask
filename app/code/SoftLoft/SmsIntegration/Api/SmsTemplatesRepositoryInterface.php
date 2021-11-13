<?php
declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface;
use SoftLoft\SmsIntegration\Api\Data\SmsTemplatesSearchResultsInterface;

interface SmsTemplatesRepositoryInterface
{
    /**
     * Save SmsTemplates
     * @param SmsTemplatesInterface $smsTemplates
     * @return SmsTemplatesInterface
     * @throws LocalizedException
     */
    public function save(
        SmsTemplatesInterface $smsTemplates
    );

    /**
     * Retrieve SmsTemplates
     * @param string $smstemplatesId
     * @return SmsTemplatesInterface
     * @throws LocalizedException
     */
    public function get(string $smstemplatesId);

    /**
     * Retrieve SmsTemplates matching the specified criteria.
     * @param SearchCriteriaInterface $searchCriteria
     * @return SmsTemplatesSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete SmsTemplates
     * @param SmsTemplatesInterface $smsTemplates
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(
        SmsTemplatesInterface $smsTemplates
    ): bool;

    /**
     * Delete SmsTemplates by ID
     * @param string $smstemplatesId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(string $smstemplatesId): bool;
}

