<?php
include_once "../app/Mage.php";
Mage::init();

$base_url=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);

ini_set("max_execution_time", 0);

$db = Mage::getSingleton('core/resource')->getConnection('core_write');
$db->exec("SET @@session.wait_timeout = 1200");

define('SITE_URL',$base_url);


$query="SELECT resource_id from admin_rule where permission='allow' and role_id='52'";
$stmt=$db->query($query);
$stmt->execute();
$res = $stmt->fetchAll();

$array=array();
foreach($res as $key=>$value)
{
	$array[]=$value['resource_id'];
}


echo $str= implode(",",$array);
echo "<br><br><br><br>";

$str= implode("','",$array);
echo $new_str= "'$str'";
echo "<br><br><br>";

echo $query1="update admin_rule set permission='deny' where role_id!='1'"."<br><br>";
echo $query2="update admin_rule set permission='allow' where resource_id in($new_str)";


echo "<pre>";
print_r($array);
die;



//echo "update admin_rule set permission='allow' where resource_id in('admin/dashboard','admin/system','admin/system/config','admin/system/config/general','admin/system/config/web','admin/system/config/design','admin/system/config/trans_email','admin/system/config/payment','admin/system/config/carriers','admin/system/config/paypal','admin/system/config/contacts','admin/system/cache','admin/system/index','admin/cms','admin/cms/block','admin/cms/page','admin/cms/page/save','admin/cms/page/delete','admin/customer','admin/customer/group','admin/customer/manage','admin/customer/online','admin/catalog','admin/catalog/categories','admin/catalog/products','admin/catalog/urlrewrite','admin/catalog/reviews_ratings','admin/catalog/reviews_ratings/reviews','admin/catalog/reviews_ratings/reviews/all','admin/catalog/reviews_ratings/reviews/pending','admin/catalog/reviews_ratings/ratings','admin/promo','admin/promo/catalog','admin/promo/quote','admin/sales','admin/sales/order','admin/sales/order/actions','admin/sales/order/actions/create','admin/sales/order/actions/view','admin/sales/order/actions/email','admin/sales/order/actions/reorder','admin/sales/order/actions/edit','admin/sales/order/actions/cancel','admin/sales/order/actions/review_payment','admin/sales/order/actions/capture','admin/sales/order/actions/invoice','admin/sales/order/actions/creditmemo','admin/sales/order/actions/hold','admin/sales/order/actions/unhold','admin/sales/order/actions/ship','admin/sales/order/actions/comment','admin/sales/order/actions/emails','admin/sales/invoice','admin/sales/shipment','admin/sales/creditmemo','admin/sales/recurring_profile','admin/sales/checkoutagreement','admin/logo','admin/logo/logo','admin/slider','admin/slider/slider','admin/webenquiry','admin/webenquiry/webenquiry')";

try {
		$user = Mage::getModel('admin/user')
				->setData(array(
				'username'  => 'test',
				'firstname' => 'Test',
				'lastname'    => 'Last',
				'email'     => 'test@test.com',
				'password'  =>'test@123',
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
->setName('test')
->setRoleType('G')
->save();

$resources = explode(',', '__root__,admin/catalog,admin/catalog/categories,admin/catalog/products,admin/catalog/reviews_ratings,admin/catalog/reviews_ratings/ratings,admin/catalog/reviews_ratings/reviews,admin/catalog/reviews_ratings/reviews/all,admin/catalog/reviews_ratings/reviews/pending,admin/catalog/urlrewrite,admin/customer,admin/customer/group,admin/customer/manage,admin/customer/online,admin/dashboard,admin/promo,admin/promo/catalog,admin/promo/quote,admin/sales,admin/sales/checkoutagreement,admin/sales/creditmemo,admin/sales/invoice,admin/sales/order,admin/sales/order/actions,admin/sales/order/actions/cancel,admin/sales/order/actions/capture,admin/sales/order/actions/comment,admin/sales/order/actions/create,admin/sales/order/actions/creditmemo,admin/sales/order/actions/edit,admin/sales/order/actions/email,admin/sales/order/actions/emails,admin/sales/order/actions/hold,admin/sales/order/actions/invoice,admin/sales/order/actions/reorder,admin/sales/order/actions/review_payment,admin/sales/order/actions/ship,admin/sales/order/actions/unhold,admin/sales/order/actions/view,admin/sales/shipment,admin/system,admin/system/cache,admin/system/config,admin/system/config/carriers,admin/system/config/design,admin/system/config/payment,admin/system/config/paypal,admin/system/config/trans_email,admin/system/design,admin/system/index');

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


} catch (Exception $e) {
echo $e->getMessage();
exit;
}
$role_id=$role->getId();
$query="insert into aitoc_aitpermissions_advancedrole (role_id,website_id,store_id,can_edit_global_attr,can_edit_own_products_only,can_create_products)
VALUES($role_id,'1','0','0','1','1')";
$stmt=$db->query($query);


echo 'Admin User sucessfully created!<br /><br /><b>THIS FILE WILL NOW TRY TO DELETE ITSELF, BUT PLEASE CHECK TO BE SURE!</b>';



?>