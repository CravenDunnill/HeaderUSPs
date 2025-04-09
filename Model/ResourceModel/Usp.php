<?php
namespace CravenDunnill\HeaderUSPs\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Usp extends AbstractDb
{
	/**
	 * Initialize resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('cravendunnill_headerusps', 'usp_id');
	}
}