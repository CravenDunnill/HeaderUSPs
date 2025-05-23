<?php
namespace CravenDunnill\HeaderUSPs\Model;

use Magento\Framework\Model\AbstractModel;
use CravenDunnill\HeaderUSPs\Model\ResourceModel\Usp as UspResourceModel;

class Usp extends AbstractModel
{
	/**
	 * Initialize resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init(UspResourceModel::class);
	}
}