<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Customer
 * @copyright  Copyright (c) 2006-2018 Magento, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Customer account controller
 *
 * @category   Mage
 * @package    Mage_Customer
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class St_Override_IndexController extends Mage_Core_Controller_Front_Action
{
    public function checkprimarymobilenoAction()
	{
		$primarymobileno = Mage::app()->getRequest()->getParam('primarymobileno');
		$customer    = Mage::getResourceModel('customer/customer_collection')
                     ->addAttributeToSelect('*')
                    ->addAttributeToFilter('primarymobileno', $primarymobileno )
                    ->getFirstItem();
		 $customerEmail = $customer->getEmail();			
					
					//echo  "<pre>"; print_r($customer);
					//echo "size=".sizeof($customer);
	  if($customerEmail!='')
	  {
		   echo "exist";
	  }
	  else
	  {
		 echo "false";
	  }
	}
	
	
	public function checkemailAction()
	{ //echo "testing"; die;
		$email = Mage::app()->getRequest()->getParam('email'); //die;
		$customer    = Mage::getResourceModel('customer/customer_collection')
                     ->addAttributeToSelect('*')
					
                    ->addAttributeToFilter('email', $email )
                    ->getFirstItem();
		 $customerEmail = $customer->getEmail();
	  if($customerEmail!='')
	  {
		  echo "exist";
	  }
	  else
	  {
		 echo "false";
	  }
	}
        
        public function newsletterAction()
	 {
      

		  if ( $this->getRequest()->isPost() && $this->getRequest()->getPost('email') ) 
		  {      
				 $email = $this->getRequest()->getPost('email');
				 if( eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email) )
				  { 
					 ///////////////////////////////////////////////////////////////////
					 
			
						$subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($email);
						if ($subscriber->getId()) {
							 echo "You are already subscribed to newsletter.";
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
    
    
    public function getcategoryproductsAction()
    {  //echo "shailesh"; 
        $catid = Mage::app()->getRequest()->getParam('catid');
        $showfav = Mage::app()->getRequest()->getParam('showfav'); 
         $identifier = 'category-products-'.$catid;
        if(isset($showfav) && $showfav==1)
        {
             $identifier = 'category-products-'.$catid.'-fav';
        }
        
       echo $this->getLayout()->createBlock('cms/block')->setBlockId($identifier)->toHtml(); 
    }

    public function setdeliverytimedateAction() { 
      $deliverydaytime = Mage::app()->getRequest()->getParam('deliverydaytime');
      Mage::getSingleton('core/session')->setDeliverydaytime($deliverydaytime);
      $myValue  =  Mage::getSingleton('core/session')->getDeliverydaytime();
    }
    
     public function getcuisinitemsAction()
    {
        // $entityId = 1835; 
         $entityId = Mage::app()->getRequest()->getParam('entityid'); 
         $cuisine = Mage::app()->getRequest()->getParam('cuisine'); 
            
         $bundled_product = Mage::getModel("catalog/product")->load($entityId);
         
         $removeBundleItem = $bundled_product->getRemoveBundleItem(); 
               $removeFirst=false;
               $removeSecond=false;
               
               $firstItemname  = 'Rice/ Roti';
               $tmpFirstname   =  $bundled_product->getFirstitem();
               if(isset($tmpFirstname) && $tmpFirstname!=''){          $firstItemname = $tmpFirstname; }
               
               $secondItemname = 'Soup'; 
               $tmpSecondname=    $bundled_product->getSeconditem();
               if(isset($tmpSecondname) && $tmpSecondname!=''){         $secondItemname = $tmpSecondname; }
               
               
               $thirdItemname  = 'Salad';    
               $tmpThirditemname =$bundled_product->getThirditem();
                if(isset($tmpThirditemname) && $tmpThirditemname!=''){  $thirdItemname = $tmpThirditemname; }
               
            
              /* if(isset($removeBundleItem) && $removeBundleItem!='')
               {
                   $removeBundleItemArray = explode("-",$removeBundleItem); 
                  // if($_product->getSku()=='combo-penne-pasta-arrabiata') {  print_r($removeBundleItemArray);  } 
                   if(isset($removeBundleItemArray[0]) && $removeBundleItemArray[0]==1)
                   {
                        $removeFirst=true;
                   }
                   else
                   {
                       if(isset($removeBundleItemArray[1]) && $removeBundleItemArray[1]==2)
                       {
                          $removeSecond=true;
                       }
                   }    
                   
               }*/
         
         
         
         
         $productName =  $bundled_product->getName(); 
         $productPrice =  round($bundled_product->getPrice(),4); 
         $ProductPricePlusCheckedItemPrice=0;
         $ProductPricePlusCheckedItemPrice+=$productPrice;
         $specialPrice =  round($bundled_product->getSpecialPrice(),4);
         if((isset($specialPrice) && $specialPrice > 0 )&& ($specialPrice < $productPrice)  ) { $productPrice = $specialPrice; }
         $status = $bundled_product->getStatus();
       
	    $optionsCollection = $bundled_product->getTypeInstance(true)->getOptionsCollection($bundled_product);
           // echo '<pre>'; 
           
            $optionArray = array();
            $bundleItem ='';
           
            $positionWiseOutPutArray = array();
            $cuisinePosition=0;
            $removeText='';
            if($cuisine=='riceroti'){ $cuisinePosition = 1;}
            else if($cuisine=='sabji'){ $cuisinePosition = 2; $removeText="Add ".$secondItemname."(<span class=\'rupee\'>50</span>)";
                 }
            elseif($cuisine=='salad'){ $cuisinePosition = 3;  $removeText="Add ".$thirdItemname."(<span class=\'rupee\'>50</span>)"; 
            }
            
	    foreach ($optionsCollection as $options) 
             { 
                //print_r($options); die;
                $optionArray[$options->getOptionId()]['option_id'] =  $options->getOptionId();
	        $optionArray[$options->getOptionId()]['option_title'] = $options->getDefaultTitle();
	        $optionArray[$options->getOptionId()]['option_type'] = $options->getType();
                $optionArray[$options->getOptionId()]['option_position'] = $options->getPosition();
                
                $optionId =  $options->getOptionId();
                $optionPosition = $options->getPosition();
                
                $selectionCollection = $bundled_product->getTypeInstance()->getSelectionsCollection(array($optionId));
           
                
                $countOptions=0;
                $bundleItemOption='';
                $bundled_items = array(); 
                
                if($optionPosition == $cuisinePosition ) 
                {
                    $cuisineOutput='<ul class="dd--crst" >';
                    foreach($selectionCollection as $option) 
                    {

                            $bundled_items[$optionId][$countOptions]['option_id']  = $option->option_id;
                            $bundled_items[$optionId][$countOptions]['product_id'] = $option->product_id;
                            $bundled_items[$optionId][$countOptions]['name']       = $option->name;
                            $bundled_items[$optionId][$countOptions]['status']     = $option->status;
                            $bundled_items[$optionId][$countOptions]['is_default']    = ($option->is_default==1)?1:'0';
                            $bundled_items[$optionId][$countOptions]['selection_id'] = $option->selection_id;
                            $bundled_items[$optionId][$countOptions]['selection_qty'] = $option->selection_qty;
                            $bundled_items[$optionId][$countOptions]['sku'] = $option->sku;
                            $bundled_items[$optionId][$countOptions]['price'] = round($option->price,4);
                            $bundled_items[$optionId][$countOptions]['selection_price_value'] = round($option->selection_price_value,4); 
                            $bundled_items[$optionId][$countOptions]['position'] = $option->position;

                            if($option->is_default==1)
                            {
                                $ProductPricePlusCheckedItemPrice+=round($option->selection_price_value,4); 
                            }
                            ++$countOptions;

                            if(  $optionArray[$options->getOptionId()]['option_type'] == 'radio')
                             {

                                $cuisineOutput.='<li class="itm-dsc__actn__sz__dd-mn__itm '.$cuisine.'" id="'.$option->option_id.'_'.$option->selection_id.'"
                                    onmouseover="setSelection(\''.$cuisine.'\',\''.$option->option_id.'\',\''.$option->selection_id.'\')"  
                                    
                                    onclick="setCuisineItem('.$productPrice.','.$entityId.',\''.$cuisine.'\',\''.$option->option_id.'\',\''.$option->selection_id.'\',\''.$option->name.'\',\''.round($option->selection_price_value,4).'\')" >
                                                    <span class="crst-dd-spn" >
                                                               <span class="crst-dd-spn1"><b>'.$option->name.'</b></span>
                                                    </span>						
                                            </li>'; 

                             }

                    }
                    
                    if($cuisinePosition == 2 || $cuisinePosition == 3)
                    {
                      $cuisineOutput.='<li class="itm-dsc__actn__sz__dd-mn__itm '.$cuisine.'" id=""
                                    onmouseover="setSelection(\''.$cuisine.'\',\'\',\'\')"  
                                    
                                    onclick="setCuisineItem('.$productPrice.','.$entityId.',\''.$cuisine.'\',\'\',\'\',\''.$removeText.'\',\'\')" >
                                                    <span class="crst-dd-spn" >
                                                               <span class="crst-dd-spn1"><b>Remove</b></span>
                                                    </span>						
                                            </li>'; 
                    }
                    $cuisineOutput.='</ul>';
                    
                    
                    
                    
                }
                
              
                $optionArray[$options->getOptionId()]['selectionItems'] = $bundled_items;
                $positionWiseOutPutArray[$cuisine] =  $cuisineOutput;     
             }
             //echo '<pre>';
           //  print_r($positionWiseOutPutArray);
             echo $positionWiseOutPutArray[$cuisine];
             //echo $cuisineOutput;
        
    }
    
    public function getdeluxoptionitemsAction()
    {
        // $entityId = 1835; 
         $entityId = Mage::app()->getRequest()->getParam('entityid'); 
         $optionIdParam = Mage::app()->getRequest()->getParam('optionid'); 
            
         $bundled_product = Mage::getModel("catalog/product")->load($entityId);
         
         
              
         $productName =  $bundled_product->getName(); 
         $productPrice =  round($bundled_product->getPrice(),4); 
         $ProductPricePlusCheckedItemPrice=0;
         $ProductPricePlusCheckedItemPrice+=$productPrice;
         $specialPrice =  round($bundled_product->getSpecialPrice(),4);
         if((isset($specialPrice) && $specialPrice > 0 )&& ($specialPrice < $productPrice)  ) { $productPrice = $specialPrice; }
         $status = $bundled_product->getStatus();
         $optionsCollection = $bundled_product->getTypeInstance(true)->getOptionsCollection($bundled_product);
           
                    
	 foreach ($optionsCollection as $options) 
         { 
               $optionId =  $options->getOptionId();
             
                if($optionId== $optionIdParam ) 
                {
                      //echo $optionId."==". $optionIdParam;
                      $optionPosition = $options->getPosition();
                      $options_type = $options->getType();
                      $optionTitle = $options->getDefaultTitle();
                      $selectionCollection = $bundled_product->getTypeInstance()->getSelectionsCollection(array($optionId));

                      $selectionPrice=0;
                      $countOptions=0;


                        $cuisineOutput='<ul class="dd--crst" >';
                        foreach($selectionCollection as $option) 
                        {

                               /* $bundled_items[$optionId][$countOptions]['option_id']  = $option->option_id;
                                $bundled_items[$optionId][$countOptions]['product_id'] = $option->product_id;
                                $bundled_items[$optionId][$countOptions]['name']       = $option->name;
                                $bundled_items[$optionId][$countOptions]['status']     = $option->status;
                                $bundled_items[$optionId][$countOptions]['is_default']    = ($option->is_default==1)?1:'0';
                                $bundled_items[$optionId][$countOptions]['selection_id'] = $option->selection_id;
                                $bundled_items[$optionId][$countOptions]['selection_qty'] = $option->selection_qty;
                                $bundled_items[$optionId][$countOptions]['sku'] = $option->sku;
                                $bundled_items[$optionId][$countOptions]['price'] = round($option->price,4);
                                $bundled_items[$optionId][$countOptions]['selection_price_value'] = round($option->selection_price_value,4); 
                                $bundled_items[$optionId][$countOptions]['position'] = $option->position;
                                */
                                if(round($option->selection_price_value,4) >0)
                                {
                                    $selectionPrice= round($option->selection_price_value,4);
                                }
                               // ++$countOptions;

                                if(  $options_type == 'radio')
                                 {

                                    $cuisineOutput.='<li class="itm-dsc__actn__sz__dd-mn__itm class'.$optionId.'" id="'.$optionId.'_'.$option->selection_id.'"
                                        onmouseover="setDeluxSelection(\''.$optionId.'\',\''.$option->selection_id.'\')"   
                                        onmouseout="unsetDeluxSelection(\''.$optionId.'\',\''.$option->selection_id.'\')" 
                                        onclick="setDeluxCuisineItem('.$productPrice.','.$entityId.',\''.$optionId.'\',\''.$option->selection_id.'\',\''.$option->name.'\',\''.round($option->selection_price_value,4).'\')" >
                                                        <span class="crst-dd-spn" >
                                                                   <span class="crst-dd-spn1"><b>'.$option->name.'</b></span>
                                                        </span>						
                                                </li>'; 

                                 }

                        }

                       //  $removeText="Add ".$optionTitle."(<span class=\'rupee\'>".$selectionPrice."</span>)";
                           $removeText="Add ".$optionTitle;

                          $cuisineOutput.='<li class="itm-dsc__actn__sz__dd-mn__itm class'.$optionId.'" id=""
                                        onmouseover="setDeluxSelection(\''.$optionId.'\',\'\')"  
 onmouseout="unsetDeluxSelection(\''.$optionId.'\',\''.$option->selection_id.'\')" 
                                        onclick="setDeluxCuisineItem('.$productPrice.','.$entityId.',\''.$optionId.'\',\'\',\''.$removeText.'\',\'\')" >
                                                        <span class="crst-dd-spn" >
                                                                   <span class="crst-dd-spn1"><b>Remove</b></span>
                                                        </span>						
                                                </li>'; 

                        $cuisineOutput.='</ul>';
                        echo  $cuisineOutput;  
                    
                }
        }
            
        
    }
    public function oldajaxgetmodalwithcusomoptionAction()
    {
         //$entityId = 1833; 
         $entityId = Mage::app()->getRequest()->getParam('entityid'); 
         $bundled_product = Mage::getModel("catalog/product")->load($entityId);
         $productName =  $bundled_product->getName(); 
         $productPrice =  round($bundled_product->getPrice(),4); 
         $ProductPricePlusCheckedItemPrice=0;
         $ProductPricePlusCheckedItemPrice+=$productPrice;
         $specialPrice =  round($bundled_product->getSpecialPrice(),4);
         if((isset($specialPrice) && $specialPrice > 0 )&& ($specialPrice < $productPrice)  ) { $productPrice = $specialPrice; }
         $status = $bundled_product->getStatus();
       
	    $optionsCollection = $bundled_product->getTypeInstance(true)->getOptionsCollection($bundled_product);
            
           
            $optionArray = array();
            $bundleItem ='';
               
	    foreach ($optionsCollection as $options) 
             { 
                
                $optionArray[$options->getOptionId()]['option_id'] =  $options->getOptionId();
	        $optionArray[$options->getOptionId()]['option_title'] = $options->getDefaultTitle();
	        $optionArray[$options->getOptionId()]['option_type'] = $options->getType();
                $optionId =  $options->getOptionId();
                
                $bundleItem.= '<div class="productnamecombo">
				 <span style="width: 100%;float: left;"><span class="asterikbox">*</span>'.$options->getDefaultTitle().'</span><span id="count_'.$options->getOptionId().'"></span>';  
               
                $selectionCollection = $bundled_product->getTypeInstance()->getSelectionsCollection(array($optionId));
           
                $bundled_items = array();
                $countOptions=0;
                $bundleItemOption='';
                foreach($selectionCollection as $option) 
                {

                       
                        $bundled_items[$countOptions]['product_id'] = $option->product_id;
                        $bundled_items[$countOptions]['name'] = $option->name;
                        $bundled_items[$countOptions]['status'] = $option->status;
                        $bundled_items[$countOptions]['checked'] = ($option->is_default==1)?'checked':'';
                        $bundled_items[$countOptions]['option_id'] = $option->option_id;
                        $bundled_items[$countOptions]['selection_id'] = $option->selection_id;
                        $bundled_items[$countOptions]['selection_qty'] = $option->selection_qty;
                        $bundled_items[$countOptions]['sku'] = $option->sku;
                        $bundled_items[$countOptions]['price'] = round($option->price,4);
                        $bundled_items[$countOptions]['selection_price_value'] = round($option->selection_price_value,4); 
                        $bundled_items[$countOptions]['position'] = $option->position;
                        
                        if($option->is_default==1)
                        {
                            $ProductPricePlusCheckedItemPrice+=round($option->selection_price_value,4); 
                        }
                        ++$countOptions;
                         if($options->getType()=='select')
                        {
                             $bundleItemOption.='<label class="containerradio radio-inline" >'. $option->name.'+'. round($option->selection_price_value,4).'
                                               <input type="radio" '.$bundled_items[$countOptions]['checked'].'   name="radio'.$option->option_id.'" selectionid = "'.$option->selection_id.'" 
                                                   optionid = "'.$option->option_id.'" price = "'.round($option->selection_price_value,4).'" 
                                                   value="'.$option->option_id.','.$option->selection_id.'" onclick="finalPrice('.$productPrice.');">
                                             <span class="checkmark"></span> </label>';
                        }
                       else if($options->getType()=='radio')
                        {
                             $bundleItemOption.='<label class="containerradio radio-inline" >'. $option->name.'+'. round($option->selection_price_value,4).'
                                               <input type="radio" '.$bundled_items[$countOptions]['checked'].'   name="radio'.$option->option_id.'" selectionid = "'.$option->selection_id.'" 
                                                   optionid = "'.$option->option_id.'" price = "'.round($option->selection_price_value,4).'" 
                                                   value="'.$option->option_id.','.$option->selection_id.'" onclick="finalPrice('.$productPrice.');">
                                             <span class="checkmark"></span> </label>';
                        }
                        elseif($options->getType()=='checkbox') 
                        {
                            $bundleItemOption.='<label class="containerradio radio-inline" >'. $option->name.'+'. round($option->selection_price_value,4).'
                                               <input type="checkbox" '.$bundled_items[$countOptions]['checked'].'  name="checkbox'.$option->selection_id.'"  selectionid = "'.$option->selection_id.'" 
                                                   optionid = "'.$option->option_id.'"   price = "'.round($option->selection_price_value,4).'" 
                                                   value="'.$option->option_id.','.$option->selection_id.'" onclick="finalPrice('.$productPrice.');">
                                             <span class="checkmark"></span> </label>';
                        }
                }  
               
                 $optionArray[$options->getOptionId()]['selection_items'] = $bundled_items;
                 
                  $bundleItem.= $bundleItemOption.'</div>';  
             }
             
             $finalOutput='  <!-- Modal content -->
                      <div class="modal-content">
                        <span class="close" onClick="hidepopup()">&times;</span>
                               <div class="_1EZLh">
                                     <div class="_1ZOkC icon-foodSymbol _3qfEf"></div>
                                     <div class="_1H0SZ">
                                            <div class="hzcR7">
                                                    <div class="draJe" >'.$productName.'</div>
                                                    <div class="_3GIu4" id="combopriceup"><span class="ueSas finalPrice" id="upFinalPrice">' .$ProductPricePlusCheckedItemPrice.'</span></div>
                                                    <div class="hrbox"></div>'.$bundleItem.'


                                           </div>
										  
                                      </div>
 <textarea rows="4" cols="50" style="margin-left: 0px;width: 100%;display: -ms-flexbox;display: flex;margin-bottom: 20px;"></textarea>
                               </div>
                              <div class="_3coNr"><span class="mmytI">Total <span class="_3RJsr" id="downFinalPrice">'.$ProductPricePlusCheckedItemPrice.'</span></span><span class="_38xdN" onclick="addCompboTOCart('.$entityId.')">Add Item</span></div>	
                              
                    </div>';
           echo $finalOutput;
        
    }
    
    public function getsubcatsinfoAction()
    {
             $catId = Mage::app()->getRequest()->getParam('catid'); 
             $buttonid = Mage::app()->getRequest()->getParam('buttonid'); 
              
            $model_category =   Mage::getModel('catalog/category')->load($catId);
            $sub_categories     =   $model_category->getCollection();
            $sub_categories     ->  addAttributeToSelect('url_key')
                                ->  addAttributeToSelect('name')
                                ->  addAttributeToFilter('is_active',1)
                                ->  addIdFilter($model_category->getChildren())
                                ->  setOrder('position', 'ASC')
                                ->  load();
        

          $subCatStr='<a href="javascript:void(0);" onclick="showCategoryProducts(\''.$buttonid.'\')" >All</a>';
          foreach($sub_categories as $subcategory)
          {
              if($subcategory->getIsActive())
              {
                 $subcatId   = $subcategory->getEntityId();
                 $subCatname = $subcategory->getName();
                 $urlKey     = $subcategory->getUrlKey();
                 
                 $subCatStr.='<a href="javascript:void(0);" onclick="showCategoryProducts(\''.$urlKey.'\')" >'.$subCatname.'</a>';
              }
          }
          echo $subCatStr;
    }
    
    public function checkcustomerloginornotAction()
        {
             if(!Mage::getSingleton('customer/session')->isLoggedIn()){
                        echo "notloggedin";
            }else{
                echo "loggedin";
            }         
        }
        
        
        public function customerloginAction()
        {
            
                 $email    = Mage::app()->getRequest()->getParam('email'); 
                 $pass     = Mage::app()->getRequest()->getParam('pass'); 
                 $isemail  = Mage::app()->getRequest()->getParam('isemail'); 
                  $collection = Mage::getModel('customer/customer')->getCollection();
                 if($isemail==false)
                 {
                   $collection->addAttributeToFilter('primarymobileno', array('eq' => $email));
                 }else
                 {
                   $collection->addAttributeToFilter('email', array('eq' => $email)); 
                 }
                    
                    //echo 'size of collection='.sizeof($collection);
                    if(sizeof($collection)==1)
                    {
                      $custData = $collection->getData();
                      $customer = Mage::getModel('customer/customer')->load($custData[0]['entity_id']);
                      Mage::getSingleton('customer/session')->loginById($customer->getId());
                      echo 'loggedin';
                    }
                    else
                    {
                        echo 'notloggedin';
                    }
                //   $return['succeess'] = "Login Otp Verified Succeess";
                  //  print_r($customer);
        }
        
         public function deluxsubscriptionAction()
        {
              $comboId    = Mage::app()->getRequest()->getParam('productid');  //echo '<br>';
              $selectedOptionids     = Mage::app()->getRequest()->getParam('selectedoptionids');//echo '<br>';
              $customerpreference     = Mage::app()->getRequest()->getParam('customerPreference');//echo '<br>';
              $productType     = Mage::app()->getRequest()->getParam('productType');//echo '<br>';
            
              $optionType = 'radio';
              $optionType = Mage::app()->getRequest()->getParam('optionType');//echo '<br>';
              if(isset($optionType) && $optionType!='')
              {
                 $optionType='checkbox'; 
              }
              
             //  echo 'customerpreference='.$customerpreference; die;
            $allParams =  $this->getRequest()->getParams();
        //  echo '<pre>';  print_r($allParams);
             
             $LoggedIncustomer = Mage::helper('customer')->getCustomer();
             $customerId = $LoggedIncustomer->getId();
             $customerName = $LoggedIncustomer->getFirstname();
             $mobileno = $LoggedIncustomer->getPrimarymobileno();
          
            
             $bundled_product = Mage::getModel("catalog/product")->load($comboId);
             $comboProductName =  $bundled_product->getName(); 
             
             $comboInfo = array();
             
             if(is_object($bundled_product) && $productType=='bundle' && $selectedOptionids!='')
             {
                 $selectedOptionIdArray = explode(",",$selectedOptionids);
                 $count=0;
                 foreach($selectedOptionIdArray as $OptionIdSelectionId)
                 { 
                     if($OptionIdSelectionId!='')
                     {  
                         
                         $optionIdSelectionArray = explode("-",$OptionIdSelectionId);
                         $optionId = $optionIdSelectionArray[0];
                         $selectionId = $optionIdSelectionArray[1];
                         $iteminfo    = $this->getOptionSelectionItemname($bundled_product,$optionId,$selectionId);
                         $itemName    = $iteminfo[0];
                         $itemEntityId = $iteminfo[1];
                         
                         $data='';
                         $data = array(
                            'custid'=>$customerId,
                            'mobileno'=>$mobileno,
                            'custname'=>$customerName, 
                            'combo_id'=>$comboId,
                            'combo_name'=>$comboProductName,
                            'combo_options'=>$optionType,
                            'combo_option_id'=>$optionId,
                            'combo_selection_id'=>$selectionId, 
                            'product_is_combo_child'=>'yes',
                            'productid'=>$itemEntityId,
                            'productname'=>$itemName
                             );
                         
                         $comboInfo[] = $data;
                         
                     }
                 }
             }
             else if(is_object($bundled_product) && $productType=='simple' ){

                    $data='';
                         $data = array(
                            'custid'=>$customerId,
                            'mobileno'=>$mobileno,
                            'custname'=>$customerName, 
                           //'combo_id'=>$comboId,
                            //'combo_name'=>$comboProductName,
                           // 'combo_option_id'=>$optionId,
                            //'combo_selection_id'=>$selectionId, 
                            'product_is_combo_child'=>'no',
                            'productid'=>$comboId,
                            'productname'=>$comboProductName
                             );
                         
                         $comboInfo[] = $data;
                }
             
            echo '<pre>'; print_r($comboInfo);
             $comboCollection='';
             if($productType=='bundle')
             {
                  $comboCollection = Mage::getModel('favourite/customerfavourite')->getCollection()
                              ->addFieldToFilter('custid',$customerId)
                                ->addFieldToFilter('combo_id',$comboId)
                                 ->addFieldToFilter('product_is_combo_child','yes');
                               
             }
             else  if($productType=='simple')
             {
                  $comboCollection = Mage::getModel('favourite/customerfavourite')->getCollection()
                              ->addFieldToFilter('custid',$customerId)
                                ->addFieldToFilter('productid',$comboId)
                                 ->addFieldToFilter('product_is_combo_child','no');
                               
             }
          //  echo 'size='.sizeof($comboCollection);
            if(sizeof($comboCollection)>0)
            {
               foreach($comboCollection as $row)
               {
                 //  print_r($row); die;
                    $custFavId = $row->getCustfavId();
                   $model = Mage::getModel('favourite/customerfavourite')->load($custFavId);
                   $model->delete();

               }
            }
          //echo 'customerpreference='.$customerpreference;
            if($customerpreference=='liked')
            {
                if(sizeof($comboInfo)>0)
                {
                    foreach($comboInfo as $key=>$data)
                    {
                       // print_r($data); //die;
                        $model = Mage::getModel('favourite/customerfavourite');
                        $model->setData($data);
                        $model->save();
                    }
                }
            }
  
        }

        
        protected function getOptionSelectionItemname($bundled_product,$optionIdParam,$selectionIdParam)
        {
            $optionsCollection = $bundled_product->getTypeInstance(true)->getOptionsCollection($bundled_product);
           foreach ($optionsCollection as $options) 
           { 
               $optionId =  $options->getOptionId();
             
               if($optionId== $optionIdParam ) 
                {
                     
                      
                      $selectionCollection = $bundled_product->getTypeInstance()->getSelectionsCollection(array($optionId));

                      
                        foreach($selectionCollection as $option) 
                        {
                            
                            if($option->selection_id==$selectionIdParam)
                            {
                                return array($option->name,$option->product_id);
                            }
                        }

                 
                  }
             }
        }
        
        
        public function accountmobileAction(){
          //$helper = Mage::helper('sociallogin');
          $params = $this->getRequest()->getParams(); 
          $phone = $params['phone'];
          $otp = $params['otp'];
          $this->sendOtp($phone,$otp);
          //echo $helper->sendOtp($phone,$otp);
        }

        public function sendOtp($phone, $otp){ 
         $response = array();
		 $email= $phone."@lifeheal.in";
         $customers  = Mage::getResourceModel('customer/customer_collection')
             ->addAttributeToSelect('*')
             ->addAttributeToFilter('primarymobileno', $phone)
			  ->addAttributeToFilter('email', $email);
			 

         if(count($customers)>0){ 
         $message = 'Dear+Customer,+'.$otp.'+is+your+OTP+to+authenticate+your+login';
        
	//	$varSMSURL = "http://msg160.com/sendsms/send1?userid=lifeheal&pass=lifeheal2019&sender=UPDATE&mobile=".$phone."&message=".$message."&route=5";
	  $varSMSURL = "185.136.166.131/domestic/sendsms/bulksms.php?username=lifeheal&password=lifeheal&type=TEXT&sender=UPDATE&mobile=".$phone."&message=".$message;
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
          $message =('An OTP Code has been sent to your Number');
          $response['status'] = 'success';
          $response['message'] = $message;
          }else{
            $message =('Please register with us for login');
            $response['status'] = 'error';
            $response['message'] = $message;
          }
          $this->getResponse()->clearHeaders()->setHeader('Content-type','application/json',true);
          $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
        }

        public function verifyotpAction(){
          //$helper = Mage::helper('sociallogin');
          // $params = $this->getRequest()->getParams(); 
          // $phone = $params['phone'];
          // $otp = $params['otp'];
          // $this->sendOtp($phone,$otp);
          //echo $helper->sendOtp($phone,$otp);
        }
        
        public function loginmobileAction(){
          $params = $this->getRequest()->getParams(); 
          $phone = $params['phone'];
		  $email= $phone."@lifeheal.in";
          $reditts = $params['reditts'];
           $customers  = Mage::getResourceModel('customer/customer_collection')
             ->addAttributeToSelect('*')
             ->addAttributeToFilter('primarymobileno', $phone)
			 ->addAttributeToFilter('email', $email);

            if(count($customers)==1){
                foreach($customers as $tmpCustomer) {
                    $email= $tmpCustomer->getEmail();
                }
            }
			
			 // echo "count=".count($customers); echo "<br>";
			 // echo "website id=".Mage::app()->getWebsite()->getId(); echo "<br>";
            // echo "Email=".$email;  //die;
            if($email){ // echo "---1---";
              $logincustomer = Mage::getModel("customer/customer");
              $logincustomer->setWebsiteId(Mage::app()->getWebsite()->getId());
			  
			 
              // Load our customer by email
              $logincustomer->loadByEmail($email);
			// echo "<pre>"; print_r($logincustomer);; die;
			  
			  // echo "custid=".$logincustomer->getId(); 
              // Load the session up
              $sess = Mage::getSingleton("customer/session");
              // Login by ID
              $sess->loginById($logincustomer->getId());
              // Set the customer as logged in
              $sess->setCustomerAsLoggedIn($logincustomer);
			//  echo "---2----";
			   
			   /*if(Mage::getSingleton('customer/session')->isLoggedIn()) {
     
                  echo "Logged in".$logincustomer->getId(); die;
                 }
				 else
				 { echo "Not logged in"; die;}  */
              if($reditts =='reditts'){
                $this->_redirectReferer();
              }
            }
        }
        
        		//////////////////////////// Start OTP For registeration ///////////////////////
		
		 public function newaccountmobileAction(){
          //$helper = Mage::helper('sociallogin');
          $params = $this->getRequest()->getParams(); 
          $phone = $params['phone'];
          $otp = $params['otp'];
          $this->newaccountSendOtp($phone,$otp);
          //echo $helper->sendOtp($phone,$otp);
        }

        public function newaccountSendOtp($phone, $otp){ 
         $response = array();
		 $email = $phone."lifeheal.in";
         $customers  = Mage::getResourceModel('customer/customer_collection')
             ->addAttributeToSelect('*')
             ->addAttributeToFilter('primarymobileno', $phone)
			 ->addAttributeToFilter('email', $email);

         if(count($customers)==0 || count($customers)==1){ 
         $message = 'Dear+Customer,+'.$otp.'+is+your+OTP+to+authenticate+your+login';
        
			
		$varSMSURL = "185.136.166.131/domestic/sendsms/bulksms.php?username=lifeheal&password=lifeheal&type=TEXT&sender=UPDATE&mobile=".$phone."&message=".$message;
		

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
          $message =('An OTP Code has been sent to your Number');
          $response['status'] = 'success';
          $response['message'] = $message;
          }else{
            $message =('Please fill the registration form');
            $response['status'] = 'error';
            $response['message'] = $message;
          }
          $this->getResponse()->clearHeaders()->setHeader('Content-type','application/json',true);
          $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
        }
  
        public function newverifyotpAction(){
          //$helper = Mage::helper('sociallogin');
          // $params = $this->getRequest()->getParams(); 
          // $phone = $params['phone'];
          // $otp = $params['otp'];
          // $this->sendOtp($phone,$otp);
          //echo $helper->sendOtp($phone,$otp);
        }
        
        public function newloginmobileAction(){
				 
 
          $params = $this->getRequest()->getParams(); 
		  //  echo "<pre>"; print_r($params);
          $phone = $params['phone'];
	      $name = $params['name']; //echo "<br>";
          $reditts = $params['reditts'];
		  $email = $phone."@lifeheal.in";
		  
          $customers  = Mage::getResourceModel('customer/customer_collection')
             ->addAttributeToSelect('*')
             ->addAttributeToFilter('primarymobileno', $phone)
			 ->addAttributeToFilter('email', $email);
			 
          //  echo "Count of customers=".count($customers); //die;
		  
		  
            if(count($customers)==0){
                $websiteId = Mage::app()->getWebsite()->getId();
				$store = Mage::app()->getStore();
				
				$customer = Mage::getModel("customer/customer");
				$customer   ->setWebsiteId($websiteId)
							->setStore($store)
							->setFirstname('Dear')
							->setLastname($name)  
							->setEmail($email)
							->setPassword($email)
							->setPrimarymobileno($phone);
				 
				try{
					$customer->setForceConfirmed(true);
        
					// save customer
					$customer->save();
					
					$customer->setConfirmation(null);
					$customer->save();
					
					
					
					
					///////////////// Start Send Email Notification for new customer registration /////////////////
        
		             $to ="diet@lifeheal.in, junior@lifeheal.in, nehabhale@gmail.com, yash.munot@gmail.com, st.homespice@gmail.com";
					   
					//   $to ="st.homespice@gmail.com";
					   $from ="team@lifeheal.in";

						   // Always set content-type when sending HTML email
						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

						// More headers
						$headers .= "From: ".$from . "\r\n";
						$subject = "New Customer Registered";
						$message="Hi team, a new customer, ".$name." (".$phone.") has been registered on ".date("d-m-Y");
						mail($to,$subject,$message,$headers); 
	
		
					///////////////// End Send Email Notification for new customer registration /////////////////
					
				
				
					
					$First_Name = 'Dear';
					$Last_Name  = $name;
					$Description = 'New Customer From Website';
										
					////////////////////////// Start Creating Zoho Lead ////////////////////
					
					$zoho_access_token = Mage::helper("heal")->generate_Zoho_access_token();
					$post_data = [
		               'data'=>[
					             [
								   
									  
									 "First_Name"        => $First_Name,
									 "Last_Name"         => $Last_Name,  
									 "Email"             => $email,    //mandatory
									  "Mobile"           => $phone, 
									 "Description"       => $Description,
									 "Company"           =>"Default Company" //,
									
									// "value_LEADCF1"         =>"Weight Loss"
									
								 ]
					           ],
		               
					  'trigger'=>[
					                "approval",
									"workflow",
									"blueprint"
								 ]
					];			 
		
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,"https://zohoapis.in/crm/v2/Leads");
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));

					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);  
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Authorization: Zoho-oauthtoken '.$zoho_access_token,
					'Content-type: application/x-www-form-urlencoded')
					);

					$response = curl_exec($ch);
					$response = json_decode($response);
					
					
					///////////////////////// End Creating Zoho Lead ///////////////////////
					     
							  $logincustomer = Mage::getModel("customer/customer");
							  $logincustomer->setWebsiteId(Mage::app()->getWebsite()->getId());
							  // Load our customer by email
							  $logincustomer->loadByEmail($email);
							  // Load the session up
							  
							  $sess = Mage::getSingleton("customer/session");
							  $sess->loginById($logincustomer->getId());
							  $sess->setCustomerAsLoggedIn($logincustomer);
							  
							 /*  if(Mage::helper('customer')->isLoggedIn())
							  {
								  echo 'New Customer logged in';
							  }
							  else
							  {
								   echo 'New Customer  Not logged in';
							  }
							  die;	*/ 
                       
					
				}
				catch (Exception $e) {
					Zend_Debug::dump($e->getMessage());
				}
				
				
            }
            elseif(count($customers)==1){
                				 
				try{
					
						     $email = $phone."@lifeheal.in";				
					
							  $logincustomer = Mage::getModel("customer/customer");
							  $logincustomer->setWebsiteId(Mage::app()->getWebsite()->getId());
							  // Load our customer by email
							  $logincustomer->loadByEmail($email);
							 // echo "<pre>"; print_r($logincustomer); die;
							  
							  $sess = Mage::getSingleton("customer/session");
							  $sess->loginById($logincustomer->getId());
							  $sess->setCustomerAsLoggedIn($logincustomer);
							  
							 /* if(Mage::helper('customer')->isLoggedIn())
							  {
								  echo 'Customer exist and logged in';
							  }
							  else
							  {
								   echo 'Customer exist and Not logged in';
							  }
								 
                            die;*/
					
				}
				catch (Exception $e) {
					Zend_Debug::dump($e->getMessage());
				}
				
				
            }
            
        }
		
		//////////////////////////// End OTP for registration //////////////////////////
        
        
     
        
