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
$numdays=365;
$startdate = date('y:m:d');   
$enddate = Date('y:m:d', strtotime("+".$numdays." days"));
foreach($res as $key=>$value)
{
	$id=$value['id'];
	$insert1="INSERT INTO `merchant_plan_info` 
		(`merchant_id`, `plan_id`, `start_date`, `end_date`, `update_date`, `max_sku`) 
			VALUES ('$id', '4536', '$startdate', '$enddate', '$startdate', '1000');";
	$stmt=$db->query($insert1);
}
?>