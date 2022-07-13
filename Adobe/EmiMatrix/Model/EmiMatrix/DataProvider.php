<?php

namespace Adobe\EmiMatrix\Model\EmiMatrix;

use Magento\Framework\Exception\LocalizedException;
use Adobe\EmiMatrix\Api\EmiMatrixRepositoryInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Magento\Framework\App\RequestInterface;
use Adobe\EmiMatrix\Model\ResourceModel\EmiMatrix\CollectionFactory;
use Psr\Log\LoggerInterface;

class DataProvider extends ModifierPoolDataProvider
{
    /**
     * @var EmiMatrixRepositoryInterface
     */
    private $emiMatrixRepository;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var array
     */
    private $loadedData;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param string $name
     * @param EmiMatrixRepositoryInterface $emiMatrixRepository
     * @param CollectionFactory $emiMatrixCollectionFactory
     * @param LoggerInterface $logger
     * @param RequestInterface $request
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        EmiMatrixRepositoryInterface $emiMatrixRepository,
        CollectionFactory $emiMatrixCollectionFactory,
        LoggerInterface $logger,
        RequestInterface $request,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $emiMatrixCollectionFactory->create();
        $this->logger = $logger;
        $this->emiMatrixRepository = $emiMatrixRepository;
        $this->request = $request;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        $id = (int) $this->request->getParam($this->getRequestFieldName());
        if ($id) {
            try {
                $emiMatrix = $this->emiMatrixRepository->getById($id);
            } catch (LocalizedException $exception) {
                $this->logger->critical($exception->getMessage());
            }
            $this->loadedData[$emiMatrix->getId()] = $emiMatrix->getData();
        }
        return $this->loadedData;
    }
}
