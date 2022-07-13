<?php
namespace Adobe\EmiMatrix\CustomerData;

use Adobe\EmiMatrix\Api\EmiMatrixRepositoryInterface;
use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Customer\Model\Session;
use Adobe\EmiMatrix\Model\EmiMatrix\Source\Gender;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;


class EmiMatrix implements SectionSourceInterface
{
    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var EmiMatrixRepositoryInterface
     */
    private $emiMatrixRenderList;

    /**
     * @param Session $customerSession
     * @param FilterBuilder $filterBuilder,
     * @param SearchCriteriaBuilder $searchCriteriaBuilder,
     * @param EmiMatrixRepositoryInterface $emiMatrixRenderList
     */
    public function __construct(
        Session $customerSession,
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        EmiMatrixRepositoryInterface $emiMatrixRenderList
    ) {
        $this->customerSession = $customerSession;
        $this->filterBuilder = $filterBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->emiMatrixRenderList = $emiMatrixRenderList;
    }

    /**
     * Get customer gender.
     * @return string
     */
    private function getCustomerGender()
    {
        return $this->customerSession->getCustomerData()->getGender();
    }

    /**
     * @return array
     */
    public function getSectionData()
    {
        $sectionData = [];
        $gender = ($this->getCustomerGender() == Gender::FEMALE) ? Gender::FEMALE : Gender::MALE;
        $filter = $this->filterBuilder
            ->setField('gender')
            ->setValue($gender)
            ->setConditionType('eq')
            ->create();
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilters([$filter])
            ->create();
        $renderSearchResults = $this->emiMatrixRenderList->getList($searchCriteria);

        /** @var ProductRenderInterface $item */
        foreach ($renderSearchResults->getItems() as $item) {
            $sectionData[] = [
                'interest_rate' => $item->getInterestRate(),
                'tenure' => $item->getTenure()
            ];
        }

        return [
            'items' => $sectionData
        ];
        // return [
        //     'items' => [
        //         ['interest_rate' => '8', 'tenure' => '5'],
        //         ['interest_rate' => '10', 'tenure' => '10'],
        //         ['interest_rate' => '11', 'tenure' => '15']            
        //     ]
        // ];
    }
}
