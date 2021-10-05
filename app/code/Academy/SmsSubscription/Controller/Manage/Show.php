<?php

namespace Academy\SmsSubscription\Controller\Manage;



use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Academy\SmsSubscription\Model\ResourceModel\SmsSubscription\CollectionFactory;

class Show extends \Magento\Framework\App\Action\Action implements ActionInterface
{
    protected $_pageFactory;
    protected $_collection;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        CollectionFactory $collectionFactory)
    {
        $this->_pageFactory = $pageFactory;
        $this->_collection= $collectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        return $this->_pageFactory->create();
    }
}
