<?php

namespace Academy\SmsSubscription\Controller\Manage;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\View\Result\PageFactory;
use Academy\SmsSubscription\Model\ResourceModel\SmsSubscription\CollectionFactory;
use Academy\SmsSubscription\Model\SmsSubscriptionFactory;
use Academy\SmsSubscription\Model\ResourceModel\SmsSubscription;


class Update extends \Magento\Framework\App\Action\Action implements ActionInterface
{
    protected $_auth;
    protected $_pageFactory;
    protected $_collection;
    protected $_smsSubscriptionFactory;
    protected $_smsSubscriptionResource;
    private $_redirectFactory;


    public function __construct(
        Context $context,
        Session $auth,
        PageFactory $pageFactory,
        RedirectFactory $redirectFactory,
        CollectionFactory $collectionFactory,
        SmsSubscriptionFactory $smsSubscriptionFactory,
        SmsSubscription $smsSubscriptionResource)
    {
        parent::__construct($context);
        $this->_auth = $auth;
        $this->_pageFactory = $pageFactory;
        $this->_redirectFactory = $redirectFactory;
        $this->_smsSubscriptionCollectionFactory= $collectionFactory;
        $this->_smsSubscriptionFactory= $smsSubscriptionFactory;
        $this->_smsSubscriptionResource= $smsSubscriptionResource;
    }

    public function execute()
    {
        $countError = 0;
        $allData = $this->_request->getParam('data');

        foreach ($allData as $data){

            $subscriptionId = $data[2];
            $subscriptionStatus = ($data[1] == 'true') ? 1 : 0;
            $updatedAt = date("Y-m-d H:i:s");

            $updateSmsSubscryption= $this->_smsSubscriptionFactory->create();
;
            $this->_smsSubscriptionResource->load($updateSmsSubscryption, $subscriptionId);

            $updateSmsSubscryption->setSubscriptionStatus($subscriptionStatus);
            $updateSmsSubscryption->setUpdatedAt($updatedAt);

            try {
                $this->_smsSubscriptionResource->save($updateSmsSubscryption);
            } catch (\Exception $exception) {
                $countError += 1;
            }

        }

        if ($countError > 0){
            $this->messageManager->addErrorMessage(__('Something went wrong while updating your subscription.'));
        }else{
            $this->messageManager->addSuccessMessage("SMS Subscription updated successfully!");
        }

        return $this->_redirectFactory('subscription/manage/show');

    }
}
