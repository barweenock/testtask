<?php
declare(strict_types=1);

namespace SoftLoft\SmsIntegration\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface SmsTemplatesRepositoryInterface
{

    /**
     * Save SmsTemplates
     * @param \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface $smsTemplates
     * @return \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface $smsTemplates
    );

    /**
     * Retrieve SmsTemplates
     * @param string $smstemplatesId
     * @return \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($smstemplatesId);

    /**
     * Retrieve SmsTemplates matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete SmsTemplates
     * @param \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface $smsTemplates
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \SoftLoft\SmsIntegration\Api\Data\SmsTemplatesInterface $smsTemplates
    );

    /**
     * Delete SmsTemplates by ID
     * @param string $smstemplatesId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($smstemplatesId);
}

