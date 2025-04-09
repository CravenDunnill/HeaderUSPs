<?php
namespace CravenDunnill\HeaderUSPs\Controller\Adminhtml\Usp;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use CravenDunnill\HeaderUSPs\Model\UspFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends Action
{
	/**
	 * @var UspFactory
	 */
	protected $uspFactory;

	/**
	 * @var DataPersistorInterface
	 */
	protected $dataPersistor;

	/**
	 * @param Context $context
	 * @param UspFactory $uspFactory
	 * @param DataPersistorInterface $dataPersistor
	 */
	public function __construct(
		Context $context,
		UspFactory $uspFactory,
		DataPersistorInterface $dataPersistor
	) {
		parent::__construct($context);
		$this->uspFactory = $uspFactory;
		$this->dataPersistor = $dataPersistor;
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
	 * Save action
	 *
	 * @return \Magento\Framework\Controller\ResultInterface
	 */
	public function execute()
	{
		$resultRedirect = $this->resultRedirectFactory->create();
		$data = $this->getRequest()->getPostValue();
		
		if ($data) {
			if (empty($data['usp_id'])) {
				$data['usp_id'] = null;
			}

			$model = $this->uspFactory->create();

			$id = $this->getRequest()->getParam('usp_id');
			if ($id) {
				$model->load($id);
				if (!$model->getId()) {
					$this->messageManager->addErrorMessage(__('This Header USP no longer exists.'));
					return $resultRedirect->setPath('*/*/');
				}
			}

			$model->setData($data);

			try {
				$model->save();
				$this->messageManager->addSuccessMessage(__('You saved the Header USP.'));
				$this->dataPersistor->clear('cravendunnill_headerusp');

				if ($this->getRequest()->getParam('back')) {
					return $resultRedirect->setPath('*/*/edit', ['usp_id' => $model->getId()]);
				}
				return $resultRedirect->setPath('*/*/');
			} catch (LocalizedException $e) {
				$this->messageManager->addErrorMessage($e->getMessage());
			} catch (\Exception $e) {
				$this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Header USP.'));
			}

			$this->dataPersistor->set('cravendunnill_headerusp', $data);
			return $resultRedirect->setPath('*/*/edit', ['usp_id' => $this->getRequest()->getParam('usp_id')]);
		}
		return $resultRedirect->setPath('*/*/');
	}
}