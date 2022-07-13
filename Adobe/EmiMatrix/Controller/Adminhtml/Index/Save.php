<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Adobe\EmiMatrix\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Adobe\EmiMatrix\Api\EmiMatrixRepositoryInterface;
use Adobe\EmiMatrix\Model\EmiMatrix;
use Adobe\EmiMatrix\Model\EmiMatrixFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var EmiMatrixRepositoryInterface
     */
    private $emiMatrixRepository;

    /**
     * @var EmiMatrixFactory
     */
    private $emiMatrixFactory;

    /**
     * @param Context $context
     * @param EmiMatrixRepositoryInterface $emiMatrixRepository
     * @param EmiMatrixFactory $emiMatrixFactory
     */
    public function __construct(
        Context $context,
        EmiMatrixRepositoryInterface $emiMatrixRepository,
        EmiMatrixFactory $emiMatrixFactory
    ) {
        $this->emiMatrixRepository = $emiMatrixRepository;
        $this->emiMatrixFactory = $emiMatrixFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (empty($data['entity_id'])) {
                $data['entity_id'] = null;
            }
            /** @var EmiMatrix $model */
            $model = $this->emiMatrixFactory->create();
            $id = $this->getRequest()->getParam('entity_id');
            if ($id) {
                try {
                    $model = $this->emiMatrixRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This Entity no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            $model->setData($data);
            try {
                $this->emiMatrixRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the Data.'));
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?: $e);
            } catch (\Throwable $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the Emi Matrix Entity.'));
            }
            return $resultRedirect->setPath(
                '*/*/index',
                ['entity_id' => $this->getRequest()->getParam('entity_id')]
            );
        }
        return $resultRedirect->setPath('*/*/index');
    }
}
