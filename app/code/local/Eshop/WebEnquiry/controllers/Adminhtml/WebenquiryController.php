<?php

class Eshop_WebEnquiry_Adminhtml_WebenquiryController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("webenquiry/webenquiry")->_addBreadcrumb(Mage::helper("adminhtml")->__("Webenquiry  Manager"),Mage::helper("adminhtml")->__("Webenquiry Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("WebEnquiry"));
			    $this->_title($this->__("Manager Webenquiry"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("WebEnquiry"));
				$this->_title($this->__("Webenquiry"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("webenquiry/webenquiry")->load($id);
				if ($model->getId()) {
					Mage::register("webenquiry_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("webenquiry/webenquiry");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Webenquiry Manager"), Mage::helper("adminhtml")->__("Webenquiry Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Webenquiry Description"), Mage::helper("adminhtml")->__("Webenquiry Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("webenquiry/adminhtml_webenquiry_edit"))->_addLeft($this->getLayout()->createBlock("webenquiry/adminhtml_webenquiry_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("webenquiry")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("WebEnquiry"));
		$this->_title($this->__("Webenquiry"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("webenquiry/webenquiry")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("webenquiry_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("webenquiry/webenquiry");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Webenquiry Manager"), Mage::helper("adminhtml")->__("Webenquiry Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Webenquiry Description"), Mage::helper("adminhtml")->__("Webenquiry Description"));


		$this->_addContent($this->getLayout()->createBlock("webenquiry/adminhtml_webenquiry_edit"))->_addLeft($this->getLayout()->createBlock("webenquiry/adminhtml_webenquiry_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{
			$post_data=$this->getRequest()->getPost();
			
			$req_id=$this->getRequest()->getParam("id");
			
			$collection = Mage::getModel("webenquiry/webenquiry")->getCollection()->addFilter('sno',$req_id);
			$data1=$collection->getData();
			
			
			/* Enquiry Mail Code Start */
			$customer_name=$data1[0]['name'];
			$reply_to=$data1[0]['email'];
			$customer_message=$data1[0]['message'];
			$replied_message=$post_data['reply_message'];
			$inquiry_subject=$data1[0]['subject'];
			
			
			$templateId = 3; // Id is that created in admin email template 

			//$from_email = Mage::getStoreConfig('trans_email/ident_general/email'); //fetch sender email Admin
			//$from_name = Mage::getStoreConfig('trans_email/ident_general/name'); //fetch sender name Admin
			
			//Sales Representative
 			$from_name = Mage::getStoreConfig('trans_email/ident_sales/name'); //sender name
 			$from_email = Mage::getStoreConfig('trans_email/ident_sales/email'); //sender email
			
			
			$sender = Array('name' => $from_name,'email' => $from_email);
			
			$vars = Array();
			$vars = Array('customer_name'=>$customer_name,'customer_email'=>$reply_to,'customer_message'=>$customer_message,'replied_message'=>$replied_message,'inquiry_subject'=>$inquiry_subject);
			
			$storeId = Mage::app()->getStore()->getId();
			$translate = Mage::getSingleton('core/translate');
			Mage::getModel('core/email_template')->sendTransactional($templateId, $sender, $reply_to, $from_name, $vars, $storeId);
			$translate->setTranslateInline(true); 
			/* Enquiry Mail Code End */
			

				if ($post_data) {
					try {
						$model = Mage::getModel("webenquiry/webenquiry")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Enquiry email was successfully sent."));
						Mage::getSingleton("adminhtml/session")->setWebenquiryData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setWebenquiryData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}



		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$model = Mage::getModel("webenquiry/webenquiry");
						$model->setId($this->getRequest()->getParam("id"))->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
						$this->_redirect("*/*/");
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}

		
		public function massRemoveAction()
		{
			try {
				$ids = $this->getRequest()->getPost('snos', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("webenquiry/webenquiry");
					  $model->setId($id)->delete();
				}
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
			}
			catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			}
			$this->_redirect('*/*/');
		}
			
		/**
		 * Export order grid to CSV format
		 */
		public function exportCsvAction()
		{
			$fileName   = 'webenquiry.csv';
			$grid       = $this->getLayout()->createBlock('webenquiry/adminhtml_webenquiry_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'webenquiry.xml';
			$grid       = $this->getLayout()->createBlock('webenquiry/adminhtml_webenquiry_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
