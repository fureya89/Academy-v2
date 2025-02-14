<?php

namespace Academy\SmsSubscription\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Message extends Action implements HttpGetActionInterface
{

    const MENU_ID = 'Snowdog_Academy:greetings_manage';

    protected $pageFactory;

    public function __construct(
        Context     $context,
        PageFactory $rawFactory
    )
    {
        $this->pageFactory = $rawFactory;
        parent::__construct($context);
    }


    public function execute(): Page
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu(static::MENU_ID);
        $resultPage->getConfig()->getTitle()->prepend(__('List of subscription'));

        return $resultPage;
    }
}

