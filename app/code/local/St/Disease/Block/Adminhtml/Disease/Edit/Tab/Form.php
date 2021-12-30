<?php
class St_Disease_Block_Adminhtml_Disease_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("disease_form", array("legend"=>Mage::helper("disease")->__("Item information")));

				
						 $fieldset->addField('disease', 'select', array(
						'label'     => Mage::helper('disease')->__('Disease'),
						'values'   => St_Disease_Block_Adminhtml_Disease_Grid::getValueArray0(),
						'name' => 'disease',
						"class" => "required-entry",
						"required" => true,
						));
						$fieldset->addField("lowrange", "text", array(
						"label" => Mage::helper("disease")->__("Low Range"),
						"name" => "lowrange",
						));
					
						$fieldset->addField("highrange", "text", array(
						"label" => Mage::helper("disease")->__("High Range"),
						"name" => "highrange",
						));
					
						$fieldset->addField("comment", "text", array(
						"label" => Mage::helper("disease")->__("comment"),
						"name" => "comment",
						));
					
						$fieldset->addField("label", "text", array(
						"label" => Mage::helper("disease")->__("Label"),
						"class" => "required-entry",
						"required" => true,
						"name" => "label",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getDiseaseData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getDiseaseData());
					Mage::getSingleton("adminhtml/session")->setDiseaseData(null);
				}
				elseif(Mage::registry("disease_data")) {
				    $form->setValues(Mage::registry("disease_data")->getData());
				}
				return parent::_prepareForm();
		}
}
