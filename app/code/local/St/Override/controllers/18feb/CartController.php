<?php
require_once 'Mage/Checkout/controllers/CartController.php';
class St_Override_CartController extends Mage_Checkout_CartController
{
	public function customAction()
	{
		
				$productId = Mage::app()->getRequest()->getParam('id');
				$qty= Mage::app()->getRequest()->getParam('qty');
                                
				$params = array( 'product' => $productId,'qty' => $qty );
				
				$cart = Mage::getSingleton('checkout/cart'); 
				$product = new Mage_Catalog_Model_Product();
				$product->load($productId); 
				
				if(is_object($product) && $productId>0 && $product->getSku()!='')
				{
				  $cart->addProduct($product, $params);
				  $cart->save(); 
				  Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
				  $this->_redirect('onestepcheckout');
				}
				else
				{
					 $this->_redirectUrl(Mage::getBaseUrl());
				}
                  //  echo 'I successfully Override Cart Controller';
	 
	}

	public function customremoveAction()
	{
		try {
        	$productId = Mage::app()->getRequest()->getParam('id');
			$qty= Mage::app()->getRequest()->getParam('qty');
			$cartHelper = Mage::helper('checkout/cart');
			$items = $cartHelper->getCart()->getItems();
			foreach ($items as $item) {
			    if ($item->getProduct()->getId() == $productId) {
			        if( $item->getQty() == 1 ){
			            $cartHelper->getCart()->removeItem($item->getItemId())->save();
			        }
			        else if($item->getQty() > 1){
			            $item->setQty($item->getQty() - 1);
			            $cartHelper->getCart()->save();
			        }
			        break;
			    }
			}

        } catch (Exception $e) {
            $this->_getSession()->addException($e, $this->__('Cannot update shopping cart.'));
            Mage::logException($e);
        }
    }
	
	public function addcustomAction()
	{
		
				$productId = Mage::app()->getRequest()->getParam('id');
				$qty=1;
				$params = array( 'product' => $productId,'qty' => $qty );
				
				$cart = Mage::getSingleton('checkout/cart'); 
				$product = new Mage_Catalog_Model_Product();
				$product->load($productId); 
				
				if(is_object($product) && $productId>0 && $product->getSku()!='')
				{
				  $cart->addProduct($product, $params);
				  $cart->save(); 
				  Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
				  echo "success";
				}
				
                  
	 
	}
	
	public function paylaterAction()
	{
		$params         = $this->getRequest()->getParams(); 
		//print_r($params); die;
		$customerLoginStatus   = $params['customerStatus'];
		if($customerLoginStatus=='notloggedin')
		{
						$customerFirstname     = '';//trim($params['firstname']);
						$customerLastname      = trim($params['lastname']);
						$customermobileno      = trim($params['mobileno']);
						$customerEmail         = trim($params['email']);
						
						$customerName = $customerLastname; //die;
						$packageArray=array();
						$cart = Mage::getModel('checkout/cart')->getQuote();

						foreach ($cart->getAllVisibleItems() as $item) 
						{ 
						  $packageArray[]= $item->getProduct()->getName();
						  
						}
						$packages  = implode(",",$packageArray);
						
						$tmpMessage="In lifeheal.com, a customer ".$customerName." with mobile no ".$customermobileno." applied for ".$packages;
						$message = urlencode($tmpMessage);
					   // echo $message;
						//die;
						$mobileNoArray = array('9990536388');
						foreach($mobileNoArray as $mobileNo)
						{
							$varSMSURL = "http://msg160.com/sendsms/send1?userid=lifeheal&pass=cq.z7*kC}NF9&sender=FOODFL&mobile=".$mobileNo."&message=".$message."&route=5";
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
										//echo "<br>done<br>";
						} 
						$cart = Mage::getSingleton('checkout/cart'); 
						$quoteItems = Mage::getSingleton('checkout/session')
										  ->getQuote()
										  ->getItemsCollection();
						 
						foreach( $quoteItems as $item ){
							$cart->removeItem( $item->getId() );    
						}
						$cart->save();
						echo  "success";
	    }          
	 
	}
	
