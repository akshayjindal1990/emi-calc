<?php

namespace Adobe\EmiMatrix\Api;

use Adobe\EmiMatrix\Api\Data\EmiMatrixInterface;

interface EmiMatrixRepositoryInterface
{
    /**
     * Get emi data by id
     *
     * @param int $id
     * @return EmiMatrixInterface
     */
    public function getById(int $id);

    /**
     * Save emi data
     *
     * @param EmiMatrixInterface $emiMatrix
     * @return EmiMatrixInterface
     */
    public function save(EmiMatrixInterface $emiMatrix);

    /**
     * Retrieve emi matrix matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Adobe\EmiMatrix\Api\Data\EmiMatrixResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete EMI
     *
     * @param EmiMatrixInterface $emiMatrix
     * @return bool
     */
    public function delete(EmiMatrixInterface $emiMatrix);

    /**
     * Delete EMI by id
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id);
}
