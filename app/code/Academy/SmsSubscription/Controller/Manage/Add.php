<?php

namespace Academy\SmsSubscription\Controller\Manage;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\State\UserLockedException;
use Magento\Framework\Validator\Exception as ValidatorException;
use Academy\SmsSubscription\Model\ResourceModel\SmsSubscription\CollectionFactory;
use Academy\SmsSubscription\Model\SmsSubscriptionFactory;
use Academy\SmsSubscription\Model\ResourceModel\SmsSubscription;
use Exception;


class Add extends \Magento\Framework\App\Action\Action implements ActionInterface
{

    protected $_pageFactory;
    protected $_collection;
    protected $_smsSubscriptionFactory;
    protected $_smsSubscriptionResource;
    private $_redirectFactory;
    protected Session $customerSession;


    public function __construct(
        Session $customerSession,
        Context $context,
        PageFactory $pageFactory,
        RedirectFactory $redirectFactory,
        CollectionFactory $collectionFactory,
        SmsSubscriptionFactory $smsSubscriptionFactory,
        SmsSubscription $smsSubscriptionResource
        )
    {
        $this->_customerSession = $customerSession;
        parent::__construct($context);
        $this->_pageFactory = $pageFactory;
        $this->_redirectFactory = $redirectFactory;
        $this->_collection= $collectionFactory;
        $this->_smsSubscriptionFactory= $smsSubscriptionFactory;
        $this->_smsSubscriptionResource= $smsSubscriptionResource;
    }

    public function execute()
    {
        $customerId = (int)$this->_customerSession->getCustomer()->getId();


            try {
                if (!$customerId) {
                    throw new Exception('Invalid customer ID');
                }

                $phone = (string)$this->_request->getParam('phone');

                $collection = $this->_collection->create()->addFieldToFilter('phone', array('eq' => $phone))->getFirstItem();

                if($collection->getSubscriptionId()){
                    throw new Exception('The phone number exists in the database!');
                }

                    $subscriptionStatus = (int)1;
                    $createdAt = date("Y-m-d H:i:s");
                    $updatedAt = date("Y-m-d H:i:s");

                    $newSmsSubscryption = $this->_smsSubscriptionFactory->create();
                    $newSmsSubscryption->setCustomerId($customerId);
                    $newSmsSubscryption->setPhone($phone);
                    $newSmsSubscryption->setSubscriptionStatus($subscriptionStatus);
                    $newSmsSubscryption->setCreatedAt($createdAt);
                    $newSmsSubscryption->setUpdatedAt($updatedAt);

                    $this->_smsSubscriptionResource->save($newSmsSubscryption);

                    $this->messageManager->addSuccess(__('We have saved your subscription.'));


            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }

        $redirect = $this->_redirectFactory->create();
        $redirect->setPath('subscription/manage/show');
        return $redirect;
    }
}