public function getcustomerfavitemsSantAction() {
$custid    = Mage::app()->getRequest()->getParam('custid'); 
$customer = Mage::getModel('customer/customer')->load($custid);
$customerEmail = $customer->getEmail();
$customerName = ucfirst($customer->getFirstname()).' '.ucfirst($customer->getLastname());
$tomorrowDay    = Mage::app()->getRequest()->getParam('day');

$comboLI='';   $countComboLI =0 ;
$soupLI='';    $countSoupLI =0 ;
$saladLI='';   $countSaladLI =0 ;
$ricerotLI='';   $countRicerotLI =0 ;
$dessertLI='';   $countDessertLI =0 ;
$breakfastLI='';   $countBreakfastLI =0 ;
$indiancomboLI='';   $countIndianComboLI =0 ;
$chinesecomboLI='';   $countChineseComboLI =0 ;
$italinacomboLI='';   $countItalinaComboLI =0 ;
$gharcomboLI='';   $countGharComboLI =0 ;

$comboLInonFav='';   $countComboLInonFav =0 ;
$soupLInonFav='';    $countSoupLInonFav =0 ;
$saladLInonFav='';   $countSaladLInonFav =0 ;
                
  $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
                        
$sqlDistinctCombo = "SELECT  distinct combo_id FROM  customerfavourite where custid='" . $custid . "' and combo_id!='NULL' and product_is_combo_child='yes'";
$favComboCollection = $connection->fetchAll($sqlDistinctCombo);
// die;
 $comboName  =  ''; 
  
 if(sizeof($favComboCollection) >0)
 {
           foreach($favComboCollection as $value)
           {
              $comboItemnameArray = array();
             
              $comboId = $value['combo_id']; 
              $bundled_product = Mage::getModel("catalog/product")->load($comboId);
              $isMealToShow = $this->checkMealDayAvailability($bundled_product,$tomorrowDay);
              if($isMealToShow==true)
              { 
              $countComboLI++;
              $comboName='';
              /////////////////////
            
             
                  
                 $favComboItemCollection='';
                 $sqlComboItems = "SELECT combo_id,custname,combo_name,productname,combo_option_id,combo_selection_id,product_is_combo_child,productid  from customerfavourite  where combo_id='".$comboId."' and custid='".$custid."'"; //die;
                 $favComboItemCollection = $connection->fetchAll($sqlComboItems);
            
                if(sizeof($favComboItemCollection) >0)
                 {         $comboItemnameArray = array();
                           foreach($favComboItemCollection as $value)
                           {

                                 $comboName             =  $value['combo_name']; 
                            
                               
                                 $comboItemnameArray[]  =  array($value['productid'],$value['productname']);
                              
                             
                           }
                           
                           
                 }
              ////////////////////  end of combocollection loop/////////////
           
                   
         
                  $comboLI.='<li class="item">
        <div class="itm-wrppr">
    <div class="sc-bbmXgH gfbLKA">
    <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
      <div class="wd-100">
        <div class="sc-ksYbfQ PVrMb">
          <div class="img-cvr">
            <img id="product-collection-image-'.$bundled_product->getId().'"  class="img-wrpr__img"
                         src="'. Mage::helper('catalog/image')->init($bundled_product, 'small_image')->resize(null).'" />
          </div>
          <div class="img-wrpr__fav" data-label="favorite">
            <div class="injectStyles-sc-1jy9bcf-0 liked"></div>           
          </div>
        </div>
      </div>
      <div class="sc-hmzhuo cCbxqa">
        <div class="itm-nm-dsc ">
          <span class="itm-dsc__nm">'.$comboName.'</span>         
          </div>';                  
                                if(sizeof($comboItemnameArray)>0)
                                {
                                     for($i=0;$i< sizeof($comboItemnameArray);$i++)
                                     {
                                         
                                          $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$comboItemnameArray[$i][0],$connection);
        $comboLI.='<div class="itm-dsc__actn">
                         <div class="itm-dsc__actn__crst" data-label="selectCrust"  style="width:100%;">
            <div>
              <div class="injectStyles-sc-1jy9bcf-0">
                <div class="nm-icn">
                  <div datalabel="crust" class="itm-dsc__actn__sz__dd-ttl" >
				  <span style="width:75%;float:left;">'.$comboItemnameArray[$i][1].' <br>
          <span style="font-size:10px;line-height: 1.3;">'.$countIteminPreviousOrder.'</span></span>'.'
		  
		  <span style="width:25%;float:left;">
              <label class="checkbox-inline" style="font-size: 10px;margin: 0px;text-align: center;">
              B<br>
              <input type="checkbox" style="height:14px; width:14px;" productid="'.$bundled_product->getId().'" name="breakfast" value="'. $bundled_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: 10px;margin: 0px;text-align: center;">
              L<br>
              <input type="checkbox" style="height:14px; width:14px;" productid="'.$bundled_product->getId().'" name="lunch" value="'. $bundled_product->getName().'"> 
			  
             </label>
            <label class="checkbox-inline" style="font-size: 10px;margin: 0px;text-align: center;">
            H<br>
              <input type="checkbox" style="height:14px; width:14px;" productid="'.$bundled_product->getId().'" name="hightea" value="'. $bundled_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: 10px;margin: 0px;text-align: center;">
              D<br>
                <input type="checkbox" style="height:14px; width:14px;" productid="'.$bundled_product->getId().'" name="dinner" value="'. $bundled_product->getName().'">  
              </label>
                                  </span> 
          </div>
                </div>              
                <div class="dd-wrpr" ></div>
              </div>
            </div>
            
            </div>
        </div>';
                                 }  
                               }
        $comboLI.='</div>';
                   
                               
         $comboLI.='</div>
      </div>
    </div>
            </li>';
                   
                   
                 //  die;
              }
             
         }
 }  
 
 
$sqlSoup = "SELECT distinct productid  FROM  customerfavourite where  custid='".$custid."' and product_is_combo_child='no' and productname like '%soup%'";
$favSoupCollection = $connection->fetchAll($sqlSoup);
 
 $favSoupCollections =array();
 if(sizeof($favSoupCollection) >0){
   foreach($favSoupCollection as $value) {
        $favSoupCollections[] =  $value['productid'];
        $soup_product = Mage::getModel("catalog/product")->load($value['productid']);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$soup_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($soup_product,$tomorrowDay);
      if($isMealToShow==true) { 
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value['productid'],$connection);
      $countSoupLI++;
      
      
        $soupLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$soup_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($soup_product, 'small_image')->resize(null).'"       />

                                </div>
<div class="img-wrpr__fav" data-label="favorite">
            <div class="injectStyles-sc-1jy9bcf-0 liked"></div>           
          </div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $soup_product->getName().'</span>
                    <span style="font-size:10px;line-height: 1.3;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$soup_product->getId().'" name="breakfast" value="'. $soup_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$soup_product->getId().'" name="lunch" value="'. $soup_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$soup_product->getId().'" name="hightea" value="'. $soup_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$soup_product->getId().'" name="dinner" value="'. $soup_product->getName().'">  
              </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
     
      }
   }
  }
  
