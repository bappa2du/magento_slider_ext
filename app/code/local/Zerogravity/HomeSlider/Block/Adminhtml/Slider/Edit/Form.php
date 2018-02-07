<?php

class Zerogravity_HomeSlider_Block_Adminhtml_Slider_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _initFormValues()
    {
        if ($slider = Mage::registry('current_slider')) {
            $data = $slider->getData();
            $this->getForm()->setValues($data);
        }

    }

    protected function _prepareForm()
    {
        $slider = Mage::registry('current_slider');

        $form = new Varien_Data_Form(
            array(
                'id'      => 'edit_form',
                'action'  => $this->getData('action'),
                'method'  => 'post',
                'enctype' => 'multipart/form-data',
            )
        );
        $fieldset = $form->addFieldset('homeslider_form', array(
            'legend' => Mage::helper('homeslider')->__('Slider Information'),
            'class'  => 'fieldset-wide',
        ));

        $fieldset->addField('title', 'text', array(
            'name'     => 'title',
            'label'    => Mage::helper('homeslider')->__('Title'),
            'title'    => Mage::helper('homeslider')->__('Title'),
            'note'     => Mage::helper('homeslider')->__('Slider title as slider alter text'),
            'required' => true,
        ));

        $fieldset->addField('position', 'text', array(
            'name'     => 'position',
            'label'    => Mage::helper('homeslider')->__('Slider Position'),
            'title'    => Mage::helper('homeslider')->__('Slider Position'),
            'note'     => Mage::helper('homeslider')->__('Slider Position'),
            'required' => true,
        ));

        $fieldset->addField('url_link', 'text', array(
            'name'     => 'url_link',
            'label'    => Mage::helper('homeslider')->__('URL Link'),
            'title'    => Mage::helper('homeslider')->__('URL Link'),
            'note'     => Mage::helper('homeslider')->__('Enter link after base url: '.Mage::getBaseUrl()),
            'required' => true,
        ));

        $fieldset->addField('url_target', 'select', array(
            'name'     => 'url_target',
            'label'    => Mage::helper('homeslider')->__('URL Target'),
            'title'    => Mage::helper('homeslider')->__('URL Target Tab'),
            'note'     => Mage::helper('homeslider')->__('Open Link in Current Tab or New Tab'),
            'required' => true,
            'values'   => array(
                array(
                    'value' => '_self',
                    'label' => Mage::helper('homeslider')->__('Self'),
                ),array(
                    'value' => '_blank',
                    'label' => Mage::helper('homeslider')->__('New Tab'),
                ),

            ),
        ));

        $fieldset->addField('type', 'select', array(
            'name'     => 'type',
            'label'    => Mage::helper('homeslider')->__('Type'),
            'title'    => Mage::helper('homeslider')->__('Type'),
            'required' => true,
            'values'   => array(
                array(
                    'value' => '1',
                    'label' => Mage::helper('homeslider')->__('Desktop'),
                ), array(
                    'value' => '2',
                    'label' => Mage::helper('homeslider')->__('Mobile'),
                ), array(
                    'value' => '3',
                    'label' => Mage::helper('homeslider')->__('Category'),
                ),

            ),
        ));

        $fieldset->addField('description', 'textarea', array(
            'name'     => 'description',
            'label'    => Mage::helper('homeslider')->__('Description'),
            'title'    => Mage::helper('homeslider')->__('Description'),
        ));

        $fieldset->addField('status', 'select', array(
            'name'     => 'status',
            'label'    => Mage::helper('homeslider')->__('Slider Status'),
            'title'    => Mage::helper('homeslider')->__('Slider Status'),
            'required' => true,
            'values'   => array(
                array(
                    'value' => '1',
                    'label' => Mage::helper('homeslider')->__('Enable'),
                ), array(
                    'value' => '2',
                    'label' => Mage::helper('homeslider')->__('Disable'),
                ),

            ),
        ));

        $slider_image_field = $fieldset->addField('image_file', 'file', array(
            'name'     => 'image_file',
            'label'    => Mage::helper('homeslider')->__('Slider Image'),
            'title'    => Mage::helper('homeslider')->__('Slider Image'),
            'note'     => Mage::helper('homeslider')->__('Slider Image Resolution 1176px X 420px'),
            'required' => empty($slider['image_file']) ? true : false,
            'class'=>'slider-img-size',
            'onchange'           => "checkimage('slider-img-size',1176,420)",
        ));
        if (!empty($slider['image_file'])) {
            $image_file = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . 'home_Slider_images' . DS . $slider['image_file'];
            $preview = '<br/><a href="' . $image_file . '" target="_blank"><img style="max-width:200px;" src="' . $image_file . '" /></a>';
            //$slider_image_field->setAfterElementHtml($preview);
        }else{
            $preview = '';
        }
        $afterHtml = "<script type='text/javascript'> 
            function checkimage(elementClass,imgwidth,imgheight) {  
                var imageupload = document.getElementsByClassName(elementClass)[0];
                var regex = new RegExp('([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.png|.gif)$');
                if (regex.test(imageupload.value.toLowerCase())) {
                 
                    if (typeof (imageupload.files[0]) != 'undefined') {   
                        var readerfile = new FileReader();    
                        readerfile.readAsDataURL(imageupload.files[0]); 
                        readerfile.onload = function (e) { 
                            var image_file = new Image();  
                            image_file.src = e.target.result;  
                            image_file.onload = function () {
                                var height = this.height; 
                                var width = this.width;
                                if (height != imgheight || width != imgwidth) {   
                                    alert('Image must be height '+imgheight+'px and width '+imgwidth+'px.');
                                    document.getElementsByClassName(elementClass)[0].value = ''; 
                                    return false;  
                                }
                            };
                        }
                    } else { 
                        alert('This browser does not support HTML5.');
                        return false;
                    }
                } else {
                    alert('Please select a valid Image file.');
                    return false; 
                }    
            }
            </script>";
        $slider_image_field->setAfterElementHtml($preview.$afterHtml);

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}