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
         $customers  = Mage::getResourceModel('customer/customer_collection')
             ->addAttributeToSelect('*')
             ->addAttributeToFilter('primarymobileno', $phone);

         if(count($customers)>0){ 
         $message = 'Dear+Customer,+'.$otp.'+is+your+OTP+to+authenticate+your+login';
         $varSMSURL = "http://msg160.com/sendsms/send1?userid=lifeheal&pass=lifeheal2019&sender=LIFEHL&mobile=".$phone."&message=".$message."&route=5";

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
          $reditts = $params['reditts'];
           $customers  = Mage::getResourceModel('customer/customer_collection')
             ->addAttributeToSelect('*')
             ->addAttributeToFilter('primarymobileno', $phone);

            if(count($customers)>0){
                foreach($customers as $tmpCustomer) {
                    $email= $tmpCustomer->getEmail();
                }
            }

            if($email){
              $logincustomer = Mage::getModel("customer/customer");
              $logincustomer->setWebsiteId(Mage::app()->getWebsite()->getId());
              // Load our customer by email
              $logincustomer->loadByEmail($email);
              // Load the session up
              $sess = Mage::getSingleton("customer/session");
              // Login by ID
              $sess->loginById($logincustomer->getId());
              // Set the customer as logged in
              $sess->setCustomerAsLoggedIn($logincustomer);
              if($reditts =='reditts'){
                $this->_redirectReferer();
              }
            }
        }  
        
        
        public function getcustomerfavitemsAction()
        {
             $custID    = Mage::app()->getRequest()->getParam('custid');  //echo '<br>';
             
             $comboLI='';
             $soupLI='';
             $saladLI='';
                
			$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
                        
$sqlDistinctCombo = "SELECT  distinct combo_id FROM  customerfavourite where custid='".$custID."' and combo_id!='NULL' and product_is_combo_child='yes'";
$favComboCollection = $connection->fetchAll($sqlDistinctCombo);
 
 
 if(sizeof($favComboCollection) >0)
 {
           foreach($favComboCollection as $value)
           {
              $comboItemnameArray = array();
              $comboId = $value['combo_id']; 
              $bundled_product = Mage::getModel("catalog/product")->load($comboId);
               $comboName='';
              /////////////////////
                $sqlComboItems = "SELECT combo_name,productname,combo_option_id,combo_selection_id,product_is_combo_child  from customerfavourite  where combo_id='".$comboId."'"; //die;
                $favComboItemCollection = $connection->fetchAll($sqlComboItems);
               // print_r($favComboItemCollection); //die;
                if(sizeof($favComboItemCollection) >0)
                 {
                           foreach($favComboItemCollection as $value)
                           {

                              $comboName          =     $value['combo_name']; 
                             // $comboOptionId      = $value['combo_option_id'];
                             // $combo_selection_id = $value['combo_selection_id'];
                             $comboItemnameArray[]      =  $value['productname'];
                              
                              
                              
                           }
                           
                           $comboItemnameArray[] = $comboName;
                           
                          
                 }
              ////////////////////  end of combocollection loop/////////////
              //    print_r($comboItemnameArray); die;
                   
			   
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
				</div>
			</div>
			<div class="sc-hmzhuo cCbxqa">
				<div class="itm-nm-dsc ">
					<span class="itm-dsc__nm">'.$comboItemnameArray[3].'</span>					
						<span class="itm-dsc__dscrptn" title="Mushroom Soup &amp; Salad (Combo)">'.$bundled_product->getShortDescription().'</span>
				</div>';                  
                                if(sizeof($comboItemnameArray)>0)
                                {
                                     for($i=0;$i< sizeof($comboItemnameArray)-1;$i++)
                                     {
				$comboLI.='<div class="itm-dsc__actn">
                         <div class="itm-dsc__actn__crst" data-label="selectCrust"  style="width:100%;">
						<div>
							<div class="injectStyles-sc-1jy9bcf-0 dVfvkq">
								<div class="nm-icn">
									<div datalabel="crust" class="itm-dsc__actn__sz__dd-ttl" >'.$comboItemnameArray[$i].'</div>
								</div>							
								<div class="dd-wrpr" ></div>
							</div>
						</div>
						<div class="sz-ln drp-dwn-crst-hr"></div>
				    </div>
				</div>';
                 }	
               }
				$comboLI.='</div>
				</div>
			</div>
		</div>
            </li>';
                   
                   
                 //  die;
             
           }
 } 
else
{
    $comboLI.='There is no subscribed combo item.';
}
 
 
$sqlSoup = "SELECT  *  FROM  customerfavourite where  custid='".$custID."' and product_is_combo_child='no' and productname like '%soup%'";
$favSoupCollection = $connection->fetchAll($sqlSoup);
 
 
 if(sizeof($favSoupCollection) >0)
 {
           foreach($favSoupCollection as $value)
           {
                $soup_product = Mage::getModel("catalog/product")->load($value['productid']);
                 
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

                                        </div>
                                </div>
                                <div class="sc-hmzhuo cCbxqa">
                                        <div class="itm-nm-dsc ">
                                                <span class="itm-dsc__nm">'. $soup_product->getName().'</span>

                                                        <span class="itm-dsc__dscrptn" title="'. $soup_product->getName().'">'. $soup_product->getShortDescription().'</span>
                                        </div>
                                 </div>
                        </div>
		  </div>
		</div>
	
            </li>';    
               
           }
  }
  else
{
    $soupLI.='There is no subscribed soup item.';
}
  
  
  
  $sqlSalad = "SELECT  *  FROM  customerfavourite where custid='".$custID."' and product_is_combo_child='no' and productname like '%salad%'";
$favSaladCollection = $connection->fetchAll($sqlSalad);
 
 
 if(sizeof($favSaladCollection) >0)
 {
           foreach($favSaladCollection as $value)
           {
                $salad_product = Mage::getModel("catalog/product")->load($value['productid']);
                   
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

                                        </div>
                                </div>
                                <div class="sc-hmzhuo cCbxqa">
                                        <div class="itm-nm-dsc ">
                                                <span class="itm-dsc__nm">'. $salad_product->getName().'</span>

                                                        <span class="itm-dsc__dscrptn" title="'. $salad_product->getName().'">'. $salad_product->getShortDescription().'</span>
                                        </div>
                                 </div>
                        </div>
		  </div>
		</div>
	
            </li>';    
               
           }
  }
  else
  {
      $saladLI.='There is no subscribed salad item';
  }
  
  
   echo '<div class="catalog__list">
                            <h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;">Soup</h3>
                              <ul class="products-grid products-grid--max-3-col">'. $soupLI.'</ul>
			    <h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;">Salad</h3>
                              <ul class="products-grid products-grid--max-3-col">'.$saladLI.'</ul>
			   <h3 style="font-weight: 600;color: #000;width: 100%;float: left;border-bottom: 2px solid #000;padding-bottom: 10px;">Combos</h3>
                             <ul class="products-grid products-grid--max-3-col">'.$comboLI.'</ul>
                        </div>';
                        
                        
  
  
        }

}
