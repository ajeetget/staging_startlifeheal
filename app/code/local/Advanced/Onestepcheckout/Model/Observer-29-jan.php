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
class Advanced_Onestepcheckout_Model_Observer {

    const SCOPE_DEFAULT = 'default';
    const SCOPE_WEBSITES = 'websites';
    const SCOPE_STORES = 'stores';

    /**
     * process controller_action_predispatch event
     *
     * @return Advanced_Onestepcheckout_Model_Observer
     */
    public function controllerActionPredispatch($observer) {
        $action = $observer->getEvent()->getControllerAction();
        return $this;
    }

    /**
     * process checkout_cart_add_product_complete event
     *
     * @return Advanced_Onestepcheckout_Model_Observer
     */
    public function initCartController($observer) {
        $storeId = Mage::app()->getStore()->getStoreId();
        if (Mage::getStoreConfig('onestepcheckout/general/enable', $storeId)) {
            if (Mage::getStoreConfig('onestepcheckout/features/redirect_to_checkout', $storeId)) {
                $message = Mage::helper('onestepcheckout')->__('%s was added to your shopping cart.', Mage::helper('core')->escapeHtml($observer->getProduct()->getName()));
                Mage::getSingleton('checkout/session')->addSuccess($message);
                $redirect = Mage::getUrl('onestepcheckout/index', array('_secure' => true));
                Header('Location: ' . $redirect);
                exit();
            }
        }
    }

    /**
     * process sales_order_save_after event
     *
     * @return Advanced_Onestepcheckout_Model_Observer
     */
    public function orderSaveAfter($observer) {
        if (Mage::registry('ULTIMATECHECKOUT_ORDER_SAVE_AFTER'))
            return;
        Mage::register('ULTIMATECHECKOUT_ORDER_SAVE_AFTER', true);
        $params = Mage::app()->getRequest()->getParams();
        $order = $observer->getEvent()->getOrder();


        if (Mage::getStoreConfig('onestepcheckout/features/enable_survey', Mage::app()->getStore()->getStoreId())) {
            $survey = Mage::getModel('onestepcheckout/survey');

            $surveyQuestion = Mage::getStoreConfig('onestepcheckout/features/survey_question', Mage::app()->getStore()->getStoreId());
            $surveyValues = unserialize(Mage::getStoreConfig('onestepcheckout/features/answer_values', Mage::app()->getStore()->getStoreId()));
            $surveyValue = '';

            if (isset($params['survey']))
                $surveyValue = $params['survey'];
            $surveyFreeText = '';
            if (isset($params['survey-freetext']))
                $surveyFreeText = $params['survey-freetext'];
            $surveyAnswer = '';
            if (isset($surveyValue)) {
                if ($surveyValue != 'freetext') {
                    if (isset($surveyValues[$surveyValue]['value']))
                        $surveyAnswer = $surveyValues[$surveyValue]['value'];
                } else {
                    $surveyAnswer = $surveyFreeText;
                }
            }

            if ($surveyAnswer) {
                try {
                    $survey->setData('question', $surveyQuestion)
                            ->setData('answer', $surveyAnswer)
                            ->setData('order_id', $order->getId())
                            ->save();
                } catch (Exception $e) {
                    
                }
            }
        }
		
		$orderNumber = $order->getId();
$order = Mage::getModel('sales/order')->load($orderNumber);
$orderItems = $order->getItemsCollection();
$skuArray= array();
$billingAddress = $order->getBillingAddress();
 $fistName = $billingAddress->getFirstname();
 $lastName = $billingAddress->getLastname();
 $mobile = $billingAddress->getTelephone();
 $city = $billingAddress->getCity();
 $createdAtDetails = $order->getCreatedAt();
$dateInfo = explode(" ",$createdAtDetails);
 $originalDate = $dateInfo[0];
 $date = date("d-M-Y", strtotime($originalDate));
$time = $dateInfo[1];
$incrementId = $order->getIncrementId();
$grandTotal = round($order->getGrandTotal(),0); 


///////////////////// Send SMS to customer ////////////////////////

$tmpMessage="For order no ".$incrementId .", order amount is Rs".$grandTotal; //die;
$message = urlencode($tmpMessage);  
      
   $varSMSURL = "http://msg160.com/sendsms/send1?userid=lifeheal&pass=lifeheal2019&sender=LIFEHL&mobile=".$mobile."&message=".$message."&route=5&sms_type=Unicode";
		
		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $varSMSURL);
		
