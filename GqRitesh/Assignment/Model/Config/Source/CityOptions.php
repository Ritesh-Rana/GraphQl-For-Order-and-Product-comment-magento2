<?php

namespace GqRitesh\Assignment\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class CityOptions extends AbstractSource{


    public function getAllOptions()
    {
        if (null === $this->_options) {
            $this->_options=[
                                ['label' => __('Bangalore'), 'value' => 'Bangalore'],
                                ['label' => __('Indore'), 'value' =>'Indore' ],
                                ['label' => __('Jaipure'), 'value' =>'Jaipur' ],
                                ['label' => __('Jodhpur'), 'value' =>'Jodhpur' ]
                            ];
        }
        return $this->_options;
    }
}