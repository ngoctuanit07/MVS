<?php
include_once "../app/Mage.php";
Mage::init();

$base_url=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);

ini_set("max_execution_time", 0);

$db = Mage::getSingleton('core/resource')->getConnection('core_write');
$db->exec("SET @@session.wait_timeout = 1200");

define('SITE_URL',$base_url);

$enddate5 = date('Y-m-d', strtotime(' +5 day'));
$enddate1 = date('Y-m-d', strtotime(' +1 day'));
$enddate_1 = date('Y-m-d', strtotime(' -1 day'));

//$query="SELECT merchant_id FROM merchant_plan_info WHERE end_date between now() and '$enddate5'";
//$query="SELECT merchant_id FROM merchant_plan_info WHERE end_date between '$enddate_1' and now()";
//mail for 5days
$query="SELECT merchant_id FROM merchant_plan_info WHERE end_date = '$enddate5'"; 
$stmt=$db->query($query);
$stmt->execute();
$res = $stmt->fetchAll();
$midarray5=array();
foreach ($res as $mid)
{
	$midarray5[] = $mid[merchant_id];
}
 

$mids = implode(",", $midarray5);
if($mids==''){ $mids="''"; }

$query = "SELECT email,store_name  FROM merchant WHERE id IN ($mids)";
$stmt=$db->query($query);
$stmt->execute();
$res = $stmt->fetchAll();
$emailarray5=array();

$customer = Mage::getModel("customer/customer");
//$customer->loadByEmail($customer_email); //load customer by email id
//use

/*foreach ($res as $email)
{
	$email = explode( ',', $email[email]);
	$emailarray5[] = $email[0];
}
echo"<pre>";
print_r($emailarray5);*/


foreach ($res as $email )
{
	$store_name =  $email['store_name'];
	$email = explode( ',', $email['email']);
	$email = $email[0];
	$customer->loadByEmail($email);
	
			/* Merchant Mail Code End */
			$base_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
			$merchant_name = $customer->getName();
			$number_days = 5;
			
			$templateId = 7; // Id is that created in admin email template 

			$from_email = Mage::getStoreConfig('trans_email/ident_general/email'); //fetch sender email Admin
			$from_name = Mage::getStoreConfig('trans_email/ident_general/name'); //fetch sender name Admin
			$coustomer_care = Mage::getStoreConfig('trans_email/ident_support/email'); //fetch sender email Admin
			$phne_num = Mage::getStoreConfig('general/store_information/phone'); //fetch sender name Admin
			$sender = Array('name' => $from_name,'email' => $from_email);
			
			
			//recipent info
			$recepientEmail = $email;
			$recepientName = $merchant_name;
			$vars = Array();
			$vars = Array('store_name'=>$store_name,'number_days'=>$number_days, 'coustomer_care'=>$coustomer_care,'phne_num'=>$phne_num, 'merchant_name'=>$merchant_name );
			
			$translate = Mage::getSingleton('core/translate');
			Mage::getModel('core/email_template')->sendTransactional($templateId, $sender, $recepientEmail, $from_name, $vars);
			$translate->setTranslateInline(true); 	
}


// mail one day left
$query="SELECT merchant_id FROM merchant_plan_info WHERE end_date = '$enddate1'"; 
$stmt=$db->query($query);
$stmt->execute();
$res = $stmt->fetchAll();
$midarray1=array();
foreach ($res as $mid)
{
	$midarray1[] = $mid[merchant_id];
}


$mids = implode(",", $midarray1);
if($mids==''){ $mids="''"; }

$query = "SELECT email,store_name  FROM merchant WHERE id IN ($mids)";
$stmt=$db->query($query);
$stmt->execute();
$res = $stmt->fetchAll();
$emailarray1=array();

$customer = Mage::getModel("customer/customer");
$customer->loadByEmail($customer_email); //load customer by email id
//use
//$customer->getId();
//$customer->getFirstName();
/*foreach ($res as $email)
{
	$email = explode( ',', $email[email]);
	$emailarray5[] = $email[0];
}
echo"<pre>";
print_r($emailarray5);*/

foreach ($res as $email )
{
	$store_name =  $email['store_name'];
	$email = explode( ',', $email['email']);
	$email = $email[0];
	$customer->loadByEmail($email);
	
			/* Merchant Mail Code End */
			$base_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
			
			$merchant_name = $customer->getName();
			$number_days = 1;
			
			$templateId = 7; // Id is that created in admin email template 

			$from_email = Mage::getStoreConfig('trans_email/ident_general/email'); //fetch sender email Admin
			$from_name = Mage::getStoreConfig('trans_email/ident_general/name'); //fetch sender name Admin
			$coustomer_care = Mage::getStoreConfig('trans_email/ident_support/email'); //fetch sender email Admin
			$phne_num = Mage::getStoreConfig('general/store_information/phone'); //fetch sender name Admin
			$sender = Array('name' => $from_name,'email' => $from_email);
			
			
			//recipent info
			$recepientEmail = $email;
			$recepientName = $merchant_name;
			$vars = Array();
			$vars = Array('store_name'=>$store_name,'number_days'=>$number_days, 'coustomer_care'=>$coustomer_care,'phne_num'=>$phne_num, 'merchant_name'=>$merchant_name );
			
			$translate = Mage::getSingleton('core/translate');
			Mage::getModel('core/email_template')->sendTransactional($templateId, $sender, $recepientEmail, $from_name, $vars);
		    $translate->setTranslateInline(true);	
}

