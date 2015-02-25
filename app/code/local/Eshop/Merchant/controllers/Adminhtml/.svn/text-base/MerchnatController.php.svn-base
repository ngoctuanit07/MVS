<?php

class Eshop_Merchant_Adminhtml_MerchnatController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("merchant/merchnat")->_addBreadcrumb(Mage::helper("adminhtml")->__("Merchnat  Manager"),Mage::helper("adminhtml")->__("Merchnat Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Merchant"));
			    $this->_title($this->__("Manager Merchnat"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Merchant"));
				$this->_title($this->__("Merchnat"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("merchant/merchnat")->load($id);
				if ($model->getId()) {
					Mage::register("merchnat_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("merchant/merchnat");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Merchant Manager"), Mage::helper("adminhtml")->__("Merchant Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Merchant Description"), Mage::helper("adminhtml")->__("Merchant Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("merchant/adminhtml_merchnat_edit"))->_addLeft($this->getLayout()->createBlock("merchant/adminhtml_merchnat_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("merchant")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{
		$this->_title($this->__("Merchant"));
		$this->_title($this->__("Merchnat"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("merchant/merchnat")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("merchnat_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("merchant/merchnat");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Merchant Manager"), Mage::helper("adminhtml")->__("Merchant Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Merchant Description"), Mage::helper("adminhtml")->__("Merchant Description"));


		$this->_addContent($this->getLayout()->createBlock("merchant/adminhtml_merchnat_edit"))->_addLeft($this->getLayout()->createBlock("merchant/adminhtml_merchnat_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{
			$post_data=$this->getRequest()->getPost();
			$req_id=$this->getRequest()->getParam("id");
			$store_alias=strtolower($post_data['store_alias']);
			$status=$post_data['status'];
			
			$base_url=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
			$root_path=Mage::getBaseDir();
			$base_url=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
			$skin_url= Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN);
			$media_url= Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA); 
			$js_url= Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_JS);
			
			$db = Mage::getSingleton('core/resource')->getConnection('core_write');
			$db->exec("SET @@session.wait_timeout = 1200");
			
			//echo "<pre>";
			//print_r($post_data);die;
			
				if ($post_data) {
					try {
						$model = Mage::getModel("merchant/merchnat")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();
						
											
						if($req_id=='')
						{
						$store_email=$post_data['email'];
						$virtual_product_id= $post_data['merchant_plan'];
						$prod = Mage::getModel('catalog/product')->loadByAttribute('entity_id', $virtual_product_id);
						$connection = Mage::getSingleton('core/resource')->getConnection('core_read');//get merchant id
					    $select = $connection->select()
					    ->from('merchant', 'id') // select * from tablename or use array('id','name') selected values
					    ->where('email=?',$store_email);
					    //$rowsArray = $connection->fetchAll($select); // return all rows
					    $rowArray = $connection->fetchRow($select);  //get merchant id from merchant
					    $insertid = $rowArray[id];
					  	$maxsku = Mage::getModel('catalog/product')->load($prod->getId())->getMaxSku();
					   	$numdays = Mage::getModel('catalog/product')->load($prod->getId())->getPlanDuration();
					    $startdate = date('y:m:d');   
					    $enddate = Date('y:m:d', strtotime("+".$numdays." days"));
					    $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
						$connection->beginTransaction();
								    $fields = array();
								    $fields['merchant_id'] = $insertid;
								    $fields['plan_id'] = $virtual_product_id;
								    $fields['start_date'] = $startdate;
								    $fields['end_date'] = $enddate;
								  	$fields['update_date'] = $startdate;
								  	$fields['max_sku'] = $maxsku;
								    $connection->insert('merchant_plan_info', $fields);
									$connection->commit();
							//Create Customer Start						
							$customer = Mage::getModel('customer/customer');
							$password = '123456';
							$email = $post_data['email'];
							$name_array=explode(" ",$post_data['name']);
							$first_name=$name_array[0];
							$last_name=$name_array[1];
							if($last_name=='')
							{ $last_name='last'; }
												
							$customer->setWebsiteId('1');
							$customer->loadByEmail($email);
	
							if(!$customer->getId()) {
							    $customer->setEmail($email);
							    $customer->setFirstname($first_name);
							    $customer->setLastname($last_name);
							    $customer->setPassword($password);
								$customer->setGroupId(4);
								$customer->setWebsiteId('1');							    
							}
							try {
							    $customer->save();
							    $customer->setConfirmation(null);
							    $customer->save();
							}
							catch (Exception $ex) {
							    //Zend_Debug::dump($ex->getMessage());
							}
							//Create Customer End
						
						
							if($status=='0')
							{
									//Create Website and Store Code Start
									$website_name=$store_alias;
									$file_name=$root_path."/index_website.php";
									$file_cng_path=$root_path."/".$website_name."/index.php";
									
									//Create Folder for website and copy 2 files Start
									mkdir($root_path."/".$website_name, 0755);
									copy($file_name, $file_cng_path);
									copy($root_path."/.htaccess", $root_path."/".$website_name."/.htaccess");
									//Create Folder for website and copy 2 End
									
									//Edit index.php file for change website name Start 
									$filecontent=file_get_contents($file_cng_path);
									$pos=strpos($filecontent, 'Mage::run($mageRunCode, $mageRunType)');
									$string='Mage::run("'.$website_name.'", "website");';
									$filecontent=substr($filecontent, 0, $pos)."\r\n".$string."\r\n".substr($filecontent, $pos);
									$filecontent=str_replace('Mage::run($mageRunCode, $mageRunType);','',$filecontent);
									file_put_contents($file_cng_path, $filecontent);
									//Edit index.php file for change website name End
									
									//die;
									//Create Website, store in admin Start 
									
									Mage::registry('isSecureArea');
									//#addWebsite
								    /** @var $website Mage_Core_Model_Website */
								    $website = Mage::getModel('core/website');
								    $website->setCode($website_name)
								        ->setName($website_name)
								        ->save();
								        
								        
								    $write = Mage::getSingleton('core/resource')->getConnection('core_write');
								
								    $new_web_url=$base_url.$website_name."/";
								
								    //$site =  Mage::getModel('core/website')->getCollection()->getAllIds();
								    //$website_id=max($site);
								    $website_id=$website->getId();
								    
									// now $write is an instance of Zend_Db_Adapter_Abstract
									$write->query("insert into core_config_data (scope,scope_id,path,value)values ('websites','$website_id','web/unsecure/base_url','$new_web_url')");
									$write->query("insert into core_config_data (scope,scope_id,path,value)values ('websites','$website_id','web/unsecure/base_link_url','$new_web_url')");
									$write->query("insert into core_config_data (scope,scope_id,path,value)values ('websites','$website_id','web/unsecure/base_skin_url','$skin_url')");
									$write->query("insert into core_config_data (scope,scope_id,path,value)values ('websites','$website_id','web/unsecure/base_media_url','$media_url')");
									$write->query("insert into core_config_data (scope,scope_id,path,value)values ('websites','$website_id','web/unsecure/base_js_url','$js_url')");
									$write->query("insert into core_config_data (scope,scope_id,path,value)values ('websites','$website_id','design/theme/template','merchant')");
									$write->query("insert into core_config_data (scope,scope_id,path,value)values ('websites','$website_id','design/theme/skin','green')");
									$write->query("insert into core_config_data (scope,scope_id,path,value)values ('websites','$website_id','design/theme/layout','merchant')");
								    
								
										//#addStoreGroup
								    	/* @var $storeGroup Mage_Core_Model_Store_Group */
								    	
								        $storeGroup = Mage::getModel('core/store_group');
								    	$storeGroup->setWebsiteId($website->getId())
								        ->setName($website_name)
								        ->setRootCategoryId(2)
								        ->save();
								
										//#addStore
								    	/* @var $store Mage_Core_Model_Store */
								    	$store = Mage::getModel('core/store');
								    	$store->setCode($website_name.'_en')
								        ->setWebsiteId($storeGroup->getWebsiteId())
								        ->setGroupId($storeGroup->getId())
								        ->setName('English')
								        ->setIsActive(1)
								        ->save();
								        
								        $store1 = Mage::getModel('core/store');
								    	$store1->setCode($website_name.'_ma')
								        ->setWebsiteId($storeGroup->getWebsiteId())
								        ->setGroupId($storeGroup->getId())
								        ->setName('Malay')
								        ->setIsActive(1)
								        ->save();
								        
								        $store2 = Mage::getModel('core/store');
								    	$store2->setCode($website_name.'_jp')
								        ->setWebsiteId($storeGroup->getWebsiteId())
								        ->setGroupId($storeGroup->getId())
								        ->setName('Chinese')
								        ->setIsActive(1)
								        ->save();
								        
								        //Create Website and store code End
										
							        
									//Create Rule and User Code Start
							
									try {
									$user = Mage::getModel('admin/user')
											->setData(array(
											'username'  => $store_alias,
											'firstname' => $first_name,
											'lastname'  => $last_name,
											'email'     => $email,
											'password'  => $store_alias.'@123',
											'is_active' => 1
											))->save();
									} 
									catch(Exception $e)
									{
										//echo $e->getMessage();
										//exit;
									}
									
									try {
									//create new role
									$role = Mage::getModel("admin/roles")
									->setName($store_alias)
									->setRoleType('G')
									->save();
									
									$resources=array();
									$resources = explode(',', '__root__,admin/dashboard,admin/system,admin/system/config,admin/system/config/general,admin/system/config/web,admin/system/config/design,admin/system/config/trans_email,admin/system/config/payment,admin/system/config/carriers,admin/system/config/paypal,admin/system/config/contacts,admin/system/cache,admin/system/index,admin/cms,admin/cms/block,admin/cms/page,admin/cms/page/save,admin/cms/page/delete,admin/customer,admin/customer/group,admin/customer/manage,admin/customer/online,admin/catalog,admin/catalog/categories,admin/catalog/products,admin/catalog/urlrewrite,admin/catalog/reviews_ratings,admin/catalog/reviews_ratings/reviews,admin/catalog/reviews_ratings/reviews/all,admin/catalog/reviews_ratings/reviews/pending,admin/catalog/reviews_ratings/ratings,admin/promo,admin/promo/catalog,admin/promo/quote,admin/sales,admin/sales/order,admin/sales/order/actions,admin/sales/order/actions/create,admin/sales/order/actions/view,admin/sales/order/actions/email,admin/sales/order/actions/reorder,admin/sales/order/actions/edit,admin/sales/order/actions/cancel,admin/sales/order/actions/review_payment,admin/sales/order/actions/capture,admin/sales/order/actions/invoice,admin/sales/order/actions/creditmemo,admin/sales/order/actions/hold,admin/sales/order/actions/unhold,admin/sales/order/actions/ship,admin/sales/order/actions/comment,admin/sales/order/actions/emails,admin/sales/invoice,admin/sales/shipment,admin/sales/creditmemo,admin/sales/recurring_profile,admin/sales/checkoutagreement,admin/logo,admin/logo/logo,admin/slider,admin/slider/slider,admin/webenquiry,admin/webenquiry/webenquiry');
									
									//give "all" privileges to role
									Mage::getModel("admin/rules")
									->setRoleId($role->getId())
									->setResources($resources)
									->saveRel();
									} catch (Mage_Core_Exception $e) {
										//echo $e->getMessage();
										//exit;
									} catch (Exception $e) {
										//echo 'Error while saving role.';
										//exit;
									}
									
									
									try {
									//assign user to role
									$user->setRoleIds(array($role->getId()))
									->setRoleUserId($user->getUserId())
									->saveRelations();
									
									$role_id=$role->getId();
									
									$store_model = Mage::getModel('core/store');
									$store_ids=array();
									$store_group_id=$storeGroup->getId();
									$stores = $store_model->getCollection()->addGroupFilter($store_group_id);   //get the stores from the existing store group         
									foreach ($stores as $_store):
							    		$store_ids[] = $_store->getId(); //get store id  
									$store_id=$_store->getId();
						    		$store_lang=substr($_store->getCode(),-2);
									if($store_lang=='jp')
									{
										$write->query("insert into core_config_data(scope,scope_id,path,value)values ('stores','$store_id','general/locale/code','zh_CN')");	
									}
									if($store_lang=='ma')
									{
										$write->query("insert into core_config_data(scope,scope_id,path,value)values ('stores','$store_id','general/locale/code','ms_MY')");	
									}               
									endforeach;
									
									$store_id_str=implode(",",$store_ids);
									
									$business_category=$post_data['business_category'];
									$cat = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name', $business_category);
									$business_categoryid=$cat->getFirstItem()->getEntityId();
									
									$query="insert into aitoc_aitpermissions_advancedrole(role_id,website_id,store_id,storeview_ids,category_ids,can_edit_global_attr,can_edit_own_products_only,can_create_products)
									VALUES($role_id,'0','$store_group_id','$store_id_str','$business_categoryid','1','1','1')";
									$stmt=$db->query($query);
									
									} catch (Exception $e) {
										//echo $e->getMessage();
										//exit;
									}
									
									//echo 'Admin User sucessfully created!<br /><br />';
									//Create Rule and User Code End		

									/* Merchant Mail Code End */
									$base_url=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
									$store_url=$base_url.$store_alias;
									$admin_url=$base_url.'admin';
									$store_password=$store_alias."@123";
									
									$templateId = 4; // Id is that created in admin email template 
						
									$from_email = Mage::getStoreConfig('trans_email/ident_general/email'); //fetch sender email Admin
									$from_name = Mage::getStoreConfig('trans_email/ident_general/name'); //fetch sender name Admin
									$coustomer_care = Mage::getStoreConfig('trans_email/ident_support/email'); //fetch sender email Admin
									$phne_num = Mage::getStoreConfig('general/store_information/phone'); //fetch sender name Admin
									$sender = Array('name' => $from_name,'email' => $from_email);
									$storeId = Mage::app()->getStore()->getId();
									//recipent info
									$recepientEmail = $email;
						   			$recepientName = $post_data['name'];
									$vars = Array();
									$vars = Array('customer_name'=>$post_data['name'],'admin_url'=>$admin_url,'store_alias'=>$store_alias,'store_password'=>$store_password,'store_url'=>$store_url,'coustomer_care'=>$coustomer_care,'phne_num'=>$phne_num );
									
									$translate = Mage::getSingleton('core/translate');
									Mage::getModel('core/email_template')->sendTransactional($templateId, $sender, $recepientEmail, $from_name, $vars, $storeId);
									$translate->setTranslateInline(true); 
									/* Merchant Mail Code End */
									
									/*super admin Mail Code Start */
									$customer_name= Mage::getStoreConfig('trans_email/ident_general/name');
									$templateId = 5; // Id is that created in admin email template 
									$merchant_name = $post_data['name'];
									$sender = Array('name' => $from_name,'email' => $from_email);
									//recipent info
									$recepientEmail = Mage::getStoreConfig('trans_email/ident_general/email');
						   			$recepientName = Mage::getStoreConfig('trans_email/ident_general/name');
									
									$vars = Array();
									$vars = Array('customer_name'=>$customer_name,'admin_url'=>$admin_url,'merchant_name'=>$merchant_name);
									$translate = Mage::getSingleton('core/translate');
									
									Mage::getModel('core/email_template')->sendTransactional($templateId, $sender, $recepientEmail, $from_name, $vars, $storeId);
									$translate->setTranslateInline(true); 
									/*super admin Mail Code End */
							}
						}
						else
						{
							$collection = Mage::getModel("merchant/merchnat")->getCollection()->addFilter('id',$req_id);
							$data1=$collection->getData();
							$status=$data1[0]['status'];
							$store_alias=$data1[0]['store_alias'];
							$site = Mage::getResourceModel('core/website_collection')->addFieldToFilter('name', $store_alias);
							if(count($site->getData())>0)
							{
								//echo "yes";die;
							}
							else
							{
								$business_category=$data1[0]['business_category'];
								$cat = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name', $business_category);
								$business_categoryid=$cat->getFirstItem()->getEntityId();	
								
								
								//Create Website and Store Code Start
									$website_name=$store_alias;
									$file_name=$root_path."/index_website.php";
									$file_cng_path=$root_path."/".$website_name."/index.php";
									
									//Create Folder for website and copy 2 files Start
									mkdir($root_path."/".$website_name, 0755);
									copy($file_name, $file_cng_path);
									copy($root_path."/.htaccess", $root_path."/".$website_name."/.htaccess");
									//Create Folder for website and copy 2 End
									
									//Edit index.php file for change website name Start 
									$filecontent=file_get_contents($file_cng_path);
									$pos=strpos($filecontent, 'Mage::run($mageRunCode, $mageRunType)');
									$string='Mage::run("'.$website_name.'", "website");';
									$filecontent=substr($filecontent, 0, $pos)."\r\n".$string."\r\n".substr($filecontent, $pos);
									$filecontent=str_replace('Mage::run($mageRunCode, $mageRunType);','',$filecontent);
									file_put_contents($file_cng_path, $filecontent);
									//Edit index.php file for change website name End
									
									//die;
									//Create Website, store in admin Start 
									
									Mage::registry('isSecureArea');
									//#addWebsite
								    /** @var $website Mage_Core_Model_Website */
								    $website = Mage::getModel('core/website');
								    $website->setCode($website_name)
								        ->setName($website_name)
								        ->save();
								        
								        
								    $write = Mage::getSingleton('core/resource')->getConnection('core_write');
								
								    $new_web_url=$base_url.$website_name."/";
								
								    //$site =  Mage::getModel('core/website')->getCollection()->getAllIds();
								    //$website_id=max($site);
								    $website_id=$website->getId();
								    
									// now $write is an instance of Zend_Db_Adapter_Abstract
									$write->query("insert into core_config_data (scope,scope_id,path,value)values ('websites','$website_id','web/unsecure/base_url','$new_web_url')");
									$write->query("insert into core_config_data (scope,scope_id,path,value)values ('websites','$website_id','web/unsecure/base_link_url','$new_web_url')");
									$write->query("insert into core_config_data (scope,scope_id,path,value)values ('websites','$website_id','web/unsecure/base_skin_url','$skin_url')");
									$write->query("insert into core_config_data (scope,scope_id,path,value)values ('websites','$website_id','web/unsecure/base_media_url','$media_url')");
									$write->query("insert into core_config_data (scope,scope_id,path,value)values ('websites','$website_id','web/unsecure/base_js_url','$js_url')");
									$write->query("insert into core_config_data (scope,scope_id,path,value)values ('websites','$website_id','design/theme/template','merchant')");
									$write->query("insert into core_config_data (scope,scope_id,path,value)values ('websites','$website_id','design/theme/skin','green')");
									$write->query("insert into core_config_data (scope,scope_id,path,value)values ('websites','$website_id','design/theme/layout','merchant')");
								    
								
										//#addStoreGroup
								    	/* @var $storeGroup Mage_Core_Model_Store_Group */
								    	
								        $storeGroup = Mage::getModel('core/store_group');
								    	$storeGroup->setWebsiteId($website->getId())
								        ->setName($website_name)
								        ->setRootCategoryId(2)
								        ->save();
								
										//#addStore
								    	/* @var $store Mage_Core_Model_Store */
								    	$store = Mage::getModel('core/store');
								    	$store->setCode($website_name.'_en')
								        ->setWebsiteId($storeGroup->getWebsiteId())
								        ->setGroupId($storeGroup->getId())
								        ->setName('English')
								        ->setIsActive(1)
								        ->save();
								        
								        $store1 = Mage::getModel('core/store');
								    	$store1->setCode($website_name.'_ma')
								        ->setWebsiteId($storeGroup->getWebsiteId())
								        ->setGroupId($storeGroup->getId())
								        ->setName('Malay')
								        ->setIsActive(1)
								        ->save();
								        
								        $store2 = Mage::getModel('core/store');
								    	$store2->setCode($website_name.'_jp')
								        ->setWebsiteId($storeGroup->getWebsiteId())
								        ->setGroupId($storeGroup->getId())
								        ->setName('Chinese')
								        ->setIsActive(1)
								        ->save();
								        
								        //Create Website and store code End
										
							        
									//Create Rule and User Code Start
							
									try {
									$user = Mage::getModel('admin/user')
											->setData(array(
											'username'  => $store_alias,
											'firstname' => $first_name,
											'lastname'  => $last_name,
											'email'     => $email,
											'password'  => $store_alias.'@123',
											'is_active' => 1
											))->save();
									} 
									catch(Exception $e)
									{
										//echo $e->getMessage();
										//exit;
									}
									
									try {
									//create new role
									$role = Mage::getModel("admin/roles")
									->setName($store_alias)
									->setRoleType('G')
									->save();
									
									$resources=array();
									$resources = explode(',', '__root__,admin/dashboard,admin/system,admin/system/config,admin/system/config/general,admin/system/config/web,admin/system/config/design,admin/system/config/trans_email,admin/system/config/payment,admin/system/config/carriers,admin/system/config/paypal,admin/system/config/contacts,admin/system/cache,admin/system/index,admin/cms,admin/cms/block,admin/cms/page,admin/cms/page/save,admin/cms/page/delete,admin/customer,admin/customer/group,admin/customer/manage,admin/customer/online,admin/catalog,admin/catalog/categories,admin/catalog/products,admin/catalog/urlrewrite,admin/catalog/reviews_ratings,admin/catalog/reviews_ratings/reviews,admin/catalog/reviews_ratings/reviews/all,admin/catalog/reviews_ratings/reviews/pending,admin/catalog/reviews_ratings/ratings,admin/promo,admin/promo/catalog,admin/promo/quote,admin/sales,admin/sales/order,admin/sales/order/actions,admin/sales/order/actions/create,admin/sales/order/actions/view,admin/sales/order/actions/email,admin/sales/order/actions/reorder,admin/sales/order/actions/edit,admin/sales/order/actions/cancel,admin/sales/order/actions/review_payment,admin/sales/order/actions/capture,admin/sales/order/actions/invoice,admin/sales/order/actions/creditmemo,admin/sales/order/actions/hold,admin/sales/order/actions/unhold,admin/sales/order/actions/ship,admin/sales/order/actions/comment,admin/sales/order/actions/emails,admin/sales/invoice,admin/sales/shipment,admin/sales/creditmemo,admin/sales/recurring_profile,admin/sales/checkoutagreement,admin/logo,admin/logo/logo,admin/slider,admin/slider/slider,admin/webenquiry,admin/webenquiry/webenquiry');
									
									//give "all" privileges to role
									Mage::getModel("admin/rules")
									->setRoleId($role->getId())
									->setResources($resources)
									->saveRel();
									} catch (Mage_Core_Exception $e) {
										//echo $e->getMessage();
										//exit;
									} catch (Exception $e) {
										//echo 'Error while saving role.';
										//exit;
									}
									
									
									try {
									//assign user to role
									$user->setRoleIds(array($role->getId()))
									->setRoleUserId($user->getUserId())
									->saveRelations();
									
									$role_id=$role->getId();
									
									$store_model = Mage::getModel('core/store');
									$store_ids=array();
									$store_group_id=$storeGroup->getId();
									$stores = $store_model->getCollection()->addGroupFilter($store_group_id);   //get the stores from the existing store group         
									foreach ($stores as $_store):
							    	$store_ids[] = $_store->getId(); //get store id   
									$store_id=$_store->getId();
						    		$store_lang=substr($_store->getCode(),-2);
									if($store_lang=='jp')
									{
										$write->query("insert into core_config_data(scope,scope_id,path,value)values ('stores','$store_id','general/locale/code','zh_CN')");	
									}
									if($store_lang=='ma')
									{
										$write->query("insert into core_config_data(scope,scope_id,path,value)values ('stores','$store_id','general/locale/code','ms_MY')");	
									}             
									endforeach;
									
									$store_id_str=implode(",",$store_ids);
									
									$query="insert into aitoc_aitpermissions_advancedrole(role_id,website_id,store_id,storeview_ids,category_ids,can_edit_global_attr,can_edit_own_products_only,can_create_products)
									VALUES($role_id,'0','$store_group_id','$store_id_str','$business_categoryid','1','0','1')";
									$stmt=$db->query($query);
									
									} catch (Exception $e) {
										//echo $e->getMessage();
										//exit;
									}
									
									//echo 'Admin User sucessfully created!<br /><br />';
									//Create Rule and User Code End			
									
									
									/* Merchant Mail Code End */
									$base_url=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
									$store_url=$base_url.$store_alias;
									$admin_url=$base_url.'admin';
									$store_password=$store_alias."@123";
									
									$templateId = 4; // Id is that created in admin email template 
						
									$from_email = Mage::getStoreConfig('trans_email/ident_general/email'); //fetch sender email Admin
									$from_name = Mage::getStoreConfig('trans_email/ident_general/name'); //fetch sender name Admin
									$coustomer_care = Mage::getStoreConfig('trans_email/ident_support/email'); //fetch sender email Admin
									$phne_num = Mage::getStoreConfig('general/store_information/phone'); //fetch sender name Admin
									$sender = Array('name' => $from_name,'email' => $from_email);
									$storeId = Mage::app()->getStore()->getId();
									//recipent info
									$recepientEmail = $email;
						   			$recepientName = $post_data['name'];
									$vars = Array();
									$vars = Array('customer_name'=>$post_data['name'],'admin_url'=>$admin_url,'store_alias'=>$store_alias,'store_password'=>$store_password,'store_url'=>$store_url,'coustomer_care'=>$coustomer_care,'phne_num'=>$phne_num );
									
									$translate = Mage::getSingleton('core/translate');
									Mage::getModel('core/email_template')->sendTransactional($templateId, $sender, $recepientEmail, $from_name, $vars, $storeId);
									$translate->setTranslateInline(true); 
									/* Merchant Mail Code End */
									
									/*super admin Mail Code Start */
									$customer_name= Mage::getStoreConfig('trans_email/ident_general/name');
									$templateId = 5; // Id is that created in admin email template 
									$merchant_name = $post_data['name'];
									$sender = Array('name' => $from_name,'email' => $from_email);
									//recipent info
									$recepientEmail = Mage::getStoreConfig('trans_email/ident_general/email');
						   			$recepientName = Mage::getStoreConfig('trans_email/ident_general/name');
									
									$vars = Array();
									$vars = Array('customer_name'=>$customer_name,'admin_url'=>$admin_url,'merchant_name'=>$merchant_name);
									$translate = Mage::getSingleton('core/translate');
									
									Mage::getModel('core/email_template')->sendTransactional($templateId, $sender, $recepientEmail, $from_name, $vars, $storeId);
									$translate->setTranslateInline(true); 
									/*super admin Mail Code End */
									
									
								
							}
						}

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Merchant was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setMerchnatData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setMerchnatData($this->getRequest()->getPost());
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
						$model = Mage::getModel("merchant/merchnat");
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
                      $model = Mage::getModel("merchant/merchnat");
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
			$fileName   = 'merchnat.csv';
			$grid       = $this->getLayout()->createBlock('merchant/adminhtml_merchnat_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'merchnat.xml';
			$grid       = $this->getLayout()->createBlock('merchant/adminhtml_merchnat_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
