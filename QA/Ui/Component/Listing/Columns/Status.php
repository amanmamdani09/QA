<?php

namespace Brainvire\QA\Ui\Component\Listing\Columns;

class Status implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray(){
		return[
			['value' => 0, 'label' => __('Not Approved')],
			['value' => 1, 'label' => __('Approved')],
			['value' => 2, 'label' => __('Pending')]
		];
	}
}