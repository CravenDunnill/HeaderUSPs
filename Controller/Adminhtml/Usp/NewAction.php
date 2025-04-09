<?php
namespace CravenDunnill\HeaderUSPs\Controller\Adminhtml\Usp;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class NewAction extends Action
{
	/**
	 * @var PageFactory
	 */
	protected $resultPageFactory;

	/**
	 * @param Context $context
	 * @param PageFactory $resultPageFactory
	 */
	public function __construct(
		Context $context,
		PageFactory $resultPageFactory
	) {
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
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
	 * Create new USP
	 *
	 * @return \Magento\Framework\Controller\ResultInterface
	 */
	public function execute()
	{
		$resultPage = $this->resultPageFactory->create();
		$resultPage->setActiveMenu('CravenDunnill_HeaderUSPs::usps');
		$resultPage->addBreadcrumb(__('Header USP Ticker'), __('Header USP Ticker'));
		$resultPage->addBreadcrumb(__('Manage Header USPs'), __('Manage Header USPs'));
		$resultPage->addBreadcrumb(__('New Header USP'), __('New Header USP'));
		$resultPage->getConfig()->getTitle()->prepend(__('New Header USP'));

		return $resultPage;
	}
}