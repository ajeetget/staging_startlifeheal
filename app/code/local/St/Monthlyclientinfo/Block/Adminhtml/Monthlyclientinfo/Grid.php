<?php

class St_Monthlyclientinfo_Block_Adminhtml_Monthlyclientinfo_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("monthlyclientinfoGrid");
				$this->setDefaultSort("monthlyinfoid");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("monthlyclientinfo/monthlyclientinfo")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("monthlyinfoid", array(
				"header" => Mage::helper("monthlyclientinfo")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "monthlyinfoid",
				));
                
					$this->addColumn('date', array(
						'header'    => Mage::helper('monthlyclientinfo')->__('Submission Date'),
						'index'     => 'date',
						'type'      => 'datetime',
					));
				$this->addColumn("name", array(
				"header" => Mage::helper("monthlyclientinfo")->__("Name"),
				"index" => "name",
				));
				$this->addColumn("mobile", array(
				"header" => Mage::helper("monthlyclientinfo")->__("Mobile"),
				"index" => "mobile",
				));
				$this->addColumn("hba1c", array(
				"header" => Mage::helper("monthlyclientinfo")->__("HBA1c"),
				"index" => "hba1c",
				));
				$this->addColumn("hscrp", array(
				"header" => Mage::helper("monthlyclientinfo")->__("HSCRP"),
				"index" => "hscrp",
				));
				$this->addColumn("hdl", array(
				"header" => Mage::helper("monthlyclientinfo")->__("HDL"),
				"index" => "hdl",
				));
				$this->addColumn("ldl", array(
				"header" => Mage::helper("monthlyclientinfo")->__("LDL"),
				"index" => "ldl",
				));
				$this->addColumn("vitamind", array(
				"header" => Mage::helper("monthlyclientinfo")->__("Vitamin D"),
				"index" => "vitamind",
				));
				$this->addColumn("b12", array(
				"header" => Mage::helper("monthlyclientinfo")->__("B12"),
				"index" => "b12",
				));
				$this->addColumn("fasting", array(
				"header" => Mage::helper("monthlyclientinfo")->__("Fasting"),
				"index" => "fasting",
				));
				$this->addColumn("pp", array(
				"header" => Mage::helper("monthlyclientinfo")->__("PP"),
				"index" => "pp",
				));
				$this->addColumn("homair", array(
				"header" => Mage::helper("monthlyclientinfo")->__("HOMA - IR"),
				"index" => "homair",
				));
				$this->addColumn("homocysteine", array(
				"header" => Mage::helper("monthlyclientinfo")->__("Homocysteine"),
				"index" => "homocysteine",
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
			$this->setMassactionIdField('monthlyinfoid');
			$this->getMassactionBlock()->setFormFieldName('monthlyinfoids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_monthlyclientinfo', array(
					 'label'=> Mage::helper('monthlyclientinfo')->__('Remove Monthlyclientinfo'),
					 'url'  => $this->getUrl('*/adminhtml_monthlyclientinfo/massRemove'),
					 'confirm' => Mage::helper('monthlyclientinfo')->__('Are you sure?')
				));
			return $this;
		}
			

}