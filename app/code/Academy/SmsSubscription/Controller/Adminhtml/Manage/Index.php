<?php

namespace Academy\SmsSubscription\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;

class Index extends Action implements HttpGetActionInterface
{
    const MENU_ID = 'Snowdog_Academy:greetings_manage';

    protected $pageFactory;

    public function __construct(
        Context $context,
        PageFactory $rawFactory
    ) {
        $this->pageFactory = $rawFactory;

        parent::__construct($context);
    }


    public function execute(): Page
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu(static::MENU_ID);
        $resultPage->getConfig()->getTitle()->prepend(__('Admin Grid SMS Subscription'));

        return $resultPage;
    }
}



/*
use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;


class Index implements ActionInterface
{
    const MENU_ID = 'Snowdog_Academy:greetings_manage';

    protected PageFactory $resultPageFactory;

    public function __construct(PageFactory $resultPageFactory) {
        $this->resultPageFactory = $resultPageFactory;
    }
    public function execute(): Page
    {
        $resultPage = $this->resultPageFactory->create();

        $resultPage->setActiveMenu(static::MENU_ID);
        $resultPage->getConfig()->getTitle()->prepend(__('Hello World!'));

        return $resultPage;
    }
}
*/
