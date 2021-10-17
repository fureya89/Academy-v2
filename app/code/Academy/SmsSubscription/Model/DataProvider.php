<?php

namespace Academy\SmsSubscription\Model;

use Magento\Ui\DataProvider\AbstractDataProvider;

use Academy\SmsSubscription\Model\ResourceModel\SmsSubscription\CollectionFactory;


 class DataProvider extends AbstractDataProvider
 {

     public function __construct($name,
                                 $primaryFieldName,
                                 $requestFieldName,
                                 CollectionFactory $collectionFactory,
                                 array $meta = [],
                                 array $data = [])
     {
         $this->collection = $collectionFactory->create();
         parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
     }

     public function getData()
     {
        return [];
     }
}

