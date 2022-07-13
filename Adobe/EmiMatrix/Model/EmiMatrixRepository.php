<?php

namespace Adobe\EmiMatrix\Model;

use Adobe\EmiMatrix\Api\Data\EmiMatrixInterface;
use Adobe\EmiMatrix\Api\EmiMatrixRepositoryInterface;
use Adobe\EmiMatrix\Api\Data\EmiMatrixInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Adobe\EmiMatrix\Model\ResourceModel\EmiMatrix as ResourceModel;
use Magento\Framework\Api\SearchCriteriaInterface;
use Adobe\EmiMatrix\Model\ResourceModel\EmiMatrix\CollectionFactory as EmiMatrixCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Adobe\EmiMatrix\Api\Data;

/**
 * Emi Collection Repository
 */
class EmiMatrixRepository implements EmiMatrixRepositoryInterface
{
    /**
     * @var ResourceModel
     */
    private $resourceModel;

    /**
     * @var EmiMatrixInterfaceFactory
     */
    private $emiMatrixInterfaceFactory;

    /**
     * @var EmiMatrixCollectionFactory
     */
    private $emiMatrixCollectionFactory;

    /**
     * @var CollectionProcessorInterface $collectionProcessor
     */
    private $collectionProcessor;

    /**
     * @var Data\EmiMatrixSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @param EmiMatrixInterfaceFactory $emiMatrixInterfaceFactory
     * @param ResourceModel $resourceModel
     * @param EmiMatrixCollectionFactory $emiMatrixCollectionFactory
     * @param Data\EmiMatrixSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        EmiMatrixInterfaceFactory $emiMatrixInterfaceFactory,
        ResourceModel $resourceModel,
        EmiMatrixCollectionFactory $emiMatrixCollectionFactory,
        Data\EmiMatrixSearchResultsInterfaceFactory $searchResultsFactory,  
        CollectionProcessorInterface $collectionProcessor = null              
    ) {
        $this->emiMatrixCollectionFactory = $emiMatrixCollectionFactory;
        $this->emiMatrixInterfaceFactory = $emiMatrixInterfaceFactory;
        $this->resourceModel = $resourceModel;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * Retrieve EMI data by ID
     *
     * @param int $id
     * @return EmiMatrixInterface
     * @throws NoSuchEntityException
     */

    public function getById(int $id)
    {
        $emiMatrix = $this->emiMatrixInterfaceFactory->create();
        $this->resourceModel->load($emiMatrix, $id);
        if (!$emiMatrix->getEntityId()) {
            throw new NoSuchEntityException(__('Emi Matrix requisite with id "%1" does not exist.', $id));
        }
        return $emiMatrix;
    }

    /**
     * Save Emi data
     *
     * @param EmiMatrixInterface $emiMatrix
     * @return EmiMatrixInterface
     * @throws CouldNotSaveException
     */

    public function save(EmiMatrixInterface $emiMatrix)
    {
        try {
            $this->resourceModel->save($emiMatrix);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $emiMatrix;
    }

    /**
     * Load emi matrix data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param SearchCriteriaInterface $criteria
     * @return EmiMatrixSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $collection = $this->emiMatrixCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }


    /**
     * Delete EMI
     *
     * @param EmiMatrixInterface $emiMatrix
     * @return bool
     * @throws CouldNotDeleteException
     */

    public function delete(EmiMatrixInterface $emiMatrix)
    {
        try {
            $this->resourceModel->delete($emiMatrix);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete by id
     *
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */

    public function deleteById(int $id)
    {
        return $this->delete($this->getById($id));
    }
}
