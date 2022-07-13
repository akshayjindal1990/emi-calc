<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Adobe\EmiMatrix\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for emi matrix search results.
 * @api
 */
interface EmiMatrixSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get emi matrix list.
     *
     * @return \Adobe\EmiMatrix\Api\Data\EmiMatrixInterface[]
     */
    public function getItems();

    /**
     * Set emi matrix list.
     *
     * @param \Adobe\EmiMatrix\Api\Data\EmiMatrixInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