	public function createuseronsuccessAction()
	{
		$params         = $this->getRequest()->getParams();
		
		$status = trim($params['status']);
		$lastname = trim($params['name']);
		$city = trim($params['city']);
		$mobile = trim($params['mobile']);
		$newemail = trim($params['email']); 
		$newpassword = trim($params['password']);	
		
		$emailStr    = 'Dear'.$mobile;
		$oldemail       = trim($emailStr."@curemydiabetes.com"); 
				
			
		if($status=='notloggedin' )
		{
			
		
			
			///////////////////////////SEND SMS, USERNAME AND PASSWORD, To Customer ////////////////////////
 $tmpMessage ="Thank you for registering with CureMyDiabetes.com, your username is ".$mobile." and password is ".$newpassword;
 $message = urlencode($tmpMessage);

$mobileNoArray = array($mobile);
						foreach($mobileNoArray as $mobileNo)
						{
							$varSMSURL = "http://msg160.com/sendsms/send1?userid=lifeheal&pass=cq.z7*kC}NF9&sender=FOODFL&mobile=".$mobileNo."&message=".$message."&route=5";
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
										//echo "<br>done<br>";
						} 
 
  ///////////////////////////End SMS To Customer ////////////////////////
			
			
			
			////////////////////////Send Email To Customer ///////////////////
					
				$templateId = 1;
	             $storeId=Mage::app()->getStore()->getStoreId();
				// Set sender information			
				$senderName = Mage::getStoreConfig('trans_email/ident_support/name');
				$senderEmail = 'test@gmail.com';//Mage::getStoreConfig('trans_email/ident_support/email');		
				$sender = array('name' => $senderName,
							'email' => $senderEmail);
				
				// Set recepient information
				$recepientEmail = $newemail;
				$recepientName = $name;		
				
				// Get Store ID		
				$store = Mage::app()->getStore()->getId();
			    $emailTemplate = Mage::getModel('core/email_template')->loadByCode($templateId);
				// Set variables that can be used in email template
				$vars = array('customeremail' => $newemail,
						  'customerpassword' => $newpassword);
				// echo $emailTemplate->getProcessedTemplate($vars);     
				$translate  = Mage::getSingleton('core/translate');
			 
				// Send Transactional Email
				Mage::getModel('core/email_template')
					->sendTransactional($templateId, $sender, $recepientEmail, $recepientName, $vars, $storeId);
						
				$translate->setTranslateInline(true);	
			
			///////////////////////////////////////////////////////
		}
		
	}
	
