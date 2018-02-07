<?php

class Zerogravity_HomeSlider_Block_Adminhtml_Slider extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'homeslider';
        $this->_controller = 'adminhtml_slider';
        $this->_headerText = Mage::helper('homeslider')->__('Slider/Banner List');
        $this->_addButtonLabel = Mage::helper('homeslider')->__('Add New Slider');
        parent::__construct();

    }
}