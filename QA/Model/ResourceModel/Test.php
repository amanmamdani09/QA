<?php

namespace Brainvire\QA\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Test extends AbstractDb
{
    
    protected function _construct()
    {
        $this->_init('qa', 'id');
    }
}