	public function nextAction()
	{
		$params         = $this->getRequest()->getParams();
		
		$status      = trim($params['status']);
		$firstname   = 'Dear';
		$lastname    = trim($params['fullname']);
		$mobile      = trim($params['mobile']);
		$emailStr    = 'Dear'.$mobile;
		$email       = trim($emailStr."@curemydiabetes.com"); 

		////////////////////////////// Check By Mobile No that customer already exist or not ///////////////////////
		$existingCustomerEmail='';
		$customers    = Mage::getResourceModel('customer/customer_collection')
									 ->addAttributeToSelect('*')
									->addAttributeToSelect('primarymobileno')
									->addAttributeToFilter('primarymobileno', $mobile )
									->getFirstItem();
	
	;	
		if(isset($customers) && count($customers)==1 && $customers->getEmail()!='')
		{
			$existingCustomerEmail= $customers->getEmail(); //die;
		}
		
		
		/////////////////////////////////////////////////////////////////////////////////////////////////
		
	

		if( $existingCustomerEmail=='' )  //If customer not exist then create a new customer
		{
			
			$password = $mobile;
			$websiteId = Mage::app()->getWebsite()->getId();
            $store = Mage::app()->getStore();
			$customer = Mage::getModel("customer/customer");
			$customer->setWebsiteId($websiteId);
			$customer->setStore($store);
			
			$customer->setFirstname($firstname);
			$customer->setLastname($lastname);
			
			$customer->setEmail($email);
			$customer->setPassword($password);
			$customer->setPrimarymobileno($mobile);
			$customer->save();
			
			/*$customer = Mage::getModel('customer/customer');
		$customer->setWebsiteId(Mage::app()->getWebsite()->getId());
		$customer->loadByEmail($email);	
		
			$tmpPostcode = 110001;
		    $tmpCity = 'tmpcity';
		    $tmpStreet='Street Address';
		
			
			$address = Mage::getModel("customer/address");
			$address->setCustomerId($customer->getEntityId())
					->setFirstname($customer->getFirstname())
					
					->setLastname($customer->getLastname())
					->setCountryId('IN')
					->setTelephone($mobile)
					->setCity($tmpCity)
					->setPostcode($tmpPostcode)
					->setStreet($tmpStreet)
					->setIsDefaultBilling('1')
					->setIsDefaultShipping(false)
					->setSaveInAddressBook('1');
			       $address->save();*/
			
			
		}
		else 
		{
			   $customer = Mage::getModel('customer/customer');
		       $customer->setWebsiteId(Mage::app()->getWebsite()->getId());
		       $customer->loadByEmail($existingCustomerEmail);	
		
			   $customer->setFirstname($firstname);
			   $customer->setLastname($lastname);
			   $customer->setPrimarymobileno($mobile);

			   $customer->save();
			
			/*$defaultBilling  = $customer->getDefaultBillingAddress();
			$defaultBilling->getTelephone();
			$defaultBilling->setTelephone($mobile);
			$defaultBilling->save();*/
			
			//echo "Customer email changed"; 
		}
	}
	
