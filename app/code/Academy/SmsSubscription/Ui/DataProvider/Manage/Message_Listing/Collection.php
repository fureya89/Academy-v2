<?php

namespace Academy\SmsSubscription\Ui\DataProvider\Manage\Message_Listing;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class Collection extends SearchResult
{

    protected function _initSelect()
    {
        $this->addFilterToMap('message_id', 'main_table.message_id');
        parent::_initSelect();
    }
}
