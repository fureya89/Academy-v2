<?php

namespace Academy\SmsSubscription\Plugin;

use Academy\SmsSubscription\Ui\DataProvider\Manage\MessageListingDataProvider as MessageDataProvider;

use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class AddMessageAttributesToUiDataProvider
{
    private $attributeRepository;
    private $productMetadata;

    public function __construct(
        ProductMetadataInterface $productMetadata
    ) {
        $this->productMetadata = $productMetadata;
    }

    public function afterGetSearchResult(MessageDataProvider $subject, SearchResult $result)
    {
        if ($result->isLoaded()) {
            return $result;
        }

        $columnSubscription = 'customer_id';
        $columnCustomer = 'entity_id';

        $result->getSelect();

        return $result;
    }

}
