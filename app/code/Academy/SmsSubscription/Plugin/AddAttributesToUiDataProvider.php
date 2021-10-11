<?php

namespace Academy\SmsSubscription\Plugin;

use Academy\SmsSubscription\Ui\DataProvider\Manage\ListingDataProvider as SubscriptionDataProvider;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class AddAttributesToUiDataProvider
{

    private $attributeRepository;

    private $productMetadata;


    public function __construct(
        AttributeRepositoryInterface $attributeRepository,
        ProductMetadataInterface $productMetadata
    ) {
        $this->attributeRepository = $attributeRepository;
        $this->productMetadata = $productMetadata;
    }


    public function afterGetSearchResult(SubscriptionDataProvider $subject, SearchResult $result)
    {
        if ($result->isLoaded()) {
            return $result;
        }

        $columnSubscription = 'customer_id';
        $columnCustomer = 'entity_id';

        $result->getSelect()->joinLeft(
            ['customer_entity'],
            'customer_entity.' . $columnCustomer . ' = main_table.' . $columnSubscription,
            ['lastname' => 'customer_entity.lastname','firstname' => 'customer_entity.firstname']
        );

        return $result;
    }
}
