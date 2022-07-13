<?php

namespace Adobe\EmiMatrix\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class EmiMatrix extends AbstractDb
{
    /**
     * Main table
     */
    const EMI_MATRIX_TABLE = 'emi_matrix';

    /**
     * unique field
     */
    protected $_uniqueFields = [
        ['field' => ['tenure', 'gender'], 'title' => 'provided tenure and gender entry already exists']
    ];

    /**
     * Define main table
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::EMI_MATRIX_TABLE, 'entity_id');
    }
}
