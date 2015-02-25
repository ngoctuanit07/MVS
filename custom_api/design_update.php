<?php
include_once "../app/Mage.php";
Mage::init();

$base_url=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);

ini_set("max_execution_time", 0);

$db = Mage::getSingleton('core/resource')->getConnection('core_write');
$db->exec("SET @@session.wait_timeout = 1200");

define('SITE_URL',$base_url);


$query="SELECT * FROM `core_config_data` WHERE `scope_id` not in(20,0,1) and `scope`='websites' group by `scope_id`";
$stmt=$db->query($query);
$stmt->execute();
$res = $stmt->fetchAll();

$array=array();
foreach($res as $key=>$value)
{
	$scope_id=$value['scope_id'];
	$insert1="insert into core_config_data (scope,scope_id,path,value) VALUES('websites','".$scope_id."','design/theme/template','merchant')";
	$stmt=$db->query($insert1);
	
	$insert2="insert into core_config_data (scope,scope_id,path,value) VALUES('websites','".$scope_id."','design/theme/skin','green')";
	$stmt=$db->query($insert2);
	
	$insert3="insert into core_config_data (scope,scope_id,path,value) VALUES('websites','".$scope_id."','design/theme/layout','merchant')";
	$stmt=$db->query($insert3);	
}


?>