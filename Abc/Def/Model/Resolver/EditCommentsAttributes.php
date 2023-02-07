<?php

namespace Abc\Def\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;

class EditCommentsAttributes implements ResolverInterface
{
    
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (false === $context->getExtensionAttributes()->getIsCustomer()) {
            throw new GraphQlAuthorizationException(__('The current customer isn\'t authorized.'));
        }
        $orderId =$args['id'];
        
        $Comment =$args['entireOrderComment'];

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $orderObj = $objectManager->create(\Magento\Sales\Model\OrderFactory::class)->create()->load($orderId);

        $quoteId = $orderObj->getQuoteId();
        $qouteObj = $objectManager->create(\Magento\Quote\Model\QuoteFactory::class)->create()->load($quoteId);

        if($quoteId){
            $qouteObj->setOrderComment("Comment for entire Order : ".$Comment);
            $args['entireOrderCommentUpdateFlag']='true';
            $args['updatedComment']=$Comment;
            $qouteObj->save();
        }
        else{
            $args['entireOrderCommentUpdateFlag']='false';
            if($qouteObj->getOrderComment())
              $args['updatedComment']=$qouteObj->getOrderComment();
        }
        if($args['entireOrderCommentUpdateFlag']=='false')
            throw new GraphQlInputException(__('Order Id entered Does Not exits.'));

        return $args;
    }
}
