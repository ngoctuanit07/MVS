<?php

class Eshop_Event_Adminhtml_EventController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("event/event")->_addBreadcrumb(Mage::helper("adminhtml")->__("Event  Manager"),Mage::helper("adminhtml")->__("Event Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Event"));
			    $this->_title($this->__("Manager Event"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Event"));
				$this->_title($this->__("Event"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("event/event")->load($id);
				if ($model->getId()) {
					Mage::register("event_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("event/event");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Event Manager"), Mage::helper("adminhtml")->__("Event Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Event Description"), Mage::helper("adminhtml")->__("Event Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("event/adminhtml_event_edit"))->_addLeft($this->getLayout()->createBlock("event/adminhtml_event_edit_tabs"));
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
		$this->_title($this->__("Event"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("event/event")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("event_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("event/event");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Event Manager"), Mage::helper("adminhtml")->__("Event Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Event Description"), Mage::helper("adminhtml")->__("Event Description"));


		$this->_addContent($this->getLayout()->createBlock("event/adminhtml_event_edit"))->_addLeft($this->getLayout()->createBlock("event/adminhtml_event_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{ 
				$post_data=$this->getRequest()->getPost();
				//echo "<pre>";print_r($post_data);die;
				if ($post_data) {
					try {
						$model = Mage::getModel("event/event")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Event was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setEventData(false);
						
						
						//Create Virtual Product Start 
						$base_url=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
						$client = new SoapClient($base_url.'index.php/api/soap/?wsdl', array('connection_timeout' => 120));
						$session = $client->login('vimalparihar', '123456');
						
						
						$event_id=$model->getId();
						$product_sku='event-'.$event_id;
						$productid = Mage::getModel('catalog/product')->getIdBySku($product_sku);
						$product_array=array(
							    'websites' => array(1),
								'categories' => array(),
							    'name' => $post_data['event_name'],
							    'description' => $post_data['event_description'],
							    'short_description' => $post_data['event_description'],
								'eventid' => $event_id,
							    'status' => '1',
							    'visibility' => '2',
							    'price' => '0',
							    'tax_class_id' => '0'
							);
							
							
						$customTextFieldOption = array(
									    "title" => "SKU",
									    "type" => "field",
									    "is_require" => 1,
									    "sort_order" => 0,
									    "additional_fields" => array(
									        array(
									            "price" => $post_data['price_per_product'],
									            "price_type" => "fixed",
									            "sku" => "",
									        )
									    )
						 );
						 
						 $customTextFieldOption1 = array(
									    "title" => "SKU",
									    "type" => "field",
									    "is_require" => 0,
									    "sort_order" => 1,
									    "additional_fields" => array(
									        array(
									            "price" => $post_data['price_per_product'],
									            "price_type" => "fixed",
									            "sku" => "",
									        )
									    )
						 );

						 $customTextFieldOption_update = array(
									    "title" => "SKU",
									    "type" => "field",
									    "additional_fields" => array(
									        array(
									            "price" => $post_data['price_per_product'],
									            "price_type" => "fixed",
									            "sku" => "",
									        )
									    )
						 );
						
						if(!$productid)
						{
							$attributeSets = $client->call($session, 'product_attribute_set.list');
							$attributeSet = current($attributeSets);
							
							$productid = $client->call($session,'catalog_product.create',array('virtual',$attributeSet['set_id'],$product_sku,$product_array));
							
							// Add custom option of Text Field type
	   						$resultCustomTextFieldOptionAdd = $client->call($session,"product_custom_option.add",array($productid,$customTextFieldOption));
							for($i=0;$i<9;$i++)
							{
								$resultCustomTextFieldOptionAdd = $client->call($session,"product_custom_option.add",array($productid,$customTextFieldOption1));
							}
							
							try {
							    Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Event invitation mail has been sent to merchant $product_url"));
							}
							catch (Exception $e) {
							    Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Event invitation mail has not been sent to merchant $product_url"));
							}
							
							//Code For send email to merchant with product url End
						}
						else
						{
							$result = $client->call($session, 'catalog_product.update', array($product_sku,$product_array));
							$result_options = $client->call($session, 'product_custom_option.list', $productid);
							
							// Add custom option of Text Field type
							
							foreach($result_options as $key=>$value)
							{
								$textOptionId=$value['option_id'];
								$resultCustomTextFieldOptionUpdate = $client->call(
							    $session,
							    "product_custom_option.update",
							    array(
							         $textOptionId,
							         $customTextFieldOption_update
							         )
								);
							}
						}
						//fetch email of merchants
						$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
						$select = $connection->select()
						->from ('merchant', 'email')
						->where ("status= '0' ");
						$rowsArray = $connection->fetchAll($select);
						$emails = array();

						foreach ($rowsArray as $v1)
						{
							$emails[] = $v1['email'];
						}
						
						
						   //Code For send email to merchant with product url Start	
							$merchant_name='Merchant';
							$reply_to='vimal.parihar@a3logics.in';
							$event_name=$post_data['event_name'];
							$event_description=$post_data['event_description'];
							$sub_start_date=$post_data['submittion_start_date'];
							$sub_end_date=$post_data['submittion_end_date'];
							$product = Mage::getModel('catalog/product')->load($productid);
							$product_url = $product->getProductUrl();
							
							
							$templateId = 6; // Id is that created in admin email template 
							$from_email = Mage::getStoreConfig('trans_email/ident_general/email'); //fetch sender email Admin
							$from_name = Mage::getStoreConfig('trans_email/ident_general/name'); //fetch sender name Admin
							$sender = Array('name' => $from_name,'email' => $from_email);
							$vars = Array();
							$vars = Array('event_name'=>$event_name,'merchant_name'=>$merchant_name,'event_description'=>$event_description,'sub_start_date'=>$sub_start_date,'sub_end_date'=>$sub_end_date,'product_url'=>$product_url);
							
							$storeId = Mage::app()->getStore()->getId();
							$translate = Mage::getSingleton('core/translate');
							Mage::getModel('core/email_template')
							->addBcc($emails)
							->sendTransactional($templateId, $sender, $reply_to, $from_name, $vars, $storeId);
							$translate->setTranslateInline(true); 
							/* Event Invite Mail Code End */
						
						
						//Create Virtual Product End
						
						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setEventData($this->getRequest()->getPost());
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
						$model = Mage::getModel("event/event");
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
                      $model = Mage::getModel("event/event");
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
			$fileName   = 'event.csv';
			$grid       = $this->getLayout()->createBlock('event/adminhtml_event_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'event.xml';
			$grid       = $this->getLayout()->createBlock('event/adminhtml_event_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
