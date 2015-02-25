<?php
class Eshop_EnquiryManagement_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("EnquiryManagement"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("enquirymanagement", array(
                "label" => $this->__("EnquiryManagement"),
                "title" => $this->__("EnquiryManagement")
		   ));

      $this->renderLayout(); 
	  
    }
    public function saveAction()
 {
$data = $this->getRequest()->getPost();
Mage::getModel('enquirymanagement/enquirymanagement')->setData($data)->save();
echo "enquiry sent!! ";
 } 
}