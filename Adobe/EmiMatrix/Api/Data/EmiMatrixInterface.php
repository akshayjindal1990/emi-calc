<?php

namespace Adobe\EmiMatrix\Api\Data;

interface EmiMatrixInterface
{
    /**
     * constant declaration:
     */
    const ENTITY_ID = 'entity_id';
    const INTEREST_RATE = 'interest_rate';
    const TENURE = 'tenure';
    const GENDER = 'gender';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Get Entity ID
     *
     * @return int
     */
    public function getEntityId();

    /**
     * Set Entity ID
     *
     * @param int $entityId
     * @return $this
     */
    public function setEntityId($entityId);

    /**
     * Retrieve created date
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * Set Created date
     *
     * @param string $createdDate
     * @return $this
     */
    public function setCreatedAt($createdDate);

    /**
     * Retrieve updated date
     *
     * @return string
     */
    public function getUpdatedAt();

    /**
     * Set Updated date
     *
     * @param string $updatedDate
     * @return $this
     */
    public function setUpdatedAt($updatedDate);

    /**
     * Set Interest rate
     *
     * @param int $interestRate
     * @return $this
     */
    public function setInterestRate($interestRate);

    /**
     * get Interest rate
     *
     * @return int
     */
    public function getInterestRate();

    /**
     * Set Interest rate
     *
     * @param int $tenure
     * @return $this
     */
    public function setTenure($tenure);

    /**
     * get Tenure
     *
     * @return int
     */
    public function getTenure();

    /**
     * Retrieve gender
     *
     * @return string
     */
    public function getGender();

    /**
     * Set gender
     *
     * @param string $gender
     * @return $this
     */
    public function setGender($gender);
}
