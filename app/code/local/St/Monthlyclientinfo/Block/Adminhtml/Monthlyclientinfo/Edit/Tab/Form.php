<?php
class St_Monthlyclientinfo_Block_Adminhtml_Monthlyclientinfo_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("monthlyclientinfo_form", array("legend"=>Mage::helper("monthlyclientinfo")->__("Item information")));

				
						$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(
							Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
						);

						$fieldset->addField('date', 'date', array(
						'label'        => Mage::helper('monthlyclientinfo')->__('Submission Date'),
						'name'         => 'date',
						'time' => true,
						'image'        => $this->getSkinUrl('images/grid-cal.gif'),
						'format'       => $dateFormatIso
						));
						$fieldset->addField("name", "text", array(
						"label" => Mage::helper("monthlyclientinfo")->__("Name"),
						"name" => "name",
						));
					
						$fieldset->addField("mobile", "text", array(
						"label" => Mage::helper("monthlyclientinfo")->__("Mobile"),
						"name" => "mobile",
						));
					
						$fieldset->addField("hba1c", "text", array(
						"label" => Mage::helper("monthlyclientinfo")->__("HBA1c"),
						"name" => "hba1c",
						));
					
						$fieldset->addField("hscrp", "text", array(
						"label" => Mage::helper("monthlyclientinfo")->__("HSCRP"),
						"name" => "hscrp",
						));
					
						$fieldset->addField("hdl", "text", array(
						"label" => Mage::helper("monthlyclientinfo")->__("HDL"),
						"name" => "hdl",
						));
					
						$fieldset->addField("ldl", "text", array(
						"label" => Mage::helper("monthlyclientinfo")->__("LDL"),
						"name" => "ldl",
						));
					
						$fieldset->addField("vitamind", "text", array(
						"label" => Mage::helper("monthlyclientinfo")->__("Vitamin D"),
						"name" => "vitamind",
						));
					
						$fieldset->addField("b12", "text", array(
						"label" => Mage::helper("monthlyclientinfo")->__("B12"),
						"name" => "b12",
						));
					
						$fieldset->addField("fasting", "text", array(
						"label" => Mage::helper("monthlyclientinfo")->__("Fasting"),
						"name" => "fasting",
						));
					
						$fieldset->addField("pp", "text", array(
						"label" => Mage::helper("monthlyclientinfo")->__("PP"),
						"name" => "pp",
						));
					
						$fieldset->addField("homair", "text", array(
						"label" => Mage::helper("monthlyclientinfo")->__("HOMA - IR"),
						"name" => "homair",
						));
					
						$fieldset->addField("homocysteine", "text", array(
						"label" => Mage::helper("monthlyclientinfo")->__("Homocysteine"),
						"name" => "homocysteine",
						));
					
						
					

				if (Mage::getSingleton("adminhtml/session")->getMonthlyclientinfoData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getMonthlyclientinfoData());
					Mage::getSingleton("adminhtml/session")->setMonthlyclientinfoData(null);
				} 
				elseif(Mage::registry("monthlyclientinfo_data")) {
				    $form->setValues(Mage::registry("monthlyclientinfo_data")->getData());
				}
				return parent::_prepareForm();
		}
}
