<?php

namespace Brainvire\QA\Model;

use Magento\Framework\Model\AbstractModel;
use Brainvire\QA\Model\ResourceModel\Test as TestResourceModel;

class Test extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init(TestResourceModel::class);
    }
}