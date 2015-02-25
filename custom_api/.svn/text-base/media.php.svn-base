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
    
   	public function getAttributes() {
        return $this->proxy->call($this->sessionId, 'product_attribute_set.list');
    }
}

$api = new migrationApi();
$set = current($api->getAttributes());
$createdProducts = array();
//$products=array();

$query="select a.*,b.store_url,c.name as cat_name from jos_eshoppingmall_merchant_product as a left join jos_eshoppingmall_merchant as b on a.merchant=b.id left join jos_eshoppingmall_product_sub_category as c on a.product_sub_category=c.id where a.img_status='0' group by a.product_code order by a.id";
//$query="select a.*,b.store_url,b.store_url,c.name as cat_name from jos_eshoppingmall_merchant_product as a left join jos_eshoppingmall_merchant as b on a.merchant=b.id left join jos_eshoppingmall_product_sub_category as c on a.product_sub_category=c.id where a.merchant=24 Limit 0,1";
$stmt=$db->query($query);
$stmt->execute();
$res = $stmt->fetchAll();

foreach($res as $key=>$value)
{
	$pro_table_id=$value['id'];
	
	if(is_numeric($value['product_code']))
	{
		$productSKU="a".$value['product_code'];
	}
	else
	{
		$productSKU=$value['product_code'];
	}
	
	
	try 
	{
		$product_exist = Mage::getModel('catalog/product')->loadByAttribute('sku', $productSKU);
		if($product_exist)
		{
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
		$query_up="update jos_eshoppingmall_merchant_product set img_status='1' where id='$pro_table_id'";
		$stmt_up=$db->query($query_up);
	}
	catch (SoapFault $e) 
	{
		echo '<br><br>Error in Customer web service: '.$e->getMessage();
	}

}
?>