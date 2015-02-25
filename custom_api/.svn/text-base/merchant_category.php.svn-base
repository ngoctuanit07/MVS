<?php 
ini_set("max_execution_time", 0);
include_once "../app/Mage.php";
Mage::init();

$base_url=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);

ini_set("max_execution_time", 0);

$db = Mage::getSingleton('core/resource')->getConnection('core_write');
$db->exec("SET @@session.wait_timeout = 1200");

define('SITE_URL',$base_url);

class migrationApi {
    public $proxy;
    public $sessionId;
         
    public function __construct(){
        $this->proxy = new SoapClient(SITE_URL.'index.php/api/soap/?wsdl');
        $this->sessionId = $this->proxy->login('vimalparihar', '123456');
    }
   
   	public function createCategory($root_categoryid,$params,$store_id) {
        return $this->proxy->call($this->sessionId, 'catalog_category.create', array($root_categoryid,$params,$store_id));
    }
	
}

$api = new migrationApi();

//$query="select a.*,b.store_url,b.business_category,c.name as business_cat_name from jos_eshoppingmall_product_category as a left join jos_eshoppingmall_merchant as b on a.merchant=b.id left join jos_eshoppingmall_business_category as c on b.business_category=c.id where b.store_url!='' order by a.id";
$query="select a.*,b.store_url,b.business_category,c.name as business_cat_name from jos_eshoppingmall_product_category as a left join jos_eshoppingmall_merchant as b on a.merchant=b.id left join jos_eshoppingmall_business_category as c on b.business_category=c.id where b.store_url!='' and a.merchant='32' order by a.id";

$stmt=$db->query($query);
$stmt->execute();
$res = $stmt->fetchAll();

foreach($res as $key=>$value)
{
	$category_joomla_id=$value['id'];
	$merchant_id=$value['merchant'];
	
	$category_name=$value['name'];
	$url_key=str_replace(" ","-",$category_name);
	
	$store_url_arr=explode(".eshoppingmall.com.my",$value['store_url']);
	$store_alias=strip_tags(addslashes($store_url_arr[0]));
	$store_alias = preg_replace('/[^A-Za-z0-9\. -]/','', $store_alias);
	$store_alias=strtolower($store_alias);
	$website_name=$store_alias;
	
	$category_array=array(
    'name' => $category_name,
    'is_active' => 1,
    'position' => 1,
    'available_sort_by' => 'position',
    'custom_design' => null,
    'custom_apply_to_products' => null,
    'custom_design_from' => null,
    'custom_design_to' => null,
    'custom_layout_update' => null,
    'default_sort_by' => 'position',
    'description' => $category_name,
    'display_mode' => null,
    'is_anchor' => 1,
    'landing_page' => null,
    'meta_description' => null,
    'meta_keywords' => null,
    'meta_title' => null,
    'page_layout' => 'two_columns_left',
    'url_key' => $url_key,
    'include_in_menu' => 0,
	);
	
	$cat = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name', $value['business_cat_name']);
	$root_categoryid=$cat->getFirstItem()->getEntityId();
	
	$query1="select role_id from admin_role where role_name='$website_name'";
	$stmt1=$db->query($query1);
	$stmt1->execute();
	$res1 = $stmt1->fetch();
	$role_id=$res1['role_id'];
	
	
	$query2="select a.website_id,b.code,b.store_id from core_website as a left join `core_store` as b on a.website_id=b.website_id where a.code='$website_name'";
	$stmt2=$db->query($query2);
	$stmt2->execute();
	$res1 = $stmt2->fetch();
	$store_id=$res1['store_id'];
	
	$new_category_array=array();
	
		try 
		{
			$category_id=$api->createCategory($root_categoryid,$category_array,$store_id);
			$new_category_array[]=$category_id;
			echo "$category_id Category Added Successfully<br><br>";
			
			$query_sub="select * from jos_eshoppingmall_product_sub_category where product_category='$category_joomla_id' and merchant='$merchant_id'";
			$stmt_sub=$db->query($query_sub);
			$stmt_sub->execute();
			$res_sub = $stmt_sub->fetchAll();
			
			foreach($res_sub as $key_sub=>$value_sub)
			{	
				$category_name_sub=$value_sub['name'];
				$url_key_sub=str_replace(" ","-",$category_name);
				$root_categoryid_sub=$category_id;
				
				$category_array_sub=array(
					    'name' => $category_name_sub,
					    'is_active' => 1,
					    'position' => 1,
					    'available_sort_by' => 'position',
					    'custom_design' => null,
					    'custom_apply_to_products' => null,
					    'custom_design_from' => null,
					    'custom_design_to' => null,
					    'custom_layout_update' => null,
					    'default_sort_by' => 'position',
					    'description' => $category_name_sub,
					    'display_mode' => null,
					    'is_anchor' => 1,
					    'landing_page' => null,
					    'meta_description' => null,
					    'meta_keywords' => null,
					    'meta_title' => null,
					    'page_layout' => 'two_columns_left',
					    'url_key' => $url_key_sub,
					    'include_in_menu' => 0,
						);
				$category_id_sub=$api->createCategory($root_categoryid_sub,$category_array_sub,$store_id);
				$new_category_array[]=$category_id_sub;		
			}
		}
		catch (SoapFault $e) 
		{
			echo '<br><br>Error in Customer web service: '.$e->getMessage();
		}
		
		
	 $select_adv_query="select category_ids from aitoc_aitpermissions_advancedrole where role_id='$role_id'";
	 $stmt3=$db->query($select_adv_query);
	 $stmt3->execute();
	 $res3 = $stmt3->fetch();
	 $category_ids=$res3['category_ids'];
	 $category_ids_arr=array();
	 $category_ids_arr=explode(",",$category_ids);
	 //$category_ids_arr[]=$category_id;
	 $category_ids_arr_new = array_merge($category_ids_arr, $new_category_array);
	 $new_cat_id_str=implode(",",$category_ids_arr_new);
	 
	 $update_adv_query="update aitoc_aitpermissions_advancedrole set category_ids='$new_cat_id_str' where role_id='$role_id'";
	 $stmt4=$db->query($update_adv_query);	 	 
}
?>