<?php

namespace Academy\SmsSubscription\Controller\Adminhtml\Manage;

use Magento\Framework\HTTP\ZendClientFactory;
use Academy\SmsSubscription\Logger\Logger;
use Academy\SmsSubscription\Model\Config;
use Zend_Http_Client;
use Zend_Http_Client_Exception;

class SmsSendClient
{

    private $_httpClientFactory;
    private $_config;
    private $_logger;

    public function __construct(
        ZendClientFactory $httpClientFactory,
        Config            $config,
        Logger            $logger
    )
    {
        $this->_httpClientFactory = $httpClientFactory;
        $this->_config = $config;
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
        $client->setUri($this->_config->getUrl());
        $client->setMethod(Zend_Http_Client::POST);
        $client->setHeaders("X-API-Key", $this->_config->getApiKey());

        $this->_logger->info('Subscription content: ' . $contents);
        $this->_logger->info('Telephone numbers to which SMS was sent : ');

        $body = $this->prepareDataToSend($smsSubscriptionCollections, $contents);

        $client->setRawData($body);

        $attempts = 0;
        do {
            $response = $client->request();
            $attempts++;
            if($response->getStatus()==408){
                $this->_logger->info('Timeout appeared - sending has been resumed. Attempt '.$attempts.' of '.$this->_config->getMaxAttemps());
            }
        } while ($response->getStatus()==408 && $attempts <= $this->_config->getMaxAttemps());

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
        $body = [];
        foreach ($smsSubscriptionCollections as $smsSubscriptionCollection) {
            $phone = $smsSubscriptionCollection['phone'];
            $this->_logger->info('Number: ' . $phone);
            $body[] = ['number' => $phone, 'message' => $contents];
        }

        return json_encode($body);
    }

}
