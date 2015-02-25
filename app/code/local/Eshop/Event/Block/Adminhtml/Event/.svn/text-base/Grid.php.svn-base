<?php

class Eshop_Event_Block_Adminhtml_Event_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("eventGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("event/event")->getCollection();
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
                
				$this->addColumn("event_name", array(
				"header" => Mage::helper("event")->__("Event Name"),
				"index" => "event_name",
				));
					
					$this->addColumn('submittion_start_date', array(
						'header'    => Mage::helper('event')->__('Submittion Start Date'),
						'index'     => 'submittion_start_date',
						'type'      => 'datetime',
					));
					$this->addColumn('submittion_end_date', array(
						'header'    => Mage::helper('event')->__('Submittion End Date'),
						'index'     => 'submittion_end_date',
						'type'      => 'datetime',
					));
					$this->addColumn('publish_start_date', array(
						'header'    => Mage::helper('event')->__('Publish Start Date'),
						'index'     => 'publish_start_date',
						'type'      => 'datetime',
					));
					$this->addColumn('publish_end_date', array(
						'header'    => Mage::helper('event')->__('Publish End Date'),
						'index'     => 'publish_end_date',
						'type'      => 'datetime',
					));
				$this->addColumn("price_per_product", array(
				"header" => Mage::helper("event")->__("Price Per Product"),
				"index" => "price_per_product",
				));
				$this->addColumn("total_items", array(
				"header" => Mage::helper("event")->__("Total Items"),
				"index" => "total_items",
				));
						$this->addColumn('event_method', array(
						'header' => Mage::helper('event')->__('Event Method'),
						'index' => 'event_method',
						'type' => 'options',
						'options'=>Eshop_Event_Block_Adminhtml_Event_Grid::getOptionArray8(),				
						));

						$this->addColumn('position', array(
						'header' => Mage::helper('event')->__('Position'),
						'index' => 'position',
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
			$this->getMassactionBlock()->addItem('remove_event', array(
					 'label'=> Mage::helper('event')->__('Delete'),
					 'url'  => $this->getUrl('*/adminhtml_event/massRemove'),
					 'confirm' => Mage::helper('event')->__('Are you sure to delete event?')
				));
			return $this;
		}
			
		static public function getOptionArray8()
		{
            $data_array=array(); 
			$data_array[0]='Method1';
			$data_array[1]='Method2';
			$data_array[2]='Method3';
            return($data_array);
		}
		static public function getValueArray8()
		{
            $data_array=array();
			foreach(Eshop_Event_Block_Adminhtml_Event_Grid::getOptionArray8() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}