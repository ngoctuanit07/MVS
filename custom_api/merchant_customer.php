<?php 
include_once "../app/Mage.php";
Mage::init();

$base_url=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);

ini_set("max_execution_time", 0);

$db = Mage::getSingleton('core/resource')->getConnection('core_write');
$db->exec("SET @@session.wait_timeout = 1200");

define('SITE_URL',$base_url);


$query="select * from merchant";

$stmt=$db->query($query);
$stmt->execute();
$res = $stmt->fetchAll();

//echo "<pre>";print_r($res);die;

foreach($res as $key=>$value)
{
	$name_array=explode(" ",$value['name']);
	$first_name=$name_array[0];
	$last_name=$name_array[1];
	if($last_name=='')
	{ $last_name='last'; }
	$email_arr=explode(",",$value['email']);
	$email=$email_arr[0];
	$password='123456';
	
	//Create Customer Start						
	$customer = Mage::getModel('customer/customer');
	
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
	else
	{
		$customer->setGroupId(4);
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
		
}
?>