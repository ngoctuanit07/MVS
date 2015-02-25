<?php
//include_once "/opt/lampp/htdocs/eshoppingmall/app/Mage.php";
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
   
   	public function createCategory($params) {
        return $this->proxy->call($this->sessionId, 'catalog_category.create', array(2,$params));
    }
	
}

$api = new migrationApi();

$query="select * from jos_eshoppingmall_business_category";

$stmt=$db->query($query);
$stmt->execute();
$res = $stmt->fetchAll();

foreach($res as $key=>$value)
{
	$category_name=$value['name'];
	$url_key=str_replace(" ","-",$category_name);
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
	
	try 
	{
		$category_id=$api->createCategory($category_array);
		echo "$category_id Category Added Successfully<br><br>";
	}
	catch (SoapFault $e) 
	{
		echo '<br><br>Error in Customer web service: '.$e->getMessage();
	}
}
?>