<?php

namespace Abc\Def\Model\Resolver;

use Exception;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;

class EditProductAttributes implements ResolverInterface
{

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (false === $context->getExtensionAttributes()->getIsCustomer()) {
            throw new GraphQlAuthorizationException(__('The current customer isn\'t authorized.'));
        }

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $ProductFactory = $objectManager->create('Magento\Catalog\Model\ProductFactory')->create();
        if($args['id'])
            $ProductFactory->load($args['id']);
        else{
            $ProductFactory = $objectManager->create('\Magento\Catalog\Model\ProductRepository');
            $ProductFactory=$ProductFactory->get($args['sku']);
        }
        
        $options = $objectManager->create(\GqRitesh\Assignment\Model\Config\Source\Options::class);
        $options=$options->getAllOptions();
        
        $flag=false;
        foreach ($options as $option) {
            if($args['unit']==$option['value']){
                $flag=true;
            }
        }
        if(!$flag)
            throw new GraphQlInputException(__('Please provide correct unit argument'));
        if($flag){
            $ProductFactory->setUnitOfProduct($args['unit']);
            
            if($ProductFactory->save()){
                $args['flag']='true';
                $args['updatedUnit']=$ProductFactory->getUnitOfProduct();
                return $args;
        }
        }
        
    }
}