// mail expired
$query="SELECT merchant_id FROM merchant_plan_info WHERE end_date = '$enddate_1'"; 
$stmt=$db->query($query);
$stmt->execute();
$res = $stmt->fetchAll();
$midarray_1=array();
foreach ($res as $mid)
{
	$midarray_1[] = $mid[merchant_id];
}


$mids = implode(",", $midarray_1);
if($mids==''){ $mids="''"; }

$query = "SELECT email,store_name  FROM merchant WHERE id IN ($mids)";
$stmt=$db->query($query);
$stmt->execute();
$res = $stmt->fetchAll();
$emailarray_1=array();

$customer = Mage::getModel("customer/customer");
$customer->loadByEmail($customer_email); //load customer by email id
//use
/*echo $customer->getId();
echo $customer->getFirstName();*/
/*foreach ($res as $email)
{
	$email = explode( ',', $email[email]);
	$emailarray5[] = $email[0];
}
echo"<pre>";
print_r($emailarray5);*/
foreach ($res as $email )
{
	$store_name =  $email['store_name'];
	$email = explode( ',', $email['email']);
	$email = $email[0];
	$customer->loadByEmail($email);
	
			/* Merchant Mail Code End */
			$base_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
			$merchant_name = $customer->getName();
			//$number_days = 5;
			
			$templateId = 8; // Id is that created in admin email template 

			$from_email = Mage::getStoreConfig('trans_email/ident_general/email'); //fetch sender email Admin
			$from_name = Mage::getStoreConfig('trans_email/ident_general/name'); //fetch sender name Admin
			$coustomer_care = Mage::getStoreConfig('trans_email/ident_support/email'); //fetch sender email Admin
			$phne_num = Mage::getStoreConfig('general/store_information/phone'); //fetch sender name Admin
			$sender = Array('name' => $from_name,'email' => $from_email);
			
			
			//recipent info
			$recepientEmail = $email;
			$recepientName = $merchant_name;
			$vars = Array();
			$vars = Array('store_name'=>$store_name,'number_days'=>$number_days, 'coustomer_care'=>$coustomer_care,'phne_num'=>$phne_num, 'merchant_name'=>$merchant_name );
			
			$translate = Mage::getSingleton('core/translate');
			Mage::getModel('core/email_template')->sendTransactional($templateId, $sender, $recepientEmail, $from_name, $vars);
			$translate->setTranslateInline(true);
}
// mail expired
$query="SELECT merchant_id FROM merchant_plan_info WHERE end_date = '$enddate_1'"; 
$stmt=$db->query($query);
$stmt->execute();
$res = $stmt->fetchAll();
$midarray_1=array();
foreach ($res as $mid)
{
	$midarray_1[] = $mid[merchant_id];
}


$mids = implode(",", $midarray_1);
if($mids==''){ $mids="''"; }


$query = "SELECT email,store_name  FROM merchant WHERE id IN ($mids)";
$stmt=$db->query($query);
$stmt->execute();
$res = $stmt->fetchAll();
$emailarray_1=array();

$customer = Mage::getModel("customer/customer");
$customer->loadByEmail($customer_email); //load customer by email id
//use
/*echo $customer->getId();
echo $customer->getFirstName();*/
/*foreach ($res as $email)
{
	$email = explode( ',', $email[email]);
	$emailarray5[] = $email[0];
}
echo"<pre>";
print_r($emailarray5);*/
foreach ($res as $email )
{
	$store_name =  $email['store_name'];
	$email = explode( ',', $email['email']);
	$email = $email[0];
	$customer->loadByEmail($email);
	
			/* Merchant Mail Code End */
			$base_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
			$merchant_name = $customer->getName();
			
			$templateId = 9; // Id is that created in admin email template 

			$from_email = Mage::getStoreConfig('trans_email/ident_general/email'); //fetch sender email Admin
			$from_name = Mage::getStoreConfig('trans_email/ident_general/name'); //fetch sender name Admin
			$coustomer_care = Mage::getStoreConfig('trans_email/ident_support/email'); //fetch sender email Admin
			$phne_num = Mage::getStoreConfig('general/store_information/phone'); //fetch sender name Admin
			$sender = Array('name' => $from_name,'email' => $from_email);
			
			
			//recipent info
			$recepientEmail = Mage::getStoreConfig('trans_email/ident_general/email');
   			$recepientName = $merchant_name;
			$vars = Array();
			$vars = Array('store_name'=>$store_name,'coustomer_care'=>$coustomer_care,'phne_num'=>$phne_num, 'merchant_name'=>$merchant_name, 'mer_email'=>$mer_email);
			
			$translate = Mage::getSingleton('core/translate');
			Mage::getModel('core/email_template')->sendTransactional($templateId, $sender, $recepientEmail, $from_name, $vars);
			$translate->setTranslateInline(true);		
}

?>