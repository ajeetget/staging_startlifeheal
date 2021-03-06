<?php

/**
 * Advanced Checkout
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Onestepcheckout.com license that is
 * available through the world-wide-web at this URL:
 * http://www.advancedcheckout.com/license-agreement
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category 	Advanced Checkout
 * @package 	Advanced_Onestepcheckout
 * @copyright 	Copyright (c) 2015 Advanced Checkout (http://www.advancedcheckout.com/)
 * @license 	http://www.advancedcheckout.com/license-agreement
 */

/**
 * Onestepcheckout Block
 * 
 * @category 	Onestepcheckout
 * @package 	Advanced_Onestepcheckout
 * @author  	Onestepcheckout Developer
 */
class Advanced_Onestepcheckout_Model_Config_Stylebackgroundicon {

    public function toOptionArray() {

        $arr = array();

        $arr = array(array('value' => 'none', 'label' => Mage::helper('onestepcheckout')->__('None'))
            , array('value' => 'arrow-right', 'label' => Mage::helper('onestepcheckout')->__('Arrow Right'))
            , array('value' => 'arrow-left', 'label' => Mage::helper('onestepcheckout')->__('Arrow Left'))
            , array('value' => 'slant-right', 'label' => Mage::helper('onestepcheckout')->__('Slant Right'))
            , array('value' => 'slant-left', 'label' => Mage::helper('onestepcheckout')->__('Slant Left'))
        );

        return $arr;
    }

}

?>
