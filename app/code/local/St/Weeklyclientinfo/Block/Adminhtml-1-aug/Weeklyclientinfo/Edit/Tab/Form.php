<?php
class St_Weeklyclientinfo_Block_Adminhtml_Weeklyclientinfo_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("weeklyclientinfo_form", array("legend"=>Mage::helper("weeklyclientinfo")->__("Item information")));

				
						$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(
							Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
						);

						$fieldset->addField('date', 'date', array(
						'label'        => Mage::helper('weeklyclientinfo')->__('Submission Date'),
						'name'         => 'date',					
						"class" => "required-entry",
						"required" => true,
						'time' => true,
						'image'        => $this->getSkinUrl('images/grid-cal.gif'),
						'format'       => $dateFormatIso
						));
						$fieldset->addField("name", "text", array(
						"label" => Mage::helper("weeklyclientinfo")->__("Name"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "name",
						));
					
						$fieldset->addField("mobile", "text", array(
						"label" => Mage::helper("weeklyclientinfo")->__("Mobile"),
						"name" => "mobile",
						));
					
						
					
						$fieldset->addField("weight", "text", array(
						"label" => Mage::helper("weeklyclientinfo")->__("Weight"),
						"name" => "weight",
						));
					
						$fieldset->addField("waist", "text", array(
						"label" => Mage::helper("weeklyclientinfo")->__("Waist"),
						"name" => "waist",
						));
					
						$fieldset->addField("bpsystolic", "text", array(
						"label" => Mage::helper("weeklyclientinfo")->__("BP Systolic"),
						"name" => "bpsystolic",
						));
					
						$fieldset->addField("bpdiastloc", "text", array(
						"label" => Mage::helper("weeklyclientinfo")->__("BP Diastloc "),
						"name" => "bpdiastloc",
						));
					
						
					

				if (Mage::getSingleton("adminhtml/session")->getWeeklyclientinfoData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getWeeklyclientinfoData());
					Mage::getSingleton("adminhtml/session")->setWeeklyclientinfoData(null);
				} 
				elseif(Mage::registry("weeklyclientinfo_data")) {
				    $form->setValues(Mage::registry("weeklyclientinfo_data")->getData());
				}
				return parent::_prepareForm();
		}
}