                        curl_setopt($ch, CURLOPT_HEADER, 0);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_VERBOSE, 1);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        $varData = curl_exec($ch);
                        curl_close($ch);


                
	//////////////////////// Send Sms to Junior sir,mam,jasmine,chef,shailesh ///////////////////
        
         $orderItems=array();
        foreach ($order->getAllItems() as $item) {


            if($item->getParentItemId()!='')
            {
               $comboItemsDetails = round($item->getQtyOrdered(),4).' x '.$item->getName();
               $orderItems['combo'][$item->getParentItemId()][] =  $comboItemsDetails;

            }   
            else
            {
                $orderItems['noncombo'][] =  round($item->getQtyOrdered(),4).' x '.$item->getName();
            }   

        } 
        
        $orderMessage ='Order Id:'.$incrementId.',';
        $orderMessage.='Order Total:'.$grandTotal.',';
        $orderMessage.='Customer Name :'.$fistName.',';
        $orderMessage.='Mobile No:'.$mobile.',';

        if(sizeof($orderItems['combo'])>0)
        {
            foreach($orderItems['combo'] as $key=>$comboitemDetailsArray)
            {
                $comboMessage='';

                $comboProductId = $comboProduct= Mage::getModel('sales/order_item')->load($key)->getProductId(); 
                $comboProduct = Mage::getModel('catalog/product')->load($comboProductId);

                $comboMessage.= $comboProduct->getName().' items are :-';
                foreach($comboitemDetailsArray as $value)
                {
                  $comboMessage.=$value.',';
                }
                $orderMessage.=$comboMessage;
            }
        }

        if(sizeof($orderItems['noncombo'])>0)
        {
            foreach($orderItems['noncombo'] as $value)
            {

                $orderMessage.=$value.',';
            }
        } 
        
        $message = urlencode($orderMessage);  
		$mobileNoArray = array('9999956777','9999958766','9810589020','9873841650','9990536388');
               // $mobileNoArray = array('9990536388');
		foreach($mobileNoArray as $mobileNo)
		{
		   $varSMSURL = "http://msg160.com/sendsms/send1?userid=lifeheal&pass=lifeheal2019&sender=LIFEHL&mobile=".$mobileNo."&message=".$message."&route=5";
		
		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $varSMSURL);
		
                        curl_setopt($ch, CURLOPT_HEADER, 0);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_VERBOSE, 1);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        $varData = curl_exec($ch);
                        curl_close($ch);
                }
            
/////////////////////End Sending SMS ///////////////////// 
                        
foreach ($order->getAllItems() as $item) {
	     $skuArray[] = $item->getSku();
	
}

$showTests='';
if(in_array("Basic Package",$skuArray)){ $showTests='Basic';}	
if(in_array("Premium Package",$skuArray)){ $showTests='Premium';}		
if(in_array("Super Premium Package",$skuArray)){ $showTests='Super';}

$to = "st.homespice@gmail.com";
$subject = "HTML email";

$message = '
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body  bgcolor="#f3f3f3">
<div style="padding:0;margin:0;FONT-SIZE:13px;FONT-FAMILY:Arial,Helvetica,sans-serif;background:#f3f3f3">
                     <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#f3f3f3">
                     <tbody>
		             <tr>
                     <td valign="top">
                     <table style="max-width:600px; width:100%" cellspacing="0" cellpadding="0" align="center" border="0">
                     <tbody>
					 <tr>
                     <td style="BORDER-TOP:medium none;BORDER-RIGHT:medium none;BORDER-BOTTOM:medium none;PADDING-BOTTOM:0px;PADDING-TOP:0px;PADDING-LEFT:0px;BORDER-LEFT:medium none;PADDING-RIGHT:0px;BACKGROUND-COLOR:#fff;padding: 0px 10px;">
                     <table style="WIDTH:100%" cellspacing="0" cellpadding="0" align="left">
                                <tbody><tr style="HEIGHT:10px">
                                    <td style="BORDER-TOP:medium none;BORDER-RIGHT:medium none;WIDTH:100%;VERTICAL-ALIGN:top;BORDER-BOTTOM:medium none;PADDING-BOTTOM:20px;TEXT-ALIGN:center;PADDING-TOP:20px;PADDING-LEFT:15px;BORDER-LEFT:medium none;PADDING-RIGHT:15px;BACKGROUND-COLOR:#fff">
                                        
                                         <table cellspacing="0" cellpadding="0" align="center" border="0">
                                            <tbody>
											<tr>
                                                <td style="PADDING-BOTTOM:2px;PADDING-TOP:2px;PADDING-LEFT:2px;PADDING-RIGHT:2px" align="center">
                                                    <table cellspacing="0" cellpadding="0" border="0">
                                                        <tbody>
														<tr>
                                                            <td style="BORDER-TOP:medium none;BORDER-RIGHT:medium none;BORDER-BOTTOM:medium none;BORDER-LEFT:medium none;BACKGROUND-COLOR:transparent">
                                                                                                                    <a href="https://www.braided-rugs.com/" style="color:#fff;text-decoration:none" target="_blank">

