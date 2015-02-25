
<script type="text/javascript">
function onSub()
{
	if(!emailok)
    {
         $jq("#email").focus();
         return false;
    }    
    if(!storealisok)
	{
	        $jq("#store_alias").focus();
	        return false;
	}	
    if(storealisok && emailok)
    {
       // alert("here");
        editForm.submit();
        return true;
    }
}

function onSubContinueEdit()
{
	if(!emailok)
    {
         $jq("#email").focus();
         return false;
    }    
    if(!storealisok)
	{
	        $jq("#store_alias").focus();
	        return false;
	}	
    if(storealisok && emailok)
    {
        saveAndContinueEdit();
        return true;
    }
}
</script>
<?php
class Eshop_Merchant_Block_Adminhtml_Merchnat_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("merchant_form", array("legend"=>Mage::helper("merchant")->__("Merchant information")));

						$fieldset->addField("name", "text", array(
						"label" => Mage::helper("merchant")->__("Name"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "name",
						));
						
					
						$fieldset->addField("email", "text", array(
						"label" => Mage::helper("merchant")->__("Email"),					
						"class" => "required-entry ",
						"required" => true,
						"name" => "email",
						"id" => "email",
						));
					
						$fieldset->addField("store_name", "text", array(
						"label" => Mage::helper("merchant")->__("Store Name"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "store_name",
						));
					
						$fieldset->addField("store_alias", "text", array(
						"label" => Mage::helper("merchant")->__("Store Alias"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "store_alias",
						"id" => "store_alias",
						"maxlength" => "15",
						));
					
						$category_array=array();
						$category = Mage::getModel('catalog/category'); 
					    $category->load(2); 
					    $childrenString = $category->getChildren(); 
					    $children = explode(',',$childrenString); 
					    foreach($children as $c)
					    { 
					        $catname= $category->load($c)->getName();
							$category_array[]=array('value'=>$catname,'label'=>$catname); 
					    } 
				
						$fieldset->addField("business_category", "select", array(
						"label" => Mage::helper("merchant")->__("Business Category"),					
						'values'   => $category_array,
						"class" => "required-entry",
						"required" => true,
						"name" => "business_category",
						));
						
					$plan_array=array();
					$category = Mage::getModel('catalog/category')->load($store_cat);
					$_productCollection = Mage::getResourceModel('catalog/product_collection')
					->setStoreId(1)
					->addAttributeToSelect('*')
					->addAttributeToSelect('price')
					->addAttributeToSelect('entity_id')
					->addAttributeToSelect('name')
					->setOrder('price', 'ASC')
					->addAttributeToFilter('status', array('eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED))
					->addAttributeToFilter('plan', 5 ,'left');

						foreach ($_productCollection as $_product)
					    { 
					    	$_prosplprice =  $_product = Mage::getModel('catalog/product')->loadByAttribute('sku', $_product->getSku());
					        $proid= $_product->getEntityId();
					        $proname =$_prosplprice->getName();
							$plan_array[]=array('value'=>$proid,'label'=>$proname); 
							
					    } 
					    
						$fieldset->addField("merchant_plan", "select", array(
						"label" => Mage::helper("merchant")->__("Merchant Plan"),
						'values'   => $plan_array,					
						"class" => "required-entry",
						"required" => true,
						"name" => "merchant_plan",
						));
					
						$fieldset->addField("owner_company_name", "text", array(
						"label" => Mage::helper("merchant")->__("Owner Company Name"),
						"name" => "owner_company_name",
						));
					
						$fieldset->addField("registration_no", "text", array(
						"label" => Mage::helper("merchant")->__("Registration Number"),
						"name" => "registration_no",
						));
					
						$fieldset->addField("address", "text", array(
						"label" => Mage::helper("merchant")->__("Address"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "address",
						));
					
						$fieldset->addField("city", "text", array(
						"label" => Mage::helper("merchant")->__("City"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "city",
						));
					
						$fieldset->addField("state", "text", array(
						"label" => Mage::helper("merchant")->__("State"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "state",
						));
					
						$fieldset->addField("postcode", "text", array(
						"label" => Mage::helper("merchant")->__("Postcode"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "postcode",
						));
					
						$fieldset->addField("country", "text", array(
						"label" => Mage::helper("merchant")->__("Country"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "country",
						));
					
						$fieldset->addField("telephone", "text", array(
						"label" => Mage::helper("merchant")->__("Telephone"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "telephone",
						));
					
						$fieldset->addField("fax", "text", array(
						"label" => Mage::helper("merchant")->__("Fax "),
						"name" => "fax",
						));
					/*
						$fieldset->addField("order_status", "text", array(
						"label" => Mage::helper("merchant")->__("Order Status"),
						"name" => "order_status",
						));
					*/				
						 $fieldset->addField('status', 'select', array(
						'label'     => Mage::helper('merchant')->__('Status'),
						'values'   => Eshop_Merchant_Block_Adminhtml_Merchnat_Grid::getValueArray16(),
						'name' => 'status',					
						"class" => "required-entry",
						"required" => true,
						));

				if (Mage::getSingleton("adminhtml/session")->getMerchnatData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getMerchnatData());
					Mage::getSingleton("adminhtml/session")->setMerchnatData(null);
				} 
				elseif(Mage::registry("merchnat_data")) {
				    	 $form->setValues(Mage::registry("merchnat_data")->getData());
				    	
				    	 
	    	             $p = $form->getElement('store_alias')->getValue();
	    	            /* $merchant_plan = $form->getElement('merchant_plan')->getValue();
	    	             print_r($form[element]);
	    	             if (merchant_plan)
	    	             {
	    	             	$_product = Mage::getModel('catalog/product')->load($merchant_plan);
							$planprice = $_product->getPrice();
							$_productCollection = Mage::getResourceModel('catalog/product_collection')
							->setStoreId(1)
							->addAttributeToSelect('*')
							->addAttributeToSelect('price')
							->addAttributeToSelect('entity_id')
							->addAttributeToSelect('name')
							->addAttributeToSelect('plan_duration')
							->addAttributeToSelect('max_sku')
							->setOrder('price', 'ASC')
							->addAttributeToFilter('price', array('gt' => "$planprice"))
							->addAttributeToFilter('status', array('eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED))
							->addAttributeToFilter('plan', 5 ,'left');
							
							foreach ($_productCollection as $_product)
					    { 
					    	$_prosplprice =  $_product = Mage::getModel('catalog/product')->loadByAttribute('sku', $_product->getSku());
					        $proid= $_product->getEntityId();
					        $proname =$_prosplprice->getName();
							$plan_array[]=array('value'=>$proid,'label'=>$proname);
					    } 
					    	
	    	             }*/
							if($p!='')
							{
								 $targetElement=$form->getElement("store_alias");
							 	 //$targetElement->setReadonly(true);
							 	 $targetElement->setDisabled(true);

							 	 $targetElement1=$form->getElement("business_category");
							 	 $targetElement1->setDisabled(true);
							 	 
							 	 $targetElement2=$form->getElement("email");
							 	 $targetElement2->setDisabled(true);

							 	 $targetElement3=$form->getElement("merchant_plan");
							 	 $targetElement3->setDisabled(true);
						    }
				     	
				}
				return parent::_prepareForm();
		}
}
?>
<script type="text/javascript" src="<?php echo str_replace("index.php/", "", Mage::getBaseUrl())."js/js/jquery-1.11.1.js";?>"></script>
<script type="text/javascript" src="<?php echo str_replace("index.php/", "", Mage::getBaseUrl())."js/js/noConflict.js";?>"></script>
<script type="text/javascript">
var emailok = false;
var storealisok = false;
var baseUrl = '<?php echo str_replace("index.php/", "", Mage::getBaseUrl()); ?>';

$jq( document ).ready(function() {
	$jq("#store_alias").blur(function(){
		var storea =$jq("#store_alias").val();
		var splchar = new RegExp("^[a-zA-Z0-9.]*$");
		var defaultfolders =  new Array("app","downloader","errors","includes","js","lib","media","pkginfo","shell", "skin","var","custom_api");
			if(storea =="")
			{
				return false;
				storealisok = false;
			}
		
			if(storea.length < 3 ||!splchar.test(storea)|| !isNaN(+storea.charAt(0)) || $jq.inArray( storea , defaultfolders ) != -1 || storea.indexOf('.') != -1  )
			{
				$jq("#s_alias").remove();
				$jq("#store_alias").after("<div id='s_alias'><font color='red'>Store Alias invalid </font></div>");
				return false;
				storealisok = false;
			}
			
			else
			{
			$jq.ajax({
	            url: baseUrl +"checkuser.php" ,
	            type: 'POST',
	            async: false,
	            data: 'store_alias=' + $jq("#store_alias").val(),
	            success: function(data) 
	            {
				if(data.trim() != "0")
		         {
					storealisok = false;
		                $jq("#s_alias").remove();
		 				$jq("#store_alias").after("<div id='s_alias'><font color='red'>Store Alias Already Taken</font></div>");
		                 
		         }
		         else
		         {
		        	 storealisok = true;
		                 $jq("#s_alias").remove();
		 				$jq("#store_alias").after("<div id='s_alias'><font color='green'>Store Alias available</font></div>");
		                 
		         }
	            }
	       });
			}
		});
	});

		$jq( document ).ready(function() {
		$jq("#email").blur(function(){
		if($jq("#email").val()=='')
		{
			return false;
		}
		else
		{
			$jq.ajax({
            url: baseUrl +"checkuser.php",
            type: 'POST',
            async: false,
            data: 'email=' + $jq("#email").val(),
            success: function(data) {
			if(data.trim() != "0")
	         {
	                 emailok = false;
	                 $jq( "#email_info" ).remove();
		 			 $jq("#email").after("<div id='email_info'><font color='red'>Email Already Exists. Please login to Continue</font></div>");
		                 
	         }
	         else
	         {
	                 emailok = true;
	                 $jq( "#email_info" ).remove();
		 			$jq("#email").after("<div id='email_info'><font color='green'>Email available</font></div>");
		                 
	         }
            }
       });
		}
	});
});
</script>