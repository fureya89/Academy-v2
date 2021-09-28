<?php

namespace Academy\SmsSubscription\Model\ResourceModel\SmsSubscription;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected function _construct()
    {
        $this->_init(
            'Academy\SmsSubscription\Model\SmsSubscription',
            'Academy\SmsSubscription\Model\ResourceModel\SmsSubscription'
        );
    }
}
