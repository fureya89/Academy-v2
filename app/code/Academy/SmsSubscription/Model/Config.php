<?php

namespace Academy\SmsSubscription\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;


class Config
{

    private ScopeConfigInterface $scopeConfig;

    public const FIELD_NAME_ENABLE = 'sms_subscription/general/enable';
    public const FIELD_NAME_URL = 'sms_subscription/general/url';
    public const FIELD_NAME_API_KEY = 'sms_subscription/general/apikey';
    public const FIELD_NAME_MAX_ATTEMPS = 'sms_subscription/general/max_attemps';

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function isEnabled(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::FIELD_NAME_ENABLE,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getUrl(): ?string
    {
        return $this->scopeConfig->getValue(
            self::FIELD_NAME_URL,
            ScopeInterface::SCOPE_STORE);
    }

    public function getApiKey(): ?string
    {
        return $this->scopeConfig->getValue(
            self::FIELD_NAME_API_KEY,
            ScopeInterface::SCOPE_STORE);
    }

    public function getMaxAttemps(): ?int
    {
        return $this->scopeConfig->getValue(
            self::FIELD_NAME_MAX_ATTEMPS,
            ScopeInterface::SCOPE_STORE);
    }


}



