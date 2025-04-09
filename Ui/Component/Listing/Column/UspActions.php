<?php
namespace CravenDunnill\HeaderUSPs\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class UspActions extends Column
{
	/**
	 * @var UrlInterface
	 */
	protected $urlBuilder;

	/**
	 * @param ContextInterface $context
	 * @param UiComponentFactory $uiComponentFactory
	 * @param UrlInterface $urlBuilder
	 * @param array $components
	 * @param array $data
	 */
	public function __construct(
		ContextInterface $context,
		UiComponentFactory $uiComponentFactory,
		UrlInterface $urlBuilder,
		array $components = [],
		array $data = []
	) {
		$this->urlBuilder = $urlBuilder;
		parent::__construct($context, $uiComponentFactory, $components, $data);
	}

	/**
	 * Prepare Data Source
	 *
	 * @param array $dataSource
	 * @return array
	 */
	public function prepareDataSource(array $dataSource)
	{
		if (isset($dataSource['data']['items'])) {
			foreach ($dataSource['data']['items'] as & $item) {
				if (isset($item['usp_id'])) {
					$item[$this->getData('name')] = [
						'edit' => [
							'href' => $this->urlBuilder->getUrl(
								'cravendunnill_headerusps/usp/edit',
								['usp_id' => $item['usp_id']]
							),
							'label' => __('Edit')
						],
						'delete' => [
							'href' => $this->urlBuilder->getUrl(
								'cravendunnill_headerusps/usp/delete',
								['usp_id' => $item['usp_id']]
							),
							'label' => __('Delete'),
							'confirm' => [
								'title' => __('Delete Header USP'),
								'message' => __('Are you sure you want to delete this Header USP?')
							]
						]
					];
				}
			}
		}
		
		return $dataSource;
	}
}