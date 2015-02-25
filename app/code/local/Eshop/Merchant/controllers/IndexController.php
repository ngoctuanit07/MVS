<?php
/**
 * A3logics
 *
 *
 * @category   Eshop
 * @package    Eshop_MerchantRegistration
 */
class Eshop_Merchant_IndexController extends Mage_Core_Controller_Front_Action{
public function IndexAction() {
$status = Mage::getSingleton( 'customer/session' )->isLoggedIn();
$customer = Mage::getSingleton('customer/session')->getCustomer();
$email = $customer->getEmail();

	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Merchant Registration"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("Merchant Registration", array(
                "label" => $this->__("Merchant Registration"),
                "title" => $this->__("Merchant Registration")
		   ));

      $this->renderLayout();

    }
    /**
     * Render layout (blocks / view of the module ).
     *
     * 
     */

public function saveAction()
 {
 	if (isset($_POST[upgrade_merchant_plan]))
 	{
	Mage::getSingleton( 'customer/session' )->setData( 'updateplan', "$_POST[upgrade_merchant_plan]" ); 	
 	}
	$error = true;
 	$proemail = $_POST['email'];
 	$prosa = $_POST['store_alias'];
 	$owner_company_name = $_POST['owner_company_name'];
  //if user logged in then update where email
/*if($status)
{
	$customer = Mage::getSingleton('customer/session')->getCustomer();
	$email = $customer->getEmail();

$proid = $_POST['merchant_plan'];
$store_name = $_POST['store_name'] ;
$business_category = $_POST['business_category'];
$merchant_plan =$_POST['merchant_plan'];
$owner_company_name = $_POST['owner_company_name'];
$registration_no = $_POST['registration_no'];

$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
  $connection->beginTransaction();
  	$fields = array();
    $fields['store_name'] = $store_name;
    $fields['business_category'] = $business_category;
    $fields['merchant_plan'] = $merchant_plan;
    $fields['owner_company_name'] = $owner_company_name;
    $fields['registration_no'] = $registration_number;  
    $where = $connection->quoteInto('email =?', "$email");
    $connection->update('merchant', $fields, $where);
    $connection->commit();

//clear cart
Mage::getSingleton('checkout/session')->clear();
//add product to cart 
$cart = Mage::getModel('checkout/cart');
    $cart->init();
    $cart->addProduct($proid, array('qty' => 1));
    $cart->save();
$this->_redirect('checkout/cart');
}
else {*/
//email server side validation
/* 	if(!$status)
{
	if(filter_var($proemail, FILTER_VALIDATE_EMAIL)) 
	{
		
		$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
		$select = $connection->select()
		->from ('merchant', array('*'))
		->where ('email=?',$proemail);
		$rowsArray = $connection->fetchAll($select);        
		$count = count($rowsArray);
		if($count!= "0")
		{
				$error = "Email already Exists please login to continue";
				Mage::getModel('core/session')->setErrmsg($error);
				$this->_redirectUrl(Mage::getBaseUrl().'merchant');
		}
	}
	else 
	{
	$error = "Invalid Email ";
	Mage::getModel('core/session')->setErrmsg($error);
	$this->_redirectUrl(Mage::getBaseUrl().'merchant');
	}
// end of email validation
 //storealias server side validation
$splchar = "^[a-zA-Z0-9.]*$";

	if(strlen($prosa) > 3  )
	{
$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
$select = $connection->select()
->from ('merchant', array('*'))
->where ('store_alias=?',$prosa);
$rowsArray = $connection->fetchAll($select);        
$count = count($rowsArray);

	if($count!= "0")
		{
				$error = "Store Alias already Taken ";
				Mage::getModel('core/session')->setErrmsg($error);
				$this->_redirectUrl(Mage::getBaseUrl().'merchant');
		}
	}
	else 
	{
	$error = "Invalid store alias ";
	Mage::getModel('core/session')->setErrmsg($error);
	$this->_redirectUrl(Mage::getBaseUrl().'merchant');

	}
}*/
	
//end of store validation
if($error)
{

if (isset($_POST['upgrade_merchant_plan']))
 	{
 		
 		$proid = $_POST['upgrade_merchant_plan'];
 	}
 	
elseif (isset($_POST['current_plan']))
 	{
 		
 		$proid = $_POST['current_plan'];
 	}
 else 
 	{
 	$proid = $_POST['merchant_plan'];
 	}
//get data
//$data = $this->getRequest()->getPost();
//$dbinsert = Mage::getModel('merchant/merchnat')->setData($data)->save();
//$lastinsertid = $dbinsert->getId();

//Mage::getModel('core/session')->setLastid($lastinsertid);
Mage::getModel('core/session')->setMercomp($owner_company_name);
Mage::getModel('core/session')->setMercemail($proemail);

Mage::getSingleton( 'customer/session' )->setData( 'postarray', $_POST );
//clear cart
$cart = Mage::getSingleton('checkout/cart');
foreach( Mage::getSingleton('checkout/session')->getQuote()->getItemsCollection() as $item ){
$cart->removeItem( $item->getId() );
}
$cart->save();
Mage::getSingleton('checkout/session')->clear();
//add product to cart 
$cart = Mage::getModel('checkout/cart');
    $cart->init();
    $cart->addProduct($proid, array('qty' => 1));
    $cart->save();
$this->_redirect('checkout/cart');
}


else
{

	$this->_redirectUrl(Mage::getBaseUrl().'merchant');
}

//}
}
}


 ?>