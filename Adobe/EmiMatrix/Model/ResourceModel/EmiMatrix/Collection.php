<?php

namespace Adobe\EmiMatrix\Model\ResourceModel\EmiMatrix;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Adobe\EmiMatrix\Model\EmiMatrix;
use Adobe\EmiMatrix\Model\ResourceModel\EmiMatrix as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(EmiMatrix::class, ResourceModel::class);
    }
}
