<?php

namespace Adobe\EmiMatrix\Block\Adminhtml\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Adobe\EmiMatrix\Api\EmiMatrixRepositoryInterface;
use Psr\Log\LoggerInterface;

class GenericButton
{
    /**
     * @var Context
     */
    private $context;

    /**
     * @var EmiMatrixRepositoryInterface
     */
    private $emiMatrixRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param Context $context
     * @param EmiMatrixRepositoryInterface $emiMatrixRepository
     */
    public function __construct(
        Context $context,
        LoggerInterface $logger,
        EmiMatrixRepositoryInterface $emiMatrixRepository
    ) {
        $this->context = $context;
        $this->logger = $logger;
        $this->emiMatrixRepository = $emiMatrixRepository;
    }

    /**
     * Return the Id.
     *
     * @return int|null
     */
    public function getId()
    {
        $id = $this->context->getRequest()->getParam('entity_id');
        if (isset($id)) {
            try {
                return $this->emiMatrixRepository->getById(
                    $this->context->getRequest()->getParam('entity_id')
                )->getId();
            } catch (NoSuchEntityException $e) {
                $this->logger->debug($e->getMessage());
            }
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
