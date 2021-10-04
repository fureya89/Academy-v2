<?php

namespace Academy\SmsSubscription\Block;

use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Academy\SmsSubscription\Model\ResourceModel\SmsSubscription\CollectionFactory;

class Manage extends Template

{
    const PAGE = 1;
    const PAGE_SIZE = 10;
    protected Session $customerSession;
    private CollectionFactory $_smsSubscriptionCollectionFactory;

    public function __construct(Context $context,
                                CollectionFactory $smsSubscriptionCollectionFactory,
                                Session $customerSession,
                                array $data = [])
    {
        $this->_smsSubscriptionCollectionFactory = $smsSubscriptionCollectionFactory;
        parent::__construct($context, $data);
        $this->customerSession = $customerSession;
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

    public function getCurrentCustomerId(): int
    {
        return (int)$this->customerSession->getCustomerId();
    }

    public function getSmsSubscriptionCollection(): \Academy\SmsSubscription\Model\ResourceModel\SmsSubscription\Collection
    {
        $customerId = $this->getCurrentCustomerId();

        $page = $this->getRequest()->getParam('p') ?: self::PAGE;
        $pageSize = $this->getRequest()->getParam('limit') ?: self::PAGE_SIZE;
        $collection = $this->_smsSubscriptionCollectionFactory->create();
        $collection->addFieldToFilter('customer_id', array('eq' => $customerId));
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        return $collection;
    }

    public function getAction()
    {
        return $this->getUrl('subscription/manage/update');
    }

    public function getSaveUrl()
    {
        return $this->getUrl('subscription/manage/add');
    }

}
