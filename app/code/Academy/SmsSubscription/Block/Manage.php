<?php

namespace Academy\SmsSubscription\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Academy\SmsSubscription\Model\ResourceModel\SmsSubscription\CollectionFactory;

class Manage extends Template

{
    private CollectionFactory $_smsSubscriptionCollectionFactory;
    public function __construct(Context $context, CollectionFactory $smsSubscriptionCollectionFactory, array $data = [])
    {
        $this->_smsSubscriptionCollectionFactory = $smsSubscriptionCollectionFactory;
        parent::__construct($context, $data);
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('My SMS Subscription'));
        if ($this->getSmsSubscriptionCollection()) {
            $pager = $this->getLayout()
                ->createBlock('Magento\Theme\Block\Html\Pager','subscription.pager')
                ->setAvailableLimit([5 => 5, 10 => 10, 15 => 15, 20 => 20])
                ->setShowPerPage(true)
                ->setCollection($this->getSmsSubscriptionCollection());
            $this->setChild('pager', $pager);
            $this->getSmsSubscriptionCollection()->load();
        }
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getSmsSubscriptionCollection()
    {
        $page = $this->getRequest()->getParam('p') ?: 1;
        $pageSize = $this->getRequest()->getParam('limit') ?: 5;
        $collection = $this->_smsSubscriptionCollectionFactory->create();
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        return $collection;
    }
}
