<?php
require_once('app/Mage.php'); //Path to Magento
umask(0);
Mage::app();
//get values from session	
$email = $_REQUEST['email'];
$store_alias = $_REQUEST['store_alias'];
$store_aliasl = $_REQUEST['store_aliasl'];
$usersa = $_REQUEST['usersa'];
//email validations
if (isset($email))
{
	if(filter_var($email, FILTER_VALIDATE_EMAIL)) 
	{
/*$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
$select = $connection->select()
->from ('merchant', array('*'))
->where ('email=?',$email);
$rowsArray = $connection->fetchAll($select);        
$msg = count($rowsArray);*/

$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
$select = $connection->select()
->from ('customer_entity', array('*'))
->where ("email='$email' or email like '$email,%' or email like '%,$email,%' or email like '%,$email%' ");
$rowsArray = $connection->fetchAll($select);        
$msg = count($rowsArray);
	}
	echo $msg;
}
//store alias validation	
else if (isset($store_alias))
{
$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
$select = $connection->select()
->from ('merchant', array('*'))
->where ('store_alias=?',$store_alias);
$rowsArray = $connection->fetchAll($select);        
$msg = count($rowsArray);
echo $msg;
}
//get store id after validation
/*else if (isset($store_aliasl))
{
$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
$select = $connection->select()
->from ('merchant', array('*'))
->where ('store_alias=?',$store_aliasl);
$rowsArray = $connection->fetchAll($select);        
$msg = count($rowsArray);
echo $msg;
}
else if (isset($usersa))
{
	$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
	$select = $connection->select()
	->from ('merchant', array('store_alias'))
	->where ('email=?',$usersa);
	$rowsArray = $connection->fetchAll($select);
	echo $rowsArray[0][store_alias];
}*/
?>
