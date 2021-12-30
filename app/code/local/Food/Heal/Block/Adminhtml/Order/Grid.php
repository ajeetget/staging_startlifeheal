<?php

class Food_Heal_Block_Adminhtml_Order_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("orderGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("heal/order")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id", array(
				"header" => Mage::helper("heal")->__("ID"),
				"align" =>"right",
				"width" => "10px",
			    "type" => "number",
				"index" => "id",
				));
                
				$this->addColumn("name", array(
				"header" => Mage::helper("heal")->__("Name"),
				"index" => "name",
				));
				$this->addColumn("email", array(
				"header" => Mage::helper("heal")->__("Email"),
				"index" => "email",
				));
				$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(
							Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
						);
				$this->addColumn('orderdate', array(
					'header'    => Mage::helper('heal')->__('Order Date'),
					'index'     => 'orderdate',
					'type'      => 'datetime',
					'format'       => $dateFormatIso
				));
				
				$this->addColumn("mobile", array(
				"header" => Mage::helper("heal")->__("Mobile"),
				"index" => "mobile",
				));
				$this->addColumn("breakfast", array(
				"header" => Mage::helper("heal")->__("Breakfast"),
				"index" => "breakfast",
				));
				$this->addColumn("lunch", array(
				"header" => Mage::helper("heal")->__("Lunch"),
				"index" => "lunch",
				));
				$this->addColumn("hightea", array(
				"header" => Mage::helper("heal")->__("Hightea"),
				"index" => "hightea",
				));
				$this->addColumn("dinner", array(
				"header" => Mage::helper("heal")->__("Dinner"),
				"index" => "dinner",
				));
				$this->addColumn("note", array(
				"header" => Mage::helper("heal")->__("Note"),
				"index" => "note",
				));
				$this->addColumn("address", array(
				"header" => Mage::helper("heal")->__("Address"),
				"index" => "address",
				));
				/*$this->addColumn("alernatemobile", array(
				"header" => Mage::helper("heal")->__("Alternate Mobile"),
				"index" => "alernatemobile",
				));
				$this->addColumn('foodtype', array(
				'header' => Mage::helper('heal')->__('Order Type'),
				'index' => 'foodtype',
				'type' => 'options',
				'options'=>Food_Heal_Block_Adminhtml_Order_Grid::getOptionArray6(),				
				));*/
				
				$this->addColumn('status', array(
				'header' => Mage::helper('heal')->__('Status'),
				'index' => 'status',
				'type' => 'options',
				'options'=>Food_Heal_Block_Adminhtml_Order_Grid::getOptionArray14(),				
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
			$this->getMassactionBlock()->addItem('remove_order', array(
					 'label'=> Mage::helper('heal')->__('Remove Order'),
					 'url'  => $this->getUrl('*/adminhtml_order/massRemove'),
					 'confirm' => Mage::helper('heal')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray6()
		{
            $data_array=array(); 
			$data_array[0]='Break Fast';
			$data_array[1]='Lunch';
			$data_array[2]='Tea';
			$data_array[3]='Dinner';
            return($data_array);
		}
		static public function getValueArray6()
		{
            $data_array=array();
			foreach(Food_Heal_Block_Adminhtml_Order_Grid::getOptionArray6() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		
		static public function getOptionArray14()
		{
            $data_array=array(); 
			$data_array[0]='Pending';
			$data_array[1]='Not Delivered';
			$data_array[2]='Delivered';
			$data_array[3]='Cancel';
            return($data_array);
		}
		static public function getValueArray14()
		{
            $data_array=array();
			foreach(Food_Heal_Block_Adminhtml_Order_Grid::getOptionArray14() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}