$search ='soup';
$soupcollection = Mage::getModel('catalog/product')
->getCollection()
->addAttributeToFilter( array( array('attribute' => 'menucode', 'like' => '%'.$search.'%') ) )
->load();

$nonfavSoupCollections = array();
foreach($soupcollection as $product){
  $nonfavSoupCollections[] = $product->getId();
}

$nonfavSoupCollection = array_diff($nonfavSoupCollections, $favSoupCollections);
if(sizeof($nonfavSoupCollection) >0){
   foreach($nonfavSoupCollection as $value) {
    $soup_product = Mage::getModel("catalog/product")->load($value);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$soup_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($soup_product,$tomorrowDay);
      if($isMealToShow==true) { 
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value,$connection);
           
        $soupLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$soup_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($soup_product, 'small_image')->resize(null).'"       />

                                </div>
<div class="img-wrpr__fav" data-label="favorite">
            <div class="injectStyles-sc-1jy9bcf-0 disliked"></div>            
          </div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $soup_product->getName().'</span>
                    <span style="font-size:10px;line-height: 1.3;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$soup_product->getId().'" name="breakfast" value="'. $soup_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$soup_product->getId().'" name="lunch" value="'. $soup_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$soup_product->getId().'" name="hightea" value="'. $soup_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$soup_product->getId().'" name="dinner" value="'. $soup_product->getName().'">  
              </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
     
      } 
      $countSoupLI++;
   }
  }  

//echo "non fav soup " .$soupLInonFav; die();


  
  $sqlSalad = "SELECT distinct productid  FROM  customerfavourite where  custid='".$custid."' and product_is_combo_child='no' and productname like '%salad%'";
$favSaladCollection = $connection->fetchAll($sqlSalad);
 
 
 if(sizeof($favSaladCollection) >0)
 {
           foreach($favSaladCollection as $value)
           {
                $salad_product = Mage::getModel("catalog/product")->load($value['productid']);
                $isMealToShow = $this->checkMealDayAvailability($salad_product,$tomorrowDay);
              if($isMealToShow==true)
              { 
               $countSaladLI++;
                $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value['productid'],$connection);
                 
                $saladLI.='<li class="item">
  <div class="itm-wrppr">
    <div class="sc-bbmXgH gfbLKA">
                        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                                <div class="wd-100">
                                        <div class="sc-ksYbfQ PVrMb">
                                                <div class="img-cvr">
                                                        <img id="product-collection-image-'.$salad_product->getId().'"  class="img-wrpr__img"
                                 src="'. Mage::helper('catalog/image')->init($salad_product, 'small_image')->resize(null).'"       />

                                                </div>
<div class="img-wrpr__fav" data-label="favorite">
            <div class="injectStyles-sc-1jy9bcf-0 liked"></div>           
          </div>
                                        </div>
                                </div>
                                <div class="sc-hmzhuo cCbxqa">
                                        <div class="itm-nm-dsc ">
                                                <span class="itm-dsc__nm">'. $salad_product->getName().'</span>
                                                <span style="font-size:10px;line-height: 1.3;">'.$countIteminPreviousOrder.'</span>   
                                              <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                                          <span>
                       <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
                      B<br>
                                          <input type="checkbox" productid="'.$salad_product->getId().'" name="breakfast" value="'. $salad_product->getName().'">
                      </label>
                       <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
                      L<br>
                                          <input type="checkbox" productid="'.$salad_product->getId().'" name="lunch" value="'. $salad_product->getName().'"> 
                      </label>
                       <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
                     H<br>
                                          <input type="checkbox" productid="'.$salad_product->getId().'" name="hightea" value="'. $salad_product->getName().'"> 
                      </label>
                       <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
                      D<br>
                                          <input type="checkbox" productid="'.$salad_product->getId().'" name="dinner" value="'. $salad_product->getName().'"> 
                      </label>
                                          </span>  
                                        </div>
                                 </div>
                        </div>
      </div>
    </div>
  
            </li>';    
             
           }
               
           }
  }


$search ='salad';
$saladcollection = Mage::getModel('catalog/product')
->getCollection()
->addAttributeToFilter( array( array('attribute' => 'menucode', 'like' => '%'.$search.'%') ) )
->load();

$nonfavSaladCollections = array();
foreach($saladcollection as $product){
  $nonfavSaladCollections[] = $product->getId();
}

$nonfavSaladCollection = array_diff($nonfavSaladCollections, $favSaladCollection);
if(sizeof($nonfavSaladCollection) >0){
   foreach($nonfavSaladCollection as $value) {
    $salad_product = Mage::getModel("catalog/product")->load($value);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$salad_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($salad_product,$tomorrowDay);
      if($isMealToShow==true) { 
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value,$connection);
           
        $saladLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$salad_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($salad_product, 'small_image')->resize(null).'"       />

                                </div>
<div class="img-wrpr__fav" data-label="favorite">
            <div class="injectStyles-sc-1jy9bcf-0 disliked"></div>            
          </div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $salad_product->getName().'</span>
                    <span style="font-size:10px;line-height: 1.3;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$salad_product->getId().'" name="breakfast" value="'. $salad_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$salad_product->getId().'" name="lunch" value="'. $salad_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$salad_product->getId().'" name="hightea" value="'. $salad_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$salad_product->getId().'" name="dinner" value="'. $salad_product->getName().'">  
              </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
     
      } 
      $countSaladLI++;
   }
  }

$sqlRiceroti = "SELECT distinct productid  FROM  customerfavourite where  custid='".$custid."' and product_is_combo_child='no' and productname like '%roti%'";
$favRicerotiCollection = $connection->fetchAll($sqlRiceroti);

 $favRicerotiCollections =array();
 if(sizeof($favRicerotiCollection) >0){
   foreach($favRicerotiCollection as $value) {
        $favRicerotiCollections[] =  $value['productid'];
        $riceroti_product = Mage::getModel("catalog/product")->load($value['productid']);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$soup_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($riceroti_product,$tomorrowDay);
      if($isMealToShow==true) { 
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value['productid'],$connection);
      $countRicerotLI++;
        $ricerotLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$riceroti_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($riceroti_product, 'small_image')->resize(null).'"       />

                                </div>
<div class="img-wrpr__fav" data-label="favorite">
            <div class="injectStyles-sc-1jy9bcf-0 liked"></div>           
          </div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $riceroti_product->getName().'</span>
                    <span style="font-size:10px;line-height: 1.3;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$riceroti_product->getId().'" name="breakfast" value="'. $riceroti_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$riceroti_product->getId().'" name="lunch" value="'. $riceroti_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$riceroti_product->getId().'" name="hightea" value="'. $riceroti_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$riceroti_product->getId().'" name="dinner" value="'. $riceroti_product->getName().'">  
              </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
     
      }
   }
  } 



$search ='rrc';
$riceroticollection = Mage::getModel('catalog/product')
->getCollection()
->addAttributeToFilter( array( array('attribute' => 'menucode', 'like' => '%'.$search.'%') ) )
->load();
$nonfavRiceRotiCollections = array();
foreach($riceroticollection as $product){
  $nonfavRiceRotiCollections[] = $product->getId();
}

$nonfavRicerotiCollection = array_diff($nonfavRiceRotiCollections, $favSaladCollection);
if(sizeof($nonfavRicerotiCollection) >0){
   foreach($nonfavRicerotiCollection as $value) {
    $riceroti_product = Mage::getModel("catalog/product")->load($value);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$salad_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($riceroti_product,$tomorrowDay);
      if($isMealToShow==true) { 
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value,$connection);
           
        $ricerotLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$riceroti_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($riceroti_product, 'small_image')->resize(null).'"       />

                                </div>
<div class="img-wrpr__fav" data-label="favorite">
            <div class="injectStyles-sc-1jy9bcf-0 disliked"></div>            
          </div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $riceroti_product->getName().'</span>
                    <span style="font-size:10px;line-height:1.3;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$riceroti_product->getId().'" name="breakfast" value="'. $riceroti_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$riceroti_product->getId().'" name="lunch" value="'. $riceroti_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$riceroti_product->getId().'" name="hightea" value="'. $riceroti_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$riceroti_product->getId().'" name="dinner" value="'. $riceroti_product->getName().'">  
              </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
     
      } 
      $countRicerotLI++;
   }
  }


$sqlDessert = "SELECT distinct productid  FROM  customerfavourite where  custid='".$custid."' and product_is_combo_child='no' and productname like '%dessert%'";
$favDessertCollection = $connection->fetchAll($sqlDessert);
 $favDessertCollections =array();
 if(sizeof($favDessertCollection) >0){
   foreach($favDessertCollection as $value) {
        $favDessertCollections[] =  $value['productid'];
        $dessert_product = Mage::getModel("catalog/product")->load($value['productid']);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$soup_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($dessert_product,$tomorrowDay);
      if($isMealToShow==true) { 
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value['productid'],$connection);
      $countDessertLI++;
        $dessertLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$dessert_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($dessert_product, 'small_image')->resize(null).'"       />

                                </div>
<div class="img-wrpr__fav" data-label="favorite">
            <div class="injectStyles-sc-1jy9bcf-0 liked"></div>           
          </div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $dessert_product->getName().'</span>
                    <span style="font-size:10px;line-height: 1.3;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$dessert_product->getId().'" name="breakfast" value="'. $dessert_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$dessert_product->getId().'" name="lunch" value="'. $dessert_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$dessert_product->getId().'" name="hightea" value="'. $dessert_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$dessert_product->getId().'" name="dinner" value="'. $dessert_product->getName().'">  
              </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
     
      }
   }
  }

$search ='dessert';
$dessertcollection = Mage::getModel('catalog/product')
->getCollection()
->addAttributeToFilter( array( array('attribute' => 'menucode', 'like' => '%'.$search.'%') ) )
->load();
$nonfavDessertCollections = array();
foreach($dessertcollection as $product){
  $nonfavDessertCollections[] = $product->getId();
}

$nonfavdessertCollection = array_diff($nonfavDessertCollections, $favSaladCollection);
if(sizeof($nonfavdessertCollection) >0){
   foreach($nonfavdessertCollection as $value) {
    $dessert_product = Mage::getModel("catalog/product")->load($value);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$salad_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($dessert_product,$tomorrowDay);
      if($isMealToShow==true) { 
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value,$connection);
        $dessertLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$dessert_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($dessert_product, 'small_image')->resize(null).'"       />

                                </div>
<div class="img-wrpr__fav" data-label="favorite">
            <div class="injectStyles-sc-1jy9bcf-0 disliked"></div>            
          </div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $dessert_product->getName().'</span>
                    <span style="font-size:10px;line-height:1.3;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$dessert_product->getId().'" name="breakfast" value="'. $dessert_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$dessert_product->getId().'" name="lunch" value="'. $dessert_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$dessert_product->getId().'" name="hightea" value="'. $dessert_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$dessert_product->getId().'" name="dinner" value="'. $dessert_product->getName().'">  
              </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
      $countDessertLI++;
      } 
      
   }
  }


$breakfastcollection = Mage::getModel('catalog/category')->load(125)
 ->getProductCollection()
 ->addAttributeToSelect('*') // add all attributes - optional
 ->addAttributeToFilter('status', 1) // enabled
 //->addAttributeToFilter('visibility', 4) //visibility in catalog,search
 ->setOrder('price', 'ASC');  

 $nonfavbreakfastCollections = array();
foreach($breakfastcollection as $product){
  $nonfavbreakfastCollections[] = $product->getId();
}

 if(sizeof($nonfavbreakfastCollections) >0){
   foreach($nonfavbreakfastCollections as $value) {
        //$favDessertCollections[] =  $value['productid'];
        $breakfast_product = Mage::getModel("catalog/product")->load($value);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$soup_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($breakfast_product,$tomorrowDay);
      if($isMealToShow==true) { 
          /*$sqlbreakfast = "SELECT distinct productid  FROM  customerfavourite where  custid='".$custid."' and product_is_combo_child='no' and productid like '".$value."' ";
          $favBreakfastcollection = $connection->fetchAll($sqlbreakfast);*/
          //echo "size ".sizeof($favBreakfastcollection);
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value,$connection);
      $countBreakfastLI++;
        $breakfastLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$breakfast_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($breakfast_product, 'small_image')->resize(null).'"       />

                                </div>
          <div class="img-wrpr__fav" data-label="favorite">
            <div class="injectStyles-sc-1jy9bcf-0 liked"></div>           
          </div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $breakfast_product->getName().'</span>
                    <span style="font-size:10px;line-height:1.3;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$breakfast_product->getId().'" name="breakfast" value="'. $breakfast_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$breakfast_product->getId().'" name="lunch" value="'. $breakfast_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$breakfast_product->getId().'" name="hightea" value="'. $breakfast_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$breakfast_product->getId().'" name="dinner" value="'. $breakfast_product->getName().'">  
              </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
     
      }
   }
  }

$indiancollection = Mage::getModel('catalog/category')->load(92)
 ->getProductCollection()
 ->addAttributeToSelect('*') // add all attributes - optional
 ->addAttributeToFilter('status', 1) // enabled
 //->addAttributeToFilter('visibility', 4) //visibility in catalog,search
 ->setOrder('price', 'ASC');  

 $nonfavindcomboCollections = array();
foreach($indiancollection as $product){
  $nonfavindcomboCollections[] = $product->getId();
}

 if(sizeof($nonfavindcomboCollections) >0){
   foreach($nonfavindcomboCollections as $value) {
        //$favDessertCollections[] =  $value['productid'];
        $indcombo_product = Mage::getModel("catalog/product")->load($value);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$soup_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($indcombo_product,$tomorrowDay);
      if($isMealToShow==true) { 
          $sqlbreakfast = "SELECT distinct productid  FROM  customerfavourite where  custid='".$custid."' and product_is_combo_child='no' and productid like '".$value."' ";
          $favBreakfastcollection = $connection->fetchAll($sqlbreakfast);
          //echo "size ".sizeof($favBreakfastcollection);
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value,$connection);
      $countIndianComboLI++;
        $indiancomboLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$indcombo_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($indcombo_product, 'small_image')->resize(null).'"       />

                                </div>
          <div class="img-wrpr__fav" data-label="favorite">
            <div class="injectStyles-sc-1jy9bcf-0 liked"></div>           
          </div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $indcombo_product->getName().'</span>
                    <span style="font-size:10px;line-height:1.3;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$indcombo_product->getId().'" name="breakfast" value="'. $indcombo_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$indcombo_product->getId().'" name="lunch" value="'. $indcombo_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$indcombo_product->getId().'" name="hightea" value="'. $indcombo_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$indcombo_product->getId().'" name="dinner" value="'. $indcombo_product->getName().'">  
              </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
     
      }
   }
  }

$chinesecollection = Mage::getModel('catalog/category')->load(124)
 ->getProductCollection()
 ->addAttributeToSelect('*') // add all attributes - optional
 ->addAttributeToFilter('status', 1) // enabled
 //->addAttributeToFilter('visibility', 4) //visibility in catalog,search
 ->setOrder('price', 'ASC');  

 $nonfavchcomboCollections = array();
foreach($chinesecollection as $product){
  $nonfavchcomboCollections[] = $product->getId();
}

 if(sizeof($nonfavchcomboCollections) >0){
   foreach($nonfavchcomboCollections as $value) {
        //$favDessertCollections[] =  $value['productid'];
        $chcombo_product = Mage::getModel("catalog/product")->load($value);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$soup_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($chcombo_product,$tomorrowDay);
      if($isMealToShow==true) { 
          $sqlbreakfast = "SELECT distinct productid  FROM  customerfavourite where  custid='".$custid."' and product_is_combo_child='no' and productid like '".$value."' ";
          $favBreakfastcollection = $connection->fetchAll($sqlbreakfast);
          //echo "size ".sizeof($favBreakfastcollection);
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value,$connection);
      $countChineseComboLI++;
        $chinesecomboLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$chcombo_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($chcombo_product, 'small_image')->resize(null).'"       />

                                </div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $chcombo_product->getName().'</span>
                    <span style="font-size:10px;line-height:1.3;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$chcombo_product->getId().'" name="breakfast" value="'. $chcombo_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$chcombo_product->getId().'" name="lunch" value="'. $chcombo_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$chcombo_product->getId().'" name="hightea" value="'. $chcombo_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$chcombo_product->getId().'" name="dinner" value="'. $chcombo_product->getName().'">  
              </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
     
      }
   }
  }


$italiancollection = Mage::getModel('catalog/category')->load(93)
 ->getProductCollection()
 ->addAttributeToSelect('*') // add all attributes - optional
 ->addAttributeToFilter('status', 1) // enabled
 //->addAttributeToFilter('visibility', 4) //visibility in catalog,search
 ->setOrder('price', 'ASC');  

 $nonfavitalcomboCollections = array();
foreach($italiancollection as $product){
  $nonfavitalcomboCollections[] = $product->getId();
}

 if(sizeof($nonfavitalcomboCollections) >0){
   foreach($nonfavitalcomboCollections as $value) {
        //$favDessertCollections[] =  $value['productid'];
        $itcombo_product = Mage::getModel("catalog/product")->load($value);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$soup_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($itcombo_product,$tomorrowDay);
      if($isMealToShow==true) { 
          $sqlbreakfast = "SELECT distinct productid  FROM  customerfavourite where  custid='".$custid."' and product_is_combo_child='no' and productid like '".$value."' ";
          $favBreakfastcollection = $connection->fetchAll($sqlbreakfast);
          //echo "size ".sizeof($favBreakfastcollection);
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value,$connection);
      $countItalinaComboLI++;
        $italinacomboLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$itcombo_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($itcombo_product, 'small_image')->resize(null).'"       />

                                </div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $itcombo_product->getName().'</span>
                    <span style="font-size:10px;line-height:1.3;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$itcombo_product->getId().'" name="breakfast" value="'. $itcombo_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$itcombo_product->getId().'" name="lunch" value="'. $itcombo_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$itcombo_product->getId().'" name="hightea" value="'. $itcombo_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$itcombo_product->getId().'" name="dinner" value="'. $itcombo_product->getName().'">  
              </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
     
      }
   }
  } 


/*$gharkakhanacollection = Mage::getModel('catalog/category')->load(137)
 ->getProductCollection()
 ->addAttributeToSelect('*') // add all attributes - optional
 ->addAttributeToFilter('status', 1) // enabled
 //->addAttributeToFilter('visibility', 4) //visibility in catalog,search
 ->setOrder('price', 'ASC');  

 $nonfavgharkaCollections = array();
foreach($gharkakhanacollection as $product){
  $nonfavgharkaCollections[] = $product->getId();
}

 if(sizeof($nonfavgharkaCollections) >0){
   foreach($nonfavgharkaCollections as $value) {
        //$favDessertCollections[] =  $value['productid'];
        $gharcombo_product = Mage::getModel("catalog/product")->load($value);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$soup_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($gharcombo_product,$tomorrowDay);
      if($isMealToShow==true) { 
          $sqlbreakfast = "SELECT distinct productid  FROM  customerfavourite where  custid='".$custid."' and product_is_combo_child='no' and productid like '".$value."' ";
          $favBreakfastcollection = $connection->fetchAll($sqlbreakfast);
          //echo "size ".sizeof($favBreakfastcollection);
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value,$connection);
      $countGharComboLI++;
        $gharcomboLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$gharcombo_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($gharcombo_product, 'small_image')->resize(null).'"       />

                                </div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $gharcombo_product->getName().'</span>
                    <span style="font-size:10px;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$gharcombo_product->getId().'" name="breakfast" value="'. $gharcombo_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$gharcombo_product->getId().'" name="lunch" value="'. $gharcombo_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$gharcombo_product->getId().'" name="hightea" value="'. $gharcombo_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$gharcombo_product->getId().'" name="dinner" value="'. $gharcombo_product->getName().'">  
              </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
     
      }
   }
  }*/  


 
          
                $outPut=' <div class="catalog__list">';
                $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;">
        <span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Soup Of '.$tomorrowDay.' </h3>';
                 if($countSoupLI>0 ) { 
                       $outPut.='<ul class="products-gridnew products-grid--max-3-col">'.$soupLI.'</ul>';

                 }  else { 
                     $outPut.= 'There is no soup.';
                 }
                 
                $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Salad Of '.$tomorrowDay.'</h3>';
                if($countSaladLI>0)
                {

                 $outPut.='<ul class="products-gridnew products-grid--max-3-col">'.$saladLI.'</ul>';
                } 
                else
                { $outPut.= 'There is no salad.'; }

                $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Rice/Roti Of '.$tomorrowDay.'</h3>';
                if($countRicerotLI>0)
                {

                 $outPut.='<ul class="products-gridnew products-grid--max-3-col">'.$ricerotLI.'</ul>';
                } 
                else
                { $outPut.= 'There is no Rice/Roti.'; }
                
                $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Desserts Of '.$tomorrowDay.'</h3>';
                if($countDessertLI>0){ 
                 $outPut.='<ul class="products-gridnew products-grid--max-3-col">'.$dessertLI.'</ul>';
                } 
                else
                { $outPut.= 'There is no Desserts'; }

                $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Breakfast Of '.$tomorrowDay.'</h3>';
                if($countBreakfastLI>0){ 
                 $outPut.='<ul class="products-gridnew products-grid--max-3-col">'.$breakfastLI.'</ul>';
                } 
                else
                { $outPut.= 'There is no Breakfast.'; }

                $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Indian Combo Of '.$tomorrowDay.'</h3>';
                if($countIndianComboLI>0){ 
                 $outPut.='<ul class="products-gridnew products-grid--max-3-col">'.$indiancomboLI.'</ul>';
                } 
                else
                { $outPut.= 'There is no indian combo.'; }

              $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Chinese Combo Of '.$tomorrowDay.'</h3>';
                if($countChineseComboLI>0){ 
                 $outPut.='<ul class="products-gridnew products-grid--max-3-col">'.$chinesecomboLI.'</ul>';
                } 
                else
                { $outPut.= 'There is no Chinese combo.'; }

                $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Italian Combo Of '.$tomorrowDay.'</h3>';
                if($countItalinaComboLI>0){ 
                 $outPut.='<ul class="products-gridnew products-grid--max-3-col">'.$italinacomboLI.'</ul>';
                } else { $outPut.= 'There is no Italian combo.'; }

                /*$outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Ghar ka khana Combo Of '.$tomorrowDay.'</h3>';
                if($countGharComboLI>0){ 
                 $outPut.='<ul class="products-gridnew products-grid--max-3-col">'.$gharcomboLI.'</ul>';
                } else { $outPut.= 'There is no Ghar Ka Khana.'; }*/

                $outPut.= '<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Combos Of '.$tomorrowDay.' </h3>';
                if($countComboLI>0)
                { 

                $outPut.= '<ul class="comboheight products-grid--max-3-col">'.$comboLI.'</ul>';

                }
                else 
               { $outPut.=  'There is no combo.';}
               
               
               
               
              


                if($countSoupLI==0 && $countSaladLI==0 && $countSoupLI==0)
                {
                    $outPut.='There is no favourite items of tomorrow';
                }


               $outPut.='</div>';
               
               echo $outPut;
                        
        }        
         
         