	public function updatecityAction()
	{
		$params         = $this->getRequest()->getParams();
		$status      = trim($params['status']);
		$firstname   = 'Dear';
		$lastname    = trim($params['fullname']);
		
		$mobile = trim($params['mobile']);
		$city = trim($params['city']);
		
		$emailStr    = 'Dear'.$mobile;
		$email = trim($emailStr."@curemydiabetes.com"); 
		
		////////////////////////////// Check By Mobile No that customer already exist or not ///////////////////////
		$existingCustomerEmail='';
		$customers    = Mage::getResourceModel('customer/customer_collection')
									 ->addAttributeToSelect('*')
									->addAttributeToSelect('primarymobileno')
									->addAttributeToFilter('primarymobileno', $mobile )
									->getFirstItem();
							
		if(isset($customers) && count($customers)==1 && $customers->getEmail()!='')
		{
			$existingCustomerEmail= $customers->getEmail(); //die;
		}
		/////////////////////////////////////////////////////////////////////////////////////////////////
		$customer = Mage::getModel('customer/customer');
		$customer->setWebsiteId(Mage::app()->getWebsite()->getId());
		if($existingCustomerEmail!='')  //load already existing customer
		{
			$customer->loadByEmail($existingCustomerEmail);	
			
		}
		else  // load the customer which was created by mobile no
		{
			$customer->loadByEmail($email);	
		}
					
		if($customer->getEntityId()!='')
		{
		  //  print_r($customer); die;
		    $customer->setFirstname($firstname);
			$customer->setLastname($lastname);
			$customer->setPrimarymobileno($mobile);
			$customer->setLeadcity($city);
			$customer->save();
			echo "customer data updated";// die;
		}
			
		
	}
	
	
	public function customoptionAction()
	{
		
             
              /*$entityId = '1728';
       //     $entityId= '1729';
            
            $product = Mage::getModel("catalog/product")->load($entityId);
            echo $product->getName(); echo "<br>";
         $options = $product->getProductOptionsCollection();
         foreach ($options as $o) 
         { 
              $values = $o->getValues();
              foreach($values as $v)
              {
                 echo $v->getTitle().'--'.$v->getOptionTypeId().'--'.$v->getOptionId(); echo "<br>";
               }

          } */
          
                               $params  = $this->getRequest()->getParams();
             				
                       
				$productId = Mage::app()->getRequest()->getParam('id');
                              	$qty= Mage::app()->getRequest()->getParam('qty');
                                $optionid = Mage::app()->getRequest()->getParam('optiontypeid');
                               // echo "optionTypeid=".$optiontypeid ;
                                $optiontypeid = Mage::app()->getRequest()->getParam('optionid');
                                 // echo "optionid=".$optionid ;
                                                           
                                $options[$optionid] = $optiontypeid ;
                                
                                   
                                
				$params = array( 'product' => $productId,'qty' => $qty,'options' => $options  );
				
				$cart = Mage::getSingleton('checkout/cart'); 
                                
				$product = new Mage_Catalog_Model_Product();
				$product->load($productId); 
				
				if(is_object($product) && $productId>0 && $product->getSku()!='')
				{
                                //print_r($params);  print_r($options); die();
				  $cart->addProduct($product, $params);
				  $cart->save(); 
				  Mage::getSingleton('checkout/session')->setCartWasUpdated(true); // die;
				  $this->_redirect('onestepcheckout'); return;
				}
				else
				{
					echo "else part"; die;
				}
                  
                                 
	 
	}
        
        
        public function addcombotocartAction()
	{
                   $params  = $this->getRequest()->getParams();
                    $productId = Mage::app()->getRequest()->getParam('entityid'); 
                    $qty= Mage::app()->getRequest()->getParam('qty');
                    $bundleItemsParamValue = Mage::app()->getRequest()->getParam('options');
                    $bundled_product = Mage::getModel("catalog/product")->load($productId);
                    $requireSelection = $bundled_product->getRequireSelection();
                   // echo 'requireSelection='.$requireSelection;
                    $bundleItemsArrayInfo = explode("_",$bundleItemsParamValue);
                    if(isset($requireSelection) && $requireSelection==1)
                    {  
                       $bundleItemsArrayInfo[]=10; 
                    }
                    $options = array();
                   // echo '<pre>';
                    // print_r($bundleItemsArrayInfo); die;
                    foreach($bundleItemsArrayInfo  as $bundleitem)
                    {
                       if($bundleitem!='')
                       {
                        
                        $itemDetails = explode(",",$bundleitem);
                       
                        $itemPosition =  $itemDetails[0];
                        $optionId = $itemDetails[1];
                        $selectionId = $itemDetails[2];
                        
                            if(  !isset($optionId)  || !isset($selectionId) )
                            {
                                
                               
                               if(isset($itemPosition) && in_array($itemPosition,array(1,10)))
                               {
                                  $defaultOptionidSelectionidArr = $this->getDefaultOptionidSelectionId($bundled_product,$itemPosition,true);
                                  //print_r($defaultOptionidSelectionidArr); 
                                 // echo '<hr>'; die;
                                  $optionId =   $defaultOptionidSelectionidArr[0];
                                  $selectionId = $defaultOptionidSelectionidArr[1];
                               }
                               else
                               {
                                   $defaultOptionidSelectionidArr = $this->getDefaultOptionidSelectionId($bundled_product,$itemPosition,false);

                                  $optionId =   $defaultOptionidSelectionidArr[0];
                                  $selectionId = $defaultOptionidSelectionidArr[1];
                               }
                            }
                            
                             if(isset($optionId) && $optionId>0)
                             {
                              $options[$optionId] = $selectionId;
                             }
                        /*if($itemType=='radio')
                        {
                             $options[ $optionId] = $selectionId;
                        }
                        if($itemType=='checkbox')
                        {

                            $selectionArray = explode(",",$selectionId);
                            $options[ $optionId] = $selectionArray;
                        }*/
                      }
                    }
                  //  print_r($options); die;

                    $params = array( 'product' => $productId,'qty' => $qty,'bundle_option' => $options  );
                   // print_r($params); //die;
                    $cart = Mage::getSingleton('checkout/cart'); 

                    $product = new Mage_Catalog_Model_Product();
                    $product->load($productId); 

                    if(is_object($product) && $productId>0 && $product->getSku()!='')
                    {
                      // print_r($params);
                      $cart->addProduct($product, $params);
                      $cart->save(); 
                      Mage::getSingleton('checkout/session')->setCartWasUpdated(true); // die;
                      echo 'added';
                     
                    }
                    else
                    {
                            echo "else part"; die;
                    }
     	}
        
       
        
