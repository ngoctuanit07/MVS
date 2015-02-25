<?php
/*******************************************************/
/***********  Created By : GIRISH ANAND   **************/
/*** For any query mail at girish.anand85@gmail.com ****/
/*******************************************************/
?>
<?php
class GA_Slide_Block_Adminhtml_Slide_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('slideGrid');
      $this->setDefaultSort('slide_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('slide/slide')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('slide_id', array(
          'header'    => Mage::helper('slide')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'slide_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('slide')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));

      
      

    $admin_user_session = Mage::getSingleton('admin/session');
    $adminuserId = $admin_user_session->getUser()->getUserId();
    $role_data = Mage::getModel('admin/user')->load($adminuserId)->getRole()->getData();
    //$role_name = $role_data['role_name'];

   // echo "<pre>";print_r($role_data);die;
      
      
      
      $site = Mage::getResourceModel('core/website_collection');
      $website_array=array();
      foreach($site->getData() as $website){ 
         $website_array[$website['website_id']]=$website['name'];   
       } 
      	
      
      $this->addColumn('website', array(
          'header'    => Mage::helper('slide')->__('Website'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'website',
          'type'      => 'options',
          'options'   => $website_array,
      ));    
      
	 $this->addColumn('status', array(
          'header'    => Mage::helper('slide')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('slide')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('slide')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('slide')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('slide')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('slide_id');
        $this->getMassactionBlock()->setFormFieldName('slide');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('slide')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('slide')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('slide/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('slide')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('slide')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}