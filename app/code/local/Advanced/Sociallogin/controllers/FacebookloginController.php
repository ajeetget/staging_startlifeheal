<?php

class Advanced_Sociallogin_FacebookloginController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function loginAction() {
        $params = $this->getRequest()->getParams();
		
		if(isset($params['code'])) {
			$client_id = trim(Mage::getStoreConfig('sociallogin/facebook_login/appId', $store_id));
			$redirect_uri = Mage::app()->getStore()->getBaseUrl() . 'sociallogin/facebooklogin/login';
			$client_secret = trim(Mage::getStoreConfig('sociallogin/facebook_login/secret', $store_id));
			$code = $params['code'];
			
			$url = 'https://graph.facebook.com/v2.5/oauth/access_token?client_id=' . $client_id .'&redirect_uri=' . $redirect_uri . '&client_secret=' . $client_secret . '&code=' . $code;
			
			$c = curl_init($url);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
			 
			$r = curl_exec($c);
			curl_close($c);
			$d = json_decode($r);
			
			if(isset($d->access_token)) {
				$c = curl_init('https://graph.facebook.com/v2.5/me?fields=id,name,email,first_name,last_name&access_token=' . $d->access_token);
				curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
				 
				$r = curl_exec($c);
				curl_close($c);
				$d = json_decode($r);
				
				$store_id = Mage::app()->getStore()->getStoreId(); //add
				$website_id = Mage::app()->getStore()->getWebsiteId(); //add
				$profile = array('firstname' => $d->first_name, 'lastname' => $d->last_name, 'email' => $d->email);
				
				if ($profile['email']) {
					//get customer
					$customer = Mage::helper('sociallogin')->getCustomerByEmail($profile['email'], $website_id); //add edition

					if (!$customer->getId()) {
						$customer = Mage::helper('sociallogin')->createCustomerSosial($profile, $website_id, $store_id);
						$customer->sendPasswordReminderEmail();
						$customer->setConfirmation(null);
						$customer->save();
					}
					
					Mage::getSingleton('customer/session')->setCustomerAsLoggedIn($customer);
					if(trim(Mage::getStoreConfig('sociallogin/general/redirect_url')))
						die("<script type=\"text/javascript\">try{window.opener.location.href=\"" .  Mage::helper('sociallogin/data')->getUrlLoginRedirect()  . "\";}catch(e){window.opener.location.reload(true);} window.close();</script>");
					else 
						die("<script type=\"text/javascript\">window.opener.location.reload(true); window.close();</script>");
				} else {
					Mage::getSingleton('core/session')->addError('You provided a email invalid!');
					die("<script type=\"text/javascript\">try{window.opener.location.reload(true);}catch(e){window.opener.location.href=\"" . Mage::getBaseUrl() . "\"} window.close();</script>");
				}
			}
		}
    }
}
    