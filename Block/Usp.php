<?php
namespace CravenDunnill\HeaderUSPs\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use CravenDunnill\HeaderUSPs\Model\ResourceModel\Usp\CollectionFactory;

class Usp extends Template
{
	/**
	 * @var CollectionFactory
	 */
	protected $uspCollectionFactory;

	/**
	 * @param Context $context
	 * @param CollectionFactory $uspCollectionFactory
	 * @param array $data
	 */
	public function __construct(
		Context $context,
		CollectionFactory $uspCollectionFactory,
		array $data = []
	) {
		$this->uspCollectionFactory = $uspCollectionFactory;
		parent::__construct($context, $data);
	}

	/**
	 * Get active USP slides
	 *
	 * @return array
	 */
	public function getUsps()
	{
		try {
			$collection = $this->uspCollectionFactory->create();
			$collection->addFieldToFilter('is_active', 1)
				->addFieldToFilter('content', ['notnull' => true])
				->addFieldToFilter('content', ['neq' => ''])
				->setOrder('position', 'ASC');
				
			return $collection->getItems();
		} catch (\Exception $e) {
			return [];
		}
	}

	/**
	 * Get default background color
	 *
	 * @return string
	 */
	public function getDefaultBackgroundColor()
	{
		return '#122C58';
	}

	/**
	 * Get default hover background color
	 *
	 * @return string
	 */
	public function getDefaultHoverBackgroundColor()
	{
		return '#000000';
	}

	/**
	 * Get default text color
	 *
	 * @return string
	 */
	public function getDefaultTextColor()
	{
		return '#FFFFFF';
	}
}