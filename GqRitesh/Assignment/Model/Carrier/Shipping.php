<?php

namespace GqRitesh\Assignment\Model\Carrier;

use Magento\Quote\Model\Quote\Address\RateRequest;

class Shipping extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements
    \Magento\Shipping\Model\Carrier\CarrierInterface
{
    
    protected $_code = 'samedayship';

    protected $_rateResultFactory;

    protected $_rateMethodFactory;

   
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        array $data = []
    ) {
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    
    public function getAllowedMethods()
    {
        return [$this->_code => $this->getConfigData('name')];
    }

   
    private function getShippingPrice()
    {
        $configPrice = $this->getConfigData('price');

        $shippingPrice = $this->getFinalPriceWithHandlingFee($configPrice);

        return $shippingPrice;
    }

   
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        
        $result = $this->_rateResultFactory->create();

        $method = $this->_rateMethodFactory->create();

        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title'));

        $method->setMethod($this->_code);
        $method->setMethodTitle($this->getConfigData('name'));

        $amount = $this->getShippingPrice();

        $method->setPrice($amount);
        $method->setCost($amount);
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info($method->getMethod());
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $scopeConfig=$objectManager->create('\Magento\Framework\App\Config\ScopeConfigInterface');
        $restrictedcity=$scopeConfig->getValue('carriers/samedayship/city', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $logger->info($restrictedcity);
        if ($method->getMethod() == 'samedayship') { 
            if ($request->getDestCity() == $restrictedcity) { 
                $result->append($method);
            }
        } else {
            $result->append($method);
        }

        return $result;
    }
}