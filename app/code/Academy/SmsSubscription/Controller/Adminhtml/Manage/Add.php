<?php

namespace Academy\SmsSubscription\Controller\Adminhtml\Manage;

use Magento\Framework\App\ActionInterface;

use Magento\Framework\View\Result\PageFactory;


class Add implements ActionInterface
{
     private $_pageFactory;

     public function __construct(PageFactory $pageFactory)
     {
        $this->_pageFactory = $pageFactory;
     }

     public function execute()
     {
        return $this->_pageFactory->create();
     }
}
