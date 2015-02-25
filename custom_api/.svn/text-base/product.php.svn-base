<?php
ini_set('default_socket_timeout', 6000);
include_once "/opt/lampp/htdocs/eshoppingmall/app/Mage.php";
//include_once "../app/Mage.php";
Mage::init();

$base_url=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);

ini_set("max_execution_time", 0);

$db = Mage::getSingleton('core/resource')->getConnection('core_write');
$db->exec("SET @@session.wait_timeout = 1200");

define('SITE_URL',$base_url);

$image_root='/opt/lampp/htdocs/eshoppingmall_joomla/';

class migrationApi {
    public $proxy;
    public $sessionId;
         
    public function __construct(){
        $this->proxy = new SoapClient(SITE_URL.'index.php/api/soap/?wsdl');
        $this->sessionId = $this->proxy->login('vimalparihar', '123456');
    }
   
   	public function mediaProduct($sku, $params) {
        return $this->proxy->call($this->sessionId, 'product_media.create', array($sku, $params));
    }
    
	public function createProduct($productType, $setId, $sku, $productData) {
        $result = array();
         
        $this->proxy->call($this->sessionId, 'product.create', array($productType, $setId, $sku, $productData));
        $result = $this->proxy->call($this->sessionId, 'product.info', $sku);
         
        return $result;
    }
    
 	public function updateProduct($sku, $params) {
        return $this->proxy->call($this->sessionId, 'catalog_product.update', array($sku, $params));
    }
    
   	public function getAttributes() {
        return $this->proxy->call($this->sessionId, 'product_attribute_set.list');
    }
}

$api = new migrationApi();
$set = current($api->getAttributes());
$createdProducts = array();
//$products=array();

//$query="select a.*,b.store_url,c.name as cat_name from jos_eshoppingmall_merchant_product as a left join jos_eshoppingmall_merchant as b on a.merchant=b.id left join jos_eshoppingmall_product_sub_category as c on a.product_sub_category=c.id where a.status='0' group by a.product_code order by a.id";
$query="select a.*,b.store_url,b.store_url,c.name as cat_name from jos_eshoppingmall_merchant_product as a left join jos_eshoppingmall_merchant as b on a.merchant=b.id left join jos_eshoppingmall_product_sub_category as c on a.product_sub_category=c.id where a.merchant=32";
$stmt=$db->query($query);
$stmt->execute();
$res = $stmt->fetchAll();

foreach($res as $key=>$value)
{
	$pro_table_id=$value['id'];
	$store_url_arr=explode(".eshoppingmall.com.my",$value['store_url']);
	$store_alias=strip_tags(addslashes($store_url_arr[0]));
	$store_alias = preg_replace('/[^A-Za-z0-9\. -]/','', $store_alias);
	$store_alias=strtolower($store_alias);
	$website_name=$store_alias;
	
	$cat = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name', $value['cat_name']);
	$cat_data=$cat->getData();
	
	//echo "<pre>";
	///print_r($cat_data->getEntityId());
	//die;
	$cat_array=array();
	
	if(count($cat_data)>1)
	{
		$categoryid=$cat_data[1]['entity_id'];
	}
	else
	{
		$categoryid=$cat->getFirstItem()->getEntityId();
	}
//	echo $categoryid;die;

	
	$query1="select website_id from core_website where code='$website_name'";
	$stmt1=$db->query($query1);
	$stmt1->execute();
	$res1 = $stmt1->fetch();
	$website_id=$res1['website_id'];
	
	$pro_attr_str = $value['product_attributes'];
    $pro_attr_arr=unserialize($pro_attr_str);
	
	
	if(is_numeric($value['product_code']))
	{
		$productSKU="a".$value['product_code'];
	}
	else
	{
		$productSKU=$value['product_code'];
	}
	
	
	$product_array=array(
    'categories' => array($categoryid),
    'websites' => array($website_id),
    'name' => $value['name'],
	'model' => $pro_attr_arr['model'],
	'brand' => $pro_attr_arr['brand'],
	'color' => $pro_attr_arr['color'],
	'dimension_height' => $pro_attr_arr['dimension']['height'],
	'dimension_width' => $pro_attr_arr['dimension']['width'],
	'dimension_depth' => $pro_attr_arr['dimension']['depth'],
	'weight' => $pro_attr_arr['weight'],
	'size' => $pro_attr_arr['size'],
    'description' => addslashes($value['long_description']),
    'short_description' => addslashes($value['short_description']),
    'status' => '1',
    'visibility' => '4',
    'price' => $value['product_price'],
	'special_price' => $value['product_promo_price'],
	'qty' => $value['unit_available'],
	'is_in_stock' => '1',
	'tax_class_id' => 0,
	);
	
	$product_array1=array(
    'websites' => array($website_id),
    );
	
	
	try 
	{
		$product_exist = Mage::getModel('catalog/product')->loadByAttribute('sku', $productSKU);
		if(!$product_exist)
		{
			$createdProduct = $api->createProduct('simple', $set['set_id'], $productSKU, $product_array);
			$product_id=$createdProduct['product_id'];
			echo "<br><br> $product_id product Added Successfully<br><br>";
			
			
			$image_name=$value['name'];
			$value_image=$image_root.$value['product_image'];
			$image_content=base64_encode(file_get_contents($value_image));
			       if($image_content!='')
			       {
			       		$newImage = array(
						    'file' => array(
					        'name' => $image_name,
					        'content' => $image_content,
					        'mime'    => 'image/jpeg'
						    ),
			    		    'label'    => $image_name,
						    'position' => 2,
						    'types'    => array('image','small_image','thumbnail'),
						    'exclude'  => 0
						);
					 $imageFilename = $api->mediaProduct($productSKU, $newImage);
				     }
				     
		}
		else
		{
			echo "$productSKU Pro exist<br>";
			$updatedProduct = $api->updateProduct($productSKU, $product_array1);
		}	
		$query_up="update jos_eshoppingmall_merchant_product set status='1',img_status='1' where id='$pro_table_id'";
		$stmt_up=$db->query($query_up);
	}
	catch (SoapFault $e) 
	{
		echo '<br><br>Error in Customer web service: '.$e->getMessage();
	}

}
?>