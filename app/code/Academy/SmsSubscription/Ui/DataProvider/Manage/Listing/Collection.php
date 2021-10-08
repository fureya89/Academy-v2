<?php

namespace Academy\SmsSubscription\Ui\DataProvider\Manage\Listing;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class Collection extends SearchResult
{

    protected function _initSelect()
    {
        $this->addFilterToMap('subscription_id', 'main_table.subscription_id');
        $this->addFilterToMap('firstname', 'devgridname.firstname');
        $this->addFilterToMap('lastname', 'devgridname.lastname');
        parent::_initSelect();
    }
}

