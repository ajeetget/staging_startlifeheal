<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Quickview
 */


class Amasty_Quickview_Block_Catalog_Product_Price extends Amasty_Quickview_Block_Catalog_Product_Price_Pure
{
    public function _toHtml()
    {
        $html = parent::_toHtml();

        $price = '<div style="display: none !important;" id="amasty-product-id-'
            .  $this->getProduct()->getId() . '" ></div>';
        $search = '<div class="price-box">';
        $html = str_replace($search, $search . $price, $html);

        return $html;
    }
}

