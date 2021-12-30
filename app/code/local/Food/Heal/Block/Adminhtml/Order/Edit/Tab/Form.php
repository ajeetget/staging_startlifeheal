<?php
class Food_Heal_Block_Adminhtml_Order_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("heal_form", array("legend"=>Mage::helper("heal")->__("Item information")));

				
						$fieldset->addField("name", "text", array(
						"label" => Mage::helper("heal")->__("Name"),
						"name" => "name",
						));
					
						$fieldset->addField("email", "text", array(
						"label" => Mage::helper("heal")->__("Email"),
						"name" => "email",
						));
					
						$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(
							Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
						);

						$fieldset->addField('orderdate', 'date', array(
						'label'        => Mage::helper('heal')->__('Order Date'),
						'name'         => 'orderdate',
						'time' => false,
						'image'        => $this->getSkinUrl('images/grid-cal.gif'),
						'format'       => $dateFormatIso
						));
						$fieldset->addField("mobile", "text", array(
						"label" => Mage::helper("heal")->__("Mobile"),
						"name" => "mobile",
						));
					
						$fieldset->addField("alernatemobile", "text", array(
						"label" => Mage::helper("heal")->__("Alternate Mobile"),
						"name" => "alernatemobile",
						));
									
						/*$fieldset->addField('foodtype', 'select', array(
						'label'     => Mage::helper('heal')->__('Order Type'),
						'values'   => Food_Heal_Block_Adminhtml_Order_Grid::getValueArray6(),
						'name' => 'foodtype',
						));*/
						/*$fieldset->addField("fooditems", "textarea", array(
						"label" => Mage::helper("heal")->__("Ordered Items"),
						"name" => "fooditems",
						));*/
					
						$fieldset->addField("breakfast", "textarea", array(
						"label" => Mage::helper("heal")->__("BreakFast"),
						"name" => "breakfast",
						));
					
						$fieldset->addField("lunch", "textarea", array(
						"label" => Mage::helper("heal")->__("Lunch"),
						"name" => "lunch",
						));
					
						$fieldset->addField("hightea", "textarea", array(
						"label" => Mage::helper("heal")->__("High Tea"),
						"name" => "hightea",
						));
					
						$fieldset->addField("dinner", "textarea", array(
						"label" => Mage::helper("heal")->__("Dinner"),
						"name" => "dinner",
						));
					
						$fieldset->addField("note", "textarea", array(
						"label" => Mage::helper("heal")->__("Customer Note"),
						"name" => "note",
						));
					
						$fieldset->addField("address", "textarea", array(
						"label" => Mage::helper("heal")->__("Deliver To"),
						"name" => "address",
						));
									
						 $fieldset->addField('status', 'select', array(
						'label'     => Mage::helper('heal')->__('Status'),
						'values'   => Food_Heal_Block_Adminhtml_Order_Grid::getValueArray14(),
						'name' => 'status',
						));

				if (Mage::getSingleton("adminhtml/session")->getOrderData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getOrderData());
					Mage::getSingleton("adminhtml/session")->setOrderData(null);
				} 
				elseif(Mage::registry("order_data")) {
				    $form->setValues(Mage::registry("order_data")->getData());
				}
				return parent::_prepareForm();
		}
}
