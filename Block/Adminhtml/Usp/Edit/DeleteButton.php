<?php
namespace CravenDunnill\HeaderUSPs\Block\Adminhtml\Usp\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Backend\Block\Widget\Context;

class DeleteButton implements ButtonProviderInterface
{
	/**
	 * @var Context
	 */
	protected $context;

	/**
	 * @param Context $context
	 */
	public function __construct(
		Context $context
	) {
		$this->context = $context;
	}

	/**
	 * Get button data
	 *
	 * @return array
	 */
	public function getButtonData()
	{
		$data = [];
		$uspId = $this->getUspId();
		if ($uspId) {
			$data = [
				'label' => __('Delete'),
				'class' => 'delete',
				'on_click' => 'deleteConfirm(\'' . __('Are you sure you want to delete this Header USP?') . '\', \'' . $this->getDeleteUrl() . '\')',
				'sort_order' => 20,
			];
		}
		return $data;
	}

	/**
	 * Get USP ID
	 *
	 * @return int|null
	 */
	public function getUspId()
	{
		return $this->context->getRequest()->getParam('usp_id');
	}

	/**
	 * Get delete URL
	 *
	 * @return string
	 */
	public function getDeleteUrl()
	{
		return $this->context->getUrlBuilder()->getUrl('*/*/delete', ['usp_id' => $this->getUspId()]);
	}
}