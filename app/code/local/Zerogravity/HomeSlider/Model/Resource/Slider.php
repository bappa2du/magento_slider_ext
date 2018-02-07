<?php

class Zerogravity_HomeSlider_Model_Resource_Slider extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        $this->_init('homeslider/slider','id');
    }
}