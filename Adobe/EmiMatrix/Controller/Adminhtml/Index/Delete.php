<?php
namespace Adobe\EmiMatrix\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Adobe\EmiMatrix\Api\EmiMatrixRepositoryInterface;
use Magento\Framework\Controller\ResultFactory;

class Delete extends Action
{
    /**
     * @var EmiMatrixRepositoryInterface
     */
    private $emiMatrixRepository;

    /**
     * @param Context $context
     * @param EmiMatrixRepositoryInterface $emiMatrixRepository
     */
    public function __construct(
        Context $context,
        EmiMatrixRepositoryInterface $emiMatrixRepository
    ) {
        $this->emiMatrixRepository = $emiMatrixRepository;
        parent::__construct($context);
    }

    /**
     * Delete action
     *
     * @return Redirect
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $formKeyIsValid = $this->_formKeyValidator->validate($this->getRequest());
        $isPost = $this->getRequest()->isPost();
        if (!$formKeyIsValid || !$isPost) {
            $this->messageManager->addErrorMessage(__('Emi matrix entry could not be deleted.'));
            return $resultRedirect->setPath('emi_matrix/index');
        }
        $id = $this->getRequest()->getParam('entity_id');
        if (!empty($id)) {
            try {
                $this->emiMatrixRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('You deleted the Entry.'));
            } catch (\Exception $exception) {
                $this->messageManager->addErrorMessage($exception->getMessage());
            }
        }
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('emi_matrix/index');
    }
}
