<?php

namespace Abc\Def\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;

class EditProductComment implements ResolverInterface
{
    
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (false === $context->getExtensionAttributes()->getIsCustomer()) {
            throw new GraphQlAuthorizationException(__('The current customer isn\'t authorized.'));
        }
        $orderId =$args['id'];
        $sku =$args['sku'];
        $Comment =$args['comment'];

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $orderObj= $objectManager->create(\Magento\Sales\Model\OrderFactory::class)->create()->load($orderId);
    
        $quoteId=$orderObj->getQuoteId();

        $qouteObj= $objectManager->create(\Magento\Quote\Model\QuoteFactory::class)->create()->load($quoteId);
    
        $allItems=$qouteObj->getAllItems();
        $args['flag']='false';
        foreach ($allItems as $item) {
            if ($item->getSku()==$sku) {
                $item->setProductOrderComment("Comment for product ". $item->getName().": " . $Comment);
                if($item->save()){
                    $args['flag']='true';
                    $args['updatedComment']=$item->getProductOrderComment();
                }
                break;
            }
        }
        if($args['flag']=='false')
            throw new GraphQlInputException(__('Given Oder id Or Sku not found'));
        return $args;
    }
}
