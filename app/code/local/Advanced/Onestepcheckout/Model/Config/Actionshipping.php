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
class Advanced_Onestepcheckout_Model_Config_Actionshipping {

    public function toOptionArray() {

        $arr = array();

        $arr = array(array('value' => 'payment_method', 'label' => Mage::helper('onestepcheckout')->__('Payment Method'))
            , array('value' => 'order_review', 'label' => Mage::helper('onestepcheckout')->__('Order Review'))
            , array('value' => 'none', 'label' => Mage::helper('onestepcheckout')->__('N/A')));

        return $arr;
    }

}

?>