public function getcustomerfavitemsAction() {
$custid    = Mage::app()->getRequest()->getParam('custid'); 
$customer = Mage::getModel('customer/customer')->load($custid);
$customerEmail = $customer->getEmail();
$customerName = ucfirst($customer->getFirstname()).' '.ucfirst($customer->getLastname());
$tomorrowDay    = Mage::app()->getRequest()->getParam('day');

$comboLI='';   $countComboLI =0 ;
$soupLI='';    $countSoupLI =0 ;
$saladLI='';   $countSaladLI =0 ;
$ricerotLI='';   $countRicerotLI =0 ;
$dessertLI='';   $countDessertLI =0 ;
$breakfastLI='';   $countBreakfastLI =0 ;
$indiancomboLI='';   $countIndianComboLI =0 ;
$chinesecomboLI='';   $countChineseComboLI =0 ;
$italinacomboLI='';   $countItalinaComboLI =0 ;

$comboLInonFav='';   $countComboLInonFav =0 ;
$soupLInonFav='';    $countSoupLInonFav =0 ;
$saladLInonFav='';   $countSaladLInonFav =0 ;
                
	$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
                        
$sqlDistinctCombo = "SELECT  distinct combo_id FROM  customerfavourite where custid='" . $custid . "' and combo_id!='NULL' and product_is_combo_child='yes'";
$favComboCollection = $connection->fetchAll($sqlDistinctCombo);
// die;
 $comboName  =  ''; 
  
 if(sizeof($favComboCollection) >0)
 {
           foreach($favComboCollection as $value)
           {
              $comboItemnameArray = array();
             
              $comboId = $value['combo_id']; 
              $bundled_product = Mage::getModel("catalog/product")->load($comboId);
              $isMealToShow = $this->checkMealDayAvailability($bundled_product,$tomorrowDay);
              if($isMealToShow==true)
              { 
              $countComboLI++;
              $comboName='';
              /////////////////////
            
             
                  
                 $favComboItemCollection='';
                 $sqlComboItems = "SELECT combo_id,custname,combo_name,productname,combo_option_id,combo_selection_id,product_is_combo_child,productid  from customerfavourite  where combo_id='".$comboId."' and custid='".$custid."'"; //die;
                 $favComboItemCollection = $connection->fetchAll($sqlComboItems);
            
                if(sizeof($favComboItemCollection) >0)
                 {         $comboItemnameArray = array();
                           foreach($favComboItemCollection as $value)
                           {

                                 $comboName             =  $value['combo_name']; 
                            
                               
                                 $comboItemnameArray[]  =  array($value['productid'],$value['productname']);
                              
                             
                           }
                           
                           
                 }
              ////////////////////  end of combocollection loop/////////////
           
                   
			   
                  $comboLI.='<li class="item">
				<div class="itm-wrppr">
		<div class="sc-bbmXgH gfbLKA">
		<div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
			<div class="wd-100">
				<div class="sc-ksYbfQ PVrMb">
					<div class="img-cvr">
						<img id="product-collection-image-'.$bundled_product->getId().'"  class="img-wrpr__img"
                         src="'. Mage::helper('catalog/image')->init($bundled_product, 'small_image')->resize(null).'" />
					</div>
					<div class="img-wrpr__fav" data-label="favorite">
						<div class="injectStyles-sc-1jy9bcf-0 liked"></div>						
					</div>
				</div>
			</div>
			<div class="sc-hmzhuo cCbxqa">
				<div class="itm-nm-dsc ">
					<span class="itm-dsc__nm">'.$comboName.'</span>					
					</div>';                  
                                if(sizeof($comboItemnameArray)>0)
                                {
                                     for($i=0;$i< sizeof($comboItemnameArray);$i++)
                                     {
                                         
                                          $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$comboItemnameArray[$i][0],$connection);
				$comboLI.='<div class="itm-dsc__actn">
                         <div class="itm-dsc__actn__crst" data-label="selectCrust"  style="width:100%;">
						<div>
							<div class="injectStyles-sc-1jy9bcf-0 ">
								<div class="nm-icn">
									<div datalabel="crust" class="itm-dsc__actn__sz__dd-ttl" >'.$comboItemnameArray[$i][1].' 
					<span style="font-size:10px;">'.$countIteminPreviousOrder.'</span>'.'
          <span>
              <label class="checkbox-inline" style="font-size: 10px;margin: 0px;text-align: center;">
              B<br>
              <input type="checkbox" style="height:14px; width:14px;" productid="'.$bundled_product->getId().'" name="breakfast" value="'. $bundled_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: 10px;margin: 0px;text-align: center;">
              L<br>
              <input type="checkbox" style="height:14px; width:14px;" productid="'.$bundled_product->getId().'" name="lunch" value="'. $bundled_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: 10px;margin: 0px;text-align: center;">
            H<br>
              <input type="checkbox" style="height:14px; width:14px;" productid="'.$bundled_product->getId().'" name="hightea" value="'. $bundled_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: 10px;margin: 0px;text-align: center;">
              D<br>
                <input type="checkbox" style="height:14px; width:14px;" productid="'.$bundled_product->getId().'" name="dinner" value="'. $bundled_product->getName().'">  
              </label>
                                  </span> </div>
								</div>							
								<div class="dd-wrpr" ></div>
							</div>
						</div>
						
				    </div>
				</div>';
                                 }	
                               }
				$comboLI.='</div>';
                   
                               
				 $comboLI.='</div>
			</div>
		</div>
            </li>';
                   
                   
                 //  die;
              }
             
         }
 }  
 
 
$sqlSoup = "SELECT distinct productid  FROM  customerfavourite where  custid='".$custid."' and product_is_combo_child='no' and productname like '%soup%'";
$favSoupCollection = $connection->fetchAll($sqlSoup);
 
 $favSoupCollections =array();
 if(sizeof($favSoupCollection) >0){
   foreach($favSoupCollection as $value) {
        $favSoupCollections[] =  $value['productid'];
        $soup_product = Mage::getModel("catalog/product")->load($value['productid']);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$soup_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($soup_product,$tomorrowDay);
      if($isMealToShow==true) { 
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value['productid'],$connection);
      $countSoupLI++;
      
      
        $soupLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$soup_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($soup_product, 'small_image')->resize(null).'"       />

                                </div>
<div class="img-wrpr__fav" data-label="favorite">
						<div class="injectStyles-sc-1jy9bcf-0 liked"></div>						
					</div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $soup_product->getName().'</span>
                    <span style="font-size:10px;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
						  <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
						  B<br>
              <input type="checkbox" productid="'.$soup_product->getId().'" name="breakfast" value="'. $soup_product->getName().'">
						  </label>
						  <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
						  L<br>
              <input type="checkbox" productid="'.$soup_product->getId().'" name="lunch" value="'. $soup_product->getName().'"> 
						 </label>
						<label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
						H<br>
              <input type="checkbox" productid="'.$soup_product->getId().'" name="hightea" value="'. $soup_product->getName().'">
						  </label>
						  <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
						  D<br>
                <input type="checkbox" productid="'.$soup_product->getId().'" name="dinner" value="'. $soup_product->getName().'">  
						  </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
     
      }
   }
  }
  
$search ='soup';
$soupcollection = Mage::getModel('catalog/product')
->getCollection()
->addAttributeToFilter( array( array('attribute' => 'menucode', 'like' => '%'.$search.'%') ) )
->load();

$nonfavSoupCollections = array();
foreach($soupcollection as $product){
  $nonfavSoupCollections[] = $product->getId();
}

$nonfavSoupCollection = array_diff($nonfavSoupCollections, $favSoupCollections);
if(sizeof($nonfavSoupCollection) >0){
   foreach($nonfavSoupCollection as $value) {
    $soup_product = Mage::getModel("catalog/product")->load($value);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$soup_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($soup_product,$tomorrowDay);
      if($isMealToShow==true) { 
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value,$connection);
           
        $soupLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$soup_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($soup_product, 'small_image')->resize(null).'"       />

                                </div>
<div class="img-wrpr__fav" data-label="favorite">
						<div class="injectStyles-sc-1jy9bcf-0 disliked"></div>						
					</div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $soup_product->getName().'</span>
                    <span style="font-size:10px;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$soup_product->getId().'" name="breakfast" value="'. $soup_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$soup_product->getId().'" name="lunch" value="'. $soup_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$soup_product->getId().'" name="hightea" value="'. $soup_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$soup_product->getId().'" name="dinner" value="'. $soup_product->getName().'">  
              </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
     
      } 
      $countSoupLI++;
   }
  }  

//echo "non fav soup " .$soupLInonFav; die();


  
  $sqlSalad = "SELECT distinct productid  FROM  customerfavourite where  custid='".$custid."' and product_is_combo_child='no' and productname like '%salad%'";
$favSaladCollection = $connection->fetchAll($sqlSalad);
 
 
 if(sizeof($favSaladCollection) >0)
 {
           foreach($favSaladCollection as $value)
           {
                $salad_product = Mage::getModel("catalog/product")->load($value['productid']);
                $isMealToShow = $this->checkMealDayAvailability($salad_product,$tomorrowDay);
              if($isMealToShow==true)
              { 
               $countSaladLI++;
                $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value['productid'],$connection);
                 
                $saladLI.='<li class="item">
	<div class="itm-wrppr">
		<div class="sc-bbmXgH gfbLKA">
                        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                                <div class="wd-100">
                                        <div class="sc-ksYbfQ PVrMb">
                                                <div class="img-cvr">
                                                        <img id="product-collection-image-'.$salad_product->getId().'"  class="img-wrpr__img"
                                 src="'. Mage::helper('catalog/image')->init($salad_product, 'small_image')->resize(null).'"       />

                                                </div>
<div class="img-wrpr__fav" data-label="favorite">
						<div class="injectStyles-sc-1jy9bcf-0 liked"></div>						
					</div>
                                        </div>
                                </div>
                                <div class="sc-hmzhuo cCbxqa">
                                        <div class="itm-nm-dsc ">
                                                <span class="itm-dsc__nm">'. $salad_product->getName().'</span>
                                                <span style="font-size:10px;">'.$countIteminPreviousOrder.'</span>   
                                              <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                                          <span>
										   <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
										  B<br>
                                          <input type="checkbox" productid="'.$salad_product->getId().'" name="breakfast" value="'. $salad_product->getName().'">
										  </label>
										   <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
										  L<br>
                                          <input type="checkbox" productid="'.$salad_product->getId().'" name="lunch" value="'. $salad_product->getName().'"> 
										  </label>
										   <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
										 H<br>
                                          <input type="checkbox" productid="'.$salad_product->getId().'" name="hightea" value="'. $salad_product->getName().'"> 
										  </label>
										   <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
										  D<br>
                                          <input type="checkbox" productid="'.$salad_product->getId().'" name="dinner" value="'. $salad_product->getName().'"> 
										  </label>
                                          </span>  
                                        </div>
                                 </div>
                        </div>
		  </div>
		</div>
	
            </li>';    
             
           }
               
           }
  }


$search ='salad';
$saladcollection = Mage::getModel('catalog/product')
->getCollection()
->addAttributeToFilter( array( array('attribute' => 'menucode', 'like' => '%'.$search.'%') ) )
->load();

$nonfavSaladCollections = array();
foreach($saladcollection as $product){
  $nonfavSaladCollections[] = $product->getId();
}

$nonfavSaladCollection = array_diff($nonfavSaladCollections, $favSaladCollection);
if(sizeof($nonfavSaladCollection) >0){
   foreach($nonfavSaladCollection as $value) {
    $salad_product = Mage::getModel("catalog/product")->load($value);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$salad_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($salad_product,$tomorrowDay);
      if($isMealToShow==true) { 
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value,$connection);
           
        $saladLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$salad_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($salad_product, 'small_image')->resize(null).'"       />

                                </div>
<div class="img-wrpr__fav" data-label="favorite">
						<div class="injectStyles-sc-1jy9bcf-0 disliked"></div>						
					</div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $salad_product->getName().'</span>
                    <span style="font-size:10px;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$salad_product->getId().'" name="breakfast" value="'. $salad_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$salad_product->getId().'" name="lunch" value="'. $salad_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$salad_product->getId().'" name="hightea" value="'. $salad_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$salad_product->getId().'" name="dinner" value="'. $salad_product->getName().'">  
              </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
     
      } 
      $countSaladLI++;
   }
  }

$sqlRiceroti = "SELECT distinct productid  FROM  customerfavourite where  custid='".$custid."' and product_is_combo_child='no' and productname like '%roti%'";
$favRicerotiCollection = $connection->fetchAll($sqlRiceroti);

 $favRicerotiCollections =array();
 if(sizeof($favRicerotiCollection) >0){
   foreach($favRicerotiCollection as $value) {
        $favRicerotiCollections[] =  $value['productid'];
        $riceroti_product = Mage::getModel("catalog/product")->load($value['productid']);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$soup_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($riceroti_product,$tomorrowDay);
      if($isMealToShow==true) { 
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value['productid'],$connection);
      $countRicerotLI++;
        $ricerotLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$riceroti_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($riceroti_product, 'small_image')->resize(null).'"       />

                                </div>
<div class="img-wrpr__fav" data-label="favorite">
            <div class="injectStyles-sc-1jy9bcf-0 liked"></div>           
          </div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $riceroti_product->getName().'</span>
                    <span style="font-size:10px;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$riceroti_product->getId().'" name="breakfast" value="'. $riceroti_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$riceroti_product->getId().'" name="lunch" value="'. $riceroti_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$riceroti_product->getId().'" name="hightea" value="'. $riceroti_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$riceroti_product->getId().'" name="dinner" value="'. $riceroti_product->getName().'">  
              </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
     
      }
   }
  } 



$search ='rrc';
$riceroticollection = Mage::getModel('catalog/product')
->getCollection()
->addAttributeToFilter( array( array('attribute' => 'menucode', 'like' => '%'.$search.'%') ) )
->load();
$nonfavRiceRotiCollections = array();
foreach($riceroticollection as $product){
  $nonfavRiceRotiCollections[] = $product->getId();
}

$nonfavRicerotiCollection = array_diff($nonfavRiceRotiCollections, $favSaladCollection);
if(sizeof($nonfavRicerotiCollection) >0){
   foreach($nonfavRicerotiCollection as $value) {
    $riceroti_product = Mage::getModel("catalog/product")->load($value);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$salad_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($riceroti_product,$tomorrowDay);
      if($isMealToShow==true) { 
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value,$connection);
           
        $ricerotLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$riceroti_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($riceroti_product, 'small_image')->resize(null).'"       />

                                </div>
<div class="img-wrpr__fav" data-label="favorite">
            <div class="injectStyles-sc-1jy9bcf-0 disliked"></div>            
          </div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $riceroti_product->getName().'</span>
                    <span style="font-size:10px;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$riceroti_product->getId().'" name="breakfast" value="'. $riceroti_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$riceroti_product->getId().'" name="lunch" value="'. $riceroti_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$riceroti_product->getId().'" name="hightea" value="'. $riceroti_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$riceroti_product->getId().'" name="dinner" value="'. $riceroti_product->getName().'">  
              </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
     
      } 
      $countRicerotLI++;
   }
  }


$sqlDessert = "SELECT distinct productid  FROM  customerfavourite where  custid='".$custid."' and product_is_combo_child='no' and productname like '%dessert%'";
$favDessertCollection = $connection->fetchAll($sqlDessert);
 $favDessertCollections =array();
 if(sizeof($favDessertCollection) >0){
   foreach($favDessertCollection as $value) {
        $favDessertCollections[] =  $value['productid'];
        $dessert_product = Mage::getModel("catalog/product")->load($value['productid']);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$soup_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($dessert_product,$tomorrowDay);
      if($isMealToShow==true) { 
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value['productid'],$connection);
      $countDessertLI++;
        $dessertLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$dessert_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($dessert_product, 'small_image')->resize(null).'"       />

                                </div>
<div class="img-wrpr__fav" data-label="favorite">
            <div class="injectStyles-sc-1jy9bcf-0 liked"></div>           
          </div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $dessert_product->getName().'</span>
                    <span style="font-size:10px;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$dessert_product->getId().'" name="breakfast" value="'. $dessert_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$dessert_product->getId().'" name="lunch" value="'. $dessert_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$dessert_product->getId().'" name="hightea" value="'. $dessert_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$dessert_product->getId().'" name="dinner" value="'. $dessert_product->getName().'">  
              </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
     
      }
   }
  }

$search ='dessert';
$dessertcollection = Mage::getModel('catalog/product')
->getCollection()
->addAttributeToFilter( array( array('attribute' => 'menucode', 'like' => '%'.$search.'%') ) )
->load();
$nonfavDessertCollections = array();
foreach($dessertcollection as $product){
  $nonfavDessertCollections[] = $product->getId();
}

$nonfavdessertCollection = array_diff($nonfavDessertCollections, $favSaladCollection);
if(sizeof($nonfavdessertCollection) >0){
   foreach($nonfavdessertCollection as $value) {
    $dessert_product = Mage::getModel("catalog/product")->load($value);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$salad_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($dessert_product,$tomorrowDay);
      if($isMealToShow==true) { 
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value,$connection);
        $dessertLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$dessert_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($dessert_product, 'small_image')->resize(null).'"       />

                                </div>
<div class="img-wrpr__fav" data-label="favorite">
            <div class="injectStyles-sc-1jy9bcf-0 disliked"></div>            
          </div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $dessert_product->getName().'</span>
                    <span style="font-size:10px;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$dessert_product->getId().'" name="breakfast" value="'. $dessert_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$dessert_product->getId().'" name="lunch" value="'. $dessert_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$dessert_product->getId().'" name="hightea" value="'. $dessert_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$dessert_product->getId().'" name="dinner" value="'. $dessert_product->getName().'">  
              </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
      $countDessertLI++;
      } 
      
   }
  }


$breakfastcollection = Mage::getModel('catalog/category')->load(125)
 ->getProductCollection()
 ->addAttributeToSelect('*') // add all attributes - optional
 ->addAttributeToFilter('status', 1) // enabled
 //->addAttributeToFilter('visibility', 4) //visibility in catalog,search
 ->setOrder('price', 'ASC');  

 $nonfavbreakfastCollections = array();
foreach($breakfastcollection as $product){
  $nonfavbreakfastCollections[] = $product->getId();
}

 if(sizeof($nonfavbreakfastCollections) >0){
   foreach($nonfavbreakfastCollections as $value) {
        //$favDessertCollections[] =  $value['productid'];
        $breakfast_product = Mage::getModel("catalog/product")->load($value);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$soup_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($breakfast_product,$tomorrowDay);
      if($isMealToShow==true) { 
          $sqlbreakfast = "SELECT distinct productid  FROM  customerfavourite where  custid='".$custid."' and product_is_combo_child='no' and productid like '".$value."' ";
          $favBreakfastcollection = $connection->fetchAll($sqlbreakfast);
          //echo "size ".sizeof($favBreakfastcollection);
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value,$connection);
      $countBreakfastLI++;
        $breakfastLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$breakfast_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($breakfast_product, 'small_image')->resize(null).'"       />

                                </div>
          <div class="img-wrpr__fav" data-label="favorite">
            <div class="injectStyles-sc-1jy9bcf-0 liked"></div>           
          </div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $breakfast_product->getName().'</span>
                    <span style="font-size:10px;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$breakfast_product->getId().'" name="breakfast" value="'. $breakfast_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$breakfast_product->getId().'" name="lunch" value="'. $breakfast_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$breakfast_product->getId().'" name="hightea" value="'. $breakfast_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$breakfast_product->getId().'" name="dinner" value="'. $breakfast_product->getName().'">  
              </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
     
      }
   }
  }

$indiancollection = Mage::getModel('catalog/category')->load(92)
 ->getProductCollection()
 ->addAttributeToSelect('*') // add all attributes - optional
 ->addAttributeToFilter('status', 1) // enabled
 //->addAttributeToFilter('visibility', 4) //visibility in catalog,search
 ->setOrder('price', 'ASC');  

 $nonfavindcomboCollections = array();
foreach($indiancollection as $product){
  $nonfavindcomboCollections[] = $product->getId();
}

 if(sizeof($nonfavindcomboCollections) >0){
   foreach($nonfavindcomboCollections as $value) {
        //$favDessertCollections[] =  $value['productid'];
        $indcombo_product = Mage::getModel("catalog/product")->load($value);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$soup_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($indcombo_product,$tomorrowDay);
      if($isMealToShow==true) { 
          $sqlbreakfast = "SELECT distinct productid  FROM  customerfavourite where  custid='".$custid."' and product_is_combo_child='no' and productid like '".$value."' ";
          $favBreakfastcollection = $connection->fetchAll($sqlbreakfast);
          //echo "size ".sizeof($favBreakfastcollection);
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value,$connection);
      $countIndianComboLI++;
        $indiancomboLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$indcombo_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($indcombo_product, 'small_image')->resize(null).'"       />

                                </div>
          <div class="img-wrpr__fav" data-label="favorite">
            <div class="injectStyles-sc-1jy9bcf-0 liked"></div>           
          </div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $indcombo_product->getName().'</span>
                    <span style="font-size:10px;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$indcombo_product->getId().'" name="breakfast" value="'. $indcombo_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$indcombo_product->getId().'" name="lunch" value="'. $indcombo_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$indcombo_product->getId().'" name="hightea" value="'. $indcombo_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$indcombo_product->getId().'" name="dinner" value="'. $indcombo_product->getName().'">  
              </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
     
      }
   }
  }

