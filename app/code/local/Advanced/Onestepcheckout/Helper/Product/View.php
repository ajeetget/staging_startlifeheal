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
class Advanced_Onestepcheckout_Helper_Product_View extends Mage_Catalog_Helper_Product_View
{
     /**
     * Inits layout for viewing product page
     *
     * @param Mage_Catalog_Model_Product $product
     * @param Mage_Core_Controller_Front_Action $controller
     *
     * @return Mage_Catalog_Helper_Product_View
     */
    public function initProductLayout($product, $controller)
    {
        $module = Mage::app()->getRequest()->getModuleName();
        if($module == 'onestepcheckout'){
            $design = Mage::getSingleton('catalog/design');
            $settings = $design->getDesignSettings($product);

            if ($settings->getCustomDesign()) {
                $design->applyCustomDesign($settings->getCustomDesign());
            }

            $update = $controller->getLayout()->getUpdate();
           
            $update->addHandle('default');
            $controller->addActionLayoutHandles();

            $update->addHandle('ONESTEP_PRODUCT_TYPE_' . $product->getTypeId());
            $update->addHandle('PRODUCT_' . $product->getId());
            
            $controller->loadLayoutUpdates();

            // Apply custom layout update once layout is loaded
            $layoutUpdates = $settings->getLayoutUpdates();
            if ($layoutUpdates) {
                if (is_array($layoutUpdates)) {
                    foreach($layoutUpdates as $layoutUpdate) {
                        $update->addUpdate($layoutUpdate);
                    }
                }
            }

            $controller->generateLayoutXml()->generateLayoutBlocks();

            // Apply custom layout (page) template once the blocks are generated
            if ($settings->getPageLayout()) {
                $controller->getLayout()->helper('page/layout')->applyTemplate($settings->getPageLayout());
            }

            $currentCategory = Mage::registry('current_category');
            $root = $controller->getLayout()->getBlock('root');
            if ($root) {
                $controllerClass = $controller->getFullActionName();
                if ($controllerClass != 'catalog-product-view') {
                    $root->addBodyClass('catalog-product-view');
                }
                $root->addBodyClass('product-' . $product->getUrlKey());
                if ($currentCategory instanceof Mage_Catalog_Model_Category) {
                    $root->addBodyClass('categorypath-' . $currentCategory->getUrlPath())
                        ->addBodyClass('category-' . $currentCategory->getUrlKey());
                }
            }
            return $this;
        }else{
            return parent::initProductLayout($product, $controller);
        }
        
    }
}