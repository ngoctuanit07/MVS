<?php

class Eshop_Merchant_Block_Adminhtml_Merchnat_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("merchnatGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("merchant/merchnat")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id", array(
				"header" => Mage::helper("merchant")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "id",
				));
                
				$this->addColumn("name", array(
				"header" => Mage::helper("merchant")->__("Name"),
				"index" => "name",
				));
				$this->addColumn("email", array(
				"header" => Mage::helper("merchant")->__("Email"),
				"index" => "email",
				));
				$this->addColumn("store_name", array(
				"header" => Mage::helper("merchant")->__("Store Name"),
				"index" => "store_name",
				));
				$this->addColumn("store_alias", array(
				"header" => Mage::helper("merchant")->__("Store Alias"),
				"index" => "store_alias",
				));
				
				$category_array=array();
				$category = Mage::getModel('catalog/category'); 
			    $category->load(2); 
			    $childrenString = $category->getChildren(); 
			    $children = explode(',',$childrenString); 
			    foreach($children as $c)
			    { 
			        $catname= $category->load($c)->getName();
					//$catname = preg_replace("/[\s_]/", "-", $catname);
					$category_array[$catname]=$catname; 
			    } 
				
				
				$this->addColumn("business_category", array(
				"header" => Mage::helper("merchant")->__("Business Category"),
				"index" => "business_category",
				'type' => 'options',
				'options'=> $category_array,
				));
			    
				/*
				$this->addColumn("business_category", array(
				"header" => Mage::helper("merchant")->__("Business Category"),
				"index" => "business_category",
				));
				*/
				
				$this->addColumn("merchant_plan", array(
				"header" => Mage::helper("merchant")->__("Merchant Plan"),
				"index" => "merchant_plan",
				));
				$this->addColumn("owner_company_name", array(
				"header" => Mage::helper("merchant")->__("Owner Company Name"),
				"index" => "owner_company_name",
				));
				
				/*
				
				$this->addColumn("registration_no", array(
				"header" => Mage::helper("merchant")->__("Registration Number"),
				"index" => "registration_no",
				));
				$this->addColumn("address", array(
				"header" => Mage::helper("merchant")->__("Address"),
				"index" => "address",
				));
				$this->addColumn("city", array(
				"header" => Mage::helper("merchant")->__("City"),
				"index" => "city",
				));
				$this->addColumn("state", array(
				"header" => Mage::helper("merchant")->__("State"),
				"index" => "state",
				));
				$this->addColumn("postcode", array(
				"header" => Mage::helper("merchant")->__("Postcode"),
				"index" => "postcode",
				));
				$this->addColumn("country", array(
				"header" => Mage::helper("merchant")->__("Country"),
				"index" => "country",
				));
				$this->addColumn("telephone", array(
				"header" => Mage::helper("merchant")->__("Telephone"),
				"index" => "telephone",
				));
				$this->addColumn("fax", array(
				"header" => Mage::helper("merchant")->__("Fax "),
				"index" => "fax",
				));
				$this->addColumn("order_status", array(
				"header" => Mage::helper("merchant")->__("Order Status"),
				"index" => "order_status",
				));
				
				*/
						$this->addColumn('status', array(
						'header' => Mage::helper('merchant')->__('Status'),
						'index' => 'status',
						'type' => 'options',
						'options'=>Eshop_Merchant_Block_Adminhtml_Merchnat_Grid::getOptionArray16(),				
						));
						
			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}


		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('id');
			$this->getMassactionBlock()->setFormFieldName('ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_merchnat', array(
					 'label'=> Mage::helper('merchant')->__('Delete'),
					 'url'  => $this->getUrl('*/adminhtml_merchnat/massRemove'),
					 'confirm' => Mage::helper('merchant')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray16()
		{
            $data_array=array(); 
			$data_array[0]='Approved';
			$data_array[1]='Disapproved';
            return($data_array);
		}
		static public function getValueArray16()
		{
            $data_array=array();
			foreach(Eshop_Merchant_Block_Adminhtml_Merchnat_Grid::getOptionArray16() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}