<?php

namespace Academy\SmsSubscription\Controller\Manage;

use Magento\Customer\Api\CustomerRepositoryInterface as CustomerRepository;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Newsletter\Model\Subscriber;
use Magento\Newsletter\Model\SubscriptionManagerInterface;

class Update extends \Magento\Framework\App\Action\Action implements ActionInterface
{
    protected $_auth;
    protected $_pageFactory;
    protected $_collection;
    protected $_smsSubscriptionFactory;
    protected $_smsSubscriptionResource;
    protected $_redirectFactory;


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
        $this->_smsSubscriptionCollectionFactory= $collectionFactory;
        $this->_smsSubscriptionFactory= $smsSubscriptionFactory;
        $this->_smsSubscriptionResource= $smsSubscriptionResource;
    }

    public function execute()
    {

        $customerId = 1; //(int)$this->_request->getParam('customer_id');  // TODO test dla pierwszego usera
        $allData = $this->_request->getParam('data');


        foreach ($allData as $data){

            $phone = $data[0];
            $subscriptionStatus = ($data[1] == 'true') ? 1 : 0;
            $updatedAt = date("Y-m-d H:i:s");
            $dataForChange = array('subscription_status'=>$subscriptionStatus, 'updated_at'=>$updatedAt);

            $updateSmsSubscryption= $this->_smsSubscriptionCollectionFactory->create();

            $updateSmsSubscryption->addFieldToFilter('customer_id', array('eq' => $customerId))
                ->addFieldToFilter('phone', array('eq' => $phone));

            //$this->_smsSubscriptionResource->load($updateSmsSubscryption, $phone, 'phone');

            $editedSubscription = $updateSmsSubscryption->getFirstItem();

            $editedSubscription -> setData($dataForChange);

            $this->_smsSubscriptionResource->save($editedSubscription);


/*  do poprawy
            try {
                $this->_smsSubscriptionResource->save($editedSubscription);
                $this->messageManager->addSuccessMessage("SMS Subscription updated successfully!");
            } catch (\Exception $exception) {
                $this->messageManager->addErrorMessage(__("Error updating SMS Subscription"));
            }
*/


        }


        $redirect = $this->_redirectFactory->create();
       // $redirect->setPath('subscription/manage/show');
        $redirect->setPath('customer/account');

        return $redirect;

    }
}
