<?php
namespace CravenDunnill\HeaderUSPs\Controller\Adminhtml\Usp;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use CravenDunnill\HeaderUSPs\Model\UspFactory;

class Delete extends Action
{
	/**
	 * @var UspFactory
	 */
	protected $uspFactory;

	/**
	 * @param Context $context
	 * @param UspFactory $uspFactory
	 */
	public function __construct(
		Context $context,
		UspFactory $uspFactory
	) {
		parent::__construct($context);
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
	 * Delete action
	 *
	 * @return \Magento\Framework\Controller\ResultInterface
	 */
	public function execute()
	{
		$resultRedirect = $this->resultRedirectFactory->create();
		$id = $this->getRequest()->getParam('usp_id');
		if ($id) {
			try {
				$model = $this->uspFactory->create();
				$model->load($id);
				$model->delete();
				$this->messageManager->addSuccessMessage(__('You deleted the Header USP.'));
				return $resultRedirect->setPath('*/*/');
			} catch (\Exception $e) {
				$this->messageManager->addErrorMessage($e->getMessage());
				return $resultRedirect->setPath('*/*/edit', ['usp_id' => $id]);
			}
		}
		$this->messageManager->addErrorMessage(__('We can\'t find a Header USP to delete.'));
		return $resultRedirect->setPath('*/*/');
	}
}