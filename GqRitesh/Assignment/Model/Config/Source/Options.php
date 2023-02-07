<?php
namespace GqRitesh\Assignment\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Options extends AbstractSource
{
    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        if (null === $this->_options) {
            $this->_options=[
                                ['label' => __('kg'), 'value' => 'kg'],
                                ['label' => __('gm'), 'value' =>'gm' ],
                                ['label' => __('l'), 'value' =>'l' ],
                                ['label' => __('ml'), 'value' =>'ml' ]
                            ];
        }
        return $this->_options;
    }
}