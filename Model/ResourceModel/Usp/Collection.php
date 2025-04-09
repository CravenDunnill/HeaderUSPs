<?php
namespace CravenDunnill\HeaderUSPs\Model\ResourceModel\Usp;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use CravenDunnill\HeaderUSPs\Model\Usp;
use CravenDunnill\HeaderUSPs\Model\ResourceModel\Usp as UspResourceModel;

class Collection extends AbstractCollection
{
	/**
	 * @var string
	 */
	protected $_idFieldName = 'usp_id';
	
	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init(Usp::class, UspResourceModel::class);
	}
}