<img src="https://curemydiabetes.com/skin/frontend/rwd/default/images/logo.png">
</a>
                                                      </td>
                                                        </tr>
                                                    </tbody></table>
                                                </td>
                                            </tr>
                                        </tbody></table>
                           </td>
                                </tr>
                            </tbody></table>
                     </td>
                     </tr>                    
             
                      <tr>                  
                      <td style="BORDER-TOP:medium none;BORDER-RIGHT:medium none;BORDER-BOTTOM:medium none;PADDING-BOTTOM:0px;PADDING-TOP:0px;PADDING-LEFT:0px;BORDER-LEFT:medium none;PADDING-RIGHT:0px;BACKGROUND-COLOR:#fff;padding: 0px 10px;">
                      <table style="WIDTH:100%" cellspacing="0" cellpadding="0" align="left"> 
                      <tbody>
			          <tr style="HEIGHT:100%;float:left;margin-bottom:0px;width:100%">
                      <td style="width:100%;VERTICAL-ALIGN:middle;line-height:24px;TEXT-ALIGN:justify;font-size:16px;text-align:justify;float:left;margin-bottom:10px;">
                      <p>Dear SRL</p>
                      <p style="font-size: 16px;">We have Recieved Lab test request just now. Please call to schedule blood sample collection.</p>
                      </td>
                      </tr>
                      </tbody>
					  </table>
                      </td>
                      </tr>
				      
					  <tr>                    
                      <td style="BORDER-TOP:medium none;BORDER-RIGHT:medium none;BORDER-BOTTOM:medium none;PADDING-BOTTOM:0px;PADDING-TOP:0px;PADDING-LEFT:0px;BORDER-LEFT:medium none;PADDING-RIGHT:0px;BACKGROUND-COLOR:#fff;padding: 0px 10px;">
                      <table style="WIDTH:100%" cellspacing="0" cellpadding="0" align="left"> 
                      <tbody>
					  <tr style="HEIGHT:100%;float:left;margin-bottom:20px;width:100%">
                      <td style="width:100%;VERTICAL-ALIGN:middle;line-height:24px;TEXT-ALIGN:justify;font-size:16px;text-align:left;float:left;margin-bottom:10px;">
                       <p style="width: 100%;float: left;margin: 5px;"><b>Date : </b>'.$date.'</p>
                       <p  style="width: 100%;float: left;margin: 5px;"><b>Time : </b> '.$time.'</p>
					   <p style="width: 100%;float: left;margin: 5px;"><b>Mobile : </b> '.$mobile.'</p>
                       <p  style="width: 100%;float: left;margin: 5px;"><b>Name : </b> '.$lastName.'</p>
					   <p  style="width: 100%;float: left;margin: 5px;"><b>City : </b> '.$city.'</p>
					   <p style="width: 100%;float: left;margin: 5px;"><b>Blood Tests : </b></p>';
					   if($showTests=='Basic')
					  {
						  $message.='
					   <p style="background-color: #48bfa3;text-align: left;line-height: 30px;float: left;width: 100%;color:#fff;margin:0px;"><b style="padding-left: 5px;">Basic Lab Package</b></p>
					   <div style="background: #f3f3f3; width:100%; float:left;margin: 0px 0px;">
					   <p  style="width: 100%;float: left;margin: 5px;">1. HDL</p>
					   <p  style="width: 100%;float: left;margin: 5px;">2. Triglycerides</p>
					   <p  style="width: 100%;float: left;margin: 5px;">3. Fasting Glucose</p>
					   </div>';
					  }
					  else if($showTests=='Premium')
					  {
						  $message.='
					   <p style="background-color: #48bfa3;text-align: left;line-height: 30px;float: left;width: 100%;color:#fff;margin:0px;"><b style="padding-left: 5px;">Premium Lab Package</b></p>
					   <div style="background: #f3f3f3; width:100%; float:left;margin: 0px 0px;">
					   <p  style="width: 100%;float: left;margin: 5px;">1. HDL</p>
					   <p  style="width: 100%;float: left;margin: 5px;">2. Triglycerides</p>
					   <p  style="width: 100%;float: left;margin: 5px;">3. Fasting Glucose</p>
					   <p  style="width: 100%;float: left;margin: 5px;">4. Lipid Profile</p>
					   <p  style="width: 100%;float: left;margin: 5px;">5. HBA1c</p>
					  </div>';
					  }
					   else if($showTests=='Super')
					   {
						   $message.='
					  <p style="background-color: #48bfa3;text-align: left;line-height: 30px;float: left;width: 100%;color:#fff;margin:0px;"><b style="padding-left: 5px;">Super Premium Lab Package</b></p>
					   <div style="background: #f3f3f3; width:100%; float:left;margin: 0px 0px;">
					   <p  style="width: 100%;float: left;margin: 5px;">1. HDL</p>
					   <p  style="width: 100%;float: left;margin: 5px;">2. Triglycerides</p>
					   <p  style="width: 100%;float: left;margin: 5px;">3. Fasting Glucose</p>
					   <p  style="width: 100%;float: left;margin: 5px;">4. Lipid Profile</p>
					   <p  style="width: 100%;float: left;margin: 5px;">5. HBA1c</p>
					   <p  style="width: 100%;float: left;margin: 5px;">6. Liver Function</p>
					   <p  style="width: 100%;float: left;margin: 5px;">7. HSCRP</p>
					   <p  style="width: 100%;float: left;margin: 5px;">8. Vitamin D & B12</p>
					   </div>';
					   }
					    $message.='
                       </td>
                       </tr>
                       </tbody>
					   </table>
                       </td>
                       </tr>
                    
                    
                      </tbody>
				      </table>
                      </td>
                      </tr>
       
                     </tbody>
	                 </table>
