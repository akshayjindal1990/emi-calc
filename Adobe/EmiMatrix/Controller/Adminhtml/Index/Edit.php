<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Adobe\EmiMatrix\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;
use Adobe\EmiMatrix\Api\EmiMatrixRepositoryInterface;

class Edit extends Action
{
    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @var EmiMatrixRepositoryInterface
     */
    private $emiMatrixRepository;

    /**
     * @param Context $context
     * @param EmiMatrixRepositoryInterface $emiMatrixRepository
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        EmiMatrixRepositoryInterface $emiMatrixRepository,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->emiMatrixRepository = $emiMatrixRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        if (!empty($id)) {
            try {
                $emiMatrix = $this->emiMatrixRepository->getById($id);
                if (!$emiMatrix->getId()) {
                    $this->messageManager->addErrorMessage(__('This entity no longer exists.'));
                    /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('emi_matrix/index');
                }
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addException($e, __('Something went wrong while editing the emi matrix.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setPath('emi_matrix/index');
                return $resultRedirect;
            }
        }
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Adobe_EmiMatrix::emi_matrix');
        $resultPage->addBreadcrumb(
            $id ? __('Edit EMI Option') : __('New EMI Option'),
            $id ? __('Edit EMI Option') : __('New EMI Option')
        );
        if (isset($emiMatrix) && ($emiMatrix->getId())) {
            $resultPage->getConfig()->getTitle()->prepend(__('Emi Matrix Page'));
        } else {
            $resultPage->getConfig()->getTitle()->prepend(__('New Emi Matrix'));
        }

        return $resultPage;
    }
}
