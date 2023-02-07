<?php

namespace GqRitesh\Assignment\Block\Adminhtml\Order\View;

class ShowComments extends \Magento\Backend\Block\Template
{

    
   public function myFunction()
   {
       return "Order Comments";
   }
   
   public function getAllComments(){
    
    $orderId = $this->getRequest()->getParam('order_id');

    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

    $orderObj= $objectManager->create(\Magento\Sales\Model\OrderFactory::class)->create()->load($orderId);
    
    $quoteId=$orderObj->getQuoteId();

    $qouteObj= $objectManager->create(\Magento\Quote\Model\QuoteFactory::class)->create()->load($quoteId);
    
    $allItems=$qouteObj->getAllItems();
    $comment='';

    foreach($allItems as $item){
        $comment.=$item->getProductOrderComment()."<br>";
    }
    return $comment.$qouteObj->getOrderComment();
   }
}