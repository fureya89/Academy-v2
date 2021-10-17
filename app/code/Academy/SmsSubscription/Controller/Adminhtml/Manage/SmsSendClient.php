<?php

namespace Academy\SmsSubscription\Controller\Adminhtml\Manage;

use Magento\Framework\HTTP\ZendClientFactory;
use Academy\SmsSubscription\Logger\Logger;
use Zend_Http_Client;
use Zend_Http_Client_Exception;

class SmsSendClient
{

    private $_httpClientFactory;
    private $_logger;

    public function __construct(
        ZendClientFactory $httpClientFactory,
        Logger            $logger
    )
    {
        $this->_httpClientFactory = $httpClientFactory;
        $this->_logger = $logger;
    }

    /**
     * @param $smsSubscriptionCollections
     * @param $contents
     * @return bool
     * @throws Zend_Http_Client_Exception
     */
    public function sendDataClient($smsSubscriptionCollections, $contents): bool
    {

        $client = $this->_httpClientFactory->create();
        $client->setUri('https://kbbswfakqv.cfolks.pl/api/sms/send');
        $client->setMethod(Zend_Http_Client::POST);
        $client->setHeaders("X-API-Key", "Tra1l3rParkB0y5");

        $this->_logger->info('Subscription content: ' . $contents);
        $this->_logger->info('Telephone numbers to which SMS was sent : ');

        $body = $this->prepareDataToSend($smsSubscriptionCollections, $contents);

        $client->setRawData($body);
        $response = $client->request();

        $this->_logger->info('Status: ' . $response->getStatus());
        return $response->isSuccessful();
    }

    /**
     * @param $smsSubscriptionCollections
     * @param $contents
     * @return string
     */
    private function prepareDataToSend($smsSubscriptionCollections, $contents): string
    {
        $body = "[";
        foreach ($smsSubscriptionCollections as $smsSubscriptionCollection) {
            $phone = $smsSubscriptionCollection['phone'];
            $this->_logger->info('Number: ' . $phone);
            $body = $body . '{"number":"' . $phone . '","message":"' . $contents . '"},';
        }
        $body = $body . "]";

        return str_replace("},]", "}]", $body);
    }

}
