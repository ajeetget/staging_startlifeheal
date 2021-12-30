<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Quickview
 */


if (Mage::helper('core')->isModuleEnabled('Amasty_Conf')) {
    $autoloader = new Varien_Autoload();
    $autoloader->autoload('Amasty_Quickview_Block_Catalog_Product_Price_Conf');
} else {
    class Amasty_Quickview_Block_Catalog_Product_Price_Pure
        extends Mage_Catalog_Block_Product_Price
    {
    }
}