$chinesecollection = Mage::getModel('catalog/category')->load(124)
 ->getProductCollection()
 ->addAttributeToSelect('*') // add all attributes - optional
 ->addAttributeToFilter('status', 1) // enabled
 //->addAttributeToFilter('visibility', 4) //visibility in catalog,search
 ->setOrder('price', 'ASC');  

 $nonfavchcomboCollections = array();
foreach($chinesecollection as $product){
  $nonfavchcomboCollections[] = $product->getId();
}

 if(sizeof($nonfavchcomboCollections) >0){
   foreach($nonfavchcomboCollections as $value) {
        //$favDessertCollections[] =  $value['productid'];
        $chcombo_product = Mage::getModel("catalog/product")->load($value);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$soup_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($chcombo_product,$tomorrowDay);
      if($isMealToShow==true) { 
          $sqlbreakfast = "SELECT distinct productid  FROM  customerfavourite where  custid='".$custid."' and product_is_combo_child='no' and productid like '".$value."' ";
          $favBreakfastcollection = $connection->fetchAll($sqlbreakfast);
          //echo "size ".sizeof($favBreakfastcollection);
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value,$connection);
      $countChineseComboLI++;
        $chinesecomboLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$chcombo_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($chcombo_product, 'small_image')->resize(null).'"       />

                                </div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $chcombo_product->getName().'</span>
                    <span style="font-size:10px;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$chcombo_product->getId().'" name="breakfast" value="'. $chcombo_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$chcombo_product->getId().'" name="lunch" value="'. $chcombo_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$chcombo_product->getId().'" name="hightea" value="'. $chcombo_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$chcombo_product->getId().'" name="dinner" value="'. $chcombo_product->getName().'">  
              </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
     
      }
   }
  }


$italiancollection = Mage::getModel('catalog/category')->load(93)
 ->getProductCollection()
 ->addAttributeToSelect('*') // add all attributes - optional
 ->addAttributeToFilter('status', 1) // enabled
 //->addAttributeToFilter('visibility', 4) //visibility in catalog,search
 ->setOrder('price', 'ASC');  

 $nonfavitalcomboCollections = array();
foreach($italiancollection as $product){
  $nonfavitalcomboCollections[] = $product->getId();
}

 if(sizeof($nonfavitalcomboCollections) >0){
   foreach($nonfavitalcomboCollections as $value) {
        //$favDessertCollections[] =  $value['productid'];
        $itcombo_product = Mage::getModel("catalog/product")->load($value);
        
        $countIteminPreviousOrder='';
      
        //echo $soup_product->getSku().'----'.$soup_product->getName(); echo '<br>';
      $isMealToShow = $this->checkMealDayAvailability($itcombo_product,$tomorrowDay);
      if($isMealToShow==true) { 
          $sqlbreakfast = "SELECT distinct productid  FROM  customerfavourite where  custid='".$custid."' and product_is_combo_child='no' and productid like '".$value."' ";
          $favBreakfastcollection = $connection->fetchAll($sqlbreakfast);
          //echo "size ".sizeof($favBreakfastcollection);
           $countIteminPreviousOrder = $this->itemcountinpreviousorder($customerEmail,$value,$connection);
      $countItalinaComboLI++;
        $italinacomboLI.='<li class="item">
<div class="itm-wrppr">
<div class="sc-bbmXgH gfbLKA">
        <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                <div class="wd-100">
                        <div class="sc-ksYbfQ PVrMb">
                                <div class="img-cvr">
                                  <img id="product-collection-image-'.$itcombo_product->getId().'"  class="img-wrpr__img"
                 src="'. Mage::helper('catalog/image')->init($itcombo_product, 'small_image')->resize(null).'"       />

                                </div>
                        </div>
                </div>
              <div class="sc-hmzhuo cCbxqa">
              <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'. $itcombo_product->getName().'</span>
                    <span style="font-size:10px;">'.$countIteminPreviousOrder.'</span>   
                  <span style="color:blue; font-size:10px;">('.$customer->getFirstname().')</span> 
                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$itcombo_product->getId().'" name="breakfast" value="'. $itcombo_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$itcombo_product->getId().'" name="lunch" value="'. $itcombo_product->getName().'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$itcombo_product->getId().'" name="hightea" value="'. $itcombo_product->getName().'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$itcombo_product->getId().'" name="dinner" value="'. $itcombo_product->getName().'">  
              </label>
                                  </span>   
                                </div>
                         </div>
                </div>
</div>
</div>

    </li>';  
     
      }
   }
  } 

   ///////////////////////////////////////// Start Ghar Ka Khana Checkbox Combo //////////////////////////////
  $comboLIGharkakhana ='';   $countComboLIGharkakhana =0 ;   
  $catId = 134;
  $category = Mage::getModel('catalog/category')->load($catId);
  $gharKaKhanaProductCollection = Mage::getModel('catalog/product')->getCollection()
                                  ->addAttributeToSelect('entity_id')
                                 ->addCategoryFilter($category)
                                 ->addAttributeToFilter('type_id', 'bundle')
        		         ->addAttributeToFilter('status', 1);
 $allComboIds = array();
 $favComboIds = array();
 $nonfavComboIds = array();
 foreach($gharKaKhanaProductCollection as $product)
  {
     $comboId = $product->getEntityId(); 
     $sqlDistinctCombo = "SELECT distinct  combo_id FROM  customerfavourite where custid='".$custid."' and combo_id='".$comboId."' and combo_options='checkbox' and product_is_combo_child='yes'";
     $favComboCollection = $connection->fetchAll($sqlDistinctCombo);
     
      if(sizeof($favComboCollection) ==1)
      {
          $favComboIds[] = $comboId;
      }
      else
      {
           $nonfavComboIds[]  = $comboId;
      }
  }
  $allComboIds = array_merge($favComboIds,$nonfavComboIds);
 
 
  if(sizeof($allComboIds) >0)
 {
    foreach($allComboIds as $comboId)
    {        
      $bundleProduct = Mage::getModel("catalog/product")->load($comboId);
      $optionCollection = $bundleProduct->getTypeInstance(true)->getOptionsCollection($bundleProduct);
      $selectionCollection = $bundleProduct->getTypeInstance(true)->getSelectionsCollection(
      $bundleProduct->getTypeInstance(true)->getOptionsIds($bundleProduct),$bundleProduct);

      $allOptions = $optionCollection->appendSelections($selectionCollection);
            
            
      $isMealToShow = $this->checkMealDayAvailability($bundleProduct,$tomorrowDay);
      if($isMealToShow==true)
      { 
         $countComboLIGharkakhana++;
         $comboName='';
           
        $comboLIGharkakhana.='<li class="item">
        <div class="itm-wrppr">
          <div class="sc-bbmXgH gfbLKA">
              <div class="injectStyles-sc-1jy9bcf-0 eRJwMX">
                 <div class="wd-100">
                    <div class="sc-ksYbfQ PVrMb">
                         <div class="img-cvr">
                                    <img id="product-collection-image-'.$bundleProduct->getId().'"  class="img-wrpr__img"
                                      src="'. Mage::helper('catalog/image')->init($bundleProduct, 'small_image')->resize(null).'" />
                         </div>
                    </div>
                 </div>
                 <div class="sc-hmzhuo cCbxqa">
                    <div class="itm-nm-dsc ">
                      <span class="itm-dsc__nm">'.$bundleProduct->getName().' <span style="color:blue">('.$customerName.')</span></span>	
                    </div>';                  
          
           foreach ($allOptions as $option) 
           {

             $selections = $option->getSelections();
             $optionId    = $option->getId();
             $countItemSelection=0;
             if(isset($selections) && sizeof($selections)>0)
             {
              foreach ($selections as $selection)
              {  
                    
                $countItemSelection++;
                $selectionId = $selection->getSelectionId();
                $productIdFromSelection = $selection->getProductId();
                $selectionPrice = round($selection->getSelectionPriceValue(),4); 
                $optionTitle = $selection->getName();

                /////////////////Check selection product is in databast or not ///////////////
               $checked='';
               $heartClass='';
               $checkSingleProductCollection = Mage::getModel('favourite/customerfavourite')->getCollection()
                          ->addFieldToFilter('custid',$custid)
                          ->addFieldToFilter('combo_id',$comboId )
                          ->addFieldToFilter('productid',$productIdFromSelection)
                          ->addFieldToFilter('product_is_combo_child','yes');
               
              //echo $checkSingleProductCollection->getSelect();
               if(count($checkSingleProductCollection)==1)
               {
                  $checked='checked';
                  $heartClass=' heart';
               }
                $comboLIGharkakhana.='<div class="itm-dsc__actn">
                        <div class="itm-dsc__actn__crst" data-label="selectCrust"  style="width:100%;">
                          <div>
                                <div class="injectStyles-sc-1jy9bcf-0 ">
                                   <div class="nm-icn">
                                             <div datalabel="crust" class="itm-dsc__actn__sz__dd-ttl'.$heartClass.'" >'.$optionTitle.'</div>
                                                <span>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              B<br>
              <input type="checkbox" productid="'.$productIdFromSelection.'" name="breakfast" value="'. $optionTitle.'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              L<br>
              <input type="checkbox" productid="'.$productIdFromSelection.'" name="lunch" value="'. $optionTitle.'"> 
             </label>
            <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
            H<br>
              <input type="checkbox" productid="'.$productIdFromSelection.'" name="hightea" value="'. $optionTitle.'">
              </label>
              <label class="checkbox-inline" style="font-size: smaller;margin: 0px;">
              D<br>
                <input type="checkbox" productid="'.$productIdFromSelection.'" name="dinner" value="'. $optionTitle.'">  
              </label>
                                  </span>     
                                             </div>							
                                             <div class="dd-wrpr" ></div>
                                    </div>
                                </div>
                                <div class="sz-ln drp-dwn-crst-hr"></div>
                       </div>
                   </div>';
                                ///////////////////////////////////////
				  
                    }
             }
           }
                     
                               
	  $comboLIGharkakhana.='</div></div></div>
			</div>
		
            </li>';
                   
                   
                 //  die;
              }
             
         }
 }
 ///////////////////////////////////////// End Ghar Ka Khana Checkbox Combo ///////////////////////////////


          
                $outPut=' <div class="catalog__list">';
                
                 if($countSoupLI>0 ) { 
                     $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;">
				<span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Soup Of '.$tomorrowDay.' </h3>';
                       $outPut.='<ul class="products-gridnew products-grid--max-3-col">'.$soupLI.'</ul>';

                 }  else { 
                     $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;">
				<span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Soup Of '.$tomorrowDay.' </h3>';
                     $outPut.= 'There is no soup.';
                 }
                 
               if($countSaladLI>0)
                {
                 $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Salad Of '.$tomorrowDay.'</h3>';
                  $outPut.='<ul class="products-gridnew products-grid--max-3-col">'.$saladLI.'</ul>';
                } 
                else
                {  $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Salad Of '.$tomorrowDay.'</h3>';
                   $outPut.= 'There is no salad.'; }

                 if($countRicerotLI>0)
                {
                 $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Rice/Roti Of '.$tomorrowDay.'</h3>';
             
                 $outPut.='<ul class="products-gridnew products-grid--max-3-col">'.$ricerotLI.'</ul>';
                } 
                else
                {   $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Rice/Roti Of '.$tomorrowDay.'</h3>';
                 $outPut.= 'There is no Rice/Roti.'; }
                
                 if($countDessertLI>0){ 
                      $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Desserts Of '.$tomorrowDay.'</h3>';
              
                 $outPut.='<ul class="products-gridnew products-grid--max-3-col">'.$dessertLI.'</ul>';
                } 
                else
                {  $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Desserts Of '.$tomorrowDay.'</h3>';
                 $outPut.= 'There is no Desserts'; }

               if($countBreakfastLI>0){ 
                    $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Breakfast Of '.$tomorrowDay.'</h3>';
                 
                 $outPut.='<ul class="products-gridnew products-grid--max-3-col">'.$breakfastLI.'</ul>';
                } 
                else
                {  $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Breakfast Of '.$tomorrowDay.'</h3>';
                    $outPut.= 'There is no Breakfast.'; }

              /*if($countIndianComboLI>0){ 
                    $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Indian Combo Of '.$tomorrowDay.'</h3>';
                
                 $outPut.='<ul class="comboheight comboheightsingle products-grid--max-3-col">'.$indiancomboLI.'</ul>';
                } 
                else
                {   $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Indian Combo Of '.$tomorrowDay.'</h3>';
                  $outPut.= 'There is no indian combo.'; }*/

                if($countChineseComboLI>0){ 
                     $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Chinese Combo Of '.$tomorrowDay.'</h3>';
             
                 $outPut.='<ul class="comboheight comboheightsingle products-grid--max-3-col">'.$chinesecomboLI.'</ul>';
                } 
                else
                {  $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Chinese Combo Of '.$tomorrowDay.'</h3>';
                   $outPut.= 'There is no Chinese combo.'; }

               if($countItalinaComboLI>0){ 
                    $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Italian Combo Of '.$tomorrowDay.'</h3>';
                
                 $outPut.='<ul class="comboheight comboheightsingle products-grid--max-3-col">'.$italinacomboLI.'</ul>';
                } else {  $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Italian Combo Of '.$tomorrowDay.'</h3>';
                $outPut.= 'There is no Italian combo.'; }

                $outPut.='<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Ghar ka khana Combo Of '.$tomorrowDay.'</h3>';
                if($countComboLIGharkakhana>0){ 
                 $outPut.='<ul class="comboheight products-grid--max-3-col">'.$indiancomboLI.$comboLIGharkakhana.'</ul>';
                } else { $outPut.= 'There is no Ghar Ka Khana.'; }

               if($countComboLI>0)
                { 
 $outPut.= '<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Combos Of '.$tomorrowDay.' </h3>';
                
                $outPut.= '<ul class="comboheight products-grid--max-3-col">'.$comboLI.'</ul>';

                }
                else 
               {  $outPut.= '<h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;"><span style="color: #269a9b;">( '.$customerName.' )</span> Favourite Combos Of '.$tomorrowDay.' </h3>';
                $outPut.=  'There is no combo.';} 


                if($countSoupLI==0 && $countSaladLI==0 && $countSoupLI==0)
                {
                    $outPut.='There is no favourite items of tomorrow';
                }


               $outPut.='</div>';
               
               echo $outPut;
                        
        }
        
             
        
    public  function checkMealDayAvailability($product,$DayToCheck)
{
    
    $favItemAvailableDay=array();
    if($product->getMonday()==1)
    {
        $favItemAvailableDay[] = 'Monday';
    }
      if($product->getTuesday()==1)
    {
         $favItemAvailableDay[] = 'Tuesday';
    }
      if($product->getWednesday()==1)
    {
        $favItemAvailableDay[] = 'Wednesday';
    }
      if($product->getThursday()==1)
    {
         $favItemAvailableDay[] = 'Thursday';
    }
      if($product->getFriday()==1)
    {
        $favItemAvailableDay[] = 'Friday';
    }
      if($product->getSaturday()==1)
    {
         $favItemAvailableDay[] = 'Saturday';
    }
      if($product->getSunday()==1)
    {
         $favItemAvailableDay[] = 'Sunday';
    }
    
  // echo '<pre>'; print_r($favItemAvailableDay); echo $DayToCheck; die;
    
    if(in_array($DayToCheck,$favItemAvailableDay) )
    {  //echo $product->getSku(); echo '<br>';
      return true;
    }else
    { return false;}
}


    public function itemcountinpreviousorder($customerEmail,$entityId,$connection)
  {
    
     $sqlCheck10DaysPreviousOrders = "SELECT id from healorder WHERE email='".$customerEmail."' and formatted_orderdate >= DATE_ADD(CURDATE(), INTERVAL -10 DAY)";
     $previousOrderResult10Days = $connection->fetchAll($sqlCheck10DaysPreviousOrders); 
     $count10daysItem='';
     $finalOutput='';
     if(count($previousOrderResult10Days)>0)
     {
        foreach($previousOrderResult10Days as $row)
        {  
          //  echo '<hr>';
             $sqlCheckItemExisting = "SELECT productid from healitemdetails where orderid='".$row['id']."' and productid='".$entityId."'";
             $itemCountResult = $connection->fetchAll($sqlCheckItemExisting);
             if(count($itemCountResult)>0)
             {
               $count10daysItem+=count($itemCountResult);
             }
        } 
     }
     
     $sqlCheck3DaysPreviousOrders = "SELECT id from healorder WHERE email='".$customerEmail."' and formatted_orderdate >= DATE_ADD(CURDATE(), INTERVAL -3 DAY)";
     $previousOrderResult3Days = $connection->fetchAll($sqlCheck3DaysPreviousOrders); 
     $count3daysItem='';
    
     if(count($previousOrderResult3Days)>0)
     {
        foreach($previousOrderResult3Days as $row)
        {  
          //  echo '<hr>';
             $sqlCheckItemExisting = "SELECT productid from healitemdetails where orderid='".$row['id']."' and productid='".$entityId."'";
             $itemCountResult = $connection->fetchAll($sqlCheckItemExisting);
             if(count($itemCountResult)>0)
             {
               $count3daysItem+=count($itemCountResult);
             }
        } 
     }
     
    // $product = Mage::getModel('catalog/product')->load($entityId);
     if($count10daysItem!='')
     {
         
         $finalOutput.='(In 10 Days:'.$count10daysItem.' times)';
     }
     
     if($count3daysItem!='')
     {
        
         $finalOutput.='(In 3 Days:'.$count3daysItem.' times)';
     }
     
   //  $finalOutput.= $product->getName();
         
     
     
     return $finalOutput;
  }
  
  public function checkcustomerAction()
	{
		$customerEmail = $this->getRequest()->getParam("email");
         $websiteId = Mage::app()->getWebsite()->getId();

		// Instance of customer loaded by the given email
		$customer = Mage::getModel('customer/customer')
			->setWebsiteId($websiteId)
			->loadByEmail($customerEmail);
			
			if(isset($customer) && ($customer->getEmail()==$customerEmail) ) 
			{ echo 'exist';}
		    else { echo 'not' ;   }
	}
	
	
	
	public function getcustomerintakerowsAction()
	{
		 $config  = Mage::getConfig()->getResourceConnectionConfig("default_setup");
		 $dbinfo = array("host" => $config->host,"user" => $config->username,"pass" => $config->password,"dbname" => $config->dbname);
	  
	    $host      = $dbinfo["host"];
	    $username  = $dbinfo["user"];
	    $password  = $dbinfo["pass"];
	    $dbname    =  $dbinfo["dbname"]; 
	    //print_r($dbinfo);
	    $con = mysqli_connect($host, $username,$password,$dbname);

	    if (mysqli_connect_errno()) {
		     printf("Connect failed: %s\n", mysqli_connect_error());
		     exit();
		  }
		  else
		  {   
	          $custId = Mage::app()->getRequest()->getParam('custid'); 
	          $mobileNo = Mage::app()->getRequest()->getParam('mobileno');   
	          $query = "select * from patientintakeform where custid=".$custId;
			  $result   = mysqli_query($con, $query);
			  $rowsCount = mysqli_num_rows($result);
	          //$result = mysqli_query($con,$query); 
			  
			  if ($rowsCount>0) {
			  ?>
			   <table cellpadding="0" cellspacing="2" >
			   <tr><th>Date:</th></tr>
				
			  
			<?php 
			  while ($row = mysqli_fetch_assoc($result)) {?>
				    <tr style="width: auto;margin: 0 10px 10px 0;float:left;"><td  style="cursor: pointer;float: left;list-style: none;display: block;text-align: center;width: auto;border: 1px solid silver;
padding: 10px;margin: 0 10px 10px 0;text-decoration: none;"> 
				 <span onclick="getPatientIntakeForm('<?php echo $row['patientid'];?>','<?php echo $custId;?>','<?php echo $mobileNo;?>')">
				<?php echo date('d-M-Y',strtotime($row['date'])) ;?></span>
				     </td></tr>	
			 <?php }
				
			  mysqli_free_result($result);
			   mysqli_close($con);
			   echo "</table>";
			}
			else
			{ ?>
		        <table cellpadding="0" cellspacing="2" > 
				<tr><td>There is no record.</td></tr>
				</table>
		<?php } ?> 
		  
		  <?php 
		  }
		
	}
	
	
	
		public function getcustomerintakeinformationAction()
  {
	  $patientid = Mage::app()->getRequest()->getParam('patientid'); 
	  $custId = Mage::app()->getRequest()->getParam('custid'); 
	  $mobileNo = Mage::app()->getRequest()->getParam('mobileno');

         
	   $customer = Mage::getModel('customer/customer')->load($custId);			$customerName = $customer->getFirstname()." ".$customer->getLastname();
		$customerName = str_replace("Dear ","",$customerName);	  
	  
	  $config  = Mage::getConfig()->getResourceConnectionConfig("default_setup");
     $dbinfo = array("host" => $config->host,"user" => $config->username,"pass" => $config->password,"dbname" => $config->dbname);
  
  $host      = $dbinfo["host"];
  $username  = $dbinfo["user"];
  $password  = $dbinfo["pass"];
  $dbname    =  $dbinfo["dbname"]; 
  //print_r($dbinfo);
  $con = mysqli_connect($host, $username,$password,$dbname);

  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
      }
      else 
	  {
	    $query = "select * from patientintakeform where patientid=".$patientid;
	  
		$result = mysqli_query($con,$query); 
		$row = mysqli_fetch_assoc($result);  
		//echo '<pre>'; print_r($row); 
		if(mysqli_num_rows($result)==1)
	    { 
	      $pid = $row['patientid']; ?>
       
	  <form id="contactform" method="post" action="<?php echo Mage::getBaseUrl();?>patientreport?pid=<?php echo base64_encode($pid);?>" class="intake_form">

      <div class="container">
      <div class="formbluebox">
        <div class="subheading"> <p>Client Intake Form:: <?php echo date('d-M-Y',strtotime($row['date']));?></p> </div>
        <ul id="progressbar">
          <li class="active"></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>                
        </ul>
        <div class="whitebox">
          <fieldset>         
            <div class="personal-fields">
                <div class="form-personal">
                    <div class="form-personal-left">
                        <label for="nameone">First Name</label>
                        <input type="text" name="name" id="name" value="<?php  echo $customerName;?>">
                    </div>

                   <div class="form-personal-right">
                        <div class="gender">
                            <label for="nameone">Gender</label> 
                            <div class="gender-inner">                   
                                <label class="radio_container">Male 
                                    <input type="radio" name="gender" value="male" <?php if( $row['gender']=='male') echo 'checked'; ?> />
                                    <span class="checkmark"></span>
                                </label>

                                <label class="radio_container">Female
                                     <input type="radio" name="gender" value="female" <?php if( $row['gender']=='female') echo 'checked'; ?> />
                                    <span class="checkmark"></span>
                                </label>
                            </div> 
                        </div>                                
                    </div>
                </div>               
                                   

                <div class="form-personal">
                    <div class="form-personal-left">
                        <label for="profession">Profession</label> 
                        <input type="text"  name="profession" id="profession" value="<?php echo $row['profession'];?>">
                    </div>
                    <div class="form-personal-right">
                        <label for="mobileno">Contact Number</label>
                        <input type="text" name="mobileno" id="mobileno" value="<?php echo $mobileNo;?>" >
                    </div>
                </div> 

                <div class="form-personal">
                    <label for="address1">Address</label>
                    <textarea name="address1" id="address1">
                      <?php echo $row['address1'];?>
                    </textarea>         
                </div>                                       
            </div>
            <input type="button" name="next" class="next action-button" value="Next Step" />
          </fieldset> 

          <fieldset>            
            <div class="challenges-bottom">
                <div class="challenges-bottom-inner">
                    <div class="challenges-bottom-inner-left">
                        <label for="age">Age</label>
                        <input type="text" name="age" value="<?php echo $row['age'];?>" >
                    </div>

                    <div class="challenges-bottom-inner-right">
                        <label for="height">Height </label>
                        <div class="height-col">
                            
                            <select name="height_feet">
                              <option>**</option>
                                <?php 
                                for($i=4; $i<8; $i++){
                                   if($i == $row['height_feet']){
                                    echo '<option value="'.$i.'" selected>'.$i.' Feet</option>';
                                   }else{
                                    echo '<option value="'.$i.'">'.$i.' Feet</option>';
                                   }                                  
                                } 
                                ?>
                            </select>
                            <select name="height_inch">
                              <option>**</option>
                                <?php for($i=1; $i<13; $i++){
                                  if($i==1){
                                     if($i == $row['height_inch']){
                                      echo '<option value="'.$i.'" selected>'.$i.' Inch</option>';
                                    }else{
                                      echo '<option value="'.$i.'">'.$i.' Inch</option>';
                                    }
                                  }else{
                                     if($i == $row['height_inch']){
                                      echo '<option value="'.$i.'" selected>'.$i.' Inches</option>';
                                      }else{
                                        echo '<option value="'.$i.'">'.$i.' Inches</option>';
                                      }
                                    }      
                                } ?>
                            </select>
                        </div>                        
                    </div>
                </div>

                <div class="challenges-bottom-inner">
                    <div class="challenges-bottom-inner-left">
                         <label for="weight">Weight </label>
                        <input type="text" name="weight" id="weight" placeholder="kg" value="<?php echo $row['weight'];?>">
                    </div>

                    <div class="challenges-bottom-inner-right">  
                        <label for="waist">Waist </label>
                        <select name="waist">
                          <option>**</option>
                            <?php 
                            for($i=25; $i<70; $i++){
                              if($i == $row['waist']){
                                echo '<option value="'.$i.'" selected>'.$i.' Inches</option>';
                              }else{
                                 echo '<option value="'.$i.'">'.$i.' Inches</option>';
                              }
                            } 
                            ?>
                        </select>                        
                    </div>                            
                </div>

                <div class="challenges-bottom-inner">
                    <div class="challenges-bottom-inner-left">
                        <label for="sleephour">How Many Hours Do You Sleep Per Night?</label>
                        <select name="sleephour">
                          <option>**</option>
                            <?php 
                            for($i=1; $i<13; $i++){
                              if($i == $row['sleephour']){
                                echo '<option value="'.$i.'" selected>'.$i.' Hours</option>';
                              }else{
                                  echo '<option value="'.$i.'">'.$i.' Hours</option>';  
                                }
                                        
                              } 
                              ?>
                          </select>
                    </div> 
                    <div class="challenges-bottom-inner-right">
                        <label for="exercisemin">How Many Minutes A Day Do You Exercise?</label>
                        <select name="exercisemin">
                          <option>**</option>
                          <?php
                            $b = 5;
                            for($i=1; $i<17; $i++){
                              if($b*$i == $row['exercisemin']){
                                echo '<option value="'.$b*$i.'" selected>'.$b*$i.' Minutes</option>';
                              }else{
                                echo '<option value="'.$b*$i.'">'.$b*$i.' Minutes</option>';
                              }

                            } 
                            ?>
                        </select>                        
                    </div>                           
                </div>
            </div><!--end of challenges-bottom --> 

            <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> 
            <input type="button" name="next" class="next action-button" value="Next Step" />                   
          </fieldset>


          <?php 
            $symptoms_checkbox_left = [
              "Acid Reﬂux"=>"acid", "Alzheimers disease"=>"alzheimers", "Asthma"=>"asthama", "Bloating"=>"bloating", "Blood pressure"=>"bp", "Blurred vision"=>"blurred_vision", "Body Pains"=>"body_pains", "Cardiac Diseases"=>"cardiac_disease", "Cervical Pain"=>"cervical", "Cholesterol"=>"cholestrol", "Constipation"=>"constipation", "COPD"=>"copd", "Dental Health complications"=>"dental_health_complication", "Depression"=>"depression", "Diabetes"=>"diabetes", "Eating disorders"=>"eating_disorders"
            ]; 

             $symptoms_checkbox_middle = [
              "Erectile Dysfunction"=>"erectile_dysfunction", "Fatigue"=>"fatigue", "Fatty Liver"=>"fatty_liver", "Frequent Stomach Infections"=>"frequent_stomach_infections", "Frequent Colds"=>"frequent_colds", "Frequent Urination"=>"frequent_urination", "Frozen shoulder"=>"frozen_shoulder", "Fungal Infections"=>"fungal_infections", "Headaches"=>"headaches", "Hearing Impairment "=>"hearing_impairment", "IBS"=>"ibs", "Infertility"=>"infertility", "Insomnia"=>"insomnia", "Itching or yeast infections"=>"itching_or_yiest_infections", "Joints Aches"=>"joint_aches", "Kidney Disease"=>"kidney_disease"
              ]; 

              $symptoms_checkbox_right = [
                "Migraines"=>"migranes", "Muscular Spasms"=>"muscular_spasms", "Neuropsychological problems "=>"neuropsychological_problems", "Patches of Dark Skin "=>"patches_of_dark_skin", "PCOD / PCOS"=>"pcod_pcos", "Poor wound healing"=>"poor_wound_healing", "Pre diabetic"=>"pre_diabetic", "Sinusitis"=>"sinusitis", "Sleep Apnea"=>"sleep_apnea", "Smoking"=>"smoking", "Spine issues"=>"spine_issues", "Stress"=>"stress", "Thyroid"=>"thyroid", "Tingling, numbness or pain in hands & feet"=>"tingling_numbness", "UTI's"=>"uti", "Low Immunity"=>"low_immunity"
            ];
            ?>

          <fieldset>
            <div class="symptoms">
            <h3>Please Check Any Symptoms You Are Facing</h3>
                <div class="symptoms-inner">
                    <div class="symptoms-inner-left">
                    <?php 
                      foreach ($symptoms_checkbox_left as $key => $value) { ?>
                        <div class="symptoms-checkbox"> 
                          <label class="checkbox_container"><?php echo $key; ?> 
                            <input type="checkbox"  name="<?php echo $value; ?>"  <?php if($row[$value] =='on') { echo 'checked';} ?>>
                            <span class="checkmarks"></span> 
                          </label>
                        </div>                      
                      <?php } ?>                       
                    </div><!--end of symptoms-inner-left-->

                    <div class="symptoms-inner-middle">
                    <?php 
                      foreach ($symptoms_checkbox_middle as $key => $value) { ?>
                        <div class="symptoms-checkbox"> 
                          <label class="checkbox_container"><?php echo $key; ?> 
                            <input type="checkbox"  name="<?php echo $value; ?>"  <?php if($row[$value] =='on') { echo 'checked';} ?>>
                            <span class="checkmarks"></span> 
                          </label>
                        </div>                      
                      <?php } ?>                        
                    </div><!--end of symptoms-inner-middle-->

                    <div class="symptoms-inner-right">
                      <?php 
                      foreach ($symptoms_checkbox_right as $key => $value) { ?>
                        <div class="symptoms-checkbox"> 
                          <label class="checkbox_container"><?php echo $key; ?> 
                            <input type="checkbox"  name="<?php echo $value; ?>"  <?php if($row[$value] =='on') { echo 'checked';} ?>>
                            <span class="checkmarks"></span> 
                          </label>
                        </div>                      
                      <?php } ?>
                    </div><!--end of symptoms-inner-right-->
                </div><!--end of symptoms inner -->

                <div class="lifestyle-medication">
                    <label for="medication">Current Medications</label>
                    <input type="text" name="medication" value="<?php echo $row['medication'];?>">
                </div>
                <div class="lifestyle-medication">
                    <label for="stresslevel">Your Stress Level On A Scale of 0-10</label>
                    <select name="stresslevel">
                        <option>**</option>
                        <?php
                        for($i=0; $i<11; $i++){
                           if($i == $row['stresslevel']){
                            echo '<option value="'.$i.'" selected>'.$i.'</option>';
                           }else{
                            echo '<option value="'.$i.'">'.$i.'</option>';
                           }                        
                        }
                      ?>
                    </select> 
                       
                </div>
            </div>  <!--end of symptoms -->                    
            <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> 
            <input type="button" name="next" class="next action-button" value="Next Step" />                   
          </fieldset>


            <?php 
            $challenges_checkbox = [
              "Late Night Snacking"=>"late_night_snacks", 
              "Mirch-Masala Crunchy Snacks"=>"mirch_masala", 
              "Eating Too Much With Drinks"=>"too_much_food", 
              "Heavy Afternoon Snacks"=>"afternoon_snacks",
              "Sweet Tooth"=>"sweet_tooth",
              "Fried Food Cravings"=>"fried_food",
              "Frequent Snacking"=>"frequent_snacking",
              "Heavy Carb & Gravy Cravings"=>"need_carbs"
            ];
            ?>

          <fieldset>
            <div class="challenges">
            <h3>Eating Challenges</h3>
                <div class="challenges-top">
                  <?php 
                  foreach ($challenges_checkbox as $key => $value) {?>
                    <div class="challenges-checkbox"> 
                      <label class="checkbox_container"><?php echo $key; ?>
                        <input type="checkbox"  name="<?php echo $value; ?>" <?php if($row[$value] =='on') { echo 'checked';} ?>> 
                        <span class="checkmarks"></span>
                      </label> 
                    </div>
                <?php } ?>                    
                </div><!--end of challenges-top --> 
                <div class="challenges-bottom-inner">
                    <div class="challenges-eating-inner-left">
                        <label for="stillleft">Other Food Cravings</label>
                        <input type="text" name="stillleft"  value="<?php echo $row['stillleft'];?>">
                    </div>                                    
                </div>              
            </div><!--end of challenges -->
            
            <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> 
            <input type="button" name="next" class="next action-button" value="Next Step" />                   
          </fieldset>

          <fieldset>
            <div class="lifestyle-section">
                <!--<h3>Lifestyle Assesment</h3>-->                    
                <div class="form-lifestyle">
                    <div class="form-personal-veg-left">
                        <label for="vegyes">Veg or Non Veg </label> 
                        <div class="veg-inner">
                            <label class="radio_container">Veg
                              <input type="radio" name="step3_veg_nonveg" value="veg" <?php if( $row['step3_veg_nonveg']=='veg') echo 'checked'; ?> /> 
                              <span class="checkmark"></span>
                            </label>

                            <label class="radio_container">Non Veg
                              <input type="radio" name="step3_veg_nonveg" value="non-veg" <?php if( $row['step3_veg_nonveg']=='non-veg') echo 'checked'; ?> /> 
                              <span class="checkmark"></span>
                            </label>                   
                        </div>
                    </div>
                    <div class="form-personal-veg-right">
                        <label for="eggyes">Egg</label>
                        <div class="egg-inner">
                            <label class="radio_container">Yes
                                <input type="radio" name="egg" value="egg" <?php if( $row['egg']=='yes') echo 'checked'; ?> />
                                <span class="checkmark"></span>
                            </label>

                            <label class="radio_container egg2">No
                                <input type="radio" name="egg" value="egg" <?php if( $row['egg']=='no') echo 'checked'; ?> />
                                <span class="checkmark"></span>
                            </label>    
                        </div>
                    </div>                            
                </div> 

                <div class="form-lifestyle">
                    <div class="chicken_per_week">
                        <label for="chicken_per_week" >If Non Veg, How Many Times Non Veg Per Week?</label>
                        <select name="chicken_per_week">
                            <option>**</option>
                            <?php
                            for($i=1; $i<13; $i++){
                              if($i == $row['chicken_per_week']){
                                 echo '<option value="'.$i.'" selected>'.$i.'</option>';
                              }else{
                                 echo '<option value="'.$i.'">'.$i.'</option>';
                              }                           
                            }
                            ?>
                        </select>
                        
                    </div>

                    <div class="tofu-right">
                        <label for="tofu">Tofu</label>
                        <div class="tofu-right-inner">
                            <label class="radio_container">Yes
                                <input type="radio" name="tofu" value="yes" <?php if( $row['tofu']=='yes') echo 'checked'; ?> />  
                                <span class="checkmark"></span>
                            </label>

                            <label class="radio_container">No
                                <input type="radio" name="tofu" value="no" <?php if( $row['tofu']=='no') echo 'checked'; ?> />    
                                <span class="checkmark"></span>
                            </label> 
                        </div>
                    </div>
                </div>             

                <div class="form-lifestyle">                      
                    <div class="tofu-left">
                        <label for="try_tofu">If No, Willing To Try Tofu</label>
                        <div class="tofu-left-inner">
                            <label class="radio_container">Yes
                                <input type="radio" name="try_tofu" value="no" <?php if( $row['try_tofu']=='yes') echo 'checked'; ?> />  
                                <span class="checkmark"></span>
                            </label>

                            <label class="radio_container">No
                               <input type="radio" name="try_tofu" value="no" <?php if( $row['try_tofu']=='no') echo 'checked'; ?> />  
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                     <div class="lifestyle-medication">
                    <label for="litre">Water intake per day,  in litres</label>
                    <select name="litre">
                        <option>**</option>
                        <?php
                        for($i=2; $i<13; $i++){
                            if($i == $row['litre']){
                                echo '<option value="'.$i.'" selected>'.$i.' Litres</option>';
                            }else{
                             echo '<option value="'.$i.'">'.$i.' Litres</option>';   
                            }                        
                        }
                      ?>
                    </select>
                </div>
                   
                </div>              

                <div class="form-lifestyle">
                    <label for="food_allergies">Food allergies</label>
                    <textarea name="food_allergies" id="food_allergies">
                      <?php echo $row['food_allergies'];?>
                    </textarea>
                </div>
                
            </div><!--end of lifestyle-section -->

            <input type="hidden" name="mobileno" value="<?php echo $mobileNo;?>" />
            <input type="hidden" name="custid" value="<?php  echo $custId;?>" />
            <input type="hidden" name="pid" value="<?php  echo $pid;?>" />  
           
            <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> 
            <input  type="button" name="submit" id="submit" value="Save" onclick= "submitpaitentform();"> 
        </fieldset>
        </div><!--end of whitebox-->        
      </div><!--end of formbluebox-->       
     </div><!--end of container-->	    
    </form>
    <script type="text/javascript">   
        var current_fs, next_fs, previous_fs;
        var opacity;
        jQuery(".next").click(function(){                
            current_fs = jQuery(this).parent();
            next_fs = jQuery(this).parent().next();
            jQuery("#progressbar li").eq(jQuery("fieldset").index(next_fs)).addClass("active");
            next_fs.show();
            current_fs.animate({opacity: 0}, {
                step: function(now) {
                    opacity = 1 - now;
                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({'opacity': opacity});
                },
                duration: 600
            });
        });

        jQuery(".previous").click(function(){           
            current_fs = jQuery(this).parent();
            previous_fs = jQuery(this).parent().prev();
            jQuery("#progressbar li").eq(jQuery("fieldset").index(current_fs)).removeClass("active");
            previous_fs.show();
            current_fs.animate({opacity: 0}, {
                step: function(now) {
                    opacity = 1 - now;
                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({'opacity': opacity});
                },
                duration: 600
            });
        });
        
        jQuery("#submit").click(function(){ 
            
            return true;
        });
    </script> 


    <?php  
        mysqli_close($con);
       }
	   else{ ?>
<div class="container">
		   <div class="norecord" style="width:100%; float:left;margin:20px auto;"> There is no patient record.</div>
</div>
		   
	   <?php }
	   
	   
     }
  }
  
  
  public function submitpaitentformAction()  {	 
		$data = Mage::app()->getRequest()->getParams();
		//echo '<pre>'; print_r($data);		 	
    $pid = trim($data['pid']);	   
		$config  = Mage::getConfig()->getResourceConnectionConfig("default_setup");
	$dbinfo = array("host" => $config->host,"user" => $config->username,"pass" => $config->password,"dbname" => $config->dbname);
	  
	  $host      = $dbinfo["host"];
	  $username  = $dbinfo["user"];
	  $password  = $dbinfo["pass"];
	  $dbname    = $dbinfo["dbname"]; 
	  
	 // print_r($dbinfo); die;
	  try {
	  $con = mysqli_connect($host,$username,$password ,$dbname);
	  if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      exit();
    }
		 
    $updateFields="";		
		$size= sizeof($data);
		$count=0;
		foreach($data as $key=>$value)	{
			$count++;
			if( $key!='pid')	{
				//$key= str_replace("-","_",$key);
				$updateFields.=$key."='".trim(htmlentities($value,ENT_QUOTES))."'";
				
				if($count<($size-1) )	{
					$updateFields.=','; 					
				}				
			}			
		}
		$query = "update patientintakeform "; 
		$query.="set ".$updateFields." where patientid=".$pid;
		//echo $query; 
			if (mysqli_query($con, $query)) {
				  // echo "Record updated successfully"; die;
				  echo 'Patient record has been updated successfully';
			} else {
				    echo 'not updated';
			}			
	 } 
	
	 catch(Exception $e) {
          echo 'Message: ' .$e->getMessage();
      }
  }
  
