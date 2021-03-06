<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Conf
 */  
class Amasty_Conf_Model_Source_LightboxEffects extends Varien_Object
{
	public function toOptionArray()
	{
	    $hlp = Mage::helper('amconf');
		return array(
			array('value' => 'fade', 'label' => $hlp->__('Effect of disappearance')),
			array('value' => 'slide', 'label' => $hlp->__('Effect of motion')),
            array('value' => 'none', 'label' => $hlp->__('None')),
		);
	}
	
}
