<?php
class St_Calorycarbslevel_Block_Adminhtml_Calorycarbslevel_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("calorycarbslevel_form", array("legend"=>Mage::helper("calorycarbslevel")->__("Item information")));

				
						$fieldset->addField("level1_carbs", "text", array(
						"label" => Mage::helper("calorycarbslevel")->__("Level1 Carbs/Day (gm)"),
						"class" => "required-entry",
						"required" => true,
						"name" => "level1_carbs",
						));
					
						$fieldset->addField("level1_calory", "text", array(
						"label" => Mage::helper("calorycarbslevel")->__("Level1 Calory/Day"),
						"class" => "required-entry",
						"required" => true,
						"name" => "level1_calory",
						));
					
						$fieldset->addField("level2_carbs", "text", array(
						"label" => Mage::helper("calorycarbslevel")->__("Level2 Carbs/Day (gm)"),
						"class" => "required-entry",
						"required" => true,
						"name" => "level2_carbs",
						));
					
						$fieldset->addField("level2_calory", "text", array(
						"label" => Mage::helper("calorycarbslevel")->__("Level2 Calory/Day"),
						"class" => "required-entry",
						"required" => true,
						"name" => "level2_calory",
						));
					
						$fieldset->addField("level3_carbs", "text", array(
						"label" => Mage::helper("calorycarbslevel")->__("Level3 Carbs/Day(gm)"),
						"class" => "required-entry",
						"required" => true,
						"name" => "level3_carbs",
						));
					
						$fieldset->addField("level3_calory", "text", array(
						"label" => Mage::helper("calorycarbslevel")->__("Level3 Calory/Day"),
						"class" => "required-entry",
						"required" => true,
						"name" => "level3_calory",
						));
					
						$fieldset->addField("level4_carbs", "text", array(
						"label" => Mage::helper("calorycarbslevel")->__("Level4 Carbs/Day(gm)"),
						"class" => "required-entry",
						"required" => true,
						"name" => "level4_carbs",
						));
					
						$fieldset->addField("level4_calory", "text", array(
						"label" => Mage::helper("calorycarbslevel")->__("Level4 Calory/Day"),
						"class" => "required-entry",
						"required" => true,
						"name" => "level4_calory",
						));
					
						$fieldset->addField("level5_carbs", "text", array(
						"label" => Mage::helper("calorycarbslevel")->__("Level5 Carbs/Day(gm)"),
						"class" => "required-entry",
						"required" => true,
						"name" => "level5_carbs",
						));
					
						$fieldset->addField("level5_calory", "text", array(
						"label" => Mage::helper("calorycarbslevel")->__("Level5 Calory/Day"),
						"class" => "required-entry",
						"required" => true,
						"name" => "level5_calory",
						));

						$fieldset->addField("level6_carbs", "text", array(
						"label" => Mage::helper("calorycarbslevel")->__("Level6 Carbs/Day(gm)"),
						"class" => "required-entry",
						"required" => true,
						"name" => "level6_carbs",
						));
					
						$fieldset->addField("level6_calory", "text", array(
						"label" => Mage::helper("calorycarbslevel")->__("Level6 Calory/Day"),
						"class" => "required-entry",
						"required" => true,
						"name" => "level6_calory",
						));


					

				if (Mage::getSingleton("adminhtml/session")->getCalorycarbslevelData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getCalorycarbslevelData());
					Mage::getSingleton("adminhtml/session")->setCalorycarbslevelData(null);
				}
				elseif(Mage::registry("calorycarbslevel_data")) {
				    $form->setValues(Mage::registry("calorycarbslevel_data")->getData());
				}
				return parent::_prepareForm();
		}
}
