<?php

class St_Disease_Block_Adminhtml_Disease_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("diseaseGrid");
				$this->setDefaultSort("disease_id");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("disease/disease")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("disease_id", array(
				"header" => Mage::helper("disease")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "disease_id",
				));
                
						$this->addColumn('disease', array(
						'header' => Mage::helper('disease')->__('Disease'),
						'index' => 'disease',
						'type' => 'options',
						'options'=>St_Disease_Block_Adminhtml_Disease_Grid::getOptionArray0(),
						));
						
				$this->addColumn("lowrange", array(
				"header" => Mage::helper("disease")->__("Low Range"),
				"index" => "lowrange",
				));
				$this->addColumn("highrange", array(
				"header" => Mage::helper("disease")->__("High Range"),
				"index" => "highrange",
				));
				$this->addColumn("comment", array(
				"header" => Mage::helper("disease")->__("comment"),
				"index" => "comment",
				));
				$this->addColumn("label", array(
				"header" => Mage::helper("disease")->__("Label"),
				"index" => "label",
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
			$this->setMassactionIdField('disease_id');
			$this->getMassactionBlock()->setFormFieldName('disease_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_disease', array(
					 'label'=> Mage::helper('disease')->__('Remove Disease'),
					 'url'  => $this->getUrl('*/adminhtml_disease/massRemove'),
					 'confirm' => Mage::helper('disease')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray0()
		{
            $data_array=array(); 
			$data_array[0]='BP Systolic';
			$data_array[1]='BP Diastolic';
			$data_array[2]='BP Diastolic( ng/dl )';
			$data_array[3]='Iron';
			$data_array[4]='HsCRP';
			$data_array[5]='HbA1c';
			$data_array[6]='Homocysteine';
			$data_array[7]='B12';
			$data_array[8]='Calcium';
			$data_array[9]='Triglyceride';
			$data_array[10]='LDL';
			$data_array[11]='HDL';
			$data_array[12]='SGOT';
			$data_array[13]='SPGT';
			$data_array[14]='Bilirubin (total)';
			$data_array[15]='Fasting Glucose';
			$data_array[16]='Homa IR';
			$data_array[17]='TSH';
			$data_array[18]='T4';
			$data_array[19]='T3';
			$data_array[20]='Sodium';
			$data_array[21]='Uric Acid';
			$data_array[22]='Potassium';
			$data_array[23]='Creatinine';
			$data_array[24]='Urea';
			$data_array[25]='BMI';
			$data_array[26]='IGA';
			$data_array[27]='COLD';
			$data_array[28]='FEVER';
            return($data_array);
		}
		static public function getValueArray0()
		{
            $data_array=array();
			foreach(St_Disease_Block_Adminhtml_Disease_Grid::getOptionArray0() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);
			}
            return($data_array);

		}
		

}