<?php

class Eshop_EnquiryManagement_Block_Adminhtml_Enquirymanagement_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("enquirymanagementGrid");
				$this->setDefaultSort("sno");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("enquirymanagement/enquirymanagement")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("sno", array(
				"header" => Mage::helper("enquirymanagement")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "sno",
				));
                
				$this->addColumn("name", array(
				"header" => Mage::helper("enquirymanagement")->__("Name"),
				"index" => "name",
				));
				$this->addColumn("email", array(
				"header" => Mage::helper("enquirymanagement")->__("Email"),
				"index" => "email",
				));
				$this->addColumn("product_id", array(
				"header" => Mage::helper("enquirymanagement")->__("Product"),
				"index" => "product_id",
				));
				$this->addColumn("subject", array(
				"header" => Mage::helper("enquirymanagement")->__("Subject"),
				"index" => "subject",
				));
					$this->addColumn('post_date', array(
						'header'    => Mage::helper('enquirymanagement')->__('Post Date'),
						'index'     => 'post_date',
						'type'      => 'datetime',
					));
				$this->addColumn("message", array(
				"header" => Mage::helper("enquirymanagement")->__("Message"),
				"index" => "message",
				));
						$this->addColumn('website_id', array(
						'header' => Mage::helper('enquirymanagement')->__('Website'),
						'index' => 'website_id',
						'type' => 'options',
						'options'=>Eshop_EnquiryManagement_Block_Adminhtml_Enquirymanagement_Grid::getOptionArray6(),				
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
			$this->setMassactionIdField('sno');
			$this->getMassactionBlock()->setFormFieldName('snos');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_enquirymanagement', array(
					 'label'=> Mage::helper('enquirymanagement')->__('Remove Enquirymanagement'),
					 'url'  => $this->getUrl('*/adminhtml_enquirymanagement/massRemove'),
					 'confirm' => Mage::helper('enquirymanagement')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray6()
		{
            $data_array=array(); 
			$data_array[0]='test';
			$data_array[1]='test1';
            return($data_array);
		}
		static public function getValueArray6()
		{
            $data_array=array();
			foreach(Eshop_EnquiryManagement_Block_Adminhtml_Enquirymanagement_Grid::getOptionArray6() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}