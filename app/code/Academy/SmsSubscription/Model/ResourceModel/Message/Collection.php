<?php

namespace Academy\SmsSubscription\Model\ResourceModel\Message;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected function _construct()
    {
        $this->_init(
            'Academy\SmsSubscription\Model\Message',
            'Academy\SmsSubscription\Model\ResourceModel\Message'
        );
    }
}
