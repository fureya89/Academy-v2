<?php

namespace Academy\SmsSubscription\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class SmsSubscription extends AbstractDb
{

    protected function _construct()
    {
        $this->_init('sms_subscription', 'subscription_id');
    }
}
