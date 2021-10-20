<?php

namespace Academy\SmsSubscription\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Message extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('sms_subscription_message', 'message_id');
    }
}

