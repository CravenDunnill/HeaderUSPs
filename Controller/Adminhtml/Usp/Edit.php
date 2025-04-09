<?php
namespace CravenDunnill\HeaderUSPs\Controller\Adminhtml\Usp;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use CravenDunnill\HeaderUSPs\Model\UspFactory;

class Edit extends Action
{
	/**
	 * @var PageFactory
	 */
	protected $resultPageFactory;

	/**
	 * @var UspFactory
	 */
	protected $uspFactory;

	/**
	 * @param Context $context
	 * @param PageFactory $resultPageFactory
	 * @param UspFactory $uspFactory
	 */
	public function __construct(
		Context $context,
		PageFactory $resultPageFactory,
		UspFactory $uspFactory
	) {
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
		$this->uspFactory = $uspFactory;
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
	 * Edit USP
	 *
	 * @return \Magento\Framework\Controller\ResultInterface
	 */
	public function execute()
	{
		$id = $this->getRequest()->getParam('usp_id');
		$model = $this->uspFactory->create();

		if ($id) {
			$model->load($id);
			if (!$model->getId()) {
				$this->messageManager->addErrorMessage(__('This Header USP no longer exists.'));
				$resultRedirect = $this->resultRedirectFactory->create();
				return $resultRedirect->setPath('*/*/');
			}
		}

		$resultPage = $this->resultPageFactory->create();
		$resultPage->setActiveMenu('CravenDunnill_HeaderUSPs::usps');
		$resultPage->addBreadcrumb(__('Header USP Ticker'), __('Header USP Ticker'));
		$resultPage->addBreadcrumb(__('Manage Header USPs'), __('Manage Header USPs'));

		$title = $model->getId() ? __('Edit Header USP') : __('New Header USP');
		$resultPage->addBreadcrumb($title, $title);
		$resultPage->getConfig()->getTitle()->prepend($title);

		return $resultPage;
	}
}