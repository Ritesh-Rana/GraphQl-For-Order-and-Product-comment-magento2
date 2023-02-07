<?php

namespace GqRitesh\Assignment\Model;


class PaymentMethod extends \Magento\Payment\Model\Method\AbstractMethod
{

    protected $_code = 'testpayment';

    public function canUseForCountry($country)
    {

        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/customsdfsdf.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $quote = $objectManager->create('Magento\Checkout\Model\Cart')->getQuote();
        $shippingCity = $quote->getShippingAddress()->getCity();
        // $logger->info($shippingCity);


        $scopeConfig=$objectManager->create('\Magento\Framework\App\Config\ScopeConfigInterface');
        $restrictedcity=$scopeConfig->getValue('payment/testpayment/city', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        // $logger->info($restrictedcity);
        if($shippingCity==$restrictedcity)
            return true;
        return false;
    }
}
