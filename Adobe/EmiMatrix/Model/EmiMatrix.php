<?php

namespace Adobe\EmiMatrix\Model;

use Adobe\EmiMatrix\Api\Data\EmiMatrixInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

class EmiMatrix extends AbstractModel implements IdentityInterface, EmiMatrixInterface
{
    const CACHE_TAG = 'emi_matrix';

    /**
     * @inerhitDoc
     */
    public function _construct()
    {
        $this->_init(\Adobe\EmiMatrix\Model\ResourceModel\EmiMatrix::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt($createdDate)
    {
        return $this->setData(self::CREATED_AT, $createdDate);
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdatedAt($updatedDate)
    {
        return $this->setData(self::UPDATED_AT, $updatedDate);
    }

    /**
     * {@inheritDoc}
     */
    public function setInterestRate($interestRate)
    {
        return $this->setData(self::INTEREST_RATE, $interestRate);
    }

    /**
     * {@inheritDoc}
     */
    public function getInterestRate()
    {
        return $this->getData(self::INTEREST_RATE);
    }

    /**
     * {@inheritDoc}
     */
    public function setTenure($tenure)
    {
        return $this->setData(self::TENURE, $tenure);
    }

    /**
     * {@inheritDoc}
     */
    public function getTenure()
    {
        return $this->getData(self::TENURE);
    }

    /**
     * {@inheritDoc}
     */
    public function getGender()
    {
        return $this->getData(self::GENDER);
    }

    /**
     * {@inheritDoc}
     */
    public function setGender($gender)
    {
        return $this->setData(self::GENDER, $gender);
    }

    /**
     * Get affected cache tags
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
