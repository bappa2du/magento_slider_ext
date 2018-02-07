<?php

class Zerogravity_HomeSlider_Adminhtml_HomesliderController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
//        $this->_setActiveMenu('homeslider/slider');
        $this->_setActiveMenu('cms/homeslider');
        $content = $this->getLayout()->createBlock('homeslider/adminhtml_slider');
        $this->_addContent($content);
        return $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        if ($slider_id = $this->getRequest()->getParam('slider_id')) {
            Mage::register('current_slider', Mage::getModel('homeslider/slider')->load($slider_id));
        }
        $this->loadLayout();
        $content = $this->getLayout()->createBlock('homeslider/adminhtml_slider_edit');
        $this->_addContent($content);
        return $this->renderLayout();
    }

    public function saveAction()
    {
        $slider_id = $this->getRequest()->getParam('slider_id');
        $slider_model = Mage::getModel('homeslider/slider')->load($slider_id);
        if ($data = $this->getRequest()->getPost()) {
            try {
                $slider_model->setTitle($data['title']);
                $slider_model->setPosition($data['position']);
                $slider_model->setUrlLink($data['url_link']);
                $slider_model->setStatus($data['status']);
                $slider_model->setDescription($data['description']);
                $slider_model->setType($data['type']);
                $slider_model->setUrlTarget($data['url_target']);
                if(!empty($_FILES['image_file']['name'])) {

                    if($image_file = $slider_model->getImageFile()){
                        if(file_exists(Mage::getBaseDir('media') . DS . 'home_Slider_images'.DS.$image_file)){
                            unlink(Mage::getBaseDir('media') . DS . 'home_Slider_images'.DS.$image_file);
                        }
                    }

                    $uploader = new Varien_File_Uploader(array(
                        'name'     => $_FILES['image_file']['name'],
                        'type'     => $_FILES['image_file']['type'],
                        'tmp_name' => $_FILES['image_file']['tmp_name'],
                        'error'    => $_FILES['image_file']['error'],
                        'size'     => $_FILES['image_file']['size'],
                    ));
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'png'));
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(false);
                    $date = date('d-m-y');
                    $fileName = $date . '-' . preg_replace('/ /', '_', $_FILES['image_file']['name']);
                    $path = Mage::getBaseDir('media') . DS . 'home_Slider_images';
                    if (!is_dir($path)) {
                        mkdir($path, 0777, true);
                    }
                    if (!file_exists($path . DS . $fileName)) {
                        $uploader->save($path . DS, $fileName);
                        $slider_model->setImageFile($fileName);
                    }
                }
                $slider_model->save();

                Mage::getSingleton('adminhtml/session')
                    ->addSuccess($this->__("Your Slider has been saved"));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')
                    ->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function deleteAction()
    {
        if($slider_id = $this->getRequest()->getParam('slider_id')){
            $slider_model = Mage::getModel('homeslider/slider')->load($slider_id);
            $image_file = $slider_model->getImageFile();
            if(file_exists(Mage::getBaseDir('media') . DS . 'home_Slider_images'.DS.$image_file)){
                unlink(Mage::getBaseDir('media') . DS . 'home_Slider_images'.DS.$image_file);
            }
            $slider_model->delete();
        }
        Mage::getSingleton('adminhtml/session')
            ->addSuccess($this->__("Your Slider has been deleted"));
        $this->_redirect('*/*/index');
    }

}