<?php

class St_Calorycarbslevel_Block_Adminhtml_Calorycarbslevel_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("calorycarbslevelGrid");
				$this->setDefaultSort("levelid");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("calorycarbslevel/calorycarbslevel")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("levelid", array(
				"header" => Mage::helper("calorycarbslevel")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "levelid",
				));
                
				$this->addColumn("level1_carbs", array(
				"header" => Mage::helper("calorycarbslevel")->__("Level1 Carbs/Day (gm)"),
				"index" => "level1_carbs",
				));
				$this->addColumn("level1_calory", array(
				"header" => Mage::helper("calorycarbslevel")->__("Level1 Calory/Day"),
				"index" => "level1_calory",
				));
				$this->addColumn("level2_carbs", array(
				"header" => Mage::helper("calorycarbslevel")->__("Level2 Carbs/Day (gm)"),
				"index" => "level2_carbs",
				));
				$this->addColumn("level2_calory", array(
				"header" => Mage::helper("calorycarbslevel")->__("Level2 Calory/Day"),
				"index" => "level2_calory",
				));
				$this->addColumn("level3_carbs", array(
				"header" => Mage::helper("calorycarbslevel")->__("Level3 Carbs/Day(gm)"),
				"index" => "level3_carbs",
				));
				$this->addColumn("level3_calory", array(
				"header" => Mage::helper("calorycarbslevel")->__("Level3 Calory/Day"),
				"index" => "level3_calory",
				));
				$this->addColumn("level4_carbs", array(
				"header" => Mage::helper("calorycarbslevel")->__("Level4 Carbs/Day(gm)"),
				"index" => "level4_carbs",
				));
				$this->addColumn("level4_calory", array(
				"header" => Mage::helper("calorycarbslevel")->__("Level4 Calory/Day"),
				"index" => "level4_calory",
				));
				$this->addColumn("level5_carbs", array(
				"header" => Mage::helper("calorycarbslevel")->__("Level5 Carbs/Day(gm)"),
				"index" => "level5_carbs",
				));
				$this->addColumn("level5_calory", array(
				"header" => Mage::helper("calorycarbslevel")->__("Level5 Calory/Day"),
				"index" => "level5_calory",
				));

                                $this->addColumn("level6_carbs", array(
				"header" => Mage::helper("calorycarbslevel")->__("Level6 Carbs/Day(gm)"),
				"index" => "level6_carbs",
				));
				$this->addColumn("level6_calory", array(
				"header" => Mage::helper("calorycarbslevel")->__("Level6 Calory/Day"),
				"index" => "level6_calory",
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
			$this->setMassactionIdField('levelid');
			$this->getMassactionBlock()->setFormFieldName('levelids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_calorycarbslevel', array(
					 'label'=> Mage::helper('calorycarbslevel')->__('Remove Calorycarbslevel'),
					 'url'  => $this->getUrl('*/adminhtml_calorycarbslevel/massRemove'),
					 'confirm' => Mage::helper('calorycarbslevel')->__('Are you sure?')
				));
			return $this;
		}
			

}