</div>
</body>
</html>';
//echo $message;
// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: <test.homespice@gmail.com>' . "\r\n";

//mail($to,$subject,$message,$headers);
    }

    /**
     * process controller_action_predispatch_adminhtml_system_config_edit event
     *
     * @return Advanced_Onestepcheckout_Model_Observer
     */
    public function adminhtml_system_config($observer) {
        if (Mage::app()->getRequest()->getParam('section') == 'onestepcheckout') {
            Mage::app()->getLayout()->getBlock('head')
                    ->addItem('skin_css', 'css/advanced/onestepcheckout/style.css')
                    ->addItem('skin_css', 'css/advanced/onestepcheckout/colpick.css')
                    ->addItem('js', 'advanced/checkout/lib/checkoutadmin.js')
                    ->addItem('js', 'advanced/checkout/lib/colorpicker/jquery-1.7.2.min.js')
                    ->addItem('js', 'advanced/checkout/lib/colorpicker/colpick.js')
                    ->addItem('js', 'advanced/checkout/lib/jquery-ui.min.js');
        }
    }

    /**
     * process checkout_type_onepage_save_order event
     *
     * @return Advanced_Onestepcheckout_Model_Observer
     */
    public function saveComment($observer) {
        $params = Mage::app()->getRequest()->getParams();
        if (Mage::getStoreConfig('onestepcheckout/features/order_comment', Mage::app()->getStore()->getStoreId())) {
            $comment = trim($params['billing']['order_comment']);
            if ($comment != '') {
                $order = $observer->getEvent()->getOrder();
                try {
                    $order->addStatusHistoryComment($comment, false);
                } catch (Exception $e) {
                    
                }
            }
        }
    }

}
