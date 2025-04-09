<?php
namespace CravenDunnill\HeaderUSPs\Model\Usp;

use CravenDunnill\HeaderUSPs\Model\ResourceModel\Usp\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
	/**
	 * @var \CravenDunnill\HeaderUSPs\Model\ResourceModel\Usp\Collection
	 */
	protected $collection;

	/**
	 * @var DataPersistorInterface
	 */
	protected $dataPersistor;

	/**
	 * @var array
	 */
	protected $loadedData;

	/**
	 * Constructor
	 *
	 * @param string $name
	 * @param string $primaryFieldName
	 * @param string $requestFieldName
	 * @param CollectionFactory $collectionFactory
	 * @param DataPersistorInterface $dataPersistor
	 * @param array $meta
	 * @param array $data
	 */
	public function __construct(
		$name,
		$primaryFieldName,
		$requestFieldName,
		CollectionFactory $collectionFactory,
		DataPersistorInterface $dataPersistor,
		array $meta = [],
		array $data = []
	) {
		$this->collection = $collectionFactory->create();
		$this->dataPersistor = $dataPersistor;
		parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
	}

	/**
	 * Get data
	 *
	 * @return array
	 */
	public function getData()
	{
		if (isset($this->loadedData)) {
			return $this->loadedData;
		}
		$items = $this->collection->getItems();
		
		foreach ($items as $item) {
			$this->loadedData[$item->getId()] = $item->getData();
		}

		$data = $this->dataPersistor->get('cravendunnill_headerusp');
		if (!empty($data)) {
			$item = $this->collection->getNewEmptyItem();
			$item->setData($data);
			$this->loadedData[$item->getId()] = $item->getData();
			$this->dataPersistor->clear('cravendunnill_headerusp');
		}

		return $this->loadedData;
	}
}