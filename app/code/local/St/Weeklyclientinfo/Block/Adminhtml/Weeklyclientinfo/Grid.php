<?php

class St_Weeklyclientinfo_Block_Adminhtml_Weeklyclientinfo_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("weeklyclientinfoGrid");
				$this->setDefaultSort("clientid");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
			//	Mage::helper("weeklyclientinfo")->checkDiseaseLevel();
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("weeklyclientinfo/weeklyclientinfo")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("clientid", array(
				"header" => Mage::helper("weeklyclientinfo")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "clientid",
				));
                
					$this->addColumn('date', array(
						'header'    => Mage::helper('weeklyclientinfo')->__('Date'),
						'index'     => 'date',
						'type'      => 'datetime',
					));
				$this->addColumn("name", array(
				"header" => Mage::helper("weeklyclientinfo")->__("Name"),
				"index" => "name",
				));
				$this->addColumn("mobile", array(
				"header" => Mage::helper("weeklyclientinfo")->__("Mobile"),
				"index" => "mobile",
				));
				
				$this->addColumn("weight", array(
				"header" => Mage::helper("weeklyclientinfo")->__("Weight"),
				"index" => "weight",
				));
				$this->addColumn("waist", array(
				"header" => Mage::helper("weeklyclientinfo")->__("Waist"),
				"index" => "waist",
				));
				$this->addColumn("height", array(
				"header" => Mage::helper("weeklyclientinfo")->__("Height"),
				"index" => "height",
				));
				$this->addColumn("bpsystolic", array(
				"header" => Mage::helper("weeklyclientinfo")->__("BP Systolic"),
				"index" => "bpsystolic",
				));
				$this->addColumn("bpdiastloc", array(
				"header" => Mage::helper("weeklyclientinfo")->__("BP Diastloc "),
				"index" => "bpdiastloc",
				));
				$this->addColumn("bpdiastloc", array(
				"header" => Mage::helper("weeklyclientinfo")->__("BP Diastloc "),
				"index" => "bpdiastloc",
				));
				$this->addColumn("upperbp", array(
				"header" => Mage::helper("weeklyclientinfo")->__("Upper BP"),
				"index" => "upperbp",
				));
				$this->addColumn("lowerbp", array(
				"header" => Mage::helper("weeklyclientinfo")->__("Lower BP"),
				"index" => "lowerbp",
				));
				$this->addColumn("tg", array(
				"header" => Mage::helper("weeklyclientinfo")->__("TG"),
				"index" => "tg",
				));
				$this->addColumn("hdl", array(
				"header" => Mage::helper("weeklyclientinfo")->__("HDL"),
				"index" => "hdl",
				));
				$this->addColumn("fastinggl	", array(
				"header" => Mage::helper("weeklyclientinfo")->__("Fasting Glucose"),
				"index" => "fastinggl	",
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
			$this->setMassactionIdField('clientid');
			$this->getMassactionBlock()->setFormFieldName('clientids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_weeklyclientinfo', array(
					 'label'=> Mage::helper('weeklyclientinfo')->__('Remove Weekly Report'),
					 'url'  => $this->getUrl('*/adminhtml_weeklyclientinfo/massRemove'),
					 'confirm' => Mage::helper('weeklyclientinfo')->__('Are you sure?')
				));
			return $this;
		}
			

}