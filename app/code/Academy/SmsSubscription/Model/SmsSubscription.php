<?php

namespace Academy\SmsSubscription\Model;

use Magento\Framework\Model\AbstractModel;

class SmsSubscription extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Academy\SmsSubscription\Model\ResourceModel\SmsSubscription');
    }
}

