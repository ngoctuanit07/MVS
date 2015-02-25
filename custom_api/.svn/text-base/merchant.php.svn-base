<?php 
include_once "../app/Mage.php";
Mage::init();

$base_url=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
$root_path=Mage::getBaseDir();
$base_url=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
$skin_url= Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN);
$media_url= Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA); 
$js_url= Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_JS);

ini_set("max_execution_time", 0);

$db = Mage::getSingleton('core/resource')->getConnection('core_write');
$db->exec("SET @@session.wait_timeout = 1200");

define('SITE_URL',$base_url);

//$query="select * from jos_eshoppingmall_merchant order by id";
$query="select * from jos_eshoppingmall_merchant where id='32'";
$stmt=$db->query($query);
$stmt->execute();
$res = $stmt->fetchAll();

foreach($res as $key=>$value)
{
	$name=addslashes($value['name']);
	
	$name_array=explode(" ",$value['name']);
	$first_name=$name_array[0];
	$last_name=$name_array[1];
	if($last_name=='')
	{ $last_name='last'; }
	
	$email=addslashes($value['email']);
	$store_name=addslashes($value['store_name']);
	$store_url_arr=explode(".eshoppingmall.com.my",$value['store_url']);
	$store_alias=strip_tags(addslashes($store_url_arr[0]));
	$store_alias = preg_replace('/[^A-Za-z0-9\. -]/','', $store_alias);
	$store_alias=strtolower($store_alias);
	
	
	//Create Customer Start						
	$customer = Mage::getModel('customer/customer');
	$password = '123456';
	
	$email_arr=explode(",",$email);
	$email=$email_arr[0];
	
	$name_array=explode(" ",$value['name']);
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
	
	
	
	$query="select name from jos_eshoppingmall_business_category where id='".$value['business_category']."'";
	$stmt=$db->query($query);
	$stmt->execute();
	$res = $stmt->fetch();
	
	$business_category=addslashes($res['name']);
	$cat = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name', $business_category);
	$business_categoryid=$cat->getFirstItem()->getEntityId();
	
	$merchant_plan='Default';
	$owner_company_name=addslashes($value['owner_company']);
	$registration_no=addslashes($value['registration_no']);
	$address=addslashes($value['address_line_1'])." ".addslashes($value['address_line_2'])." ".addslashes($value['address_line_3']);
	$city=addslashes($value['city']);
	$state=addslashes($value['state']);
	$postcode=addslashes($value['postcode']);
	$country=addslashes($value['country']);
	$telephone=addslashes($value['tel']);
	$fax=addslashes($value['fax']);
	$order_status='Default';
	$status='0';
	
	try 
	{
		$query="INSERT INTO `merchant` (`name`, `email`, `store_name`, `store_alias`, `business_category`, `merchant_plan`, `owner_company_name`, `registration_no`, `address`, `city`, `state`, `postcode`, `country`, `telephone`, `fax`, `order_status`, `status`) 
		VALUES ('$name', '$email', '$store_name', '$store_alias', '$business_category', '$merchant_plan', '$owner_company_name',
		 '$registration_no', '$address', '$city', '$state', '$postcode', '$country', '$telephone', '$fax', '$order_status','$status')";
		//echo $query."<br>";
		$stmt=$db->query($query);
		$merchant_id=$db->lastInsertId(); 
		echo "$merchant_id Merchant Added Successfully<br><br>";
		
		
		$customer = Mage::getModel('customer/customer');
		$password = '123456';
		$email = $email;
		$name_array=explode(" ",$name);
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
		    $customer->sendNewAccountEmail();
		}
		catch (Exception $ex) {
		    //Zend_Debug::dump($ex->getMessage());
		}

		
		
		//Create Website and Store Code Start
		
		$website_name=$store_alias;
		$file_name=$root_path."/index_website.php";
		$file_cng_path=$root_path."/".$website_name."/index.php";
		
		//Create Folder for website and copy 2 files Start
		mkdir($root_path."/".$website_name, 0777);
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
				'firstname' => $last_name,
				'lastname'  => $last_name,
				'email'     => $email,
				'password'  => $store_alias.'@123',
				'is_active' => 1
				))->save();
		} 
		catch(Exception $e)
		{
			echo $e->getMessage();
			exit;
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
		echo $e->getMessage();
		exit;
		} catch (Exception $e) {
		echo 'Error while saving role.';
		exit;
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
		echo $e->getMessage();
		exit;
		}
		
		echo 'Admin User sucessfully created!<br /><br />';
		//Create Rule and User Code End
	}
	catch (SoapFault $e) 
	{
		echo '<br><br>Error in Customer web service: '.$e->getMessage();
	}
}
?>