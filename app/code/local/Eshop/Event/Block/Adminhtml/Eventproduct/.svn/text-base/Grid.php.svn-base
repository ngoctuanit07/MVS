<?php

class Eshop_Event_Block_Adminhtml_Eventproduct_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("eventproductGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("event/eventproduct")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id", array(
				"header" => Mage::helper("event")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "id",
				));

						$data_array=array();
						$collection = Mage::getModel("event/event")->getCollection();
						//echo "<pre>";print_r($collection->getData());die;
						
						foreach ($collection as $coll=>$value)
						{
							$data_array[$value->getId()]=$value->getEventName();
						}
				
				$this->addColumn("event_name", array(
				"header" => Mage::helper("event")->__("Event Name"),
				"index" => "event_name",
				'type' => 'options',
				'options'=>$data_array,
				));
				
				$this->addColumn("sku", array(
				"header" => Mage::helper("event")->__("Product Sku"),
				"index" => "sku",
				));
				
				
				$site = Mage::getResourceModel('core/website_collection');
			    $website_array=array();
    	    	foreach($site->getData() as $website)
    	    	{ 
				    $website_array[$website['website_id']]=$website['name'];   
				 } 		
						
				$this->addColumn("merchant_website", array(
				"header" => Mage::helper("event")->__("Website"),
				"index" => "merchant_website",
				'type' => 'options',
				'options'=> $website_array,
				));
				
				
				/*
				$this->addColumn('event_method', array(
				'header' => Mage::helper('event')->__('Event Method'),
				'index' => 'event_method',
				'type' => 'options',
				'options'=>Eshop_Event_Block_Adminhtml_Eventproduct_Grid::getOptionArray13(),				
				));
				*/
				
				$this->addColumn('status', array(
				'header' => Mage::helper('event')->__('Status'),
				'index' => 'status',
				'type' => 'options',
				'options'=>Eshop_Event_Block_Adminhtml_Eventproduct_Grid::getOptionArray14(),				
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
			$this->getMassactionBlock()->addItem('remove_eventproduct', array(
					 'label'=> Mage::helper('event')->__('Delete'),
					 'url'  => $this->getUrl('*/adminhtml_eventproduct/massRemove'),
					 'confirm' => Mage::helper('event')->__('Are you sure?')
				));
				
			$this->getMassactionBlock()->addItem('approved_eventproduct', array(
					 'label'=> Mage::helper('event')->__('Approved'),
					 'url'  => $this->getUrl('*/adminhtml_eventproduct/massUpdate/status/0')
					 //'confirm' => Mage::helper('event')->__('Are you sure?')
			));		
				
			$this->getMassactionBlock()->addItem('disapproved_eventproduct', array(
					 'label'=> Mage::helper('event')->__('Disapproved'),
					 'url'  => $this->getUrl('*/adminhtml_eventproduct/massUpdate/status/1')
					 //'confirm' => Mage::helper('event')->__('Are you sure?')
			));		
			
			return $this;
		}
			
		static public function getOptionArray13()
		{
            $data_array=array(); 
			$data_array[0]='Method1';
			$data_array[1]='Method2';
			$data_array[2]='Method3';
            return($data_array);
		}
		static public function getValueArray13()
		{
            $data_array=array();
			foreach(Eshop_Event_Block_Adminhtml_Eventproduct_Grid::getOptionArray13() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		
		static public function getOptionArray14()
		{
            $data_array=array(); 
			$data_array[0]='Approved';
			$data_array[1]='Disapproved';
            return($data_array);
		}
		static public function getValueArray14()
		{
            $data_array=array();
			foreach(Eshop_Event_Block_Adminhtml_Eventproduct_Grid::getOptionArray14() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}