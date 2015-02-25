<?php 
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
   
    public function getCustomerlist() {
        return $this->proxy->call($this->sessionId, 'customer.list');
    }
	
 	public function createCustomer($params) {
        return $this->proxy->call($this->sessionId, 'customer.create', array($params));
    }
	public function createCustomeraddress($address) {
        return $this->proxy->call($this->sessionId, 'customer_address.create', $address);
    }
}

$api = new migrationApi();

$countryList = Mage::getResourceModel('directory/country_collection')
                    ->loadData()
                    ->toOptionArray(false);


$array_country=array();
foreach ($countryList as $key => $val) 
{
   $array_country[strtolower($val['label'])]=$val['value'];
}


//$customer_list=$api->getCustomerlist();

$query="select a.id as id1,a.name as name1,a.email,a.password,b.id as id2, b.tel,b.fax,b.address_line_1,b.address_line_2,b.address_line_3, b.city, b.state, b.postcode, b.country from jos_users as a left join jos_eshoppingmall_user_profile as b on a.id=b.user";

$stmt=$db->query($query);
$stmt->execute();
$res = $stmt->fetchAll();

foreach($res as $key=>$value)
{
	$name_array=explode(" ",$value['name1']);
	$first_name=$name_array[0];
	$last_name=$name_array[1];
	if($last_name=='')
	{ $last_name='last'; }
	$email=$value['email'];
	$password=$value['password'].":joomla";
	$newCustomer = array(
        'firstname'  => $first_name,
        'lastname'   => $last_name,
        'email'      => $email,
      	'password_hash' => $password,
        'store_id'   => 0,
        'website_id' => 1
	);
	
	try 
	{
		$customer_id=$api->createCustomer($newCustomer);
		echo "$customer_id Customer Added Successfully<br><br>";
	}
	catch (SoapFault $e) 
	{
		echo '<br><br>Error in Customer web service: '.$e->getMessage();
	}
	
	$id2=$value['id2'];
	
	if($id2!='' && $id2!=null && $id2!='NULL')
	{
		$address1=$value['address_line_1'];
		$address2=$value['address_line_2']." ".$value['address_line_3'];
		$country_id=$array_country[$value['country']];
		$adderss_array=array('customerId' => $customer_id, 'addressdata' => array('firstname' => $first_name, 'lastname' => $last_name, 'street' => array($address1, $address2), 'city' => $value['city'], 'country_id' => $country_id, 'region' => '', 'region_id' => '', 'postcode' => $value['postcode'], 'telephone' => $value['tel'] , 'fax' => $value['fax'], 'is_default_billing' => FALSE, 'is_default_shipping' => FALSE));
		
		try 
		{
			$address_id=$api->createCustomeraddress($adderss_array);
			echo "$address_id Customer Address Added Successfully<br><br>";
		}
		catch (SoapFault $e) 
		{
			echo '<br><br>Error in Customer web service: '.$e->getMessage();
		}		
	}	
}
?>