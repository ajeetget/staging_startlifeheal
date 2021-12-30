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
class Advanced_Onestepcheckout_Block_Onepage_Link extends Mage_Checkout_Block_Onepage_Link
{
    /**
     * Add link on checkout page to parent block
     *
     * @return Mage_Checkout_Block_Links
     */
    public function getCheckoutUrl()
    {
        if (!Mage::getStoreConfig('onestepcheckout/general/enable',Mage::app()->getStore()->getStoreId())) {
            return parent::getCheckoutUrl();
        }
        return $this->getUrl('onestepcheckout', array('_secure'=>true));
    }
}