public function getbodyjsonAction()
  {
	  $LoggedIncustomer = Mage::helper('customer')->getCustomer();
             $custId = $LoggedIncustomer->getId();
             $customerName = $LoggedIncustomer->getFirstname();
             $mobileNo = $LoggedIncustomer->getPrimarymobileno();
			// echo $customerName.'---'.$customerId;
			 $config  = Mage::getConfig()->getResourceConnectionConfig("default_setup");
			 $params = Mage::app()->getRequest()->getParams();
			 $screenWidth = $params['width'];
			 $screenHeight = $params['height'];
			 
			 
$dbinfo = array("host" => $config->host,"user" => $config->username,"pass" => $config->password,"dbname" => $config->dbname);
  
  $host      = $dbinfo["host"];
  $username  = $dbinfo["user"];
  $password  = $dbinfo["pass"];
  $dbname    = $dbinfo["dbname"]; 
  
  $con = mysqli_connect($host  , $username,  $password ,$dbname);

  if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
     

	 $checkQuery = "select * from patientintakeform where custid='".$custId."' and mobileno='".$mobileNo."'";
	 $checkRowResult = mysqli_query($con,$checkQuery);
	 $countExisting = mysqli_num_rows($checkRowResult); 
	 
      $height='';
	  $weight='';
      $bp_systolic='';
	  $bp_diastolic='';
	  $vitamin_d='';
	  $b12='';
	  $iron='';
	  $calcium='';
	  $hdl='';
	  $sgpt='';
	  $t3='';
	  $t4='';
	  $ldl='';
	  
	  $tsh='';
	  
	  $sgot='';
	  $creatinine='';
	  $spirometry='';
	  $hba1c='';
	  $iga='';
	  
	  
	   
	   $checkThyroid=''; $checkTsh=''; $checkT3=''; $checkT4='';
	   $checkLdl_Heart='';
	   $checkSgot_Liver='';
	   $checkSpirometry_Lungs='';
	   $checkHba1c_Pancreas='';
	   $checkIga_Gut = '';
	   $checkCreatinine_Kidney='';
	   $checkedBmiValue='';
	   
	  $green = "rgba(75, 220, 70, 1)";
	  $red   = "rgba(255, 0, 0, 1)";
	  $orange= "rgba(235, 130, 18,1)";
   		      
	 $allBodyParts = array();
	  
	if($countExisting>0)
	{
		 $row   = '';
		 while ($rowInfo = mysqli_fetch_assoc($checkRowResult))
  		 {
            
			 $row = $rowInfo;
         }
		// echo '<pre>'; print_r($row); die;
		 $patientid=base64_encode($row['patientid'] );
		 
		
	  
	   
	   
	   /////////////// Check Thyroid ///////////////////////////////
	   if(  isset($row['tsh']) && $row['tsh']!='')
	   {
		  
	       $tsh = $row['tsh'];
	       $diseaseName ='TSH';
	       $value       = $tsh;
		   $checkThyroid = Mage::helper('disease')->getDiseaseLabel($diseaseName,$value);
	   }
	   
	
	   
	   //////////////////////////////// Check Heart /////////////////////////////////////////////
	   
	   if(  isset($row['ldl']) && $row['ldl']!='')
	   {
		  
	       $ldl = $row['ldl'];
	       $diseaseName ='LDL';
	       $value       = $ldl;
	       $checkLdl_Heart= Mage::helper('disease')->getDiseaseLabel($diseaseName,$value);
	   }

	   
	  
	   //////////////////////////////// Check PANCREAS /////////////////////////////////////////////
	   
	   if(  isset($row['hba1c']) && $row['hba1c']!='')
	   {
		  
	       $hba1c = $row['hba1c'];
	       $diseaseName ='HbA1c';
	       $value       = $hba1c;
	       $checkHba1c_Pancreas= Mage::helper('disease')->getDiseaseLabel($diseaseName,$value);
	   }
	   
	   //////////////////////////////// Check GUT /////////////////////////////////////////////
	   
	   if(  isset($row['iga']) && $row['iga']!='')
	   {
		  
	       $iga = $row['iga'];
	       $diseaseName ='IGA';
	       $value       = $iga;
	       $checkIga_Gut = Mage::helper('disease')->getDiseaseLabel($diseaseName,$value);
		   
		  // echo "checkIga_Gut=".$checkIga_Gut; die;
	   }
	   
	   
	   //////////////////////////////// Check BMI /////////////////////////////////////////////
	    if( ( isset($row['weight']) && $row['weight']>0) && ( isset($row['height']) && $row['height']>0))
	   {
		   $height= $row['height'];
		   $weight= $row['weight'];
		   
		   $heightInMeter =  $height*.01;; 
		
           $bmiCalulated = ( $weight/($heightInMeter *$heightInMeter) ) ;
           $bmiValue = round($bmiCalulated, 1);
	 
	       $diseaseName ='BMI';
	       $value       = $bmiValue;
	       $checkedBmiValue = Mage::helper('disease')->getDiseaseLabel($diseaseName,$value);
	   }
	 
	   
	}		
	//die;
    /////////////////////// Start Body Json ///////////////
	

    if($checkThyroid!='')
	{
  
		$thyroid = array();
		
		if($screenWidth >= 999) // desktop
		{
		
		$thyroid ['pos_X']=628;
		$thyroid ['pos_Y']=430;
       $thyroid ['size']=25;
		
		}
		elseif($screenWidth <=360)
		{
		    $thyroid ['pos_X']=162;
		    $thyroid ['pos_Y']=80;
            $thyroid ['size']=14;
		
		}
		elseif($screenWidth <=400)
		{
		    $thyroid ['pos_X']=190;
		    $thyroid ['pos_Y']=93;
            $thyroid ['size']=14;
		
		}
		elseif($screenWidth <=767)
		{
		    $thyroid ['pos_X']=210;
		    $thyroid ['pos_Y']=103;
            $thyroid ['size']=14;
		
		}
		
		elseif($screenWidth >= 768)
		{
		    $thyroid ['pos_X']=615;
		    $thyroid ['pos_Y']=420;
            $thyroid ['size']=25;
		
		}
		$thyroid ['outline']="#0bd00b";
				
		if($checkThyroid==2)
		{ 
			$thyroid['upColor']  =   $green;
			$thyroid['overColor']=   $green;
			$thyroid['hover'] = "<u><b>THYROID</b></u><br>Normal";
		}
		elseif($checkThyroid==1)
		{ 
			$thyroid['upColor']  =   $orange;
			$thyroid['overColor']=   $orange;
			$thyroid['hover'] = "<u><b>THYROID</b></u><br>Below Normal";
			
		}
		elseif($checkThyroid==3)
		{ 
			$thyroid['upColor']  =   $red;
			$thyroid['overColor']=   $red;
			$thyroid['hover'] = "<u><b>THYROID</b></u><br>Above Normal";
		}
			$thyroid ['url']= "https://lifeheal.in";
		$thyroid ['target']= "none";
		$thyroid ['enable']= !0;
		$allBodyParts[] = $thyroid;
		
	}
	
	
	if($checkLdl_Heart!='')
	{
		$heart = array();
		
			if($screenWidth >= 999) // desktop
		{
		
		$heart['pos_X']=630;
		$heart['pos_Y']=520;
		$heart['size']=25;
		}
		elseif($screenWidth <=360)
		{
		     $heart ['pos_X']=165;
		    $heart ['pos_Y']=116;
            $heart ['size']=14;
		
		}
		elseif($screenWidth <=400)
		{
		     $heart ['pos_X']=200;
		    $heart ['pos_Y']=143;
            $heart ['size']=14;
		
		}
		elseif($screenWidth <=767)
		{
		   $heart ['pos_X']=220;
		    $heart ['pos_Y']=153;
            $heart ['size']=14;
		
		}
		
		elseif($screenWidth >= 768)
		{
		   $heart['pos_X']=630;
		$heart['pos_Y']=520;
		$heart['size']=25;
		
		}
		
		
		$heart['outline']="#fa9b0b";
		
		//$heart['upColor']="rgba(235, 130, 18,1)";
		//$heart['overColor']="rgba(235, 130, 18, 0.8)";
		
		if($checkLdl_Heart==2)
		{ 
			$heart['upColor']  =   $green;
			$heart['overColor']=   $green;
			$heart['hover'] = "<u><b>HEART</b></u><br>Normal";
		}
		elseif($checkLdl_Heart==1)
		{ 
			$heart['upColor']  =   $orange;
			$heart['overColor']=   $orange;
			$heart['hover'] = "<u><b>HEART</b></u><br>Below Normal";
			
		}
		elseif($checkLdl_Heart==3)
		{ 
			$heart['upColor']  =   $red;
			$heart['overColor']=   $red;
			$heart['hover'] = "<u><b>HEART</b></u><br>Above Normal";
		}
		
		$heart['url']= Mage::getBaseUrl();
		$heart['target']= "new_window";
		$heart['enable']= !0;
		$allBodyParts[] = $heart;
	}
	  
	
		$lungs = array();
		if($screenWidth >= 999) // desktop
		{
		
		$lungs['pos_X']=580;
		$lungs['pos_Y']=570;
		$lungs['size']=25;
		}
	elseif($screenWidth <=360)
		{
		      $lungs ['pos_X']=140;
		    $lungs ['pos_Y']=150;
            $lungs ['size']=14;
		}
	elseif($screenWidth <=400)
		{
		      $lungs ['pos_X']=170;
		    $lungs ['pos_Y']=170;
            $lungs ['size']=14;
		}
		elseif($screenWidth <=767)
		{
		   $lungs ['pos_X']=190;
		    $lungs ['pos_Y']=180;
            $lungs ['size']=14;
		
		}
		
		
		elseif($screenWidth >= 768)
		{
		  $lungs['pos_X']=580;
		$lungs['pos_Y']=570;
		$lungs['size']=25;
		
		}
	
		$lungs ['hover'] = "<span style='float:left'><img src='http://lifeheal.americanarearugs.com/skin/frontend/rwd/default/images/liver.png'></span>
			<span style='float:right;text-align:center'><u><b>LUNGS</b></u><br>Detail</span>";
		
		$lungs['outline']="#0bd00b";
		$lungs['upColor']="rgba(75, 220, 70, 1)";
		$lungs['overColor']="rgba(75, 220, 70, 0.8)";
		$lungs['url']= Mage::getBaseUrl();
		$lungs['target']= "new_window";
		$lungs['enable']= !0;  
		$allBodyParts[] = $lungs;
	
	 
    	$lungs2 = array();
	
	if($screenWidth >= 999) // desktop
		{
		
		$lungs2['pos_X']=670;
		$lungs2['pos_Y']=570;
		$lungs2['size']=25;
		}
		elseif($screenWidth <=360)
		{
		      $lungs2 ['pos_X']=180;
		    $lungs2 ['pos_Y']=150;
            $lungs2 ['size']=14;
		}
	elseif($screenWidth <=400)
		{
		    $lungs2 ['pos_X']=210;
		    $lungs2 ['pos_Y']=170;
            $lungs2 ['size']=14;
		}
		elseif($screenWidth <=767)
		{
		  $lungs2 ['pos_X']=230;
		    $lungs2 ['pos_Y']=190;
            $lungs2 ['size']=14;
		
		}
	
		elseif($screenWidth >= 768)
		{
		  $lungs2['pos_X']=650;
		$lungs2['pos_Y']=570;
		$lungs2['size']=25;
		
		}
	
        $lungs2['hover'] = "<span style='float:left'><img src='http://lifeheal.americanarearugs.com/skin/frontend/rwd/default/images/liver.png'></span>
        <span style='float:right;text-align:center'><u><b>LUNGS</b></u><br>Detail</span>";
		
		$lungs2['outline']="#0bd00b";
		$lungs2['upColor']="rgba(75, 220, 70, 1)";
		$lungs2['overColor']="rgba(75, 220, 70, 0.8)";
		$lungs2['url']= Mage::getBaseUrl();
		$lungs2['target']= "new_window";
		$lungs2['enable']= !0;  
		$allBodyParts[] = $lungs2;
		
		
		//$checkSpirometry_Lungs='';
	    //$checkHba1c_Pancreas='';
	    //$checkLga_Gut = '';
	
	if($checkSgot_Liver!='')  
	{
		$liver = array();
		   	if($screenWidth >= 999) // desktop
		{
		
		$liver['pos_X']=590;
		$liver['pos_Y']=640;
		$liver['size']=25;
		}
		elseif($screenWidth <=360)
		{
		     $liver ['pos_X']=300;
		    $liver ['pos_Y']=150;
            $liver ['size']=14;
		}
	elseif($screenWidth <=400)
		{
		   $liver ['pos_X']=300;
		    $liver ['pos_Y']=150;
            $liver ['size']=14;
		}
		elseif($screenWidth <=767)
		{
		   $liver ['pos_X']=300;
		    $liver ['pos_Y']=150;
            $liver ['size']=14;
		
		}
	
		elseif($screenWidth >= 768)
		{
		   $liver['pos_X']=570;
		$liver['pos_Y']=640;
		$liver['size']=25;
		
		}
		
		
		//$liver['outline']="#FF0000";
		//$liver['upColor']="rgba(255, 0, 0, 1)";
		
		if($checkSgot_Liver==2)
		{ 
				$liver['upColor']  =   $green;
				$liver['overColor']=   $green;
				$liver['hover'] = "<u><b>LIVER</b></u><br>Normal";
		}
		elseif($checkSgot_Liver==1)
		{ 
				$liver['upColor']  =   $orange;
				$liver['overColor']=   $orange;
				$liver['hover'] = "<u><b>LIVER</b></u><br>Below Normal";
				
		}
		elseif($checkSgot_Liver==3)
		{ 
				$liver['upColor']  =   $red;
				$liver['overColor']=   $red;
				$liver['hover'] = "<u><b>LIVER</b></u><br>Above Normal";
		}
			
		$liver['url']= Mage::getBaseUrl();
		$liver['target']= "new_window";
		$liver['enable']= !0;
		$allBodyParts[] = $liver;
	}
	
	if($checkHba1c_Pancreas!='')
	{
			$pancreas = array();
			 //   $pancreas['hover'] = "<u><b>PANCREAS</b></u><br>Add unlimited number of spots<br>anywhere on the diagram and<br>customize its colors and size and<br>link it to any webpage.";
		   	if($screenWidth >= 999) // desktop
		{
				
			$pancreas['pos_X']=690;
			$pancreas['pos_Y']=680;
			$pancreas['size']=25;
		}
		elseif($screenWidth <=360)
		{
		   $pancreas ['pos_X']=180;
		    $pancreas ['pos_Y']=180;
            $pancreas ['size']=14;
		}
		elseif($screenWidth <=400)
		{
		   $pancreas ['pos_X']=220;
		    $pancreas ['pos_Y']=210;
            $pancreas ['size']=14;
		}
		elseif($screenWidth <=767)
		{
		  $pancreas ['pos_X']=240;
		    $pancreas ['pos_Y']=240;
            $pancreas ['size']=14;
		}
	
	
		elseif($screenWidth >= 768)
		{
		$pancreas['pos_X']=650;
			$pancreas['pos_Y']=660;
			$pancreas['size']=25;
		
		}
			//$pancreas['upColor']=  "rgba(235, 130, 18,1)";
			//$pancreas['overColor']= "rgba(235, 130, 18, 0.8)";
			if($checkHba1c_Pancreas==2)
				{ 
						$pancreas['upColor']  =   $green;
						$pancreas['overColor']=   $green;
						$pancreas['hover'] = "<u><b>PANCREAS</b></u><br>Normal";
				}
				elseif($checkHba1c_Pancreas==1)
				{ 
						$pancreas['upColor']  =   $orange;
						$pancreas['overColor']=   $orange;
						$pancreas['hover'] = "<u><b>PANCREAS</b></u><br>Below Normal";
						
				}
				elseif($checkHba1c_Pancreas==3)
				{ 
						$pancreas['upColor']  =   $red;
						$pancreas['overColor']=   $red;
						$pancreas['hover'] = "<u><b>PANCREAS</b></u><br>Above Normal";
				}
			$pancreas['url']= Mage::getBaseUrl();
			$pancreas['target']= "new_window";
			$pancreas['enable']= !0;
			$allBodyParts[] = $pancreas;
	}
	
	if($checkIga_Gut!='')
	{
	$GUT = array();
			if($screenWidth >= 999) // desktop
		{
				
			$GUT['pos_X']=625;
	$GUT['pos_Y']=700;
	$GUT['size']=25;
		}
		elseif($screenWidth <=360)
		{
		  $GUT ['pos_X']=163;
		    $GUT ['pos_Y']=210;
            $GUT ['size']=14;
		}
		elseif($screenWidth <=400)
		{
		  $GUT ['pos_X']=190;
		    $GUT ['pos_Y']=240;
            $GUT ['size']=14;
		}
		elseif($screenWidth <=767)
		{
		 $GUT ['pos_X']=210;
		    $GUT ['pos_Y']=270;
            $GUT ['size']=14;
		}
		elseif($screenWidth >= 768)
		{
			$GUT['pos_X']=612;
	$GUT['pos_Y']=710;
	$GUT['size']=25;
		
		}
    $GUT['hover'] = "<u><b>GUT</b></u><br>Add unlimited number of spots<br>anywhere on the diagram and<br>customize its colors and size and<br>link it to any webpage.";
	
	$GUT['outline']=  "#0bd00b";
	//$GUT['upColor']=   "rgba(75, 220, 70, 1)";
	//$GUT['overColor']= "rgba(75, 220, 70, 0.8)";
	if($checkIga_Gut==2)
		{ 
				$GUT['upColor']  =   $green;
				$GUT['overColor']=   $green;
				$GUT['hover'] = "<u><b>GUT</b></u><br>Normal";
		}
		elseif($checkIga_Gut==1)
		{ 
				$GUT['upColor']  =   $orange;
				$GUT['overColor']=   $orange;
				$GUT['hover'] = "<u><b>GUT</b></u><br>Below Normal";
				
		}
		elseif($checkIga_Gut==3)
		{ 
				$GUT['upColor']  =   $red;
				$GUT['overColor']=   $red;
				$GUT['hover'] = "<u><b>GUT</b></u><br>Above Normal";
		}
	$GUT['url']= "#";
	$GUT['onclick']= "javascript:alert('hello')";
	$GUT['target']= "new_window";
	$GUT['enable']= !0;
	$allBodyParts[] = $GUT;
 
	}
    if($checkedBmiValue!='')
	{
		$bmi = array();
			if($screenWidth >= 999) // desktop
		{
				
		$bmi['pos_X']=750;
		$bmi['pos_Y']=900;
		$bmi['size']=25;
		}
		elseif($screenWidth <=360)
		{
		  $bmi ['pos_X']=218;
		    $bmi ['pos_Y']=270;
            $bmi ['size']=14;
		}
		elseif($screenWidth <=400)
		{
		  $bmi ['pos_X']=252;
		    $bmi ['pos_Y']=320;
            $bmi ['size']=14;
		}
		elseif($screenWidth <=767)
		{
		$bmi ['pos_X']=280;
		    $bmi ['pos_Y']=340;
            $bmi ['size']=14;
		}
	
		elseif($screenWidth >= 768)
		{
			$bmi['pos_X']=710;
		$bmi['pos_Y']=860;
		$bmi['size']=25;
		
		}
		
		
			$bmi['upColor']=  "#fa9b0b";
		$bmi['outline']=  "#fa9b0b";
		if($checkedBmiValue==2)
		{ 
			$bmi['upColor']  =   $green;
			$bmi['overColor']=   $green;
			$bmi['hover'] = "<u><b>BMI</b></u><br>Normal";
		}
		elseif($checkedBmiValue==1)
		{ 
			$bmi['upColor']  =   $orange;
			$bmi['overColor']=   $orange;
			
		}
		elseif($checkedBmiValue==3)
		{ 
			$bmi['upColor']  =   $red;
			$bmi['overColor']=   $red;
			$bmi['hover'] = "<u><b>BMI</b></u><br>Above Normal";
		}
		
		//$bmi['url']= Mage::getBaseUrl();
		//$bmi['target']= "new_window";
		$bmi['enable']= !0;
		$allBodyParts[] = $bmi;
	  
	}
	
	  
	
	
	$pinsArray['pins'] = $allBodyParts;
        header('Content-type: application/json');
        echo $mallJson = json_encode($pinsArray);
  }
  
  
  
