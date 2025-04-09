<?php
namespace CravenDunnill\HeaderUSPs\Controller\Adminhtml\Usp;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use CravenDunnill\HeaderUSPs\Model\ResourceModel\Usp\CollectionFactory;

class MassDelete extends Action
{
	/**
	 * @var Filter
	 */
	protected $filter;

	/**
	 * @var CollectionFactory
	 */
	protected $collectionFactory;

	/**
	 * @param Context $context
	 * @param Filter $filter
	 * @param CollectionFactory $collectionFactory
	 */
	public function __construct(
		Context $context,
		Filter $filter,
		CollectionFactory $collectionFactory
	) {
		parent::__construct($context);
		$this->filter = $filter;
		$this->collectionFactory = $collectionFactory;
	}

	/**
	 * Check the permission to run it
	 *
	 * @return bool
	 */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('CravenDunnill_HeaderUSPs::usp_manage');
	}

	/**
	 * Execute action
	 *
	 * @return \Magento\Framework\Controller\ResultInterface
	 */
	public function execute()
	{
		$collection = $this->filter->getCollection($this->collectionFactory->create());
		$collectionSize = $collection->getSize();

		foreach ($collection as $item) {
			$item->delete();
		}

		$this->messageManager->addSuccessMessage(__('A total of %1 Header USP(s) have been deleted.', $collectionSize));

		/** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
		$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
		return $resultRedirect->setPath('*/*/');
	}
}