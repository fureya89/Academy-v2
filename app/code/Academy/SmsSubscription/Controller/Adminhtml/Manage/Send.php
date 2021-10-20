<?php

namespace Academy\SmsSubscription\Controller\Adminhtml\Manage;

use Academy\SmsSubscription\Logger\Logger;
use Academy\SmsSubscription\Model\MessageFactory;
use Academy\SmsSubscription\Model\ResourceModel\Message;
use Academy\SmsSubscription\Model\ResourceModel\SmsSubscription\CollectionFactory;
use Exception;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Message\Manager;

class Send implements ActionInterface
{
    const SUBSCRITPION_ACTIVE = 1;
    private $_request;
    private $_messageResource;
    private $_messageFactory;
    private $_redirectFactory;
    private $_messageManager;
    private $_smsSubscriptionCollectionFactory;
    private $_smsSendClient;
    private $_logger;


    public function __construct(
        Http              $request,
        Message           $messageResource,
        MessageFactory    $messageFactory,
        RedirectFactory   $redirectFactory,
        Manager           $messageManager,
        CollectionFactory $smsSubscriptionCollectionFactory,
        Logger            $logger,
        SmsSendClient     $smsSendClient
    )
    {
        $this->_request = $request;
        $this->_messageResource = $messageResource;
        $this->_messageFactory = $messageFactory;
        $this->_redirectFactory = $redirectFactory;
        $this->_messageManager = $messageManager;
        $this->_smsSubscriptionCollectionFactory = $smsSubscriptionCollectionFactory;
        $this->_smsSendClient = $smsSendClient;
        $this->_logger = $logger;
    }

    public function execute()
    {
        $this->_logger->info('START send SMS Subscription');

        $contents = (string)$this->_request->getParam('contents');
        $createdAt = date("Y-m-d H:i:s");

        $smsSubscriptionCollections = $this->getListOfActiveSubscribers();

        try {
            $response = $this->_smsSendClient->sendDataClient($smsSubscriptionCollections, $contents);
            if ($response) {
                $this->saveDataToSmsSubscriptionMessageTable($contents, $createdAt);
            } else {
                $this->_messageManager->addErrorMessage('The message was not sent. Try again!');
            }
        } catch (Exception $e) {
            $this->_logger->error($e->getMessage());
            $this->_messageManager->addErrorMessage('Exception when sending messages');
        }

        $this->_logger->info('END send SMS Subscription');
        return $this->_redirectFactory->create()->setPath('subscription/manage/message');
    }


    /**
     * @return array
     */
    private function getListOfActiveSubscribers(): array
    {
        $collection = $this->_smsSubscriptionCollectionFactory->create();
        $collection->addFieldToSelect('phone')
            ->addFieldToFilter('subscription_status', array('eq' => self::SUBSCRITPION_ACTIVE));

        return $collection->getData();
    }


    /**
     * @param $contents
     * @param $createdAt
     */
    private function saveDataToSmsSubscriptionMessageTable($contents, $createdAt)
    {
        $newSmsSubscription = $this->_messageFactory->create();
        $newSmsSubscription->setContents($contents);
        $newSmsSubscription->setCreatedAt($createdAt);

        try {
            $this->_messageResource->save($newSmsSubscription);
            $this->_messageManager->addSuccessMessage('SMS send!');
        } catch (Exception $e) {
            $this->_messageManager->addErrorMessage('Error while saving SMS Subscription contents!');
        }
    }

}