/*================ TEST REPORT API ================*/
public function getapitestreportAction()  {
    $config  = Mage::getConfig()->getResourceConnectionConfig("default_setup");
    $dbinfo = array("host" => $config->host,"user" => $config->username,"pass" => $config->password,"dbname" => $config->dbname);    
    $host      = $dbinfo["host"];
    $username  = $dbinfo["user"];
    $password  = $dbinfo["pass"];
    $dbname    =  $dbinfo["dbname"]; 

    $con = mysqli_connect($host, $username,$password,$dbname);

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
      }
      else {   
         // echo '<pre>'; print_r($_POST);die;        
          if(!empty($_POST['date'])){             
            $size= sizeof($_POST);
            $date = $_POST['date'];
            $custId = $_POST['custid']; 
            $query = "select * from patientintakeform where custid='".$custId."' and date='".$date."'";            
            $result   = mysqli_query($con, $query);
            if(!empty($_FILES['report_file'])){
              if ($_FILES['report_file']['type'] == "application/pdf") {
                $filename = $_FILES['report_file']['name'];
                $type = $_FILES['report_file']['type'];
                $tmp_name = $_FILES['report_file']['tmp_name'];
                $uploadPath = Mage::getBaseDir('media').DS.'upload'.DS;
                move_uploaded_file($tmp_name, $uploadPath.$filename);          
              }
            }
            $rowsCount = mysqli_num_rows($result);             
            if($rowsCount > 0){
               $fields="";  $values=""; $updateFields=''; $count=0;
                foreach($_POST as $key=>$value) {
                  $count++; 
                  if(($_POST[$key]!='') && ($key!='height')){  
                    if($key=='waist_cm'){                     
                      $wnum = round(0.39*intval($value));                      
                      $updateFields.="waist='".$wnum."'";
                    }else if($key=='height_cm'){                       
                        $hnum = round(0.39*intval($value));
                        $updateFields.="height_inch"."='".$hnum."'";
                      }else{
                        $updateFields.=$key."='".$value."'";
                      }                      
                    if($count<$size){
                        $updateFields.=',';           
                      }        
                  }   
                } 
                  
                $updatequery="update patientintakeform ";
                $updatequery.="set ".$updateFields." where custid='".$custId."' and date='".$date."'";
                if (mysqli_query($con, $updatequery)) {
                    while ($rowInfo = mysqli_fetch_assoc($result)) {    
                        $updatedId = $rowInfo['patientid'];
                        if(!empty($_FILES['report_file'])){             
                          $filename = $_FILES['report_file']['name'];
                          $picsql = "UPDATE patientintakeform SET report_file='".$filename."' WHERE patientid=".$updatedId;
                          mysqli_query($con, $picsql);
                        }
                        echo $updatedId;
                      }
                  }
                
              }else if($rowsCount == 0){                
                $fields="";  $values=""; $count=0;
                foreach($_POST as $key=>$value) {
                  $count++;
                  if(($_POST[$key]!='') && ($key!='height')){
                    if($key=='waist_cm'){
                      $fields.="waist";
                      $wnum = round(0.39*intval($value));
                      $values.="'".$wnum."'";
                      }else if($key=='height_cm'){
                        $fields.="height_inch";
                        $hnum = round(0.39*intval($value));
                        $values.="'".$hnum."'"; 
                      }else{
                        $fields.=$key;
                        $values.="'".$value."'";
                      }                    
                      if($count<$size){
                        $fields.=',';       
                        $values.=',';                         
                      }
                  }                  
                }//end of foreach
                             
                $query="insert into patientintakeform(";
                $query.=$fields.") values(".$values.")"; 

                if (mysqli_query($con, $query)) {
                    $last_insert_id = mysqli_insert_id($con); 
                    if(!empty($_FILES['report_file'])){             
                      $filename = $_FILES['report_file']['name'];
                      $picsql = "UPDATE patientintakeform SET report_file='".$filename."' WHERE patientid=".$last_insert_id;
                      mysqli_query($con, $picsql);
                    }
                  echo $last_insert_id;
                //$last_id=base64_encode($last_insert_id);
                }
          }                
          //echo $last_insert_id;
        }    
      } 
  }
/*================ END OF TEST REPORT API ================*/


