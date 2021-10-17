<?php

namespace Academy\SmsSubscription\Model;

use Magento\Framework\Model\AbstractModel;

class Message extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Academy\SmsSubscription\Model\ResourceModel\Message');
    }
}

