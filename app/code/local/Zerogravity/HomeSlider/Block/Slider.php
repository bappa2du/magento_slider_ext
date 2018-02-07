<?php

class Zerogravity_HomeSlider_Block_Slider extends Mage_Core_Block_Template
{
    public function getSlider()
    {
        return Mage::getModel('homeslider/slider')->getCollection()
            ->addFieldToFilter('status',1)
            ->addFieldToFilter('type',1)
            ->setOrder('position','ASC');
    }
}