public function getprescriptionAction()  {
    $config  = Mage::getConfig()->getResourceConnectionConfig("default_setup");
    $dbinfo = array("host" => $config->host,"user" => $config->username,"pass" => $config->password,"dbname" => $config->dbname);    
    $host      = $dbinfo["host"];
    $username  = $dbinfo["user"];
    $password  = $dbinfo["pass"];
    $dbname    =  $dbinfo["dbname"]; 

    $con = mysqli_connect($host, $username,$password,$dbname);

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
      }
      else {   
         // echo '<pre>'; print_r($_POST);die;        
          if(!empty($_POST['date'])){  
          //echo '<pre>'; print_r($_POST);die;           
            $size= sizeof($_POST);
            $date = $_POST['date'];
            $custId = $_POST['custid']; 
            $query = "select * from patientintakeform where custid='".$custId."' and date='".$date."'";            
            $result   = mysqli_query($con, $query);
            if(!empty($_FILES['prescription'])){
              if ($_FILES['prescription']['type'] == "application/pdf") {
                $filename = $_FILES['prescription']['name'];
                $type = $_FILES['prescription']['type'];
                $tmp_name = $_FILES['prescription']['tmp_name'];
                $uploadPath = Mage::getBaseDir('media').DS.'upload'.DS;
                move_uploaded_file($tmp_name, $uploadPath.$filename);          
              }
            }
            $rowsCount = mysqli_num_rows($result);             
            if($rowsCount > 0){
               $fields="";  $values=""; $updateFields=''; $count=0;
                foreach($_POST as $key=>$value) {
                  $count++; 
                  if(($_POST[$key]!='')){ 
                      $updateFields.=$key."='".$value."'";
                    if($count < $size){
                        $updateFields.=',';           
                      }        
                  }   
                }          
                $updatequery="update patientintakeform ";
                $updatequery.="set ".$updateFields." where custid='".$custId."' and date='".$date."'";               
                if (mysqli_query($con, $updatequery)) {
                    while ($rowInfo = mysqli_fetch_assoc($result)) {    
                        $updatedId = $rowInfo['patientid'];
                        if(!empty($_FILES['prescription'])){             
                          $filename = $_FILES['prescription']['name'];
                          $picsql = "UPDATE patientintakeform SET prescription='".$filename."' WHERE patientid=".$updatedId;
                          mysqli_query($con, $picsql);
                        }
                        echo $updatedId;
                      }
                  }
                
              }else if($rowsCount == 0){                
                $fields="";  $values=""; $count=0;
                foreach($_POST as $key=>$value) {
                  $count++;
                  if(($_POST[$key]!='')){
                      $fields.=$key;
                      $values.="'".$value."'";                                         
                      if($count < $size){
                        $fields.=',';       
                        $values.=',';                         
                      }
                  }                  
                }//end of foreach
                
                $query="insert into patientintakeform(";
                $query.=$fields.") values(".$values.")"; 
                                     
                if (mysqli_query($con, $query)) {
                    $last_insert_id = mysqli_insert_id($con); 
                    if(!empty($_FILES['prescription'])){             
                      $filename = $_FILES['prescription']['name'];
                      $picsql = "UPDATE patientintakeform SET prescription='".$filename."' WHERE patientid=".$last_insert_id;         
                      mysqli_query($con, $picsql);
                    }
                  echo $last_insert_id;
                //$last_id=base64_encode($last_insert_id);
                }
          }                
          //echo $last_insert_id;
        }    
      } 
  }



  public function getconsultationAction()  {
    $config  = Mage::getConfig()->getResourceConnectionConfig("default_setup");
    $dbinfo = array("host" => $config->host,"user" => $config->username,"pass" => $config->password,"dbname" => $config->dbname);    
    $host      = $dbinfo["host"];
    $username  = $dbinfo["user"];
    $password  = $dbinfo["pass"];
    $dbname    =  $dbinfo["dbname"]; 

    $con = mysqli_connect($host, $username,$password,$dbname);

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
      }
      else {   
         // echo '<pre>'; print_r($_POST);die;        
          if(!empty($_POST['date'])){  
          //echo '<pre>'; print_r($_POST);die;           
            $size= sizeof($_POST);
            $date = $_POST['date'];
            $custId = $_POST['custid']; 
            $query = "select * from patientintakeform where custid='".$custId."' and date='".$date."'";            
            $result   = mysqli_query($con, $query);
            if(!empty($_FILES['consultation_file'])){
              if ($_FILES['consultation_file']['type'] == "application/pdf") {
                $filename = $_FILES['consultation_file']['name'];
                $type = $_FILES['consultation_file']['type'];
                $tmp_name = $_FILES['consultation_file']['tmp_name'];
                $uploadPath = Mage::getBaseDir('media').DS.'upload'.DS;
                move_uploaded_file($tmp_name, $uploadPath.$filename);          
              }
            }
            $rowsCount = mysqli_num_rows($result);             
            if($rowsCount > 0){
               $date = $_POST['date'];
               $consultation_author = $_POST['consultation_author'];
               $consultation_action = $_POST['consultation_action']; 
               $sleep = $_POST['sleep']; 
               $stress = $_POST['stress'];
               $nutrition = $_POST['nutrition']; 
               $exercise = $_POST['exercise'];
               $health = $_POST['health'];
               $success = $_POST['success'];
               $custid = $_POST['custid'];
               $name = $_POST['name'];
               $mobileno = $_POST['mobileno'];

               $consultation_summary = $sleep.":".$stress.":".$nutrition.":".$exercise.":".$health.":".$success;

              $updatequery = "UPDATE patientintakeform SET date ='".$date."', mobileno = '".$mobileno."', custid = '".$custId."', name = '".$name."', consultation_author = '".$consultation_author."', consultation_action = '".$consultation_action."', consultation_summary = '".$consultation_summary."' WHERE custid='".$custId."' and date='".$date."'";

                if (mysqli_query($con, $updatequery)) {
                    while ($rowInfo = mysqli_fetch_assoc($result)) {    
                        $updatedId = $rowInfo['patientid'];
                        if(!empty($_FILES['consultation_file'])){             
                          $filename = $_FILES['consultation_file']['name'];
                          $picsql = "UPDATE patientintakeform SET consultation_file='".$filename."' WHERE patientid=".$updatedId;
                          mysqli_query($con, $picsql);
                        }
                        echo $updatedId;
                      }
                  }
                
              }else if($rowsCount == 0){ 
               $date = $_POST['date'];
               $consultation_author = $_POST['consultation_author'];
               $consultation_action = $_POST['consultation_action']; 
               $sleep = $_POST['sleep']; 
               $stress = $_POST['stress'];
               $nutrition = $_POST['nutrition']; 
               $exercise = $_POST['exercise'];
               $health = $_POST['health'];
               $success = $_POST['success'];
               $custid = $_POST['custid'];
               $name = $_POST['name'];
               $mobileno = $_POST['mobileno'];

               $consultation_summary = $sleep.":".$stress.":".$nutrition.":".$exercise.":".$health.":".$success;
                
                $query = "insert into patientintakeform (date, mobileno, custid, name, consultation_author, consultation_action, consultation_summary) values ('".$date."', '".$mobileno."', '".$custid."', '".$name."', '".$consultation_author."', '".$consultation_action."', '".$consultation_summary."')";
                                     
                if (mysqli_query($con, $query)) {
                    $last_insert_id = mysqli_insert_id($con); 
                    if(!empty($_FILES['consultation_file'])){             
                      $filename = $_FILES['consultation_file']['name'];
                      $picsql = "UPDATE patientintakeform SET consultation_file='".$filename."' WHERE patientid=".$last_insert_id;         
                      mysqli_query($con, $picsql);
                    }
                  echo $last_insert_id;
                //$last_id=base64_encode($last_insert_id);
                }
          }                
          //echo $last_insert_id;
        }    
      } 
  }



public function getexistingprescriptionAction()  {
     $config = Mage::getConfig()->getResourceConnectionConfig("default_setup");
     $dbinfo = array("host" => $config->host,"user" => $config->username,"pass" => $config->password,"dbname" => $config->dbname);    
      $host      = $dbinfo["host"];
      $username  = $dbinfo["user"];
      $password  = $dbinfo["pass"];
      $dbname    =  $dbinfo["dbname"]; 
      //print_r($dbinfo);
      $con = mysqli_connect($host, $username,$password,$dbname);
      if (mysqli_connect_errno()) {
         printf("Connect failed: %s\n", mysqli_connect_error());
         exit();
      }
      else {   
            $mobileno = $_POST['mobileno'];
            $custId = $_POST['custid'];
            $custName = $_POST['custName'];
            $alltr ='';           
            $query = "select * from patientintakeform where custid='".$custId."' and mobileno='".$mobileno."' ORDER BY date DESC";            
            $result   = mysqli_query($con, $query);            

            while ($row = mysqli_fetch_assoc($result)) {
              if($row['prescription']!=''){
                $pdf = $row['prescription']; 
                $pdf_file = "<a href=\"javascript:void(0)\" onclick=\"downloadPdf('$pdf')\" title=\"$pdf\">
                      <img style=\"width:22px; margin-right: 5px;\" src=\"".Mage::getBaseUrl()."skin/frontend/rwd/default/images/pdf-eng-download-icon.png\">
                      </a>";               
              }else{
                $pdf_file = "";
              }           
               $alltr.='<tr>
                  <td>'.$row['date'].'</td>                 
                  <td>'.$pdf_file.'</td>                 
               </tr>';               
            }
            echo $alltr;
          } 
  }




  public function getexistingconsultationAction()  {
     $config = Mage::getConfig()->getResourceConnectionConfig("default_setup");
     $dbinfo = array("host" => $config->host,"user" => $config->username,"pass" => $config->password,"dbname" => $config->dbname);    
      $host      = $dbinfo["host"];
      $username  = $dbinfo["user"];
      $password  = $dbinfo["pass"];
      $dbname    =  $dbinfo["dbname"]; 
      //echo  $dbname;
      //die();
      $con = mysqli_connect($host, $username,$password,$dbname);
      if (mysqli_connect_errno()) {
         printf("Connect failed: %s\n", mysqli_connect_error());
         exit();
      }
      else {   
            $mobileno = $_POST['mobileno'];
            $custId = $_POST['custid'];
            $custName = $_POST['custName'];
            $alltr ='';           
            $query = "select * from patientintakeform where custid='".$custId."' and mobileno='".$mobileno."' and consultation_summary IS NOT NULL ORDER BY date DESC";            
            $result   = mysqli_query($con, $query);            

            while ($row = mysqli_fetch_assoc($result)) {
              if($row['consultation_file']!=''){
                $pdf = $row['consultation_file']; 
                $pdf_file = "<a href=\"javascript:void(0)\" onclick=\"downloadPdf('$pdf')\" title=\"$pdf\">
                      <img style=\"width:22px; margin-right: 5px;\" src=\"".Mage::getBaseUrl()."skin/frontend/rwd/default/images/pdf-eng-download-icon.png\">
                      </a>";               
              }else{
                $pdf_file = "";
              }  
              if($row['consultation_summary']!=''){                
                $summar_arr = explode(":",$row['consultation_summary']);
                $summary_content=["Sleep","Stress","Nutrition","Exercise","Any Specific Health Issue","Any Recent Success"];
                for($k = 0; $k < count($summar_arr); $k++){
                  if($summar_arr[$k]!=''){
                    $summary_str.="<span>".$summary_content[$k]."</span>".$summar_arr[$k];
                  }
                }                
              } else{
                $summary_str ='';
              }        
               $alltr.='<tr>
                  <td>'.$row['date'].'</td>
                  <td>'.$summary_str.'</td>
                  <td>'.$row['consultation_action'].'</td>
                  <td>'.$row['consultation_author'].'</td>                  
                  <td>'.$pdf_file.'</td>                 
               </tr>'; 
               $summar_arr = []; 
               $summary_str ='';             
            }
            echo $alltr;
          } 
  }



public function getpreviousreportAction()  {
     $config = Mage::getConfig()->getResourceConnectionConfig("default_setup");
     $dbinfo = array("host" => $config->host,"user" => $config->username,"pass" => $config->password,"dbname" => $config->dbname);    
      $host      = $dbinfo["host"];
      $username  = $dbinfo["user"];
      $password  = $dbinfo["pass"];
      $dbname    =  $dbinfo["dbname"]; 
      //print_r($dbinfo);
      $con = mysqli_connect($host, $username,$password,$dbname);
      if (mysqli_connect_errno()) {
         printf("Connect failed: %s\n", mysqli_connect_error());
         exit();
      }
      else {   
            $mobileno = $_POST['mobileno'];
            $custId = $_POST['custid'];
            $custName = $_POST['custName'];
            $alltr ='';
            $allspan ='';
            $query = "select * from patientintakeform where custid='".$custId."' and mobileno='".$mobileno."' ORDER BY date DESC";            
            $result   = mysqli_query($con, $query); 

          $totalTests =['weight','waist','bp_systolic','bp_diastolic','height','homa','hscrp','crp','esr','homocysteine','hba1c','fasting_glucose','ppsugar','insulin','cpeptide','cholesterol','triglycerides','ldl','hdl','bilirubin','sgpt','sgot','fattyliverultrasound','fattyliverfirbscan','fattyliverescore','creatinine','uricacid','sodium','urea','bun','potassium','vitamin_d','vitb12','iron','ferritin','zinc','magnesium','t3','t4','tsh','anti_tg','anti_tpo','age','gender','report_file'];

            while ($row = mysqli_fetch_assoc($result)) {
              for($t=0; $t<count($totalTests);$t++){
                $temprwo = $totalTests[$t];
                if($row[$temprwo]!=''){$allspan.="<span>".$temprwo."- ".$row[$temprwo]."</span>";} 
              }

              if($row['report_file']!=''){
                $pdf = $row['report_file']; 
                $pdf_file = "<a href=\"javascript:void(0)\" onclick=\"downloadPdf('$pdf')\" title=\"$pdf\">
                      <img style=\"width:22px; margin-right: 5px;\" src=\"".Mage::getBaseUrl()."skin/frontend/rwd/default/images/pdf-eng-download-icon.png\">
                      </a>";               
              }else{
                $pdf_file = "";
              }
           
               $alltr.='<tr>
                  <td>'.$row['date'].'</td>
                  <td>'.$allspan.'</td>
                  <td>'.$pdf_file.'</td>
                  <td>
                    <img style="width:30px; margin-right: 1px;" onclick="editForm(\''.$custId.'\',\''.$mobileno.'\',\''.$row['date'].'\',\''.$custName.'\')" src="'.Mage::getBaseUrl().'skin/frontend/rwd/default/images/edit_icon.png">
                  </td>
               </tr>'; 
               $allspan ='';
            }
            echo $alltr;
          } 
  }


/*================ END OF getpreviousreportAction ================*/

public function getalldatesAction()  {
     $config = Mage::getConfig()->getResourceConnectionConfig("default_setup");
     $dbinfo = array("host" => $config->host,"user" => $config->username,"pass" => $config->password,"dbname" => $config->dbname);    
      $host      = $dbinfo["host"];
      $username  = $dbinfo["user"];
      $password  = $dbinfo["pass"];
      $dbname    =  $dbinfo["dbname"];    
      $con = mysqli_connect($host, $username,$password,$dbname);
      if (mysqli_connect_errno()) {
         printf("Connect failed: %s\n", mysqli_connect_error());
         exit();
      }
      else {  
            $bloodTests =['hscrp','triglycerides','hdl','ldl','homocysteine','sgot','sgpt','bilirubin','creatinine','urea','sodium','potassium','uricacid','homa','hba1c','fasting_glucose'];  
            $mobileno = $_POST['mobileno'];
            $custId = $_POST['custid'];
            $alltr ='';          
            $query = "select * from patientintakeform where custid='".$custId."' and mobileno='".$mobileno."'";            
            $result   = mysqli_query($con, $query); 
            while ($row = mysqli_fetch_assoc($result)) {             
              if(($row['hscrp']!='')||($row['triglycerides']!='')||($row['hdl']!='')||($row['ldl']!='')||($row['homocysteine']!='')||($row['sgot']!='')||($row['sgpt']!='')||($row['bilirubin']!='')||($row['creatinine']!='')||($row['urea']!='')||($row['sodium']!='')||($row['potassium']!='')||($row['uricacid']!='')||($row['homa']!='')||($row['hba1c']!='')||($row['fasting_glucose']!='') ){
                    $alltr.='<li onclick="editScreen(\''.$custId.'\',\''.$mobileno.'\',\''.$row['date'].'\')">'.$row['date'].'</li>';
                }                               
            }
            
            echo $alltr;
          } 
  }


/*================ END OF getalldatesAction ================*/

public function editpreviousreportAction()  {
     $config = Mage::getConfig()->getResourceConnectionConfig("default_setup");
     $dbinfo = array("host" => $config->host,"user" => $config->username,"pass" => $config->password,"dbname" => $config->dbname);    
      $host      = $dbinfo["host"];
      $username  = $dbinfo["user"];
      $password  = $dbinfo["pass"];
      $dbname    =  $dbinfo["dbname"]; 
      //print_r($dbinfo);
      $con = mysqli_connect($host, $username,$password,$dbname);
      if (mysqli_connect_errno()) {
         printf("Connect failed: %s\n", mysqli_connect_error());
         exit();
      }
      else {   
            $mobileno = $_POST['mobileno'];
            $custId = $_POST['custid'];
            $cdate  = $_POST['cdate'];
            $alldata =[];         

          $totalTests =['weight','waist','bp_systolic','bp_diastolic','height','homa','hscrp','crp','esr','homocysteine','hba1c','fasting_glucose','ppsugar','insulin','cpeptide','cholesterol','triglycerides','ldl','hdl','bilirubin','sgpt','sgot','fattyliverultrasound','fattyliverfirbscan','fattyliverescore','creatinine','uricacid','sodium','urea','bun','potassium','vitamin_d','vitb12','iron','ferritin','zinc','magnesium','t3','t4','tsh','anti_tg','anti_tpo','age','gender'];

            $query = "select * from patientintakeform where custid='".$custId."' and mobileno='".$mobileno."' and date='".$cdate."'";            
            $result   = mysqli_query($con, $query); 
            while ($row = mysqli_fetch_assoc($result)) {
              for($z=0; $z<count($totalTests);$z++){
                $temprwo = $totalTests[$z];
                if($row[$temprwo]!=''){$allspan.="<span>".$temprwo."- ".$row[$temprwo]."</span>";}

                if($row[$temprwo]!=''){$alldata[$temprwo] = $row[$temprwo];} 
              }                             
            }
            $myJSON = json_encode($alldata);
            echo $myJSON;
          } 
  }

/*================ END OF editpreviousreportAction ================*/
public function sendAttachmentAction(){
    echo "page found";
  }
  
  
public function sendforgotemailAction()
    {
		  $email = $this->getRequest()->getParam('email');
		 
       	   if(isset($email) && $email!='') 
		  {      
				 
				 if( eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email) )
				  { 
					 ///////////////////////////////////////////////////////////////////
					   $websiteId = 1;
						$customer = Mage::getModel('customer/customer')
							->setWebsiteId($websiteId)
							->loadByEmail($email);
							
												
						if ($customer->getEntityId()) {
							
							
							$newResetPasswordLinkToken =  Mage::helper('customer')->generateResetPasswordLinkToken();
								$customer->changeResetPasswordLinkToken($newResetPasswordLinkToken);
								$customer->sendPasswordResetConfirmationEmail();
														
								echo "email sent";
						}
						else{ echo "Customer not exist.";}
			
				
        
					 ///////////////////////////////////////////////////////////////////
				  }
				  else
				  {
					  echo "Please enter the correct email id.";
				  }
				  
				 
		  } 
	}
	
	
	
	public function addzoholeadAction()
	{
		$name = $this->getRequest()->getParam('name');
		$email = $this->getRequest()->getParam('email');
		$Description = $this->getRequest()->getParam('message');
		
		$First_Name = "";
		$Last_Name =$name;
		$phone='';
		$lead_source = 'Contact Us Form';
		
		////////////////////////// Start Creating Zoho Lead ////////////////////
					
					$zoho_access_token = Mage::helper("heal")->generate_Zoho_access_token();
					$post_data = [
		               'data'=>[
					             [
								   
									  
									 "First_Name"        => $First_Name,
									 "Last_Name"         => $Last_Name,  
									 "Email"             => $email,    //mandatory
									  "Mobile"           => $phone, 
									 "Description"       => $Description,
									 "Company"           =>"Default Company",
									 "Lead_Source"        => $lead_source
									
									
									
								 ]
					           ],
		               
					  'trigger'=>[
					                "approval",
									"workflow",
									"blueprint"
								 ]
					];			 
		
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,"https://zohoapis.in/crm/v2/Leads");
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));

					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);  
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Authorization: Zoho-oauthtoken '.$zoho_access_token,
					'Content-type: application/x-www-form-urlencoded')
					);

					$response = curl_exec($ch);
					$response = json_decode($response);
					echo "Thank you <b>".ucfirst($name)."</b> we will contact you soon";
					
					///////////////////////// End Creating Zoho Lead ///////////////////////
	}
	
	
	public function addnewslettertozoholeadAction()
	{
		
		$email = $this->getRequest()->getParam('email');
		$Description = '';
		
		$First_Name = "Newsletter";
		$Last_Name ='Sign Up';
		$phone='';
		$lead_source = 'WebSite Visit';
		
		
		
       		  if ( isset($email) && $email!='') 
		  {      
				 
				 if( eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email) )
				  { 
					 ////////////////////////// Start Creating Zoho Lead ////////////////////
					
					$zoho_access_token = Mage::helper("heal")->generate_Zoho_access_token();
					$post_data = [
		               'data'=>[
					             [
								   
									  
									 "First_Name"        => $First_Name,
									 "Last_Name"         => $Last_Name,  
									 "Email"             => $email,    //mandatory
									  "Mobile"           => $phone, 
									 "Description"       => $Description,
									 "Company"           =>"Default Company",
									 "Lead_Source"        => $lead_source
									
									
									
								 ]
					           ],
		               
					  'trigger'=>[
					                "approval",
									"workflow",
									"blueprint"
								 ]
					];			 
		
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,"https://zohoapis.in/crm/v2/Leads");
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));

					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);  
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Authorization: Zoho-oauthtoken '.$zoho_access_token,
					'Content-type: application/x-www-form-urlencoded')
					);

					$response = curl_exec($ch);
					$response = json_decode($response);
					echo "Thank you <b>".ucfirst($name)."</b> we will contact you soon";
					
					///////////////////////// End Creating Zoho Lead ///////////////////////
				  }
				  else
				  {
					  echo "Please enter the correct email id.";
				  }
		  }
		  else
				  {
					  echo "Please enter the correct email id.";
				  }
	  
		
		
		
		
		
		
		
		
	}



}