         public function newsletterAction()
	 {
                 $email = $this->getRequest()->getParam('email');
       		  if ( isset($email) && $email!='') 
		  {      
				 
				 if( eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email) )
				  { 
					 ///////////////////////////////////////////////////////////////////
					 
			
						$subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($email);
						if ($subscriber->getId()) {
							 echo "You are already subscribed.";
						}
						else
						{
							 $status = Mage::getModel('newsletter/subscriber')->subscribe($email);
							 echo "Thank you for your subscription.";
						}
        
					 ///////////////////////////////////////////////////////////////////
				  }
				  else
				  {
					  echo "Please enter the correct email id.";
				  }
		  }
	  
    }
    
    public function getDefaultOptionidSelectionId($bundled_product,$cuisinePosition,$selectedItem)
    {
        
   
      //  
        $optionsCollection = $bundled_product->getTypeInstance(true)->getOptionsCollection($bundled_product);
        $defaultOptionidSelectionidArr = array();
        $removedPosArray = array();
        $checkItemPositionRemoved = $bundled_product->getRemoveBundleItem();
        if(isset($checkItemPositionRemoved))
        {
            $removedPosArray = explode("-",$checkItemPositionRemoved);
         }
        foreach ($optionsCollection as $options) 
        { 
          $optionId =  $options->getOptionId();
          $optionPosition = $options->getPosition();
          
                if($optionPosition == $cuisinePosition ) 
                 {
                    
                      if($selectedItem==true &&  !in_array($optionPosition,$removedPosArray) )
                      {
                        $selectionCollection = $bundled_product->getTypeInstance()->getSelectionsCollection(array($optionId));
                        foreach($selectionCollection as $option) 
                        {

                           if($option->is_default==1)
                           {
                                $defaultOptionidSelectionidArr[]= $optionId;
                                $defaultOptionidSelectionidArr[]= $option->selection_id;

                           } 

                        }
                      }
                      else
                      {
                            $defaultOptionidSelectionidArr[]= $optionId;
                            $defaultOptionidSelectionidArr[]= ''; 
                      }
                 }
           }
       return $defaultOptionidSelectionidArr;
       
    }
            
	
	public function getcartinfoAction()
        {
            $system='';
            $useragent=$_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))

        { 
            $system= "mobile";
        }
        else{
          $system= "desktop";
        }
 
            $totalItems = Mage::getModel('checkout/cart')->getQuote()->getItemsCount();
            $totalQuantity = Mage::getModel('checkout/cart')->getQuote()->getItemsQty();


            $subTotal = Mage::getModel('checkout/cart')->getQuote()->getSubtotal();
            $grandTotal = Mage::getModel('checkout/cart')->getQuote()->getGrandTotal();

           // echo $totalQuantity .'--'.$subTotal;
            $viewbottomStr ='';
           // echo $system;
            if(trim($system)!='desktop')
            {  
                $viewbottomStr.='<div class="viewdivbottom" ><div class="itemqty">'.round($totalQuantity,4).' item | <span class="rupee">'.round($subTotal,4).'</spanclass></div> <div class="viewcart"><a href="'.Mage::getBaseUrl().'onestepcheckout">View Cart</a></div></div>';
            }
            echo $viewbottomStr;
          
        }
        
        
	
}
	

