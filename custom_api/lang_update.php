<?php
include_once "../app/Mage.php";
Mage::init();

$base_url=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);

ini_set("max_execution_time", 0);

$db = Mage::getSingleton('core/resource')->getConnection('core_write');
$db->exec("SET @@session.wait_timeout = 1200");

define('SITE_URL',$base_url);


$store_model = Mage::getModel('core/store');
$store_ids=array();
//$store_group_id=$storeGroup->getId();
$stores = $store_model->getCollection();   //get the stores from the existing store group
//echo "<pre>";
//print_r($stores->getData());die;


foreach ($stores as $_store):
    //$store_ids[] = $_store->getId(); //get store id
    $store_id=$_store->getId();
    $store_lang=substr($_store->getCode(),-2);
	if($store_lang=='jp')
	{
		$q1=$db->query("select * from core_config_data where scope_id='$store_id' and path='general/locale/code' and value='zh_CN'");
		//echo $q1->rowCount()."<br>";
		if($q1->rowCount()==0)
		{
			$db->query("insert into core_config_data(scope,scope_id,path,value)values ('stores','$store_id','general/locale/code','zh_CN')");
		}
			
	}
	if($store_lang=='ma')
	{
		$q1=$db->query("select * from core_config_data where scope_id='$store_id' and path='general/locale/code' and value='ms_MY'");
		//echo $q1->rowCount()."<br>";
		if($q1->rowCount()==0)
		{
			$db->query("insert into core_config_data(scope,scope_id,path,value)values ('stores','$store_id','general/locale/code','ms_MY')");
		}
	}
endforeach;
?>