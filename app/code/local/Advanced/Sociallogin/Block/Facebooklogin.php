<?php

class Advanced_Sociallogin_Block_Facebooklogin extends Mage_Core_Block_Template {

    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    public function getUser() {
        return Mage::getModel('sociallogin/facebooklogin')->getUser();
    }

    public function getLoginUrl() {
		$store_id = Mage::app()->getStore()->getStoreId();
		$client_id = trim(Mage::getStoreConfig('sociallogin/facebook_login/appId', $store_id));
		$redirect_uri = Mage::app()->getStore()->getBaseUrl() . 'sociallogin/facebooklogin/login';
		$url = 'https://www.facebook.com/v2.5/dialog/oauth?client_id=' . $client_id  . '&redirect_uri='. $redirect_uri .'&scope=public_profile,email';
        return $url;
    }

    public function getDirectLoginUrl() {
        return Mage::helper('sociallogin')->getDirectLoginUrl();
    }

}
