<?php

class Zerogravity_HomeSlider_Block_Adminhtml_Slider_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = "slider_id";
        $this->_blockGroup = "homeslider";
        $this->_controller = "adminhtml_slider";
        parent::__construct();
    }

    public function getHeaderText()
    {
        return Mage::helper("homeslider")->__('New Slider');
    }

    public function getSaveUrl()
    {
        return $this->getUrl('*/homeslider/save', array('_current' => true));
    }
}