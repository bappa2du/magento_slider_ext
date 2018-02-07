<?php

class Zerogravity_HomeSlider_Block_Adminhtml_Slider_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $html = '<img id="' . $this->getColumn()->getId() . '" src="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) .DS.'home_Slider_images'.DS. $row->getData($this->getColumn()->getIndex()) . '"';
        $html .= ' height="100px" />';
        return $html;
    }
}

?>