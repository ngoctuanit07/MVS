<?php
class Eshop_WebEnquiry_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Contact Us"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("contact us", array(
                "label" => $this->__("Contact Us"),
                "title" => $this->__("Contact Us")
		   ));
      $this->_initLayoutMessages('core/session');    
	 // $this->_initLayoutMessages('message/session');
      $this->renderLayout(); 
	  
    }
     public function saveAction()
 	 {
 	 	$data = $this->getRequest()->getPost();
		Mage::getModel('webenquiry/webenquiry')->setData($data)->save();
		Mage::getSingleton('customer/session')->addSuccess('Your inquiry was submitted and will be responded to as soon as possible. Thank you for contacting us.');
		$this->_redirect('*/*/');

 	 } 
}