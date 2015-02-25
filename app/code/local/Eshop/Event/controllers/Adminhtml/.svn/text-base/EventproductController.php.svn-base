<?php

class Eshop_Event_Adminhtml_EventproductController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("event/eventproduct")->_addBreadcrumb(Mage::helper("adminhtml")->__("Eventproduct  Manager"),Mage::helper("adminhtml")->__("Eventproduct Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Event"));
			    $this->_title($this->__("Manager Eventproduct"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Event"));
				$this->_title($this->__("Eventproduct"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("event/eventproduct")->load($id);
				if ($model->getId()) {
					Mage::register("eventproduct_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("event/eventproduct");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Eventproduct Manager"), Mage::helper("adminhtml")->__("Eventproduct Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Eventproduct Description"), Mage::helper("adminhtml")->__("Eventproduct Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("event/adminhtml_eventproduct_edit"))->_addLeft($this->getLayout()->createBlock("event/adminhtml_eventproduct_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("event")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{
		$this->_title($this->__("Event"));
		$this->_title($this->__("Eventproduct"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("event/eventproduct")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("eventproduct_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("event/eventproduct");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Eventproduct Manager"), Mage::helper("adminhtml")->__("Eventproduct Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Eventproduct Description"), Mage::helper("adminhtml")->__("Eventproduct Description"));


		$this->_addContent($this->getLayout()->createBlock("event/adminhtml_eventproduct_edit"))->_addLeft($this->getLayout()->createBlock("event/adminhtml_eventproduct_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{
			$post_data=$this->getRequest()->getPost();
			$data_array=array();
			
			$collection = Mage::getModel("event/event")->getCollection()->addFilter('id',$post_data['event_name']);
			$data1=$collection->getData();
			
			$post_data['event_id']=$post_data['event_name'];
			$post_data['event_name']=$post_data['event_name'];
			$post_data['event_method']=$data1[0]['event_method'];
			$post_data['merchant_website']='N/A';
			
				if ($post_data) {

					try {
						$model = Mage::getModel("event/eventproduct")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Eventproduct was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setEventproductData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setEventproductData($this->getRequest()->getPost());
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
						$model = Mage::getModel("event/eventproduct");
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
				$ids = $this->getRequest()->getPost('ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("event/eventproduct");
					  $model->setId($id)->delete();
				}
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
			}
			catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			}
			$this->_redirect('*/*/');
		}
		
		
		public function massUpdateAction()
		{
			try {
				$ids = $this->getRequest()->getPost('ids', array());
				$status=$this->getRequest()->status;
				foreach ($ids as $id) {
					  $data = array('status'=>$status);	
                      $model = Mage::getModel("event/eventproduct");
					  $model->load($id)->addData($data);
					  $model->setId($id)->save();
				}
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully updated"));
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
			$fileName   = 'eventproduct.csv';
			$grid       = $this->getLayout()->createBlock('event/adminhtml_eventproduct_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'eventproduct.xml';
			$grid       = $this->getLayout()->createBlock('event/adminhtml_eventproduct_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
