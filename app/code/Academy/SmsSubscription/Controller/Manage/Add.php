<?php

namespace Academy\SmsSubscription\Controller\Manage;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\State\UserLockedException;
use Magento\Framework\Validator\Exception as ValidatorException;



class Add extends \Magento\Framework\App\Action\Action implements ActionInterface
{
    protected $_auth;
    protected $_pageFactory;
    protected $_collection;
    protected $_smsSubscriptionFactory;
    protected $_smsSubscriptionResource;
    private $_redirectFactory;


    public function __construct(
        Context $context,
        \Magento\Backend\Model\Auth\Session $auth,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        RedirectFactory $redirectFactory,
        \Academy\SmsSubscription\Model\ResourceModel\SmsSubscription\CollectionFactory $collectionFactory,
        \Academy\SmsSubscription\Model\SmsSubscriptionFactory $smsSubscriptionFactory,
        \Academy\SmsSubscription\Model\ResourceModel\SmsSubscription $smsSubscriptionResource)
    {
        parent::__construct($context);
        $this->_auth = $auth;
        $this->_pageFactory = $pageFactory;
        $this->_redirectFactory = $redirectFactory;
        $this->_collection= $collectionFactory;
        $this->_smsSubscriptionFactory= $smsSubscriptionFactory;
        $this->_smsSubscriptionResource= $smsSubscriptionResource;
    }

    public function execute()
    {
        $customerId = (int)$this->_request->getParam('customer_id');
        $phone= (string)$this->_request->getParam('phone');
        $subscriptionStatus = (int)1;
        $createdAt = date("Y-m-d H:i:s");
        $updatedAt = date("Y-m-d H:i:s");

        $newSmsSubscryption= $this->_smsSubscriptionFactory->create();
        $newSmsSubscryption -> setCustomerId($customerId);
        $newSmsSubscryption -> setPhone($phone);
        $newSmsSubscryption -> setSubscriptionStatus($subscriptionStatus);
        $newSmsSubscryption -> setCreatedAt($createdAt);
        $newSmsSubscryption -> setUpdatedAt($updatedAt);

        $this->_smsSubscriptionResource->save($newSmsSubscryption);

        $redirect = $this->_redirectFactory->create();
        $redirect->setPath('subscription/manage/show');
        return $redirect;

    }
}
