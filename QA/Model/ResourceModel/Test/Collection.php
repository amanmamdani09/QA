<?php

namespace Brainvire\QA\Model\ResourceModel\Test;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Brainvire\QA\Model\Test as TestModel;
use Brainvire\QA\Model\ResourceModel\Test as TestResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(TestModel::class, TestResourceModel::class);
    }
}