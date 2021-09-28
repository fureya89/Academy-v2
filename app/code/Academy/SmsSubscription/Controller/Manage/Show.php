<?php

namespace Academy\SmsSubscription\Controller\Manage;



use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ActionInterface;


class Show extends \Magento\Framework\App\Action\Action implements ActionInterface
{
    protected $_pageFactory;
    protected $_collection;

    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Academy\SmsSubscription\Model\ResourceModel\SmsSubscription\CollectionFactory $collectionFactory)
    {
        $this->_pageFactory = $pageFactory;
        $this->_collection= $collectionFactory;
        parent::__construct($context);
    }

    public function execute()//: \Magento\Framework\Controller\ResultInterface
    {
        return $this->_pageFactory->create();
    }
}
