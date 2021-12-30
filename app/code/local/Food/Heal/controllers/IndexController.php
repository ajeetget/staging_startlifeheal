<?php
class Food_Heal_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
		
if(!Mage::getSingleton('customer/session')->isLoggedIn() ) 
{
	 $this->_redirect('customer/account/login');					
	
}
else {
	$groupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
	if($groupId!=5)
	{ $this->_redirect('customer/account/login'); }	
	
}	
		
		
 
		
		
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Dietician"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("heal", array(
                "label" => $this->__("Dietician"),
                "title" => $this->__("Dietician")
		   ));

      $this->renderLayout(); 
	  
    }

	
	 public function printAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Print"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("Home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("print", array(
                "label" => $this->__("Print"),
                "title" => $this->__("Print")
		   ));

      $this->renderLayout(); 
	  
    }
	
public function printallAction() {
     
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Print"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("Home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("printall", array(
                "label" => $this->__("Print"),
                "title" => $this->__("Print")
		   ));

      $this->renderLayout(); 
	   
    }
    
    
     public function customermealsAction()
        {
     
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Customer Meals"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
              $breadcrumbs->addCrumb("Home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("customermeals", array(
                "label" => $this->__("Customer Meals"),
                "title" => $this->__("Customer Meals")
		   ));

      $this->renderLayout(); 
	   
    }
    
    public function customerallmealsAction()
        {
     
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Customer All Meals"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
              $breadcrumbs->addCrumb("Home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("customerallmeals", array(
                "label" => $this->__("Customer All Meals"),
                "title" => $this->__("Customer All Meals")
		   ));

      $this->renderLayout(); 
	   
    }
	
	public function qtydetailsAction() {
      

	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Order Quantity Details"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("Home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("print", array(
                "label" => $this->__("Qty Details"),
                "title" => $this->__("Qty Details")
		   ));

      $this->renderLayout(); 
	  
    }
	
	public function creportAction() {
      

	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Customer Reports"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("Home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("print", array(
                "label" => $this->__("Customer Order Report"),
                "title" => $this->__("Customer Order Report")
		   ));

      $this->renderLayout(); 
	  
    }
	
	
	public function datewiseorderqtydetailsAction()
	{
			
		$params      = $this->getRequest()->getParams(); 
		$orderdate   = $params['orderDate'];
		$city        = $params['city'];
		$dateInfo = explode("/",$orderdate);
		
		 $tmpOrderdateToShow = $dateInfo[2]."-".$dateInfo[0]."-".$dateInfo[1];	
		 $month = date("M",strtotime($tmpOrderdateToShow));
		 $orderdateToShow = $dateInfo[1]."-".$month."-".$dateInfo[2];
		
		$dbRead      = Mage::getSingleton('core/resource')->getConnection('core_read');
		$selectDatewiseOrders= "select * from healorder where city='".ucfirst($city)."' and orderdate='$orderdate'"; echo"<br>";
		$cuisineResult = $dbRead->fetchAll($selectDatewiseOrders);
		$orderResult = '';
		$result = '';
		$countOrder =0; 
		if(count($cuisineResult)>0)
		{
			$cuisineItemsDesc = array();
			
			$dinnerOrderItemsArray 		= array();
			$breakfastOrderItemsArray   = array();
			$lunchOrderItemsArray       = array();
			$highteaOrderItemsArray     = array();
			
			
			foreach($cuisineResult as $row)
			{
			  $orderId               =  $row['id'];	
			  $dinner_items_desc     = 	$row['dinner_items_desc'];   
				                        $cuisineItemsDesc[$countOrder]['dinner'] = $dinner_items_desc;
			  $breakfast_items_desc  = 	$row['breakfast_items_desc'];
				                        $cuisineItemsDesc[$countOrder]['breakfast'] = $breakfast_items_desc;
			  $lunch_items_desc      = 	$row['lunch_items_desc'];   
				                        $cuisineItemsDesc[$countOrder]['lunch'] = $lunch_items_desc;
			  $hightea_items_desc    = 	$row['hightea_items_desc'];	 
				                        $cuisineItemsDesc[$countOrder]['hightea'] = $hightea_items_desc;
             
				
			  foreach($cuisineItemsDesc[$countOrder] as $cuisine=>$itemDesc)
			  {
				 $orderItemsArray = array();
				 $cuisineDescItems = explode(",",$itemDesc);
				  
				 if(count($cuisineDescItems)>0)
				 {	 
				   foreach($cuisineDescItems as $singleItem)
					{
					  $singleItemInfo = explode("_",$singleItem);
					   //print_r($singleItemInfo);
					  $productid = $singleItemInfo[1]; 

					  $QgetOrderItemsDetails = "select * from  healitemdetails where orderid='$orderId' and cuisine='$cuisine' and productid='$productid'" ;
					 //echo"<br>";
					 $orderItems = $dbRead->fetchAll($QgetOrderItemsDetails) ;
					  if(count($orderItems) >0)
					 {
                          $countQtyOfCuisineItem =0; 
						  foreach($orderItems as $orderdetailitem)
						  {
							  
							  $itemId   =  trim($orderdetailitem['productid']);
							  $qty      =  trim($orderdetailitem['qty']);
							//  ++$countQtyOfCuisineItem;
							  $productIdValue = array();
							  
							  if($cuisine=='dinner')
							  {     
								    
									if(!array_key_exists($itemId,$dinnerOrderItemsArray) ) 
									{
									   
									   $dinnerOrderItemsArray[$itemId][$qty] = 1;
									}
									else 
									{
										if(array_key_exists($qty,$dinnerOrderItemsArray[$itemId]) )
										{
											$alreadyCountedQty                     = $dinnerOrderItemsArray[$itemId][$qty];
										    $newQtyCount                           = $alreadyCountedQty + 1;
										    $dinnerOrderItemsArray[$itemId][$qty]  = $newQtyCount;
										}
										else
										{
										  $dinnerOrderItemsArray[$itemId][$qty] = 1;
										}
										

									}
							  }
							  
							
							 if($cuisine=='breakfast')
							  {
									if(!array_key_exists($itemId,$breakfastOrderItemsArray) ) 
									{
									   
									   $breakfastOrderItemsArray[$itemId][$qty] = 1;
									}
									else 
									{
										if(array_key_exists($qty,$breakfastOrderItemsArray[$itemId]) )
										{
										    $alreadyCountedQty       = $breakfastOrderItemsArray[$itemId][$qty];
										    $newQtyCount         = $alreadyCountedQty + 1;
										    $breakfastOrderItemsArray[$itemId][$qty]  = $newQtyCount;
										}
										else
										{
										  $breakfastOrderItemsArray[$itemId][$qty] = 1;
										}
										

									}
							  }
							  
							  if($cuisine=='lunch')
							  {
									if(!array_key_exists($itemId,$lunchOrderItemsArray) ) 
									{
									   
									   $lunchOrderItemsArray[$itemId][$qty] = 1;
									}
									else 
									{
										if(array_key_exists($qty,$lunchOrderItemsArray[$itemId]) )
										{
										    $alreadyCountedQty                    = $lunchOrderItemsArray[$itemId][$qty];
										    $newQtyCount                          = $alreadyCountedQty + 1;
										    $lunchOrderItemsArray[$itemId][$qty]  = $newQtyCount;
										}
										else
										{
										   $lunchOrderItemsArray[$itemId][$qty] = 1;
										}
										

									}
							  }
							  
							  if($cuisine=='hightea')
							  {
									if(!array_key_exists($itemId,$highteaOrderItemsArray) ) 
									{
									   
									   $highteaOrderItemsArray[$itemId][$qty] = 1;
									}
									else 
									{
										if(array_key_exists($qty,$highteaOrderItemsArray[$itemId]) )
										{
										    $alreadyCountedQty                    = $highteaOrderItemsArray[$itemId][$qty];
										    $newQtyCount                          = $alreadyCountedQty + 1;
										    $highteaOrderItemsArray[$itemId][$qty]  = $newQtyCount;
										}
										else
										{
										   $highteaOrderItemsArray[$itemId][$qty] = 1;
										}
										

									}
							  }
							  
							 

						  }
						  

					 }
					 //die; 
				  }
			    }
				
			  }
			   
			} 
			
			//echo "count =".count($dinnerOrderItemsArray); echo "<br>";"<pre>"; print_r($dinnerOrderItemsArray);  die;
			
			  $result.='<table cellpadding="2" cellspacing="2" border="1">';
			  $result.='<tr rowspan="2"><td colspan="4" style="text-align:center"><strong>City: '.ucfirst($city).'</strong>, <strong>Order Date: '.$orderdateToShow.'</strong></td></tr>';
			  $result.='<td><strong>Breakfast</strong></td><td><strong>Lunch</strong></td><td><strong>Hi Tea</strong></td><td><strong>Dinner</strong></td>';
			
			
			  $dinnerTD ='';
			  if(count($dinnerOrderItemsArray)>0)
			  {
				   $dinnerTD.='<table cellpadding="1" cellspacing="1" border="1">';
				   $dinnerTD.='<tr><td><strong>Item</strong></td><td><strong>Qty (gm)</strong></td><td><strong>No</strong></td></tr>';
				   foreach($dinnerOrderItemsArray as $productId =>$qtyCountArray)
				   {
					     $product = Mage::getModel('catalog/product')->load($productId);
						 foreach($qtyCountArray as $qty=>$itemcount)
						 {
							if($qty >0)
							{	
							  $dinnerTD.='<tr><td>'.$product->getName().'</td><td>'.$qty.'</td><td>'.$itemcount.'</td></tr>';
							}
						 }
						 	
					
				   }
				   $dinnerTD.='</table>';		 
			   }
			   
			 
			
			  $breakfastTD ='';
			  if(count($breakfastOrderItemsArray)>0)
			  {
				   $breakfastTD.='<table cellpadding="1" cellspacing="1" border="1">';
				   $breakfastTD.='<tr><td><strong>Item</strong></td><td><strong>Qty (gm)</strong></td><td><strong>No</strong></td></tr>';
				   foreach($breakfastOrderItemsArray as $productId =>$qtyCountArray)
				   {
					     $product = Mage::getModel('catalog/product')->load($productId);
						 foreach($qtyCountArray as $qty=>$itemcount)
						 {
                            if($qty >0)
							{
							 $breakfastTD.='<tr><td>'.$product->getName().'</td><td>'.$qty.'</td><td>'.$itemcount.'</td></tr>';
							}
						 }	
					
				   }
				   $breakfastTD.='</table>';	
			 }
			
			
			 $lunchTD ='';
			 if(count($lunchOrderItemsArray)>0)
			  {
				   $lunchTD.='<table cellpadding="1" cellspacing="1" border="1">';
				   $lunchTD.='<tr><td><strong>Item</strong></td><td><strong>Qty (gm)</strong></td><td><strong>No</strong></td></tr>';
				   foreach($lunchOrderItemsArray as $productId =>$qtyCountArray)
				   {
					     $product = Mage::getModel('catalog/product')->load($productId);
						 foreach($qtyCountArray as $qty=>$itemcount)
						 {
							if($qty >0)
							{
							 $lunchTD.='<tr><td>'.$product->getName().'</td><td>'.$qty.'</td><td>'.$itemcount.'</td></tr>';
							}
						 }	
					
				   }
				   $lunchTD.='</table>';	
			 }
			
			 
			 $highteaTD ='';
			 if(count($highteaOrderItemsArray)>0)
			  {
				   $highteaTD.='<table cellpadding="1" cellspacing="1" border="1">';
				  $highteaTD.='<tr><td><strong>Item</strong></td><td><strong>Qty (gm)</strong></td><td><strong>No</strong></td></tr>';
				   foreach($highteaOrderItemsArray as $productId =>$qtyCountArray)
				   {
					     $product = Mage::getModel('catalog/product')->load($productId);
						 foreach($qtyCountArray as $qty=>$itemcount)
						 {
							if($qty >0)
							{
							 $highteaTD.='<tr><td>'.$product->getName().'</td><td>'.$qty.'</td><td>'.$itemcount.'</td></tr>';
							}
						 }
					
				   }
				   $highteaTD.='</table>';
			 }
			
			 $result.='<tr><td valign="top">'.$breakfastTD.'</td><td  valign="top">'.$lunchTD.'</td><td  valign="top">'.$highteaTD.'</td><td  valign="top">'.$dinnerTD.'</td></tr>';
			$result.='<tr rowspan="5" class="noprint"><td colspan="4"><input type="button" name="print" class="printbtnid" value="print" onclick="print();" /></td></tr>';
			$result.='</table>';
			$countOrder++;
			 echo $result;
		}
			
		
		else
		{
		   $result='There is no order on '.$orderdate;
		   echo $result;
		}
	
	}

	public function datewiseorderqtyAction()
	{
		$params      = $this->getRequest()->getParams(); 
		$orderdate   = $params['orderDate'];
		$city        = $params['city'];
		$dateInfo = explode("/",$orderdate);
		
		$tmpOrderdateToShow = $dateInfo[2]."-".$dateInfo[0]."-".$dateInfo[1];	
		 $month = date("M",strtotime($tmpOrderdateToShow));
		 $orderdateToShow = $dateInfo[1]."-".$month."-".$dateInfo[2];
		
		
		$dbRead      = Mage::getSingleton('core/resource')->getConnection('core_read');
		$selectDatewiseOrders= "select * from healorder where city='".ucfirst($city)."' and orderdate='$orderdate'"; 
		$cuisineResult = $dbRead->fetchAll($selectDatewiseOrders);
		$orderResult = '';
		$result = '';
		$orderItemsArray = array();
		$dinnerItemsArray = array();
		$breakfastItemsArray = array();
		$linchItemsArray = array();
		$highteaItemsArray = array();
		
		$orderedByArray = array();
		if(count($cuisineResult)>0)
		{
			$cuisineItemsDesc = array();
			
			foreach($cuisineResult as $row)
			{
			  $orderId               =  $row['id'];	
			  $dinner_items_desc     = 	$row['dinner_items_desc'];    $cuisineItemsDesc['dinner'] = $dinner_items_desc;
			  $breakfast_items_desc  = 	$row['breakfast_items_desc']; $cuisineItemsDesc['breakfast'] = $breakfast_items_desc;
			  $lunch_items_desc      = 	$row['lunch_items_desc'];     $cuisineItemsDesc['lunch'] = $lunch_items_desc;
			  $hightea_items_desc    = 	$row['hightea_items_desc'];	  $cuisineItemsDesc['hightea'] = $hightea_items_desc;

			   $customerEmail = $row['email']; 
      
	          $customer='';
			  $customer = Mage::getModel("customer/customer"); 
			  $customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
			  $customer->loadByEmail($customerEmail);
			  $customerName = 	$customer->getFirstname();
				
			  foreach($cuisineItemsDesc as $cuisine=>$itemDesc)
			  {
				 
				 $cuisineDescItems = explode(",",$itemDesc);
				  
				 if(count($cuisineDescItems)>0)
				 {	 
				   foreach($cuisineDescItems as $singleItem)
					{
					  $singleItemInfo = explode("_",$singleItem);
					  
					  $productid = $singleItemInfo[1]; 

					  $QgetOrderItemsDetails = "select * from  healitemdetails where orderid='$orderId' and cuisine='$cuisine' and productid='$productid'" ; 
					  
					 $orderItems='';
					 $orderItems = $dbRead->fetchAll($QgetOrderItemsDetails) ;
					  if(count($orderItems) >0)
					 {
                         
						  foreach($orderItems as $orderdetailitem)
						  {
							  $healitemProductid =  trim($orderdetailitem['productid']);
							  $qty               =  trim($orderdetailitem['qty']);
							  
							  if($cuisine=='dinner')
							  {
								   if(!array_key_exists($healitemProductid,$dinnerItemsArray) )
									{
									   $dinnerItemsArray[$healitemProductid] = $qty;
									}
									else 
									{    $itemAlreadyInArrayQty=0;
										 $itemAlreadyInArrayQty = $dinnerItemsArray[$healitemProductid];
										 $newQty = $itemAlreadyInArrayQty + $orderdetailitem['qty'];
										 $dinnerItemsArray[$healitemProductid] = $newQty;

									}
							  }
							  if($cuisine=='breakfast')
							  {
								   if(!array_key_exists($healitemProductid,$breakfastItemsArray) )
									{
									   $breakfastItemsArray[$healitemProductid] = $qty;
									}
									else 
									{    $itemAlreadyInArrayQty=0;
										 $itemAlreadyInArrayQty = $breakfastItemsArray[$healitemProductid];
										 $newQty = $itemAlreadyInArrayQty + $orderdetailitem['qty'];
										 $breakfastItemsArray[$healitemProductid] = $newQty;

									}
							  }
							  
							  if($cuisine=='lunch')
							  {
								   if(!array_key_exists($healitemProductid,$lunchItemsArray) )
									{
									   $lunchItemsArray[$healitemProductid] = $qty;
									}
									else 
									{    $itemAlreadyInArrayQty=0;
										 $itemAlreadyInArrayQty = $lunchItemsArray[$healitemProductid];
										 $newQty = $itemAlreadyInArrayQty + $orderdetailitem['qty'];
										 $lunchItemsArray[$healitemProductid] = $newQty;

									}
							  }
							  
							  if($cuisine=='hightea')
							  {
								   if(!array_key_exists($healitemProductid,$highteaItemsArray) )
									{
									   $highteaItemsArray[$healitemProductid] = $qty;
									}
									else 
									{    $itemAlreadyInArrayQty=0;
										 $itemAlreadyInArrayQty = $highteaItemsArray[$healitemProductid];
										 $newQty = $itemAlreadyInArrayQty + $orderdetailitem['qty'];
										 $highteaItemsArray[$healitemProductid] = $newQty;

									}
							  }

						  }

					 }
					 
				  }
			    }
			  }
			
			}
			
			$countOrderItems=0; 
			$result.='<div><strong>City: '.ucfirst($city).', Order Date: '.$orderdateToShow.'</strong></div>';
			$result.='<div><span style="width:auto;float: none;height: 35px;font-weight:bold;line-height: 35px;margin:20px auto;text-align:center;">ADVANCE MENU : FOR ORDERING SUPPLIES ONLY</span>
    <tr></div>';			
			
			if(count($breakfastItemsArray)>0)
			{
			  $result.='<table cellpadding="2" cellspacing="2" >';
			  $result.='<td><strong>No</strong></td><td colspan="10"><strong>Breakfast Items</strong></td><td><strong>Qty(gm)</strong></td></tr>';	
			 $count=0;
				
			  foreach($breakfastItemsArray as $productid =>$qty)
			  {
				$count++;  
				$customerInfo='';  
				
				$countOrderItems++;  
				$cuisineCount ="breakfast_".$count  ;
				$product = Mage::getModel('catalog/product')->load($productid);
				$result.='<tr><td  valign="top"><a href="javascript:void(0)" onClick="javascript:showdiv(\''.$orderdate.'\',\''.$productid.'\',\'breakfast\',\''.$cuisineCount.'\')" ><strong>'.$count.'</strong></a>';
				$result.='<div style="display:none" class="'.$cuisineCount.'">'.$customerInfo.'</div>';
				$result.='</td><td  valign="top" colspan="10">'.$product->getName().'</td><td  valign="top">'.$qty.'</td></tr>'; 
			  }
			  $result.='</table>';		
			}
			
			if(count($lunchItemsArray)>0)
			{
			 $result.='<table cellpadding="2" cellspacing="2" >';
			  
			  $result.='<td><strong>No</strong></td><td colspan="10"><strong>Lunch Items</strong></td><td><strong>Qty(gm)</strong></td></tr>';		
			  $count=0;
			  foreach($lunchItemsArray as $productid =>$qty)
			  {
				$count++;  
				$customerInfo='';  
				
				$countOrderItems++;  
				$cuisineCount ="lunch_".$count  ;
				$product = Mage::getModel('catalog/product')->load($productid);
				$result.='<tr><td  valign="top"><a href="javascript:void(0)" onClick="javascript:showdiv(\''.$orderdate.'\',\''.$productid.'\',\'lunch\',\''.$cuisineCount.'\')" ><strong>'.$count.'</strong></a>';
				$result.='<div style="display:none" class="'.$cuisineCount.'">'.$customerInfo.'</div>';
				$result.='</td><td  valign="top" colspan="10">'.$product->getName().'</td><td  valign="top">'.$qty.'</td></tr>';  
			  }
			  $result.='</table>';
			}
			
			if(count($highteaItemsArray)>0)
			{
			  $result.='<table cellpadding="2" cellspacing="2" >';
			  $result.='<td><strong>No</strong></td><td colspan="10"><strong>Hi Tea Items</strong></td><td><strong>Qty(gm)</strong></td></tr>';	
			  $count=0;
			  $countOrderItems++;	
			  foreach($highteaItemsArray as $productid =>$qty)
			  {
				$count++;  
				$customerInfo='';  
				
				$countOrderItems++;  
				$cuisineCount ="hightea_".$count  ;
				$product = Mage::getModel('catalog/product')->load($productid);
				$result.='<tr><td  valign="top"><a href="javascript:void(0)" onClick="javascript:showdiv(\''.$orderdate.'\',\''.$productid.'\',\'hightea\',\''.$cuisineCount.'\')" ><strong>'.$count.'</strong></a>';
				$result.='<div style="display:none" class="'.$cuisineCount.'">'.$customerInfo.'</div>';
				$result.='</td><td  valign="top" colspan="10">'.$product->getName().'</td><td  valign="top">'.$qty.'</td></tr>';  
			  }	
			  $result.='</table>';	
			}
			
			if(count($dinnerItemsArray)>0)
			{
			  $result.='<table cellpadding="2" cellspacing="2" >';
			  $result.='<td><strong>No</strong></td><td colspan="10"><strong>Dinner Items</strong></td><td><strong>Qty(gm)</strong></td></tr>';	
			  $count=0;
			  
			  foreach($dinnerItemsArray as $productid =>$qty)
			  {
				$count++;  
				$customerInfo='';  
				
				$countOrderItems++;  
				$cuisineCount ="dinner_".$count  ;
				$product = Mage::getModel('catalog/product')->load($productid);
				$result.='<tr><td valign="top"><a href="javascript:void(0)" onClick="javascript:showdiv(\''.$orderdate.'\',\''.$productid.'\',\'dinner\',\''.$cuisineCount.'\')" ><strong>'.$count.'</strong></a>';
				$result.='<div style="display:none" class="'.$cuisineCount.'">'.$customerInfo.'</div>';
				$result.='</td><td  valign="top" colspan="10">'.$product->getName().'</td><td  valign="top">'.$qty.'</td></tr>'; 
				  
				
				  
			  }
			  $result.='</table>';	
			}
			
			if($countOrderItems>0)
			{	
			$result.='<table cellpadding="2" cellspacing="2" ><tr class="noprint"><td style="margin: auto;float: none;width: 100%;"><input type="button" name="print" value="print" onclick="print();" class="printbtnid" /></td></tr></table>';
		    }
			else
			{
			$result.='<table cellpadding="2" cellspacing="2" ><tr class="noprint"><td >There is no order data</td></tr></table>';
			}
				
			echo $result;	
			 
			
			
		}
		else
		{
		   $result='There is no order on '.$orderdate;
		   echo $result;
		}
	}

	public function qtyorderwisedetailAction()
	{
	  $params      = $this->getRequest()->getParams(); 
	  $orderdate   = $params['orderdate'];
	  $entityIdArg    = $params['productid'];
	  $cuisineArg	   = $params['cuisine'];
		
	//echo"<pre>";	print_r($params );
		$dbRead      = Mage::getSingleton('core/resource')->getConnection('core_read');
		$selectDatewiseOrders= "select * from healorder where orderdate='$orderdate'"; 
		$cuisineResult = $dbRead->fetchAll($selectDatewiseOrders);
		
		$orderItemsArray = array();
		$dinnerItemsArray = array();
		$breakfastItemsArray = array();
		$linchItemsArray = array();
		$highteaItemsArray = array();
		
		if(count($cuisineResult)>0)
		{
			$cuisineItemsDesc = array();
			
			foreach($cuisineResult as $row)
			{
			  $orderId               =  $row['id'];	
			  $dinner_items_desc     = 	$row['dinner_items_desc'];    $cuisineItemsDesc['dinner'] = $dinner_items_desc;
			  $breakfast_items_desc  = 	$row['breakfast_items_desc']; $cuisineItemsDesc['breakfast'] = $breakfast_items_desc;
			  $lunch_items_desc      = 	$row['lunch_items_desc'];     $cuisineItemsDesc['lunch'] = $lunch_items_desc;
			  $hightea_items_desc    = 	$row['hightea_items_desc'];	  $cuisineItemsDesc['hightea'] = $hightea_items_desc;

			  
				
			  $customerEmail = $row['email']; 
			  $customer='';
			  $customer = Mage::getModel("customer/customer"); 
			  $customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
			  $customer->loadByEmail($customerEmail);
			  $customerName = 	$customer->getFirstname()." ".$customer->getLastname();	
				
			   foreach($cuisineItemsDesc as $cuisine=>$itemDesc)
			  {
				 
				 $cuisineDescItems = explode(",",$itemDesc);
				  
				 if(count($cuisineDescItems)>0)
				 {	 
				   foreach($cuisineDescItems as $singleItem)
					{
					  $singleItemInfo = explode("_",$singleItem);
					  
					  $productid = $singleItemInfo[1]; 

					 $QgetOrderItemsDetails = "select * from  healitemdetails where orderid='$orderId' and cuisine='$cuisine' and productid='$productid'" ; 
					  
					 $orderItems='';
					 $orderItems = $dbRead->fetchAll($QgetOrderItemsDetails) ;
					  if(count($orderItems) >0)
					 {
                         
						  foreach($orderItems as $orderdetailitem)
						  {
							  $healitemProductid =  trim($orderdetailitem['productid']);
							  $qty               =  trim($orderdetailitem['qty']);
							  
							  if($cuisine=='dinner' && $healitemProductid==$entityIdArg)
							  {
								   if(!array_key_exists($healitemProductid,$dinnerItemsArray[$orderId]) )
									{
									   $dinnerItemsArray[$orderId][$healitemProductid] = $qty;
									   $dinnerItemsArray[$orderId]['customerName'] = $customerName;
									  
									}
									else 
									{    $itemAlreadyInArrayQty=0;
										 $itemAlreadyInArrayQty = $dinnerItemsArray[$orderId][$healitemProductid];
										 $newQty = $itemAlreadyInArrayQty + $orderdetailitem['qty'];
										 $dinnerItemsArray[$orderId][$healitemProductid] = $newQty;

									}
							  }
							  if($cuisine=='breakfast' && $healitemProductid==$entityIdArg)
							  {
								   if(!array_key_exists($healitemProductid,$breakfastItemsArray[$orderId]) )
									{
									   $breakfastItemsArray[$orderId][$healitemProductid] = $qty;
									   $breakfastItemsArray[$orderId]['customerName'] = $customerName;
									  
									}
									else 
									{    $itemAlreadyInArrayQty=0;
										 $itemAlreadyInArrayQty = $breakfastItemsArray[$orderId][$healitemProductid];
										 $newQty = $itemAlreadyInArrayQty + $orderdetailitem['qty'];
										 $breakfastItemsArray[$orderId][$healitemProductid] = $newQty;

									}
							  }
							  
							  if($cuisine=='lunch' && $healitemProductid==$entityIdArg)
							  {
								   if(!array_key_exists($healitemProductid,$lunchItemsArray[$orderId]) )
									{
									   $lunchItemsArray[$orderId][$healitemProductid] = $qty;
									   $lunchItemsArray[$orderId]['customerName'] = $customerName;
									  
									}
									else 
									{    $itemAlreadyInArrayQty=0;
										 $itemAlreadyInArrayQty = $lunchItemsArray[$orderId][$healitemProductid];
										 $newQty = $itemAlreadyInArrayQty + $orderdetailitem['qty'];
										 $lunchItemsArray[$orderId][$healitemProductid] = $newQty;

									}
							  }
							  
							  if($cuisine=='hightea'&& $healitemProductid==$entityIdArg)
							  {
								   if(!array_key_exists($healitemProductid,$highteaItemsArray[$orderId]) )
									{
									   $highteaItemsArray[$orderId][$healitemProductid] = $qty;
									   $highteaItemsArray[$orderId]['customerName'] = $customerName;
									  
									}
									else 
									{    $itemAlreadyInArrayQty=0;
										 $itemAlreadyInArrayQty = $highteaItemsArray[$orderId][$healitemProductid];
										 $newQty = $itemAlreadyInArrayQty + $orderdetailitem['qty'];
										 $highteaItemsArray[$orderId][$healitemProductid] = $newQty;

									}
							  }

						  }

					 }
					 
				  }
			    }
			  }	
			  	
			}
			
			
		}
		//echo "<pre>"; print_r($dinnerItemsArray);
		
		if($cuisineArg=='dinner')
		{	$result='';
		  $result.='<table cellpadding="2" cellspacing="2" >';
		  $result.='<tr><td><strong>Client</strong></td><td><strong>Qty</strong></td></tr>';
		  foreach($dinnerItemsArray as $infoArray)
		  {
			 
				  $customerName = $infoArray['customerName'];
				  $qty = $infoArray[$entityIdArg];
				  $result.='<tr><td>'.$customerName.'</td><td>'.$qty.'</td></tr>';
			 
		  }      
		  $result.='</table>';
		 echo $result;	
		}
		
		if($cuisineArg=='breakfast')
		{	
		  $result.='<table cellpadding="2" cellspacing="2" >';
		  $result.='<tr><td><strong>Client</strong></td><td><strong>Qty</strong></td></tr>';
		  foreach($breakfastItemsArray as $infoArray)
		  {
			      $customerName = $infoArray['customerName'];
				  $qty = $infoArray[$entityIdArg];
				  $result.='<tr><td>'.$customerName.'</td><td>'.$qty.'</td></tr>';
		  }
		  $result.='</table>';	
		  echo $result;		
		}
		
		if($cuisineArg=='lunch')
		{	
		  $result.='<table cellpadding="2" cellspacing="2" >';
		  $result.='<tr><td><strong>Client</strong></td><td><strong>Qty</strong></td></tr>';
		  foreach($lunchItemsArray as $infoArray)
		  {
			      $customerName = $infoArray['customerName'];
				  $qty = $infoArray[$entityIdArg];
				  $result.='<tr><td>'.$customerName.'</td><td>'.$qty.'</td></tr>';
		  }
		  $result.='</table>';	
		  echo $result;		
		}
		
		if($cuisineArg=='hightea')
		{	
		  $result.='<table cellpadding="2" cellspacing="2" >';
		  $result.='<tr><td><strong>Client</strong></td><td><strong>Qty</strong></td></tr>';
		  foreach($highteaItemsArray as  $infoArray)
		  {
			      $customerName = $infoArray['customerName'];
				  $qty = $infoArray[$entityIdArg];
				  $result.='<tr><td>'.$customerName.'</td><td>'.$qty.'</td></tr>';
		  }
		  $result.='</table>';	
		  echo $result;		
		}
		
	
	}

	
	public function qtyAction() {
		
		
	   if(!Mage::getSingleton('customer/session')->isLoggedIn() ) 
		{
			 $this->_redirect('customer/account/login');					

		}
		else {
			$groupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
			if(!in_array($groupId,array(4,5)))
			{ $this->_redirect('customer/account/login'); }	

		}	
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Order Item Quantity"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("Home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("print", array(
                "label" => $this->__("Qty"),
                "title" => $this->__("Qty")
		   ));

      $this->renderLayout(); 
	  
    }
	
	

    public function menuorderOldAction() {
        $params = $this->getRequest()->getParams(); 
        $todaydates = $params['orderdate'];
        //print_r($orderdatas = $params['orderdate']); die;
        $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
        
        $checkdataexist = "SELECT * FROM `healorder` WHERE `email` = '".$params['email']."' AND `status` = '0' AND `orderdate` = '".$params['orderdate']."' ";

        $datacheck = $connection->query($checkdataexist);
        $check_fetch = $datacheck->fetch();
        if (!$check_fetch) {
           $insertData = "INSERT INTO `healorder` (`id`, `name`, `email`, `orderdate`, `mobile`, `alernatemobile`, `foodtype`, `fooditems`,`breakfast`,`breakfast_items_desc`,`lunch`,`lunch_items_desc`,`hightea`,`hightea_items_desc`,`dinner`,`dinner_items_desc`, `note`, `address`, `status`) VALUES (NULL, '".str_replace(",","",$params['name'])."', '".$params['email']."', '".$todaydates."', '".$params['mobile']."', '".$params['alernatemobile']."', '".$params['foodtype']."', '".$params['fooditems']."', '".$params['breakfast']."', '".$params['breakfastitemsdesc']."', '".$params['lunch']."', '".$params['lunchitemsdesc']."', '".$params['hightea']."', '".$params['highteaitemsdesc']."', '".$params['dinner']."', '".$params['dinneritemsdesc']."', '".$params['note']."', '".$params['address']."', '0');";
          $couts = count($connection->query($insertData));
          $results = " Your order has been created! ";
        }else{
           $updateData = "UPDATE `healorder` SET `name` = '".str_replace(",","",$params['name'])."', `email` = '".$params['email']."', `orderdate` = '".$todaydates."', `mobile` = '".$params['mobile']."', `alernatemobile` = '".$params['alernatemobile']."', `foodtype` =  '".$params['foodtype']."', `fooditems` = '".$params['fooditems']."',  `breakfast` = '".$params['breakfast']."',  `breakfast_items_desc` = '".$params['breakfastitemsdesc']."', `lunch` = '".$params['lunch']."', `lunch_items_desc` = '".$params['lunchitemsdesc']."', `hightea` = '".$params['hightea']."', `hightea_items_desc` = '".$params['highteaitemsdesc']."', `dinner` = '".$params['dinner']."',`dinner_items_desc` = '".$params['dinneritemsdesc']."',`note` =  '".$params['note']."', `address` = '".$params['address']."' WHERE `email` = '".$params['email']."' AND `foodtype` =  '".$params['foodtype']."' AND `orderdate` = '".$params['orderdate']."'";
          $connection->query($updateData);
          $results = " Your order has been updated! ";
        }
        $response =  array("status" => 200, "results" => $results);
        return print_r($response);
    }
	
	public function menuorderAction() {
         $unitofnutritionDatabase=100;
        $params = $this->getRequest()->getParams(); 
        $todaydates = $params['orderdate'];
        $dateInfo = explode("/",$todaydates);
	$formatted_orderdate = $dateInfo[2]."-".$dateInfo[0]."-".$dateInfo[1];
        
        $customerids = $params['customerid'];
        //print_r($orderdatas = $params['orderdate']); die;
        $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
        if(isset($customerids)){
        	$customer = Mage::getModel('customer/customer')->load($customerids);
        	$customerid = $customer->getId();
        	$params['name'] = $customer->getName();
        	$params['email'] = $customer->getEmail();
        	$params['mobile'] = $customer->getPrimarymobileno();
        	foreach ($customer->getAddresses() as $address1){
			   $customerAddress[] = $address1->toArray(); break;
			} 
			$city='';
			if(count($customerAddress[0]) > 1){
			  $tempstreet = preg_replace('/[^A-Za-z0-9\-]/', ' ', $customerAddress[0]['street']);
			  $street = $tempstreet;
			  $customerCity = trim($customerAddress[0]['city']);
			  if($customerCity!='')
			  {
			     $city  = ucfirst($customerCity);
			  }
			  $state  = trim($customerAddress[0]['region']);
			  $country  = trim($customerAddress[0]['countryId']);
			  $zipcode  = trim($customerAddress[0]['postcode']);
			  $params['address'] = $params['name'].' '. $params['mobile'].' '.$street.' '.$city.' '.$state.' ' .$zipcode;  
			}

        }else{
		    if(Mage::getSingleton('customer/session')->isLoggedIn()) {
		     $customerData = Mage::getSingleton('customer/session')->getCustomer();
		     $customerid = $customerData->getId();
			}
		}
		//echo "<pre>"; print_r($params); die();
        $checkdataexist = "SELECT * FROM `healorder` WHERE `email` = '".$params['email']."' AND `status` = '0' AND `orderdate` = '".$params['orderdate']."' ";

        $datacheck = $connection->query($checkdataexist);
        $check_fetch = $datacheck->fetch();
        if (!$check_fetch) {
           /*$insertData = "INSERT INTO `healorder` (`id`, `name`, `email`, `orderdate`, `mobile`, `alernatemobile`, `foodtype`, `fooditems`,`breakfast`,`breakfast_items_desc`,`lunch`,`lunch_items_desc`,`hightea`,`hightea_items_desc`,`dinner`,`dinner_items_desc`, `note`, `address`, `status`) VALUES (NULL, '".str_replace(",","",$params['name'])."', '".$params['email']."', '".$todaydates."', '".$params['mobile']."', '".$params['alernatemobile']."', '".$params['foodtype']."', '".$params['fooditems']."', '".$params['breakfast']."', '".$params['breakfastitemsdesc']."', '".$params['lunch']."', '".$params['lunchitemsdesc']."', '".$params['hightea']."', '".$params['highteaitemsdesc']."', '".$params['dinner']."', '".$params['dinneritemsdesc']."', '".$params['note']."', '".$params['address']."', '0');";*/
           $insertData = "INSERT INTO `healorder` (`id`, `name`, `email`,`city`,`customerid`,`orderdate`, `formatted_orderdate`,`mobile`, `alernatemobile`, `foodtype`, `fooditems`,`breakfast`,`breakfast_items_desc`,`lunch`,`lunch_items_desc`,`hightea`,`hightea_items_desc`,`dinner`,`dinner_items_desc`, `note`, `address`, `status`) VALUES (NULL, '".str_replace(",","",$params['name'])."', '".$params['email']."','".$city."','".$customerid."','".$todaydates."','".$formatted_orderdate."', '".$params['mobile']."', '".$params['alernatemobile']."', '".$params['foodtype']."', '".$params['fooditems']."', '".$params['breakfast']."', '".$params['breakfastitemsdesc']."', '".$params['lunch']."', '".$params['lunchitemsdesc']."', '".$params['hightea']."', '".$params['highteaitemsdesc']."', '".$params['dinner']."', '".$params['dinneritemsdesc']."', '".$params['note']."', '".$params['address']."', '0');";
          $connection->query($insertData); 
          $last_insert_id = $connection->lastInsertId(`healorder`); 
		 // $orderid = $last_insert_id;
          // dinner insert data
          if(trim($params['dinneritemsdesc'])){
          	$productdinnerarray = explode(",",trim($params['dinneritemsdesc']));
          	foreach ($productdinnerarray as $productdinnervalue) {
          	  if(trim($productdinnervalue)){
			  $dinnerentityid = substr($productdinnervalue, strpos($productdinnervalue, "_") + 1);
			  $dinnerEId = strtok($dinnerentityid, '_');
			  
			  $dinnerproduct = Mage::getModel('catalog/product')->load($dinnerEId);
			  $dinnerUnitofmeasure = $dinnerproduct->getUnitofmeasure();
			  $dinnerProtein = ($dinnerproduct->getProtein()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerFat = ($dinnerproduct->getFat()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerCarbohydrates = ($dinnerproduct->getCarbohydrates()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerCalories = ($dinnerproduct->getCalories()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ; 
			  $dinnerFiber = ($dinnerproduct->getFiber()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ; 
			 
			  $cousine ="dinner";
			  $dinnerItemName = $dinnerproduct->getName();
			  $insertDinnerData = "INSERT INTO `healitemdetails` (`orderid`, `cuisine`, `productid`, `itemname`, `qty`, `unitofmeasure`, `protein`,`fat`,`carbohydrates`,`fiber`,`calories`,`customerid`,`updatedby`) VALUES ('".$last_insert_id."', '".$cousine."', '".$dinnerEId."', '".$dinnerItemName."', '".$dinnerUnitofmeasure."', '".$dinnerUnitofmeasure."', '".$dinnerProtein."', '".$dinnerFat."', '".$dinnerCarbohydrates."', '".$dinnerFiber."', '".$dinnerCalories."', '".$customerid."', '');";
			   $connection->query($insertDinnerData);  
			}
			}
          }
          // Breakfast insert data
          if(trim($params['breakfastitemsdesc'])){
          	$productBreakfastarray = explode(",",trim($params['breakfastitemsdesc']));
          	foreach ($productBreakfastarray as $productBreakfastvalue) {
          	  if(trim($productBreakfastvalue)){
			  $breakfastentityid = substr($productBreakfastvalue, strpos($productBreakfastvalue, "_") + 1);
			  $dinnerEId = strtok($breakfastentityid, '_');
			  
			  $dinnerproduct = Mage::getModel('catalog/product')->load($dinnerEId);
			  $dinnerUnitofmeasure = $dinnerproduct->getUnitofmeasure();
			  $dinnerProtein = ($dinnerproduct->getProtein()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerFat = ($dinnerproduct->getFat()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerCarbohydrates = ($dinnerproduct->getCarbohydrates()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerCalories = ($dinnerproduct->getCalories()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ; 
			  $dinnerFiber = ($dinnerproduct->getFiber()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  
			  $cousine ="breakfast";
			  $dinnerItemName = $dinnerproduct->getName();
			  $insertBreakfastData = "INSERT INTO `healitemdetails` (`orderid`, `cuisine`, `productid`, `itemname`, `qty`, `unitofmeasure`, `protein`,`fat`,`carbohydrates`,`fiber`,`calories`,`customerid`,`updatedby`) VALUES ('".$last_insert_id."', '".$cousine."', '".$dinnerEId."', '".$dinnerItemName."', '".$dinnerUnitofmeasure."', '".$dinnerUnitofmeasure."', '".$dinnerProtein."', '".$dinnerFat."', '".$dinnerCarbohydrates."', '".$dinnerFiber."', '".$dinnerCalories."', '".$customerid."', '');";
			   $connection->query($insertBreakfastData);  
			}
			}
          }
          // Lunch insert data
          if(trim($params['lunchitemsdesc'])){
          	$productLuncharray = explode(",",trim($params['lunchitemsdesc']));
          	foreach ($productLuncharray as $productlunchvalue) {
          	  if(trim($productlunchvalue)){
			  $lunchentityid = substr($productlunchvalue, strpos($productlunchvalue, "_") + 1);
			  $dinnerEId = strtok($lunchentityid, '_');
			  
			  $dinnerproduct = Mage::getModel('catalog/product')->load($dinnerEId);
			  $dinnerUnitofmeasure = $dinnerproduct->getUnitofmeasure();
			  $dinnerProtein = ($dinnerproduct->getProtein()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerFat = ($dinnerproduct->getFat()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerCarbohydrates = ($dinnerproduct->getCarbohydrates()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerCalories = ($dinnerproduct->getCalories()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ; 
			  $dinnerFiber = ($dinnerproduct->getFiber()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  
			  $cousine ="lunch";
			  $dinnerItemName = $dinnerproduct->getName();
			  $insertLunchData = "INSERT INTO `healitemdetails` (`orderid`, `cuisine`, `productid`, `itemname`, `qty`, `unitofmeasure`, `protein`,`fat`,`carbohydrates`,`fiber`,`calories`,`customerid`,`updatedby`) VALUES ('".$last_insert_id."', '".$cousine."', '".$dinnerEId."', '".$dinnerItemName."', '".$dinnerUnitofmeasure."', '".$dinnerUnitofmeasure."', '".$dinnerProtein."', '".$dinnerFat."', '".$dinnerCarbohydrates."', '".$dinnerFiber."', '".$dinnerCalories."', '".$customerid."', '');";
			   $connection->query($insertLunchData);  
			}
			}
          }
          // HiTea insert data
          if(trim($params['highteaitemsdesc'])){
          	$productHiTeaarray = explode(",",trim($params['highteaitemsdesc']));
          	foreach ($productHiTeaarray as $productHiTeavalue) {
          	  if(trim($productHiTeavalue)){
			  $lunchentityid = substr($productHiTeavalue, strpos($productHiTeavalue, "_") + 1);
			  $dinnerEId = strtok($lunchentityid, '_');
			  
			  $dinnerproduct = Mage::getModel('catalog/product')->load($dinnerEId);
			  $dinnerUnitofmeasure = $dinnerproduct->getUnitofmeasure();
			  $dinnerProtein = ($dinnerproduct->getProtein()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerFat = ($dinnerproduct->getFat()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerCarbohydrates = ($dinnerproduct->getCarbohydrates()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerCalories = ($dinnerproduct->getCalories()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ; 
			  $dinnerFiber = ($dinnerproduct->getFiber()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  			  
			  $cousine ="hightea";
			  $dinnerItemName = $dinnerproduct->getName();
			  $insertHiTeaData = "INSERT INTO `healitemdetails` (`orderid`, `cuisine`, `productid`, `itemname`, `qty`, `unitofmeasure`, `protein`,`fat`,`carbohydrates`,`fiber`,`calories`,`customerid`,`updatedby`) VALUES ('".$last_insert_id."', '".$cousine."', '".$dinnerEId."', '".$dinnerItemName."', '".$dinnerUnitofmeasure."', '".$dinnerUnitofmeasure."', '".$dinnerProtein."', '".$dinnerFat."', '".$dinnerCarbohydrates."', '".$dinnerFiber."', '".$dinnerCalories."', '".$customerid."', '');";
			   $connection->query($insertHiTeaData);  
			}
			}
          }
          $healOrder  = Mage::getModel("heal/order")->load($last_insert_id);
		  $healOrder->updaterowinfo($last_insert_id);
          $results = " Your order has been placed! ";
        }else{
           $updateData = "UPDATE `healorder` SET `name` = '".str_replace(",","",$params['name'])."', `email` = '".$params['email']."', `orderdate` = '".$todaydates."', `mobile` = '".$params['mobile']."', `alernatemobile` = '".$params['alernatemobile']."', `foodtype` =  '".$params['foodtype']."', `fooditems` = '".$params['fooditems']."',  `breakfast` = '".$params['breakfast']."',  `breakfast_items_desc` = '".$params['breakfastitemsdesc']."', `lunch` = '".$params['lunch']."', `lunch_items_desc` = '".$params['lunchitemsdesc']."', `hightea` = '".$params['hightea']."', `hightea_items_desc` = '".$params['highteaitemsdesc']."', `dinner` = '".$params['dinner']."',`dinner_items_desc` = '".$params['dinneritemsdesc']."',`note` =  '".$params['note']."', `address` = '".$params['address']."' WHERE `email` = '".$params['email']."' AND `foodtype` =  '".$params['foodtype']."' AND `orderdate` = '".$params['orderdate']."'";
          $connection->query($updateData);
          $orderid = $check_fetch['id'];	
          if($orderid){
          	$deleteData = "DELETE FROM `healitemdetails` WHERE `orderid` ='".$orderid."'";
          	$connection->query($deleteData);
          	// dinner insert data
          if(trim($params['dinneritemsdesc'])){
          	$productdinnerarray = explode(",",trim($params['dinneritemsdesc']));
          	foreach ($productdinnerarray as $productdinnervalue) {
          	  if(trim($productdinnervalue)){
			  $dinnerentityid = substr($productdinnervalue, strpos($productdinnervalue, "_") + 1);
			  $dinnerEId = strtok($dinnerentityid, '_');
			  
			  $dinnerproduct = Mage::getModel('catalog/product')->load($dinnerEId);
			  $dinnerUnitofmeasure = $dinnerproduct->getUnitofmeasure();
			  $dinnerProtein = ($dinnerproduct->getProtein()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerFat = ($dinnerproduct->getFat()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerCarbohydrates = ($dinnerproduct->getCarbohydrates()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerCalories = ($dinnerproduct->getCalories()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ; 
			  $dinnerFiber = ($dinnerproduct->getFiber()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  
			  $cousine ="dinner";
			  $dinnerItemName = $dinnerproduct->getName();
			  $insertDinnerData = "INSERT INTO `healitemdetails` (`orderid`, `cuisine`, `productid`, `itemname`, `qty`, `unitofmeasure`, `protein`,`fat`,`carbohydrates`,`fiber`,`calories`,`customerid`,`updatedby`) VALUES ('".$orderid."', '".$cousine."', '".$dinnerEId."', '".$dinnerItemName."', '".$dinnerUnitofmeasure."', '".$dinnerUnitofmeasure."', '".$dinnerProtein."', '".$dinnerFat."', '".$dinnerCarbohydrates."', '".$dinnerFiber."', '".$dinnerCalories."', '".$customerid."', '');";
			   $connection->query($insertDinnerData);  
			}
			}
          }
          // Breakfast insert data
          if(trim($params['breakfastitemsdesc'])){
          	$productBreakfastarray = explode(",",trim($params['breakfastitemsdesc']));
          	foreach ($productBreakfastarray as $productBreakfastvalue) {
          	  if(trim($productBreakfastvalue)){
			  $breakfastentityid = substr($productBreakfastvalue, strpos($productBreakfastvalue, "_") + 1);
			  $dinnerEId = strtok($breakfastentityid, '_');
			  
			  $dinnerproduct = Mage::getModel('catalog/product')->load($dinnerEId);
			  $dinnerUnitofmeasure = $dinnerproduct->getUnitofmeasure();
			  $dinnerProtein = ($dinnerproduct->getProtein()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerFat = ($dinnerproduct->getFat()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerCarbohydrates = ($dinnerproduct->getCarbohydrates()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerCalories = ($dinnerproduct->getCalories()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ; 
			  $dinnerFiber = ($dinnerproduct->getFiber()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  
			  $cousine ="breakfast";
			  $dinnerItemName = $dinnerproduct->getName();
			  $insertBreakfastData = "INSERT INTO `healitemdetails` (`orderid`, `cuisine`, `productid`, `itemname`, `qty`, `unitofmeasure`, `protein`,`fat`,`carbohydrates`,`fiber`,`calories`,`customerid`,`updatedby`) VALUES ('".$orderid."', '".$cousine."', '".$dinnerEId."', '".$dinnerItemName."', '".$dinnerUnitofmeasure."', '".$dinnerUnitofmeasure."', '".$dinnerProtein."', '".$dinnerFat."', '".$dinnerCarbohydrates."', '".$dinnerFiber."', '".$dinnerCalories."', '".$customerid."', '');";
			   $connection->query($insertBreakfastData);  
			}
			}
          }
          // Lunch insert data
          if(trim($params['lunchitemsdesc'])){
          	$productLuncharray = explode(",",trim($params['lunchitemsdesc']));
          	foreach ($productLuncharray as $productlunchvalue) {
          	  if(trim($productlunchvalue)){
			  $lunchentityid = substr($productlunchvalue, strpos($productlunchvalue, "_") + 1);
			  $dinnerEId = strtok($lunchentityid, '_');
			  
			  $dinnerproduct = Mage::getModel('catalog/product')->load($dinnerEId);
			  $dinnerUnitofmeasure = $dinnerproduct->getUnitofmeasure();
			  $dinnerProtein = ($dinnerproduct->getProtein()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerFat = ($dinnerproduct->getFat()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerCarbohydrates = ($dinnerproduct->getCarbohydrates()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerCalories = ($dinnerproduct->getCalories()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ; 
			  $dinnerFiber = ($dinnerproduct->getFiber()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  
			  $cousine ="lunch";
			  $dinnerItemName = $dinnerproduct->getName();
			  $insertLunchData = "INSERT INTO `healitemdetails` (`orderid`, `cuisine`, `productid`, `itemname`, `qty`, `unitofmeasure`, `protein`,`fat`,`carbohydrates`,`fiber`,`calories`,`customerid`,`updatedby`) VALUES ('".$orderid."', '".$cousine."', '".$dinnerEId."', '".$dinnerItemName."', '".$dinnerUnitofmeasure."', '".$dinnerUnitofmeasure."', '".$dinnerProtein."', '".$dinnerFat."', '".$dinnerCarbohydrates."', '".$dinnerFiber."', '".$dinnerCalories."', '".$customerid."', '');";
			   $connection->query($insertLunchData);  
			}
			}
          }
          // HiTea insert data
          if(trim($params['highteaitemsdesc'])){
          	$productHiTeaarray = explode(",",trim($params['highteaitemsdesc']));
          	foreach ($productHiTeaarray as $productHiTeavalue) {
          	  if(trim($productHiTeavalue)){
			  $lunchentityid = substr($productHiTeavalue, strpos($productHiTeavalue, "_") + 1);
			  $dinnerEId = strtok($lunchentityid, '_');
			 
			  $dinnerproduct = Mage::getModel('catalog/product')->load($dinnerEId);
			  $dinnerUnitofmeasure = $dinnerproduct->getUnitofmeasure();
			  $dinnerProtein = ($dinnerproduct->getProtein()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerFat = ($dinnerproduct->getFat()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerCarbohydrates = ($dinnerproduct->getCarbohydrates()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  $dinnerCalories = ($dinnerproduct->getCalories()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ; 
			  $dinnerFiber = ($dinnerproduct->getFiber()/$unitofnutritionDatabase)*$dinnerUnitofmeasure ;
			  
			  $cousine ="hightea";
			  $dinnerItemName = $dinnerproduct->getName();
			  $insertHiTeaData = "INSERT INTO `healitemdetails` (`orderid`, `cuisine`, `productid`, `itemname`, `qty`, `unitofmeasure`, `protein`,`fat`,`carbohydrates`,`fiber`,`calories`,`customerid`,`updatedby`) VALUES ('".$orderid."', '".$cousine."', '".$dinnerEId."', '".$dinnerItemName."', '".$dinnerUnitofmeasure."', '".$dinnerUnitofmeasure."', '".$dinnerProtein."', '".$dinnerFat."', '".$dinnerCarbohydrates."', '".$dinnerFiber."', '".$dinnerCalories."', '".$customerid."', '');";
			   $connection->query($insertHiTeaData);  
			}
			}
          }
          $healOrder  = Mage::getModel("heal/order")->load($orderid );
          $healOrder->updaterowinfo($orderid);
          }
          
          $results = " Your order has been updated! ";
        }
        
        
        $response =  array("status" => 200, "results" => $results);
        return print_r($response);
		
    }
	public function healitemupdateAction() {
		
		 $params = $this->getRequest()->getParams(); 
		$orderid  = trim($params['orderid']);
		$cuisine = trim($params['cuisine']);
		$entityid  = trim($params['entityid']);
		$qty  = $params['qty'];
		$proteinQty  = $params['proteinQty'];
		$fatQty  = $params['fatQty'];
		$carbohydratesQty  = $params['carbohydratesQty'];
		$fiberQty  = $params['fiberQty'];
		$caloriesQty  = $params['caloriesQty'];
		
		$product  = Mage::getModel('catalog/product')->load($entityid);
		$itemname =$product->getName();
		$unitofmeasure = $product->getUnitofmeasure();
		$customerid=0;
		$custName='';
		if (Mage::getSingleton('customer/session')->isLoggedIn()) {

			$customer = Mage::getSingleton('customer/session')->getCustomer();
			$customerid = $customer->getID();
			$custName = $customer->getName();

		}
      
        $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
        
        echo $checkdataexist = "SELECT * FROM healitemdetails WHERE orderid='".$orderid."' and productid ='".$entityid."' and cuisine='".$cuisine."'";
        $datacheck = $connection->query($checkdataexist);
        $check_fetch = $datacheck->fetch();
		//print_r($check_fetch);
        if (!$check_fetch) {
           $insertData = "INSERT INTO healitemdetails(orderid,cuisine,productid,itemname,qty, unitofmeasure,protein,fat,carbohydrates,fiber, calories,customerid, updatedby)";
			
			$insertData.= " VALUES ( '".$orderid."','".$cuisine."', '".$entityid."','".$itemname."', '".$qty."', '".$unitofmeasure ."', '".$proteinQty."', '".$fatQty."', '".$carbohydratesQty."', '".$fiberQty."', '".$caloriesQty."', '".$customerid."', '".$custName."') "; 
			
			$connection->query($insertData); 
		    echo $insertData;
         
        }else{
            $updateData = "UPDATE healitemdetails SET cuisine='".$cuisine."', qty = '$qty ', unitofmeasure = '$unitofmeasure', protein = '$proteinQty', fat = '$fatQty',
 carbohydrates = '$carbohydratesQty', fiber = '$fiberQty', calories = '$caloriesQty', customerid = '$customerid', updatedby = '$custName' WHERE  orderid='".$orderid."' and productid ='".$entityid."' and cuisine='".$cuisine."'";
          $connection->query($updateData);
			echo $updateData;
         
        }
	}
	
   public function updaterowinfoAction()
	{
		$params      = $this->getRequest()->getParams(); 
		$orderid     = $params['orderid'];
		
		$healOrder  = Mage::getModel("heal/order")->load($orderid);
		$dbWrite     = Mage::getSingleton('core/resource')->getConnection('core_write');
		$dbRead      = Mage::getSingleton('core/resource')->getConnection('core_read');
		
		$order_total_protein 	     = 0;
		$order_total_fat	         = 0;
		$order_total_carbohydrates   = 0;
		$order_total_fiber           = 0;
		$order_total_calories        = 0;
	    $order_total_gram            = 0;
	   
	   $result = array();
		
		$order_protein_percent=0;
		$order_fat_percent=0;
		$order_carbohydrates_percent=0;
		
		$cuisineArray = array('breakfast','lunch','dinner','hightea');
		
		foreach($cuisineArray as $cuisine)
		{
			$QgetCuisineRows = "SELECT * FROM healitemdetails WHERE orderid =".$orderid." AND cuisine = '$cuisine'";
			$cuisineResult = $dbRead->fetchAll($QgetCuisineRows);
			
			if(count($cuisineResult)>0) 
			{
					$cuisine_total_protein =0;
					$cuisine_total_fat =0;
					$cuisine_total_carbohydrates =0;
					$cuisine_total_fiber =0;
					$cuisine_total_calories =0;
					


					foreach($cuisineResult as $row)
					{

						if($row['protein']!='no')
						{ 	
							
					    	$cuisine_total_protein+=$row['protein'];
						}
						if($row['fat']!='no'){ 				$cuisine_total_fat+=$row['fat'];	 }
						if($row['carbohydrates']!='no'){ 	$cuisine_total_carbohydrates+=$row['carbohydrates']; 	}
						if($row['fiber']!='no'){ 			$cuisine_total_fiber+=$row['fiber']; 	}
						if($row['calories']!='no'){ 		$cuisine_total_calories+=$row['calories'];	 }
						if($row['qty']>0 ){ 		            $order_total_gram+= $row['qty']; 
										  
							//echo $row['qty']."--".$row['itemdetailid']."--".$order_total_gram; echo "</br>";	
										 }

					}
				   
				   if( $cuisine_total_protein>0 )
				   {  
					   $healOrder->setData($cuisine.'_total_protein',(4*$cuisine_total_protein));
					   $order_total_protein+= $cuisine_total_protein;
					  
				   }
				
				   if( $cuisine_total_fat >0 )  
				   {   
					  //echo "cuisine_total_fat=".$cuisine_total_fat; echo "</br>";
					   
					   $healOrder->setData($cuisine.'_total_fat',(9*$cuisine_total_fat));
					   $order_total_fat+= $cuisine_total_fat;
				   }
				
				   if( $cuisine_total_carbohydrates>0 )
				   {   
					   $healOrder->setData($cuisine.'_total_carbohydrates',(4*$cuisine_total_carbohydrates));
					   $order_total_carbohydrates+= $cuisine_total_carbohydrates; 
				   }
				
				   if( $cuisine_total_fiber>0 ) 
				   {   
					   $healOrder->setData($cuisine.'_total_fiber',$cuisine_total_fiber);
					   $order_total_fiber+= $cuisine_total_fiber;
				   }
				
				   if( $cuisine_total_calories>0 )  
				   {  
					   $healOrder->setData($cuisine.'_total_calories',$cuisine_total_calories);
					   $order_total_calories+= $cuisine_total_calories;
				   }
					
					
			    
			}
			
			
		}
		
		
	
		 $calculateCaloriesForPercent = (4*$order_total_protein) + (9*$order_total_fat) + (4*$order_total_carbohydrates); 
		
		if($order_total_protein >0 && $calculateCaloriesForPercent>0)
		{
			$order_protein_percent       = (((4*$order_total_protein)/$calculateCaloriesForPercent)*100);
			
			$healOrder->setData('total_protein',$order_total_protein);
			$healOrder->setData('proteinpercent',$order_protein_percent);
		}
		
		if($order_total_fat >0 && $calculateCaloriesForPercent>0)
		{
			$order_fat_percent           = (((9*$order_total_fat)/$calculateCaloriesForPercent)*100);
			
			$healOrder->setData('total_fat',$order_total_fat);
			$healOrder->setData('fatpercent',$order_fat_percent);
		}
		
		if($order_total_carbohydrates >0 && $calculateCaloriesForPercent>0)
		{
			$order_carbohydrates_percent           = (((4*$order_total_carbohydrates)/$calculateCaloriesForPercent)*100);
			$healOrder->setData('total_carbohydrates',$order_total_carbohydrates);
			$healOrder->setData('carbohydratespercent',$order_carbohydrates_percent);
			
		}
		
		if($order_total_fiber >0 )
		{
			$healOrder->setData('total_fiber',$order_total_fiber);
		}
		
		if($order_total_calories >0 )
		{
			$healOrder->setData('total_calories',$order_total_calories);
		}
	   
		if($order_total_gram>0)
		{
			//echo $order_total_gram;
			$healOrder->setData('total_gram',$order_total_gram);
			
		}
		
	   $dieticianName=''; 
		if (Mage::getSingleton('customer/session')->isLoggedIn()) {
             
			  $customer = Mage::getSingleton('customer/session')->getCustomer();
              $customerData = Mage::getModel('customer/customer')->load($customer->getId())->getData();
			 // print_r($customerData);
			  $groupId = $customerData['group_id'];
			  //echo "groupId=".$groupId;
			  if($groupId==4)
			  {
				 $dieticianName = $customerData['firstname'];  //die;
				 $healOrder->setData('reviewedby',$dieticianName);  
			  }
              
       } 
	   
	   $healOrder->save();
			
	   echo $dieticianName; 
		
		
	}
	
	public function rowupdateAction()
	{
		$params    = $this->getRequest()->getParams(); 
		$orderid   = $params['orderid'];
		$productId = $params['entityid']; 
		$qty       = $params['qty'];
		$unitofmeasure = $params['unitofmeasure'];
		$unitofnutritionDatabase = $params['unitofnutritionDatabase'];
		
		$result= array();
		
		
		$product   = Mage::getModel("catalog/product")->load($productId);
		
		
		$protein	 = $product->getProtein();
		$fat		 = $product->getFat();
		$carbohydrates = $product->getCarbohydrates();
		$fiber		  = $product->getFiber();
		$calories     = $product->getCalories();
		
		$total=0;
		
		$calculatedProtein=0;
		$calculatedFat=0;
		$calculatedCarbohydrates=0;
		$calculatedFiber=0;
		$calculatedCalories=0;
		
		if($protein>0)
		{ 
			 $calculatedProtein = ($protein/$unitofnutritionDatabase )* $qty; 
			 $result['calculatedProtein']=(int)$calculatedProtein;
		} 
		else
		{
			$result['calculatedProtein']='no';
		}
		
		if($fat>0) 
		{   $calculatedFat = ($fat/$unitofnutritionDatabase )* $qty;  
			$result['calculatedFat']= (int)$calculatedFat;
		}
		else
		{
			$result['calculatedFat']= 'no';
		}
		
		if($carbohydrates >0)
		{ 
			  $calculatedCarbohydrates = ($carbohydrates/$unitofnutritionDatabase )* $qty; 
			  $result['calculatedCarbohydrates']= (int) $calculatedCarbohydrates;
		}
		else
		{
			 $result['calculatedCarbohydrates']='no';
		}
							  
			
			
		if($fiber>0) 
		{   
			$calculatedFiber = ($fiber/$unitofnutritionDatabase )* $qty; 
			$result['calculatedFiber']= (int)$calculatedFiber;
		}
		else
		{
		  $result['calculatedFiber']='no';
		}
		
		if($calories>0) 
		{ 
			$calculatedCalories = ($calories/$unitofnutritionDatabase )* $qty; 
			$result['calculatedCalories']= (int)$calculatedCalories;
		}
		else
		{
			 $result['calculatedCalories']='no';
		}
		
		
		$hiddenRowInfo= implode(",",$result);  // keeps info of protein,fat,carbohydrates,fiber,calories
		$result['hiddenRowInfo'] = $hiddenRowInfo;
		
		echo json_encode($result);			
		
	}
	
	public function setMenuOrderAction(){
		$params = $this->getRequest()->getParams(); 
		$indiadinnerdate = explode(",",trim($params['indiadinnerdate']));
		$indiadinnersetmenu = explode(",",trim($params['indiadinnersetmenu']));
		$removeindiadinnerdate = explode(",",trim($params['removeindiadinnerdate']));
		$removeindiadinnersetmenu = explode(",",trim($params['removeindiadinnersetmenu']));
		$menudate = trim($params['menudate']);
		$cousine = trim($params['cousine']);
		$currentadvancedate = date('d');
		echo "<pre>";
		if($cousine =='indiandinner'){
		if(count($indiadinnerdate) > 1){	
			foreach ($indiadinnerdate as $productdate) {
			  if($productdate){	
			  	 $attrCode = 'dinner_indian_date';
			     $this->setmenuoperation($attrCode,$menudate,$productdate,$currentadvancedate);
			  } 
			} // first foreach loop close
		}
		if(count($removeindiadinnerdate) > 1){	
			foreach ($removeindiadinnerdate as $productdate) {
			  if($productdate){	
			  	 $attrCode = 'dinner_indian_date';
			     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
			  } 
			} // first foreach loop close
		}
		if(count($indiadinnersetmenu) > 1){	
			foreach ($indiadinnersetmenu as $productsetmenudate) {
			  if($productsetmenudate){	
			  	 $attrCode = 'dinner_indian_menuset_date';
			  	 $productdate = $productsetmenudate;
			     $this->setmenuoperation($attrCode,$menudate,$productdate,$currentadvancedate);
			  }
			}
		}
		if(count($removeindiadinnersetmenu) > 1){	
			foreach ($removeindiadinnersetmenu as $productsetmenudate) {
			  if($productsetmenudate){	
			  	 $attrCode = 'dinner_indian_menuset_date';
			  	 $productdate = $productsetmenudate;
			     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
			  }
			}
		}
		} //Indiadinner code for dates

		if($cousine =='mughlaidinner'){
		if(count($indiadinnerdate) > 1){	
			foreach ($indiadinnerdate as $productdate) {
			  if($productdate){	
			  	 $attrCode = 'dinner_mughlai_date';
			     $this->setmenuoperation($attrCode,$menudate,$productdate,$currentadvancedate);
			  } 
			} // first foreach loop close
		}
		if(count($removeindiadinnerdate) > 1){	
			foreach ($removeindiadinnerdate as $productdate) {
			  if($productdate){	
			  	 $attrCode = 'dinner_mughlai_date';
			     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
			  } 
			} // first foreach loop close
		}
		if(count($indiadinnersetmenu) > 1){	
			foreach ($indiadinnersetmenu as $productsetmenudate) {
			  if($productsetmenudate){	
			  	 $attrCode = 'dinner_mughlai_menuset_date';
			  	 $productdate = $productsetmenudate;
			     $this->setmenuoperation($attrCode,$menudate,$productdate,$currentadvancedate);
			  }
			}
		}
		if(count($removeindiadinnersetmenu) > 1){	
			foreach ($removeindiadinnersetmenu as $productsetmenudate) {
			  if($productsetmenudate){	
			  	 $attrCode = 'dinner_mughlai_menuset_date';
			  	 $productdate = $productsetmenudate;
			     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
			  }
			}
		}
		} //mughlaidinner code for dates 

		if($cousine =='italiandinner'){
		if(count($indiadinnerdate) > 1){	
			foreach ($indiadinnerdate as $productdate) {
			  if($productdate){	
			  	 $attrCode = 'dinner_italian_date';
			     $this->setmenuoperation($attrCode,$menudate,$productdate,$currentadvancedate);
			  } 
			} // first foreach loop close
		}
		if(count($removeindiadinnerdate) > 1){	
			foreach ($removeindiadinnerdate as $productdate) {
			  if($productdate){	
			  	 $attrCode = 'dinner_italian_date';
			     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
			  } 
			} // first foreach loop close
		}
		if(count($indiadinnersetmenu) > 1){	
			foreach ($indiadinnersetmenu as $productsetmenudate) {
			  if($productsetmenudate){	
			  	 $attrCode = 'dinner_italian_menuset_date';
			  	 $productdate = $productsetmenudate;
			     $this->setmenuoperation($attrCode,$menudate,$productdate,$currentadvancedate);
			  }
			}
		}
		if(count($removeindiadinnersetmenu) > 1){	
			foreach ($removeindiadinnersetmenu as $productsetmenudate) {
			  if($productsetmenudate){	
			  	 $attrCode = 'dinner_italian_menuset_date';
			  	 $productdate = $productsetmenudate;
			     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
			  }
			}
		}
		} //italiandinner code for dates 

		if($cousine =='chinesedinner'){
		if(count($indiadinnerdate) > 1){	
			foreach ($indiadinnerdate as $productdate) {
			  if($productdate){	
			  	 $attrCode = 'dinner_chinese_date';
			     $this->setmenuoperation($attrCode,$menudate,$productdate,$currentadvancedate);
			  } 
			} // first foreach loop close
		}
		if(count($removeindiadinnerdate) > 1){	
			foreach ($removeindiadinnerdate as $productdate) {
			  if($productdate){	
			  	 $attrCode = 'dinner_chinese_date';
			     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
			  } 
			} // first foreach loop close
		}
		if(count($indiadinnersetmenu) > 1){	
			foreach ($indiadinnersetmenu as $productsetmenudate) {
			  if($productsetmenudate){	
			  	 $attrCode = 'dinner_chinese_menuset_date';
			  	 $productdate = $productsetmenudate;
			     $this->setmenuoperation($attrCode,$menudate,$productdate,$currentadvancedate);
			  }
			}
		}
		if(count($removeindiadinnersetmenu) > 1){	
			foreach ($removeindiadinnersetmenu as $productsetmenudate) {
			  if($productsetmenudate){	
			  	 $attrCode = 'dinner_chinese_menuset_date';
			  	 $productdate = $productsetmenudate;
			     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
			  }
			}
		}
		} //chinesedinner code for dates 

		if($cousine =='breakfast'){
		if(count($indiadinnerdate) > 1){	
			foreach ($indiadinnerdate as $productdate) {
			  if($productdate){	
			  	 $attrCode = 'breakfast_date';
			     $this->setmenuoperation($attrCode,$menudate,$productdate,$currentadvancedate);
			  } 
			} // first foreach loop close
		}
		if(count($removeindiadinnerdate) > 1){	
			foreach ($removeindiadinnerdate as $productdate) {
			  if($productdate){	
			  	 $attrCode = 'breakfast_date';
			     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
			  } 
			} // first foreach loop close
		}
		if(count($indiadinnersetmenu) > 1){	
			foreach ($indiadinnersetmenu as $productsetmenudate) {
			  if($productsetmenudate){	
			  	 $attrCode = 'breakfast_menuset_date';
			  	 $productdate = $productsetmenudate;
			     $this->setmenuoperation($attrCode,$menudate,$productdate,$currentadvancedate);
			  }
			}
		}
		if(count($removeindiadinnersetmenu) > 1){	
			foreach ($removeindiadinnersetmenu as $productsetmenudate) {
			  if($productsetmenudate){	
			  	 $attrCode = 'breakfast_menuset_date';
			  	 $productdate = $productsetmenudate;
			     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
			  }
			}
		}
		} //breakfast code for dates 

		if($cousine =='lunchindian'){
		if(count($indiadinnerdate) > 1){	
			foreach ($indiadinnerdate as $productdate) {
			  if($productdate){	
			  	 $attrCode = 'lunch_indian_date';
			     $this->setmenuoperation($attrCode,$menudate,$productdate,$currentadvancedate);
			  } 
			} // first foreach loop close
		}
		if(count($removeindiadinnerdate) > 1){	
			foreach ($removeindiadinnerdate as $productdate) {
			  if($productdate){	
			  	 $attrCode = 'lunch_indian_date';
			     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
			  } 
			} // first foreach loop close
		}
		if(count($indiadinnersetmenu) > 1){	
			foreach ($indiadinnersetmenu as $productsetmenudate) {
			  if($productsetmenudate){	
			  	 $attrCode = 'lunch_indian_menuset_date';
			  	 $productdate = $productsetmenudate;
			     $this->setmenuoperation($attrCode,$menudate,$productdate,$currentadvancedate);
			  }
			}
		}
		if(count($removeindiadinnersetmenu) > 1){	
			foreach ($removeindiadinnersetmenu as $productsetmenudate) {
			  if($productsetmenudate){	
			  	 $attrCode = 'lunch_indian_menuset_date';
			  	 $productdate = $productsetmenudate;
			     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
			  }
			}
		}
		} //lunchindian code for dates 

		if($cousine =='lunchmughlai'){
		if(count($indiadinnerdate) > 1){	
			foreach ($indiadinnerdate as $productdate) {
			  if($productdate){	
			  	 $attrCode = 'lunch_mughlai_date';
			     $this->setmenuoperation($attrCode,$menudate,$productdate,$currentadvancedate);
			  } 
			} // first foreach loop close
		}
		if(count($removeindiadinnerdate) > 1){	
			foreach ($removeindiadinnerdate as $productdate) {
			  if($productdate){	
			  	 $attrCode = 'lunch_mughlai_date';
			     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
			  } 
			} // first foreach loop close
		}
		if(count($indiadinnersetmenu) > 1){	
			foreach ($indiadinnersetmenu as $productsetmenudate) {
			  if($productsetmenudate){	
			  	 $attrCode = 'lunch_mughlai_menuset_date';
			  	 $productdate = $productsetmenudate;
			     $this->setmenuoperation($attrCode,$menudate,$productdate,$currentadvancedate);
			  }
			}
		}
		if(count($removeindiadinnersetmenu) > 1){	
			foreach ($removeindiadinnersetmenu as $productsetmenudate) {
			  if($productsetmenudate){	
			  	 $attrCode = 'lunch_mughlai_menuset_date';
			  	 $productdate = $productsetmenudate;
			     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
			  }
			}
		}
		} //lunchmughlai code for dates 

		if($cousine =='lunchbsb'){
		if(count($indiadinnerdate) > 1){	
			foreach ($indiadinnerdate as $productdate) {
			  if($productdate){	
			  	 $attrCode = 'lunch_bbs_date';
			     $this->setmenuoperation($attrCode,$menudate,$productdate,$currentadvancedate);
			  } 
			} // first foreach loop close
		}
		if(count($removeindiadinnerdate) > 1){	
			foreach ($removeindiadinnerdate as $productdate) {
			  if($productdate){	
			  	 $attrCode = 'lunch_bbs_date';
			     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
			  } 
			} // first foreach loop close
		}
		if(count($indiadinnersetmenu) > 1){	
			foreach ($indiadinnersetmenu as $productsetmenudate) {
			  if($productsetmenudate){	
			  	 $attrCode = 'lunch_bbs_menuset_date';
			  	 $productdate = $productsetmenudate;
			     $this->setmenuoperation($attrCode,$menudate,$productdate,$currentadvancedate);
			  }
			}
		}
		if(count($removeindiadinnersetmenu) > 1){	
			foreach ($removeindiadinnersetmenu as $productsetmenudate) {
			  if($productsetmenudate){	
			  	 $attrCode = 'lunch_bbs_menuset_date';
			  	 $productdate = $productsetmenudate;
			     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
			  }
			}
		}
		} //lunchbsb code for dates 

		if($cousine =='lunchchinese'){
		if(count($indiadinnerdate) > 1){	
			foreach ($indiadinnerdate as $productdate) {
			  if($productdate){	
			  	 $attrCode = 'lunch_chinese_date';
			     $this->setmenuoperation($attrCode,$menudate,$productdate,$currentadvancedate);
			  } 
			} // first foreach loop close
		}
		if(count($removeindiadinnerdate) > 1){	
			foreach ($removeindiadinnerdate as $productdate) {
			  if($productdate){	
			  	 $attrCode = 'lunch_chinese_date';
			     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
			  } 
			} // first foreach loop close
		}
		if(count($indiadinnersetmenu) > 1){	
			foreach ($indiadinnersetmenu as $productsetmenudate) {
			  if($productsetmenudate){	
			  	 $attrCode = 'lunch_chinese_menuset_date';
			  	 $productdate = $productsetmenudate;
			     $this->setmenuoperation($attrCode,$menudate,$productdate,$currentadvancedate);
			  }
			}
		}
		if(count($removeindiadinnersetmenu) > 1){	
			foreach ($removeindiadinnersetmenu as $productsetmenudate) {
			  if($productsetmenudate){	
			  	 $attrCode = 'lunch_chinese_menuset_date';
			  	 $productdate = $productsetmenudate;
			     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
			  }
			}
		}
		} //lunchchinese code for dates 

		if($cousine =='hitea'){
		if(count($indiadinnerdate) > 1){	
			foreach ($indiadinnerdate as $productdate) {
			  if($productdate){	
			  	 $attrCode = 'hightea_date';
			     $this->setmenuoperation($attrCode,$menudate,$productdate,$currentadvancedate);
			  } 
			} // first foreach loop close
		}
		if(count($removeindiadinnerdate) > 1){	
			foreach ($removeindiadinnerdate as $productdate) {
			  if($productdate){	
			  	 $attrCode = 'hightea_date';
			     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
			  } 
			} // first foreach loop close
		}
		if(count($indiadinnersetmenu) > 1){	
			foreach ($indiadinnersetmenu as $productsetmenudate) {
			  if($productsetmenudate){	
			  	 $attrCode = 'hightea_menuset_date';
			  	 $productdate = $productsetmenudate;
			     $this->setmenuoperation($attrCode,$menudate,$productdate,$currentadvancedate);
			  }
			}
		}
		if(count($removeindiadinnersetmenu) > 1){	
			foreach ($removeindiadinnersetmenu as $productsetmenudate) {
			  if($productsetmenudate){	
			  	 $attrCode = 'hightea_menuset_date';
			  	 $productdate = $productsetmenudate;
			     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
			  }
			}
		}
		} //hitea code for dates 




	} // setMenuOrderAction function end code

	public function removeMenuOrderAction(){
	$params = $this->getRequest()->getParams(); 
	echo $menudate = trim($params['menudate']); echo "</br>";
	echo $cousine = trim($params['cousine']);echo "</br>";
	$allProductitems = explode(",",trim($params['allProductitems']));
	if($cousine =='indiandinner'){		
	if(count($allProductitems) > 1){	
		foreach ($allProductitems as $productdate) {
		  if($productdate){	
		  	 $attrCode = 'dinner_indian_date';
		     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
		  } 
		}
	}		
	if(count($allProductitems) > 1){	
		foreach ($allProductitems as $productsetmenudate) {
		  if($productsetmenudate){	
		  	 $attrCode = 'dinner_indian_menuset_date';
		     $this->unsetmenuoperation($attrCode,$menudate,$productsetmenudate);
		  }
		}
	}
	} //Indiadinner 

	if($cousine =='mughlaidinner'){		
	if(count($allProductitems) > 1){	
		foreach ($allProductitems as $productdate) {
		  if($productdate){	
		  	 $attrCode = 'dinner_mughlai_date';
		     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
		  } 
		}
	}		
	if(count($allProductitems) > 1){	
		foreach ($allProductitems as $productsetmenudate) {
		  if($productsetmenudate){	
		  	 $attrCode = 'dinner_mughlai_menuset_date';
		     $this->unsetmenuoperation($attrCode,$menudate,$productsetmenudate);
		  }
		}
	}
	} //mughlaidinner 

	if($cousine =='italiandinner'){		
	if(count($allProductitems) > 1){	
		foreach ($allProductitems as $productdate) {
		  if($productdate){	
		  	 $attrCode = 'dinner_italian_date';
		     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
		  } 
		}
	}		
	if(count($allProductitems) > 1){	
		foreach ($allProductitems as $productsetmenudate) {
		  if($productsetmenudate){	
		  	 $attrCode = 'dinner_italian_menuset_date';
		     $this->unsetmenuoperation($attrCode,$menudate,$productsetmenudate);
		  }
		}
	}
	} //italiandinner 

	if($cousine =='chinesedinner'){		
	if(count($allProductitems) > 1){	
		foreach ($allProductitems as $productdate) {
		  if($productdate){	
		  	 $attrCode = 'dinner_chinese_date';
		     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
		  } 
		}
	}		
	if(count($allProductitems) > 1){	
		foreach ($allProductitems as $productsetmenudate) {
		  if($productsetmenudate){	
		  	 $attrCode = 'dinner_chinese_menuset_date';
		     $this->unsetmenuoperation($attrCode,$menudate,$productsetmenudate);
		  }
		}
	}
	} //chinesedinner 

	if($cousine =='breakfast'){		
	if(count($allProductitems) > 1){	
		foreach ($allProductitems as $productdate) {
		  if($productdate){	
		  	 $attrCode = 'breakfast_date';
		     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
		  } 
		}
	}		
	if(count($allProductitems) > 1){	
		foreach ($allProductitems as $productsetmenudate) {
		  if($productsetmenudate){	
		  	 $attrCode = 'breakfast_menuset_date';
		     $this->unsetmenuoperation($attrCode,$menudate,$productsetmenudate);
		  }
		}
	}
	} //breakfast 

	if($cousine =='lunchindian'){		
	if(count($allProductitems) > 1){	
		foreach ($allProductitems as $productdate) {
		  if($productdate){	
		  	 $attrCode = 'lunch_indian_date';
		     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
		  } 
		}
	}		
	if(count($allProductitems) > 1){	
		foreach ($allProductitems as $productsetmenudate) {
		  if($productsetmenudate){	
		  	 $attrCode = 'lunch_indian_menuset_date';
		     $this->unsetmenuoperation($attrCode,$menudate,$productsetmenudate);
		  }
		}
	}
	} //lunchindian 

	if($cousine =='lunchmughlai'){		
	if(count($allProductitems) > 1){	
		foreach ($allProductitems as $productdate) {
		  if($productdate){	
		  	 $attrCode = 'lunch_mughlai_date';
		     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
		  } 
		}
	}		
	if(count($allProductitems) > 1){	
		foreach ($allProductitems as $productsetmenudate) {
		  if($productsetmenudate){	
		  	 $attrCode = 'lunch_mughlai_menuset_date';
		     $this->unsetmenuoperation($attrCode,$menudate,$productsetmenudate);
		  }
		}
	}
	} //lunchmughlai 

	if($cousine =='lunchbsb'){		
	if(count($allProductitems) > 1){	
		foreach ($allProductitems as $productdate) {
		  if($productdate){	
		  	 $attrCode = 'lunch_bbs_date';
		     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
		  } 
		}
	}		
	if(count($allProductitems) > 1){	
		foreach ($allProductitems as $productsetmenudate) {
		  if($productsetmenudate){	
		  	 $attrCode = 'lunch_bbs_menuset_date';
		     $this->unsetmenuoperation($attrCode,$menudate,$productsetmenudate);
		  }
		}
	}
	} //lunchbsb 

	if($cousine =='lunchchinese'){		
	if(count($allProductitems) > 1){	
		foreach ($allProductitems as $productdate) {
		  if($productdate){	
		  	 $attrCode = 'lunch_chinese_date';
		     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
		  } 
		}
	}		
	if(count($allProductitems) > 1){	
		foreach ($allProductitems as $productsetmenudate) {
		  if($productsetmenudate){	
		  	 $attrCode = 'lunch_chinese_menuset_date';
		     $this->unsetmenuoperation($attrCode,$menudate,$productsetmenudate);
		  }
		}
	}
	} //lunchchinese 

	if($cousine =='hitea'){		
	if(count($allProductitems) > 1){	
		foreach ($allProductitems as $productdate) {
		  if($productdate){	
		  	 $attrCode = 'hightea_date';
		     $this->unsetmenuoperation($attrCode,$menudate,$productdate);
		  } 
		}
	}		
	if(count($allProductitems) > 1){	
		foreach ($allProductitems as $productsetmenudate) {
		  if($productsetmenudate){	
		  	 $attrCode = 'hightea_menuset_date';
		     $this->unsetmenuoperation($attrCode,$menudate,$productsetmenudate);
		  }
		}
	}
	} //hitea 

	} // removeMenuOrderAction close

	public function setmenuoperation($attrCode,$menudate,$productdate,$currentadvancedate){
	  $productdate = Mage::getModel('catalog/product')->load($productdate);
	  $dinner_indian_date = $productdate->getResource()->getAttribute($attrCode)->getFrontend()->getValue($productdate);

	  if(trim($dinner_indian_date)){
	  	$indiadinnerdateoptionIds =  $dinner_indian_date.', '.$menudate;
	  }else{ $indiadinnerdateoptionIds =  $menudate; }

	  $sourceModel = Mage::getModel('catalog/product')->getResource()
		    ->getAttribute($attrCode)->getSource();
	  $indiadinnerdateoptionIds = str_replace(' ', '', $indiadinnerdateoptionIds);
      $valuesText = explode(',', $indiadinnerdateoptionIds);
      // below code will work to remove past dates and add new dates in menu
      $valuesTextfinal = array();
	  $lowermenudateadd = false;
	  foreach ($valuesText as $value) {
			if($currentadvancedate >= '25'){
				$valuesTextfinal[]= $value;
				/*if($value <= $currentadvancedate){ echo "case 2 ";
					if($menudate <= 3 && !$lowermenudateadd ){ 
						$valuesTextfinal[]= $menudate;
						$lowermenudateadd = true; echo "case 3 ";
					}
		    	}else{ $valuesTextfinal[]= $value; echo "case 4 "; }*/
		    }else{
		    	if($value <= $currentadvancedate){
		    	}else{ $valuesTextfinal[]= $value; }
		    }
	   }
	 // print_r($valuesTextfinal);
	  $valuesIds = array_map(array($sourceModel, 'getOptionId'), $valuesTextfinal);
	  $productdate->setData($attrCode, $valuesIds);
	  $productdate->save();
	} // setmenuoperation close


	public function unsetmenuoperation($attrCode,$menudate,$productdate){
	  $productdate = Mage::getModel('catalog/product')->load($productdate);
	  $dinner_indian_date = $productdate->getResource()->getAttribute($attrCode)->getFrontend()->getValue($productdate);
	  
	  if(trim($dinner_indian_date)){
	  	$indiadinnerdateoptionIds =  $dinner_indian_date;
	  }else{ $indiadinnerdateoptionIds =  $menudate; }

	  $sourceModel = Mage::getModel('catalog/product')->getResource()
		    ->getAttribute($attrCode)->getSource();
	  $indiadinnerdateoptionIds = str_replace(' ', '', $indiadinnerdateoptionIds);
      $valuesText = explode(',', $indiadinnerdateoptionIds);
      // below code will work to remove past dates and add new dates in menu
	  $valuesTextfinal = array_diff($valuesText, array($menudate)); 
	  print_r($valuesTextfinal);
	  $valuesIds = array_map(array($sourceModel, 'getOptionId'), $valuesTextfinal);
	  $productdate->setData($attrCode, $valuesIds);
	  $productdate->save();
	} // unsetmenuoperation close	
	
	public function deleteitemAction()
	{
		$params      = $this->getRequest()->getParams(); 
		$orderid     = $params['orderid'];
		$cuisineArg  = $params['cuisine'];
	    $entityId    = $params['entityId'];
	
	    $dbWrite     = Mage::getSingleton('core/resource')->getConnection('core_write');
		$dbRead      = Mage::getSingleton('core/resource')->getConnection('core_read');
	
	    $Qselect = "select ".$cuisineArg."_items_desc from healorder where id='".$orderid."'";
     	$cuisineItemsArray = $dbRead->fetchRow($Qselect);
	
	    $newcuisineItemsArray = array();
	    if(count($cuisineItemsArray)>0)
		{
		  
		   $cuisine_items_desc = $cuisineItemsArray[$cuisineArg."_items_desc"];
		   $cuisineDescItems = explode(",",$cuisine_items_desc)	;
			
			if(count($cuisineDescItems)>0)
			{
			  foreach($cuisineDescItems as $singleItem)
			  {
					  $singleItemInfo = explode("_",$singleItem);
					  $productid = $singleItemInfo[1]; 
				  
				      if($productid == $entityId)
					  {
						   $qDelete ="delete from healitemdetails where orderid =".$orderid." AND cuisine = '".$cuisineArg."' and productid='".$productid."'";
						   $dbWrite->query($qDelete);
						   
						  
					  }
				      else
					  {	  
					   $newcuisineItemsArray[]=$singleItem;
					  }
				      
			  }
			}
		} 
	    $newCuisineItemsDesc = implode(",",$newcuisineItemsArray);
	    $healOrder  = Mage::getModel("heal/order")->load($orderid);
	    $healOrder[$cuisineArg."_items_desc"] = $newCuisineItemsDesc;  
	    $healOrder->Save();
	//die;
	   
	    ///////////////////////After Delete/////////////////////////////////
	 
		
		//$healOrder  = Mage::getModel("heal/order")->load($orderid);
		
		
		$order_total_protein 	     = 0;
		$order_total_fat	         = 0;
		$order_total_carbohydrates   = 0;
		$order_total_fiber           = 0;
		$order_total_calories        = 0;
	    $order_total_gram            = 0;
	   
	   $result = array();
		
		$order_protein_percent=0;
		$order_fat_percent=0;
		$order_carbohydrates_percent=0;
		
		$cuisineArray = array('breakfast','lunch','dinner','hightea');
		
		foreach($cuisineArray as $cuisine)
		{
			$QgetCuisineRows = "SELECT * FROM healitemdetails WHERE orderid =".$orderid." AND cuisine = '$cuisine'";
			$cuisineResult = $dbRead->fetchAll($QgetCuisineRows);
			
			$cuisine_total_protein =0;
			$cuisine_total_fat =0;
			$cuisine_total_carbohydrates =0;
			$cuisine_total_fiber =0;
			$cuisine_total_calories =0;
			
			if(count($cuisineResult)>0) 
			{
					
					


					foreach($cuisineResult as $row)
					{

						if($row['protein']!='no')
						{ 	
							
					    	$cuisine_total_protein+=$row['protein'];
						}
						if($row['fat']!='no'){ 				$cuisine_total_fat+=$row['fat'];	 }
						if($row['carbohydrates']!='no'){ 	$cuisine_total_carbohydrates+=$row['carbohydrates']; 	}
						if($row['fiber']!='no'){ 			$cuisine_total_fiber+=$row['fiber']; 	}
						if($row['calories']!='no'){ 		$cuisine_total_calories+=$row['calories'];	 }
						if($row['qty']>0 ){ 		        $order_total_gram+= $row['qty'];  }

					}
				   
				   if( $cuisine_total_protein>0 )
				   {  
					   $healOrder->setData($cuisine.'_total_protein',(4*$cuisine_total_protein));
					   $order_total_protein+= $cuisine_total_protein;
					  
				   }
				   else
				   {
					   $healOrder->setData($cuisine.'_total_protein',0);
				   }
					   
					   
				
				   if( $cuisine_total_fat >0 )  
				   {   
					  
					   
					   $healOrder->setData($cuisine.'_total_fat',(9*$cuisine_total_fat));
					   $order_total_fat+= $cuisine_total_fat;
				   }
				   else{ $healOrder->setData($cuisine.'_total_fat',0) ; }
				
				   if( $cuisine_total_carbohydrates>0 )
				   {   
					   $healOrder->setData($cuisine.'_total_carbohydrates',(4*$cuisine_total_carbohydrates));
					   $order_total_carbohydrates+= $cuisine_total_carbohydrates; 
				   }
				   else{ $healOrder->setData($cuisine.'_total_carbohydrates',0);}
				
				   if( $cuisine_total_fiber>0 ) 
				   {   
					   $healOrder->setData($cuisine.'_total_fiber',$cuisine_total_fiber);
					   $order_total_fiber+= $cuisine_total_fiber;
				   }
				   else{ $healOrder->setData($cuisine.'_total_fiber',0);}
				
				   if( $cuisine_total_calories>0 )  
				   {  
					   $healOrder->setData($cuisine.'_total_calories',$cuisine_total_calories);
					   $order_total_calories+= $cuisine_total_calories;
				   }
				   else{ $healOrder->setData($cuisine.'_total_calories',0); }
					
					
			    
			}
			else
			{
				$healOrder->setData($cuisine.'_total_protein',0);
				$healOrder->setData($cuisine.'_total_fat',0) ;
				$healOrder->setData($cuisine.'_total_carbohydrates',0);
				$healOrder->setData($cuisine.'_total_fiber',0);
				$healOrder->setData($cuisine.'_total_calories',0);
			}
			
					
			
		}
		
		
	
		 $calculateCaloriesForPercent = (4*$order_total_protein) + (9*$order_total_fat) + (4*$order_total_carbohydrates); 
		
		if($order_total_protein >0 && $calculateCaloriesForPercent>0)
		{
			$order_protein_percent       = (((4*$order_total_protein)/$calculateCaloriesForPercent)*100);
			
			$healOrder->setData('total_protein',$order_total_protein);
			$healOrder->setData('proteinpercent',$order_protein_percent);
		}
	   else
	   {    
		    $healOrder->setData('total_protein',0);
			$healOrder->setData('proteinpercent',0); 
	   }
		
		if($order_total_fat >0 && $calculateCaloriesForPercent>0)
		{
			$order_fat_percent           = (((9*$order_total_fat)/$calculateCaloriesForPercent)*100);
			
			$healOrder->setData('total_fat',$order_total_fat);
			$healOrder->setData('fatpercent',$order_fat_percent);
		}
	    else
		{
			$healOrder->setData('total_fat',0);
			$healOrder->setData('fatpercent',0);
		}
		
		if($order_total_carbohydrates >0 && $calculateCaloriesForPercent>0)
		{
			$order_carbohydrates_percent           = (((4*$order_total_carbohydrates)/$calculateCaloriesForPercent)*100);
			$healOrder->setData('total_carbohydrates',$order_total_carbohydrates);
			$healOrder->setData('carbohydratespercent',$order_carbohydrates_percent);
			
		}
	    else
		{
			$healOrder->setData('total_carbohydrates',0);
			$healOrder->setData('carbohydratespercent',0);
		}
		
		if($order_total_fiber >0 )
		{
			$healOrder->setData('total_fiber',$order_total_fiber);
		}
	    else
		{
			$healOrder->setData('total_fiber',0);
		}
		
		if($order_total_calories >0 )
		{
			$healOrder->setData('total_calories',$order_total_calories);
		}
	    else
		{	$healOrder->setData('total_calories',0); }
	   
		if($order_total_gram>0)
		{
			//echo $order_total_gram;
			$healOrder->setData('total_gram',$order_total_gram);
			
		}
	    else
		{
			$healOrder->setData('total_gram',0);
		}
	   
		 $dieticianName='';	
		if (Mage::getSingleton('customer/session')->isLoggedIn()) {
             
			  $customer = Mage::getSingleton('customer/session')->getCustomer();
              $customerData = Mage::getModel('customer/customer')->load($customer->getId())->getData();
			 // print_r($customerData);
			  $groupId = $customerData['group_id'];
			  //echo "groupId=".$groupId;
			  if($groupId==4)
			  {
				 $dieticianName = $customerData['firstname'];  //die;
				 $healOrder->setData('reviewedby',$dieticianName);  
			  }
              
       } 
	      
	   	$healOrder->save();
		echo "deleted"; 
	
	   ////////////////////////////////////////////////////////////
	    
  }
  
 public function addnewitemAction()
  {
    $collection = Mage::getModel('catalog/product')
                        ->getCollection()
						 ->addAttributeToSelect(array('entity_id','name','sku'))
                        ->addAttributeToSort('name', 'asc')
                        ->addAttributeToFilter('status', '1')
                        ->load();
						
	    $params         = $this->getRequest()->getParams(); 
		$orderid        = $params['orderid'];
		$cuisine        = $params['cuisine'];
		$itemcount      = $params['itemcount'];
		
		
		$columnNumber   ='';
		if($cuisine=='dinner'){ $columnNumber=7;   }
		else if($cuisine=='breakfast'){ $columnNumber=8; }
		else if($cuisine=='lunch'){ $columnNumber=9; }
		else if($cuisine=='hightea'){ $columnNumber=10; }
				
		$newDivId = "newdiv-".$orderid."-".$cuisine."-".$itemcount;
		$class='select2-'.$orderid.'-'.$cuisine.'-'.$itemcount; 
		$id = $class;
		
		$operationDivId = "opdiv-".$orderid."-".$cuisine."-".$itemcount;
		$removeCancelDivId = "removeDiv-".$orderid."-".$cuisine."-".$itemcount;
		
		$dropdown='<div id="'.$newDivId.'" class="'.$newDivId.'" >';
		$dropdown.='<select class="js-example-basic-single '.$class.'" id="'.$id.'" onchange="saveorcancel(\''.$orderid.'\',\''.$newDivId.'\',\''.$operationDivId.'\',\''.$columnNumber.'\',\''.$cuisine.'\',this.id,this.value,\''.$removeCancelDivId.'\');">';
		$dropdown.='<option value="">Select Item</option>';
        foreach($collection as $item)
        { 
	      $dropdown.='<option value="'.$item->getEntityId().'">'.$item->getName().'</option>';
	    } 
        $dropdown.='</select>';
		$dropdown.='<div class="'.$operationDivId.'"></div>';
			
		$dropdown.='<div id="'.$removeCancelDivId.'" class="'.$removeCancelDivId.'"><input type="button" class="removeitembtn" value="Remove" onclick="cancelNewOperationForNewItem(\''.$orderid.'\',\''.$newDivId.'\',\''.$cuisine.'\')"</div>';	
		$dropdown.='</div>';
       
        $infoArray = array();
		$infoArray['dropdown']        = $dropdown;
		$infoArray['columnNumber']    = $columnNumber;
		$infoArray['cuisine']         = $cuisine;
		$infoArray['itemcount']       = $itemcount;
		$infoArray['orderid']         = $orderid;
		
		echo json_encode($infoArray);
  }
  
  public  function itemcountinpreviousorderAction()
  {
      
     $params         = $this->getRequest()->getParams(); 
            
     $orderid        = $params['orderid'];
     $cuisine        = $params['cuisine'];
     $entityId        = $params['entityId'];

     $healOrder  = Mage::getModel("heal/order")->load($orderid);
     $customerEmail = $healOrder->getEmail();

     $connection     = Mage::getSingleton('core/resource')->getConnection('core_write');

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
     
     $product = Mage::getModel('catalog/product')->load($entityId);
     if($count10daysItem!='')
     {
         
         $finalOutput.='(10 Days:'.$count10daysItem.')';
     }
     
     if($count3daysItem!='')
     {
        
         $finalOutput.='(3 Days:'.$count3daysItem.')';
     }
     
     $finalOutput.= $product->getName();
         
     
     
     echo $finalOutput;
     
  }
  
  public function savenewitemAction()
  { 
  
                $params         = $this->getRequest()->getParams(); 
		$orderid        = $params['orderid'];
		$cuisine        = $params['cuisine'];
		$newDivId       = $params['newDivId'];
		$operationDivId = $params['operationDivId'];
		$columnNumber   = $params['columnNumber'];
		$dropdownId     = $params['dropdownId'];
		$entityId       = $params['entityId'];
		$newItemCount   = $params['newItemCount'];
		
                
		$product = Mage::getModel("catalog/product")->load($entityId);
		
		$dbWrite     = Mage::getSingleton('core/resource')->getConnection('core_write');
		$dbRead      = Mage::getSingleton('core/resource')->getConnection('core_read');

		$QgetCuisineRows = "SELECT * FROM healitemdetails WHERE orderid =".$orderid." AND cuisine = '$cuisine' and productid='".$entityId."'";
		$cuisineResult = $dbRead->fetchAll($QgetCuisineRows);

		if(count($cuisineResult)>0)
		{
		  echo "already";
		}
		else
		{
				$customerid=0;
				if(Mage::getSingleton('customer/session')->isLoggedIn()) {
				 $customerData = Mage::getSingleton('customer/session')->getCustomer();
				 $customerid = $customerData->getId();
				}
				

		
		
		
		$name    = $product->getName(); 
		$uom     = $product->getUnitofmeasure();
		$qty       = 0;
		$unitofnutritionDatabase = 100;
		
		$result= array();
		$protein	 = $product->getProtein();
		$fat		 = $product->getFat();
		$carbohydrates = $product->getCarbohydrates();
		$fiber		  = $product->getFiber();
		$calories     = $product->getCalories();
		
		
		
		$calculatedProtein=0;
		$calculatedFat=0;
		$calculatedCarbohydrates=0;
		$calculatedFiber=0;
		$calculatedCalories=0;
		
		
			 $calculatedProtein = ($protein/$unitofnutritionDatabase )* $qty; 
			 $result['calculatedProtein']=round($calculatedProtein);
		
		
		  $calculatedFat = ($fat/$unitofnutritionDatabase )* $qty;  
			$result['calculatedFat']= round($calculatedFat);
		
		
		
			  $calculatedCarbohydrates = ($carbohydrates/$unitofnutritionDatabase )* $qty; 
			  $result['calculatedCarbohydrates']= round($calculatedCarbohydrates);
		
							  
			
			
		
			$calculatedFiber = ($fiber/$unitofnutritionDatabase )* $qty; 
			$result['calculatedFiber']= round($calculatedFiber);
		
		
		
			$calculatedCalories = ($calories/$unitofnutritionDatabase )* $qty; 
			$result['calculatedCalories']= round($calculatedCalories);
		
		
		 $insertNewItem = "INSERT INTO `healitemdetails` (`orderid`, `cuisine`, `productid`, `itemname`, `qty`, `unitofmeasure`, `protein`,`fat`,`carbohydrates`,`fiber`,`calories`,`customerid`,`updatedby`) VALUES ('".$orderid."', '".$cuisine."', '".$entityId."', '".$name."', '".$qty."', '".$uom."', '".$result['calculatedProtein']."', '".$result['calculatedFat']."', '".$result['calculatedCarbohydrates']."', '".$result['calculatedFiber']."', '".$result['calculatedCalories']."', '".$customerid."', '');";

		  $dbWrite->query($insertNewItem); 
		  $qUpdate='';
		  
		  $qUpdateHealOrder = "select * from healorder where id=".$orderid;
		  $cuisineResult = $dbRead->fetchRow($qUpdateHealOrder); 
		  $qUpdate='';
		    if($cuisine=='dinner')
			{
			  $cuisine_items_desc = $cuisineResult['dinner_items_desc'];
			  $cuisine_items_desc_array= explode(",",$cuisine_items_desc);
			  $cuisine_items_desc_array[]= $name."_".$entityId."_1";
			 
			  $finalString  = implode(",",$cuisine_items_desc_array);
			   $qUpdate = "update healorder set dinner_items_desc='".$finalString."' where id=".$orderid;
			  $dbWrite->query($qUpdate); 
			}
			if($cuisine=='lunch')
			{
			  $cuisine_items_desc = $cuisineResult['lunch_items_desc'];
			  $cuisine_items_desc_array= explode(",",$cuisine_items_desc);
			  $cuisine_items_desc_array[]= $name."_".$entityId."_1";
			
			  $finalString  = implode(",",$cuisine_items_desc_array);
			   $qUpdate = "update healorder set lunch_items_desc='".$finalString."' where id=".$orderid;
			  $dbWrite->query($qUpdate); 
			}
			if($cuisine=='breakfast')
			{
			  $cuisine_items_desc = $cuisineResult['breakfast_items_desc'];
			  $cuisine_items_desc_array= explode(",",$cuisine_items_desc);
			  $cuisine_items_desc_array[]= $name."_".$entityId."_1";
			
			  $finalString  = implode(",",$cuisine_items_desc_array);
			   $qUpdate = "update healorder set breakfast_items_desc='".$finalString."' where id=".$orderid;
			  $dbWrite->query($qUpdate); 
			}
			if($cuisine=='hightea')
			{
			  $cuisine_items_desc = $cuisineResult['hightea_items_desc'];
			  $cuisine_items_desc_array= explode(",",$cuisine_items_desc);
			  $cuisine_items_desc_array[]= $name."_".$entityId."_1";
			
			  $finalString  = implode(",",$cuisine_items_desc_array);
			   $qUpdate = "update healorder set hightea_items_desc='".$finalString."' where id=".$orderid;
			  $dbWrite->query($qUpdate); 
			}
			
		 
			   
		  $healOrder  = Mage::getModel("heal/order")->load($orderid);
		  $healOrder->updaterowinfo($orderid);
			   
		  $hiddenRowInfo= implode(",",$result);  // keeps info of protein,fat,carbohydrates,fiber,calories
		  $backgroundColorForLikeDislike = Mage::helper("heal")->getStyleForLikeDislike($healOrder,$entityId);
		
  ?>
     <div class="formtr <?php echo $orderid;?>_<?php echo $cuisine;?>_<?php echo $entityId;?>">
					 <div class="formtd" style="text-align:left;text-align: justify;font-weight:normal;font-size: 13px;text-transform: Capitalize;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;<?php echo $backgroundColorForLikeDislike;?>"><?php echo $name;?></div>
		<div class="formtd" style="width:27%;">
			 <input type="button" id="plus_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>" value="+" onclick="operation('plus','<?php echo $orderid;?>','<?php echo $entityId;?>','<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>','hiddenUOM_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>','hiddenRowInfo_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>','labelprotein_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>','labelfat_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>','labelcarbohydrate_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>','labelfiber_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>','labelcalories_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>',
			 'hiddenProtein-<?php echo $orderid;?>-<?php echo $cuisine;?>_items_desc-<?php echo $newItemCount;?>','hiddenFat-<?php echo $orderid;?>-<?php echo $cuisine;?>_items_desc-<?php echo $newItemCount;?>','hiddenCarbohydrates-<?php echo $orderid;?>-<?php echo $cuisine;?>_items_desc-<?php echo $newItemCount;?>','hiddenFiber-<?php echo $orderid;?>-<?php echo $cuisine;?>_items_desc-<?php echo $newItemCount;?>','hiddenCalories-<?php echo $orderid;?>-<?php echo $cuisine;?>_items_desc-<?php echo $newItemCount;?>','100')">       

				 <input style="width: 20%" type="text" value="<?php echo $qty;?>" id="<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>" class="<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>"> 

				 <input type="button" id="minus_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>" value="-" onclick="operation('minus','<?php echo $orderid;?>','<?php echo $entityId;?>','<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>','hiddenUOM_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>','hiddenRowInfo_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>','labelprotein_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>','labelfat_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>','labelcarbohydrate_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>','labelfiber_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>','labelcalories_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>',
			 'hiddenProtein-<?php echo $orderid;?>-<?php echo $cuisine;?>_items_desc-<?php echo $newItemCount;?>','hiddenFat-<?php echo $orderid;?>-<?php echo $cuisine;?>_items_desc-<?php echo $newItemCount;?>','hiddenCarbohydrates-<?php echo $orderid;?>-<?php echo $cuisine;?>_items_desc-<?php echo $newItemCount;?>','hiddenFiber-<?php echo $orderid;?>-<?php echo $cuisine;?>_items_desc-<?php echo $newItemCount;?>','hiddenCalories-<?php echo $orderid;?>-<?php echo $cuisine;?>_items_desc-<?php echo $newItemCount;?>','100')">

		 <div id="showCalory1">
						<label id="labelprotein_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>" style="display:none;"></label><br>
						 <label id="labelfat_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>"  style="display:none;"></label><br>
						 <label id="labelcarbohydrate_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>"  style="display:none;"></label><br>
						 <label id="labelfiber_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>"  style="display:none;"></label><br>
						 <br>
					 <input type="hidden" class="productid-<?php echo $orderid;?>-<?php echo $cuisine;?>_items_desc-<?php echo $newItemCount;?>" id="productid-<?php echo $orderid;?>-<?php echo $cuisine;?>_items_desc-<?php echo $newItemCount;?>" value="<?php echo $entityId;?>"> 

					<input type="hidden" class="hiddenProtein-<?php echo $orderid;?>-<?php echo $cuisine;?>_items_desc-<?php echo $newItemCount;?>" id="hiddenProtein-<?php echo $orderid;?>-<?php echo $cuisine;?>_items_desc-<?php echo $newItemCount;?>" value="<?php echo $result['calculatedProtein'];?>">

					<input type="hidden" class="hiddenFat-<?php echo $orderid;?>-<?php echo $cuisine;?>_items_desc-<?php echo $newItemCount;?>" id="hiddenFat-<?php echo $orderid;?>-<?php echo $cuisine;?>_items_desc-<?php echo $newItemCount;?>" value="<?php echo $result['calculatedFat'];?>">

					<input type="hidden" class="hiddenCarbohydrates-<?php echo $orderid;?>-<?php echo $cuisine;?>_items_desc-<?php echo $newItemCount;?>" id="hiddenCarbohydrates-<?php echo $orderid;?>-<?php echo $cuisine;?>_items_desc-<?php echo $newItemCount;?>" value="<?php echo $result['calculatedCarbohydrates'];?>">

					<input type="hidden" class="hiddenFiber-<?php echo $orderid;?>-<?php echo $cuisine;?>_items_desc-<?php echo $newItemCount;?>" id="hiddenFiber-<?php echo $orderid;?>-<?php echo $cuisine;?>_items_desc-<?php echo $newItemCount;?>" value="<?php echo $result['calculatedFiber'];?>">

					<input type="hidden" class="hiddenCalories-<?php echo $orderid;?>-<?php echo $cuisine;?>_items_desc-<?php echo $newItemCount;?>" id="hiddenCalories-<?php echo $orderid;?>-<?php echo $cuisine;?>_items_desc-<?php echo $newItemCount;?>" value="<?php echo $result['calculatedCalories'];?>">


					<input type="hidden" class="hiddenUOM_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>" id="hiddenUOM_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>" value="<?php echo $uom;?>">

		 <input type="hidden" class="hiddenRowInfo_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>" id="hiddenRowInfo_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>" value="<?php echo $hiddenRowInfo;?>">


					<input type="hidden" name="attributeName" value="<?php echo $cuisine;?>_items_desc">
					<input type="hidden" name="rowid" value="<?php echo $orderid;?>">
			</div>

		</div> 
		
	        <div class="formtd" style="text-align:center;width:40%">
                     Cal<label class="labelcalories_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>" id="labelcalories_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>">:<?php echo $result['calculatedCalories'];?></label>, Carbs <label class="labelcarbohydrate_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>" id="labelcarbohydrate_<?php echo $orderid;?>_<?php echo $cuisine;?>_items_desc_<?php echo $newItemCount;?>">:<?php echo $result['calculatedCarbohydrates'];?></label>
		    </div>		
			 <span class="deleteImg" onclick="deleteItem('<?php echo $orderid;?>','<?php echo $cuisine;?>','<?php echo $entityId;?>','<?php echo $newItemCount;?>')"></span> 
</div>
  <?php 
      
     }
  }
  
  public function getcustomernamesAction()
  {
	    $params      = $this->getRequest()->getParams(); 
		$orderdate   = $params['orderDate'];
		$city        = $params['city'];
		$dateInfo = explode("/",$orderdate);
		
		$tmpOrderdateToShow = $dateInfo[2]."-".$dateInfo[0]."-".$dateInfo[1];	
		$month = date("M",strtotime($tmpOrderdateToShow));
		$orderdateToShow = $dateInfo[1]."-".$month."-".$dateInfo[2];
		
		$dbRead      = Mage::getSingleton('core/resource')->getConnection('core_read');
		$selectDatewiseOrders= "select * from healorder where city='".ucfirst($city)."' and orderdate='$orderdate'"; 
		$cuisineResult = $dbRead->fetchAll($selectDatewiseOrders);
		
		$countCustomer =0 ;
		if(count($cuisineResult)>0)
		{
		   
			$cuisineItemsDesc = array();
			$result="<table cellpadding='2' cellspacing='2' border='1'>";
			$result.="<tr><td colspan='4' valign='top'>City: <strong>".ucfirst($city)."</strong>, Meal Date: <strong>". $orderdateToShow."</strong></td></tr>";
			$result.="<tr align='center'><th>No</th><th>Customer Name</th><th>Order Details</th><th class='noprint'>Delete Meal</th></tr>";
			foreach($cuisineResult as $row)
			{
			   ++$countCustomer;
			  $orderId               =  $row['id'];	
			  $dinner_items_desc     = 	$row['dinner_items_desc'];    $cuisineItemsDesc['dinner'] = $dinner_items_desc;
			  $breakfast_items_desc  = 	$row['breakfast_items_desc']; $cuisineItemsDesc['breakfast'] = $breakfast_items_desc;
			  $lunch_items_desc      = 	$row['lunch_items_desc'];     $cuisineItemsDesc['lunch'] = $lunch_items_desc;
			  $hightea_items_desc    = 	$row['hightea_items_desc'];	  $cuisineItemsDesc['hightea'] = $hightea_items_desc;

			  
				
			  //$customerEmail = $row['email']; 
			  $customer='';
			  $customer = Mage::getModel("customer/customer"); 
			  $customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
			  $customer->load($row['customerid']);
			  $customerName = 	$customer->getFirstname()." ".$customer->getLastname();	
			  $customerName= str_replace("Dear ","",$customerName);
			  
			  $result.="<tr><td valign='top'>".$countCustomer."</td><td valign='top'>".$customerName."</td>";
			  $result.="<td valign='top'><table cellpadding='2' cellspacing='2' border='0'><tr>";	
			
			  foreach($cuisineItemsDesc as $cuisine=>$itemDesc)
			  {
				 $result.="<td valign='top'><table cellpadding='2' cellspacing='2' border='1'>";
				 $result.="<tr><td colspan='3'>".ucfirst($cuisine)."</td></tr>";
				 $result.="<tr><td>No</td><td>Itemname</td><td>Qty</td></tr>";
				 $cuisineDescItems = explode(",",$itemDesc);
				  
				 if((count($cuisineDescItems)-1)>0)
				 {
				   $countRow=0;
				   foreach($cuisineDescItems as $singleItem)
					{
						  $singleItemInfo = explode("_",$singleItem);

						  $productid = $singleItemInfo[1]; 

						  $QgetOrderItemsDetails = "select * from  healitemdetails where orderid='$orderId' and cuisine='$cuisine' and productid='$productid'" ; 

						  $orderItems='';
						  $orderItems = $dbRead->fetchAll($QgetOrderItemsDetails) ;

						 if(count($orderItems) >0)
						 {
							  foreach($orderItems as $orderdetailitem)
							  {
								  ++$countRow;
								  $healitemProductid =  trim($orderdetailitem['productid']);
								  $qty               =  trim($orderdetailitem['qty']);
								  $itemname          =  trim($orderdetailitem['itemname']);
								  $result.="<tr><td>". $countRow."</td><td>".$itemname."</td><td>".$qty."</td></tr>";
							  }
						}
				  }
			   }
			   else
			   {
					$result.="<tr><td colspan='3'>No items</td></tr>";
				}
				$result.="</table></td>";
			 }	
			  
			   $result.="</tr></table>";
			   $result.="</td><td  valign='top' class='noprint'><span class='deleteImg' onclick='deleteMeal(\"".$orderId."\",\"".$customerName."\");'></span></td></tr>";		
		}
		$result.='<tr><td colspan="4"><input type="button" name="print" value="print" onclick="print();" /></td></tr>';
		$result.="</table>";
			echo $result;
	  }
		
	}
	
	public function deletemealAction()
	{
	  $params         = $this->getRequest()->getParams(); 
	  $orderid        = $params['orderid'];
	  $dbWrite     = Mage::getSingleton('core/resource')->getConnection('core_write');
	  $dbRead      = Mage::getSingleton('core/resource')->getConnection('core_read');
	  
	  $selectOrder= "select * from healorder where id='".$orderid."'"; 
	  $cuisineResult = $dbRead->fetchAll($selectOrder);
	  
	  if(count($cuisineResult)>0)
	  {
	    echo $deleteOrder= "delete  from healorder where id='".$orderid."'"; 
		$dbWrite->query($deleteOrder);
		
		echo $deleteOrderItems= "delete  from healitemdetails where orderid='".$orderid."'";
		$dbWrite->query($deleteOrderItems);
		
	  }
	}
	public function likeAction(){ 
		$params = $this->getRequest()->getParams(); 
		$customerid = $params['customerid'];
		$customername = $params['name'];
		$customermobile = trim($params['mobile']);
		$productname = $params['productname'];
		$productid = trim($params['productid']);
		$like = $params['like'];
		$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
		$checkdataexist = "SELECT * FROM `heal_order_review` WHERE `customerid` = '".$customerid."' AND `productid` = '".$productid."' ";
		$datacheck = $connection->query($checkdataexist);
        $check_fetch = $datacheck->fetch();
        if (!$check_fetch) {
        	$insertData = "INSERT INTO `heal_order_review` (`id`, `customerid`, `customername`, `customermobile`, `productid`, `productname`, `like`) VALUES (NULL, '".$customerid."', '".$customername."', '".$customermobile."', '".$productid."', '".$productname."', '".$like."' );";
          $couts = count($connection->query($insertData));
          $results = " Data has been saved! ";
        }else{
        	$updateData = "UPDATE `heal_order_review` SET `customerid` = '".$customerid."', `customername` = '".$customername."', `customermobile` = '".$customermobile."', `productid` = '".$productid."', `productname` = '".$productname."', `like` =  '".$like."', `dislike` = '0' WHERE `customerid` = '".$customerid."' AND `productid` =  '".$productid."' ";
          $connection->query($updateData);
          $results = " Data has been updated! ";
        }
        $response =  array("status" => 200, "results" => $results);
        return print_r($response);	

	}
	public function dislikeAction(){ 
		$params = $this->getRequest()->getParams(); 
		$customerid = $params['customerid'];
		$customername = $params['name'];
		$customermobile = $params['mobile'];
		$productname = $params['productname'];
		$productid = $params['productid'];
		$dislike = $params['dislike'];
		$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
		$checkdataexist = "SELECT * FROM `heal_order_review` WHERE `customerid` = '".$customerid."' AND `productid` = '".$productid."' ";
		$datacheck = $connection->query($checkdataexist);
        $check_fetch = $datacheck->fetch();
        if (!$check_fetch) {
        	$insertData = "INSERT INTO `heal_order_review` (`id`, `customerid`, `customername`, `customermobile`, `productid`, `productname`, `dislike`) VALUES (NULL, '".$customerid."', '".$customername."', '".$customermobile."', '".$productid."', '".$productname."', '".$dislike."' );";
          $couts = count($connection->query($insertData));
          $results = " Data has been saved! ";
        }else{
        	$updateData = "UPDATE `heal_order_review` SET `customerid` = '".$customerid."', `customername` = '".$customername."', `customermobile` = '".$customermobile."', `productid` = '".$productid."', `productname` = '".$productname."', `dislike` =  '".$dislike."', `like` = '0' WHERE `customerid` = '".$customerid."' AND `productid` =  '".$productid."' ";
          $connection->query($updateData);
          $results = " Data has been updated! ";
        }
        $response =  array("status" => 200, "results" => $results);
        return print_r($response);
	}
	public function addallergiesAction(){ 
		$params = $this->getRequest()->getParams(); 
		$mobile = $params['primarymobileno'];
		$customerids = $params['customerids'];
		$customername = $params['customername'];
		$productname = $params['productname'];
		$productid = $params['productid'];
		$mild = $params['mild'];
		$nonspicy = $params['nonspicy'];
		$extraspicy = $params['extraspicy'];
		$lesschewy = $params['lesschewy'];
		$morechewy = $params['morechewy'];
		$dry = $params['dry'];
		$lipoma = $params['lipoma'];
		$gravy = $params['gravy'];
		$lessmasala = $params['lessmasala'];
		$moremasala = $params['moremasala'];
		$allergiesboxes = preg_replace('/[^A-Za-z0-9\-]/', ' ', $params['allergiesboxes']);		
		$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
        
        $checkdataexist = "SELECT * FROM `heal_dislikes` WHERE `customerid` = '".$customerids."' AND `productid` = '".$productid."' ";

        $datacheck = $connection->query($checkdataexist);
        $check_fetch = $datacheck->fetch();
        if (!$check_fetch) {
           $insertData = "INSERT INTO `heal_dislikes` (`id`, `customerid`, `customername`, `customermobile`, `productid`, `productname`, `mild`, `nonspicy`,`extraspicy`,`lesschewy`,`morechewy`,`dry`,`lipoma`,`gravy`,`lessmasala`,`moremasala`, `superdislike`) VALUES (NULL, '".$customerids."', '".$customername."', '".$mobile."', '".$productid."', '".$productname."', '".$mild."', '".$nonspicy."', '".$extraspicy."', '".$lesschewy."', '".$morechewy."', '".$dry."', '".$lipoma."', '".$gravy."', '".$lessmasala."', '".$moremasala."', '".$allergiesboxes."');";
          $couts = count($connection->query($insertData));
          $results = " Data has been saved! ";
        }else{
           $updateData = "UPDATE `heal_dislikes` SET `customerid` = '".$customerids."', `customername` = '".$customername."', `customermobile` = '".$mobile."', `productid` = '".$productid."', `productname` = '".$productname."', `mild` =  '".$mild."', `nonspicy` = '".$nonspicy."',  `extraspicy` = '".$extraspicy."',  `lesschewy` = '".$lesschewy."', `morechewy` = '".$morechewy."', `dry` = '".$dry."', `lipoma` = '".$lipoma."', `gravy` = '".$gravy."', `lessmasala` = '".$lessmasala."',`moremasala` = '".$moremasala."',`superdislike` =  '".$allergiesboxes."' WHERE `customerid` = '".$customerids."' AND `productid` =  '".$productid."' ";
          $connection->query($updateData);
          $results = " Data has been updated! ";
        }
        $response =  array("status" => 200, "results" => $results);
        return print_r($response);
		
	}
	
	public function getBPjsondataAction(){ 
		$params = $this->getRequest()->getParams(); 
		$customerid = $params['customerid'];

		$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
		$checkdataexist = "SELECT upperbp,lowerbp FROM `graphinfo` WHERE `customerid` = '".$customerid."' ";
		$datacheck = $connection->query($checkdataexist);
		$alldata = $datacheck->fetchAll();
		//echo "<pre>"; print_r($alldata); 
        $data = array();
       /* [["upperbp","lowerbp"],["80","90"],["130","90"],["140","120"],["155","110"],["158","78"],["145","95"],["155","89"]]
       */
        $encoded='[["upperbp","lowerbp"]';
        foreach ($alldata as  $key => $value) {
        	//$data[$key] = $value;
        	$encoded.=','.'["'.$value["upperbp"].'"'.','.$value["lowerbp"].']';
        }
        $encoded.=']';
       // $encoded = $this->convertDataToChartForm($data);
		//return print_r($encoded);
		echo $encoded;

	}

	function convertDataToChartForm($data) {
    $newData = array();
    $firstLine = true;
    foreach ($data as $dataRow) {
        if ($firstLine) {
            $newData[] = array_keys($dataRow);
            $firstLine = false;
        }
        $newData[] = array_values($dataRow);
    }
    return json_encode($newData);
    }	
 
    public function insetBpRecordsAction(){ 
    	$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
    	$params = $this->getRequest()->getParams();
		$customerid = $params['customerid'];
		$lowerbp = $params['lowerbp'];
		$upperbp = $params['upperbp'];
		$currentdate = Mage::getModel('core/date')->gmtDate('Y-m-d');
		$checkdataexist = "SELECT * FROM `weeklyclientinfo` WHERE `customerid` = '".$customerid."' AND `date` = '".$currentdate."' ";

        $datacheck = $connection->query($checkdataexist);
        $check_fetch = $datacheck->fetch();
        if (!$check_fetch) {
		$insertData = "INSERT INTO `weeklyclientinfo` (`clientid`, `name`, `email`, `customerid`, `mobile`, `upperbp`, `lowerbp`, `date`) VALUES (NULL, '".str_replace(",","",$params['name'])."', '".$params['email']."', '".$customerid."', '".$params['mobile']."', '".$upperbp."', '".$lowerbp."', '".$currentdate."');";
        $counts = count($connection->query($insertData));
        $results = " Your data has been created! ";
    	}else{
		$updateData = "UPDATE weeklyclientinfo SET upperbp='".$upperbp."', lowerbp = '".$lowerbp."' WHERE  customerid='".$customerid."' and date ='".$currentdate."' ";
        $connection->query($updateData);
		$results = " Your data has been updated! ";
    	}
    	$graphinfo = Mage::helper("weeklyclientinfo")->checkDiseaseLevel();
    	$response =  array("status" => 200, "results" => $results, "graphdata" => $graphinfo);
		echo json_encode($response);
        //return print_r($response);
    }

    public function insetTGRecordsAction(){ 
    	$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
    	$params = $this->getRequest()->getParams(); 
		$customerid = $params['customerid'];
		$tgvalue = $params['tg'];
		$currentdate = Mage::getModel('core/date')->gmtDate('Y-m-d');
		$checkdataexist = "SELECT * FROM `weeklyclientinfo` WHERE `customerid` = '".$customerid."' AND `date` = '".$currentdate."' ";

        $datacheck = $connection->query($checkdataexist);
        $check_fetch = $datacheck->fetch();
        if (!$check_fetch) {
		$insertData = "INSERT INTO `weeklyclientinfo` (`clientid`, `name`, `email`, `customerid`, `mobile`, `tg`, `date`) VALUES (NULL, '".str_replace(",","",$params['name'])."', '".$params['email']."', '".$customerid."', '".$params['mobile']."', '".$tgvalue."', '".$currentdate."');";
        $counts = count($connection->query($insertData));
        $results = " Your data has been created! ";
        $response =  array("status" => 200, "results" => $results);
    	}else{
		$updateData = "UPDATE weeklyclientinfo SET tg='".$tgvalue."' WHERE  customerid='".$customerid."' and date ='".$currentdate."' ";
        $connection->query($updateData);
		$results = " Your data has been updated! ";
        $response =  array("status" => 200, "results" => $results);
    	}
    	$graphinfo = Mage::helper("weeklyclientinfo")->checkDiseaseLevel();
    	$response =  array("status" => 200, "results" => $results, "graphdata" => $graphinfo);
		echo json_encode($response);
    }   
    public function insetHDLRecordsAction(){ 
    	$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
    	$params = $this->getRequest()->getParams(); 
		$customerid = $params['customerid'];
		$hdlvalue = $params['hdl'];
		$currentdate = Mage::getModel('core/date')->gmtDate('Y-m-d');
		$checkdataexist = "SELECT * FROM `weeklyclientinfo` WHERE `customerid` = '".$customerid."' AND `date` = '".$currentdate."' ";

        $datacheck = $connection->query($checkdataexist);
        $check_fetch = $datacheck->fetch();
        if (!$check_fetch) {
		$insertData = "INSERT INTO `weeklyclientinfo` (`clientid`, `name`, `email`, `customerid`, `mobile`, `hdl`, `date`) VALUES (NULL, '".str_replace(",","",$params['name'])."', '".$params['email']."', '".$customerid."', '".$params['mobile']."', '".$hdlvalue."', '".$currentdate."');";
        $counts = count($connection->query($insertData));
        $results = " Your data has been created! ";
        $response =  array("status" => 200, "results" => $results);
    	}else{
		$updateData = "UPDATE weeklyclientinfo SET hdl='".$hdlvalue."' WHERE  customerid='".$customerid."' and date ='".$currentdate."' ";
        $connection->query($updateData);
		$results = " Your data has been updated! ";
        $response =  array("status" => 200, "results" => $results);
    	}
    	$graphinfo = Mage::helper("weeklyclientinfo")->checkDiseaseLevel();
    	$response =  array("status" => 200, "results" => $results, "graphdata" => $graphinfo);
		echo json_encode($response);
    }  
    public function insetFstGlucoseRecordsAction(){ 
    	$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
    	$params = $this->getRequest()->getParams(); 
		$customerid = $params['customerid'];
		$fastingglvalue = $params['fastinggl'];
		$currentdate = Mage::getModel('core/date')->gmtDate('Y-m-d');
		$checkdataexist = "SELECT * FROM `weeklyclientinfo` WHERE `customerid` = '".$customerid."' AND `date` = '".$currentdate."' ";

        $datacheck = $connection->query($checkdataexist);
        $check_fetch = $datacheck->fetch();
        if (!$check_fetch) {
		$insertData = "INSERT INTO `weeklyclientinfo` (`clientid`, `name`, `email`, `customerid`, `mobile`, `fastinggl`, `date`) VALUES (NULL, '".str_replace(",","",$params['name'])."', '".$params['email']."', '".$customerid."', '".$params['mobile']."', '".$fastingglvalue."', '".$currentdate."');";
        $counts = count($connection->query($insertData));
        $results = " Your data has been created! ";
        $response =  array("status" => 200, "results" => $results);
    	}else{
		$updateData = "UPDATE weeklyclientinfo SET fastinggl='".$fastingglvalue."' WHERE  customerid='".$customerid."' and date ='".$currentdate."' ";
        $connection->query($updateData);
		$results = " Your data has been updated! ";
        $response =  array("status" => 200, "results" => $results);
    	}
    	$graphinfo = Mage::helper("weeklyclientinfo")->checkDiseaseLevel();
    	$response =  array("status" => 200, "results" => $results, "graphdata" => $graphinfo);
		echo json_encode($response);
    }   

    public function insetheightwaistRecordsAction(){ 
    	$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
    	$params = $this->getRequest()->getParams(); 
		$customerid = $params['customerid'];
		$waist = $params['waist'];
		$height = $params['height'];
		$currentdate = Mage::getModel('core/date')->gmtDate('Y-m-d');
		$checkdataexist = "SELECT * FROM `weeklyclientinfo` WHERE `customerid` = '".$customerid."' AND `date` = '".$currentdate."' ";

        $datacheck = $connection->query($checkdataexist);
        $check_fetch = $datacheck->fetch();
        if (!$check_fetch) {
		$insertData = "INSERT INTO `weeklyclientinfo` (`clientid`, `name`, `email`, `customerid`, `mobile`, `waist`, `height`, `date`) VALUES (NULL, '".str_replace(",","",$params['name'])."', '".$params['email']."', '".$customerid."', '".$params['mobile']."', '".$waist."', '".$height."', '".$currentdate."');";
        $counts = count($connection->query($insertData));
        $results = " Your data has been created! ";
        $response =  array("status" => 200, "results" => $results);
    	}else{
		$updateData = "UPDATE weeklyclientinfo SET waist='".$waist."', height = '".$height."' WHERE  customerid='".$customerid."' and date ='".$currentdate."' ";
        $connection->query($updateData);
		$results = " Your data has been updated! ";
        $response =  array("status" => 200, "results" => $results);
    	}
    	$graphinfo = Mage::helper("weeklyclientinfo")->checkDiseaseLevel();
    	$response =  array("status" => 200, "results" => $results, "graphdata" => $graphinfo);
		echo json_encode($response);
    }   

    public function addAllergiesDislikeAction(){ 
    	$params = $this->getRequest()->getParams(); 
		$customerid = $params['customerid'];
		$customername = $params['customername'];
		$customermobile = $params['customermobile'];
		$allergies = trim($params['allergies']);
		$dislikename = trim($params['dislikename']);
		$notes = trim($params['notes']);
		$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
		$checkdataexist = "SELECT * FROM `heal_order_review` WHERE `customerid` = '".$customerid."' AND (`allergies` IS NOT NULL  OR `dislikename` IS NOT NULL  OR `notes` IS NOT NULL) AND `productid` = '' ";
		$datacheck = $connection->query($checkdataexist);
        $check_fetch = $datacheck->fetch();
        if (!$check_fetch) {
        	$insertData = "INSERT INTO `heal_order_review` (`id`, `customerid`, `customername`, `customermobile`, `allergies`, `dislikename`, `notes`) VALUES (NULL, '".$customerid."', '".$customername."', '".$customermobile."', '".$allergies."', '".$dislikename."' , '".$notes."');";
          $couts = count($connection->query($insertData));
          $results = " Data has been saved! ";
        }else{
          $updateData = "UPDATE `heal_order_review` SET `customerid` = '".$customerid."', `customername` = '".$customername."', `customermobile` = '".$customermobile."', `allergies` = '".$allergies."', `dislikename` = '".$dislikename."', `notes` = '".$notes."' WHERE `customerid` = '".$customerid."' AND (`allergies` IS NOT NULL OR `dislikename` IS NOT  NULL OR `notes` IS NOT  NULL) AND  `productid` = '' ";
          $connection->query($updateData);
          $results = " Data has been updated! ";
        }
        $response =  array("status" => 200, "results" => $results);
        return print_r($response);
    } 
    public function insertAccountsAction(){ 
	$params = $this->getRequest()->getParams(); 
	$mobile = trim($params['mobile']);
	$name = trim($params['name']);
	$email = trim($params['email']);
	$websiteId = Mage::app()->getWebsite()->getId();
	$store = Mage::app()->getStore();
	$customer = Mage::getModel("customer/customer");
	$customer   ->setWebsiteId($websiteId)
	            ->setStore($store)
	            ->setFirstname($name)
	            ->setLastname($name)
	            ->setPrimarymobileno($mobile)
	            ->setEmail($email)
	            ->setPassword($mobile);
	 
	try{
	    $customer->save();
	    $response =  array("status" => 200, "results" => "Success");
    	return print_r($response);
	}
	catch (Exception $e) {
	    Zend_Debug::dump($e->getMessage());
	    $response =  array("status" => 200, "results" => $e->getMessage());
    	return print_r($response);
	}
    }
	
	public function setspecialinstructionsAction()
	{
		 $params = $this->getRequest()->getParams();
		 $orderid = $params['orderid'];
		 $special_instructions = $params['spi'];//die;
         $order = Mage::getModel('heal/order')->load($orderid);
		 $order->setSpecialInstructions($special_instructions);
		 $order->save();
		 echo "Instructions saved";
	}
	
	public function getrowdataAction()
	{ 
		$params = $this->getRequest()->getParams();
		$orderid = $params['orderid']; // die;
		$healOrder = Mage::getModel('heal/order')->load($orderid);
        $customerEmail = $healOrder->getEmail(); 
        
        $orderDate = date("d-m-Y",strtotime($healOrder->getFormattedOrderdate()));
		$customer = Mage::getModel("customer/customer"); 
		$customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
		$customer->loadByEmail($customerEmail);
		$customerName = str_replace("Dear ","",$customer->getFirstname()." ".$customer->getLastname());
        $pdfFilename = trim($customerName)."-".$orderDate.".pdf";    
		$license ="P3Axgf8TynOV";		
		
		$print_save_customerReviewBtns='<div  id="buttonRow_'.$orderid.'" class="submitbtn buttonRow_'.$orderid.'">
		<input type="button" name ="'.$orderid.'" value="Save Changes"  id="'.$orderid.'" class="'.$orderid.'" onClick="doFinalCalculation(this.id,\'yes\',\'no\',\'yes\')" style="margin: 0px 5px 0px 0px;"/>
        <span id="savemsg_'.$orderid.'" class="savemsg_'.$orderid.'"></span>
        <input type="button"  class="myBtn_'.$orderid.'" id="myBtn_'.$orderid.'" style="margin: 0px 0px 0px 5px;" value="Save and Print"  onClick="doFinalCalculation('.$orderid.',\'yes\',\'yes\',\'yes\')" />
         <a  href="'.Mage::getBaseUrl().'dislikedetails?id='.$orderid.'" target="_blank"  class="myBtn_'.$item['id'].'" 
style="display: inline-block;width: 20%;background: #36b993; margin: 0px 0px 0px 5px;color: #fff !important; line-height: 40px; height: 40px; text-transform: uppercase; border: 2px solid #36b993;text-align: center;font-size: 1rem !important;"> Customer Review </a>
          <a  href="https://pdfmyurl.com/api?license='.$license.'&url='.Mage::getBaseUrl().'heal/index/print?id='.$orderid.'&print=print&content[hideondownload1]=hide&content[hideondownload2]=hide&page_size=A2&orientation=portrait&filename='.$pdfFilename.'" target="_blank"  class="myBtn_'.$item['id'].'" style="display: inline-block;width: 20%;background: #36b993; margin: 0px 0px 0px 5px;color: #fff !important; line-height: 40px; height: 40px; text-transform: uppercase; border: 2px solid #36b993;text-align: center;font-size: 1rem !important;"> Download PDF </a>        
</div>';
		
		
		$mealArray = array();
		$mealArray['dinner'] =  Mage::helper("heal")->updateItems($healOrder,$orderid,'dinner',$healOrder->getDinnerItemsDesc(),$attributeName='dinner_items_desc' );
		$mealArray['breakfast'] =  Mage::helper("heal")->updateItems($healOrder,$orderid,'breakfast',$healOrder->getBreakfastItemsDesc(),$attributeName='breakfast_items_desc' );
		$mealArray['lunch'] =  Mage::helper("heal")->updateItems($healOrder,$orderid,'lunch',$healOrder->getLunchItemsDesc(),$attributeName='lunch_items_desc' );
		$mealArray['hightea'] =  Mage::helper("heal")->updateItems($healOrder,$orderid,'hightea',$healOrder->getHighteaItemsDesc(),$attributeName='hightea_items_desc' );
		$mealArray['btnsPrintSaveReview'] = $print_save_customerReviewBtns;
		
		
		
		
		echo json_encode($mealArray);
	}

	public function potcontrollerAction(){
    $params = $this->getRequest()->getParams();
    $sentreceived = trim($params['sentreceived']);
    $orderid = trim($params['orderid']);
    $ssbox = $params['ssbox'];
    $srssbox = $params['srssbox'];
    $submittedby = $params['submittedby'];
    $currentTimestamp = Mage::getModel('core/date')->date('Y-m-d H:i:s');

    $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
    $checkdataexist = "SELECT * FROM `healorder` WHERE `id` = '".$orderid."' ";
    $datacheck = $connection->query($checkdataexist);
    $check_fetch = $datacheck->fetch();
        if( $_FILES['image'] ){
            try {
                $uploader = new Varien_File_Uploader('image');
                $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);
                $path = Mage::getBaseDir() . DS . 'media/potcount' . DS ;
                $filename=$_FILES["image"]["name"];
        $extension=end(explode(".", $filename));
        $newfilename=$orderid .".".$extension; 
                //$path = Mage::getBaseDir('media/potcount') . DS;
                 // where we save images
                $result = $uploader->save($path, $newfilename);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        if (!empty($check_fetch)) {
          $checkRecord = "SELECT * FROM `healpotcount` WHERE `orderid` = '".$orderid."' AND  `sentreceived` = '".$sentreceived."' ";
      $dataRecord = $connection->query($checkRecord);
          $Recordfetch = $dataRecord->fetch();
          $orderDate = $check_fetch['orderdate'];
          if (empty($Recordfetch)) {
            $insertData = "INSERT INTO `healpotcount` (`id`, `orderid`, `sentreceived`, `ssbox`, `srssbox`, `submittedby` ,`image`, `orderdate` , `timestamp`) VALUES (NULL, '".$orderid."', '".$sentreceived."', '".$ssbox."', '".$srssbox."', '".$submittedby."' , '".$newfilename."' ,'".$orderDate."' , '".$currentTimestamp."')";
              $couts = count($connection->query($insertData));
              $results = " Record has been saved! ";
          }else{
            $updateData = "UPDATE `healpotcount` SET `ssbox` = '".$ssbox."', `srssbox` = '".$srssbox."', `submittedby` = '".$submittedby."', `image` = '".$newfilename."', `modifiedtimestamp` = '".$currentTimestamp."' WHERE `sentreceived` = '".$sentreceived."' AND  `orderid` = '".$orderid."' ";
              $connection->query($updateData);
              $results = " Record has been updated! ";
          }           
        }else{
          $results = " No Record Found. Please enter corrent order id. ";
        }
        $data = array("status" => 200, "results" => $results);
        $response =  json_encode($data);
        echo $response; exit();   
  	}

	public function potcountAction() {
        $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Pot Details"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Count"),
                "title" => $this->__("Pots"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("heal", array(
                "label" => $this->__("Pot Details"),
                "title" => $this->__("Pot Details")
		   ));

      $this->renderLayout(); 
   }

    public function deliveryreportAction() { 
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Delivery Reports"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("Home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("print", array(
                "label" => $this->__("Delivery Reports"),
                "title" => $this->__("Delivery Reports")
		   ));

      $this->renderLayout(); 	  
    }
	
	public function mealdetailsAction()
   {
        $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Meal Details"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("heal", array(
                "label" => $this->__("Meal Details"),
                "title" => $this->__("Meal Details")
		   ));

      $this->renderLayout(); 
	   
	  
   }
   
    public function meallabelAction()
   {
      
       $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Meal Labels"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("heal", array(
                "label" => $this->__("Meal Labels"),
                "title" => $this->__("Meal Labels")
		   ));
 
     $this->renderLayout(); 
	
	  
   }
   
    
   function getbaseitemsinfoAction()
   {
	   $params     = $this->getRequest()->getParams(); 
	 
       $productId  = $params['productid'];
	   $baseOrDish  = $params['baseordish'];
	   $product = Mage::getModel('catalog/product')->load($productId);
	   $productSku = $product->getSku();
	  //  echo "<pre>"; print_r($product);
	   $baseAssociatedSkus =  $product->getBaseAssociatedSku(); 
	   if($baseOrDish=='base')
		   {
		                $defaultBaseItemQty    = $product->getBaseQty()*1000;
						$baseItemUOM  = $product->getBaseUom();
						$defaultUOM='';
						if($baseItemUOM=='Kgs')
						{$defaultUOM = 'gm';}
					    else if($baseItemUOM=='Lt')
						{$defaultUOM = 'ml';}
		  $baseAssociatedSkus = $productSku."_".$defaultBaseItemQty."_".$defaultUOM;
		 }
	   ?>
	   <span id="baseItems">
	   <?php
	   if($baseAssociatedSkus!='')
	   {
		   $baseAssociatedSkuWeightArray = explode(",",$baseAssociatedSkus);
		  // echo "size=".sizeof($baseAssociatedSkuWeightArray); ?>
		  
		 <?php /* <div id="addNewItemDiv" style="margin-bottom:20px;">
			  <span> 
			  <input type="button" class="myaddbtn" name="add" id="add" onclick="showSelect('<?php echo  $productId;?>');"
			  value="+ Add New Item"  /></span>
			 <span id="selectResult">&nbsp;</span>
		 </div>*/?>
		  <script type="text/javascript">
		  function showSelect(productid)
		  {   var baseUrl = window.location.origin;
			  jQuery.ajax({
								url: baseUrl+'/heal/index/getNewItemsToAdd',
								type: "POST",
								data: {
										 productid: productid, 
									  },
									  success: function(response)
									  {  
										jQuery( "#selectResult" ).html(response);
									  }			   
					      });
		  }
		  
		  function convertQtyToCustomUnit(baseProductId)
		  {
			  var qtyTextId= "qty_"+baseProductId;
			  var unitValue = jQuery("#customUOM_"+baseProductId).find('option:selected').attr('unitValue');
			  jQuery("#"+qtyTextId).text(unitValue);
		  }
		  
		 function changePriceAfterWastage(baseQty,basePriceBeforewastage,baseWastagePrice,baseProtein,baseFat,baseFiber,baseCarbohydrate,basePriceAfterWastage,qtyTextId,qtyTextVal,productId,baseProductId,from)
		   {
			   
			   var customUOMUnitValue = jQuery("#customUOM_"+baseProductId).find('option:selected').attr('unitValue');
			   var customUOMVal = jQuery("#customUOM_"+baseProductId).find('option:selected').val();
			   var pricebeforewastage_baseProductId = 	jQuery("#pricebeforewastage_"+baseProductId).val();
               var wastage_baseProductId = 	jQuery("#wastage_"+baseProductId).val();			   
			   
			   if (typeof customUOMUnitValue !== 'undefined' && typeof customUOMVal !== 'undefined' )
				{
   		             if(from=='textbox')
					 {
						   
						 
							if(customUOMUnitValue=='0')
							{ 
							   
							   qtyTextVal = jQuery("#"+qtyTextId).val();
							}
							else
						   {
							   
							   qtyTextVal = customUOMUnitValue * jQuery("#"+qtyTextId).val();
							}
					 }
			       // alert(qtyTextVal+"____"+customUOMVal+"____"+customUOMUnitValue);
					
					
						
			   }
			   
			  // alert(qtyTextVal);
			   
			   if(isNaN(qtyTextVal))
			   {
				   alert("Please enter the correct weight");
				   return false;
			   }
			  // alert(basePriceAfterWastage);
			   if(isNaN(basePriceAfterWastage))
			   {
				   alert("Price for the item is not defined. ");
				   return false;
			   }
			   else
			   {
				 
				   
				   var calculatedCustomProtein = (baseProtein/baseQty)*qtyTextVal;
				   var calculatedCustomFat     = (baseFat/baseQty)*qtyTextVal;
				   var calculatedCustomFiber   = (baseFiber/baseQty)*qtyTextVal;
				   var calculatedCustomCarbs   = (baseCarbohydrate/baseQty)*qtyTextVal;
				   
				   var calculatedPricebeforewastage = (basePriceBeforewastage/baseQty)*qtyTextVal;
				   var calculatedWastagePrice = (baseWastagePrice/baseQty)*qtyTextVal;
				   
				  // alert("("+baseWastagePrice+"/"+baseQty+")*"+qtyTextVal);
				   var calculatedCustomPrice   = (basePriceAfterWastage/baseQty)*qtyTextVal;
				   
				   if(!isNaN(calculatedCustomProtein))
					{
						var  newProteinLabelId = "protein_"+baseProductId;
						document.getElementById(newProteinLabelId).innerHTML  = calculatedCustomProtein.toFixed(2);
                    }
										
					if(!isNaN(calculatedCustomFat))
					{
						var  newFatLabelId = "fat_"+baseProductId;
						document.getElementById(newFatLabelId).innerHTML  = calculatedCustomFat.toFixed(2);
                    }
				    
					if(!isNaN(calculatedCustomFiber))
					{
						var  newFiberLabelId = "fiber_"+baseProductId;
						document.getElementById(newFiberLabelId).innerHTML  = calculatedCustomFiber.toFixed(2);
                    }
					
					if(!isNaN(calculatedCustomCarbs))
					{
						var  newCarbsLabelId = "carbs_"+baseProductId;
						document.getElementById(newCarbsLabelId).innerHTML  = calculatedCustomCarbs.toFixed(2);
                    }
					
					if(!isNaN(calculatedPricebeforewastage))
					{
						var  newPricebeforewastageLabelId = "pricebeforewastage_"+baseProductId;
						document.getElementById(newPricebeforewastageLabelId).innerHTML  = calculatedPricebeforewastage.toFixed(2);
                    }
					
					if(!isNaN(calculatedWastagePrice))
					{
						var  newWastageLabelId = "wastageprice_"+baseProductId;
						document.getElementById(newWastageLabelId).innerHTML  = calculatedWastagePrice.toFixed(2);
                    }
				   
				   
				   
				   
				   if(!isNaN(calculatedCustomPrice))
					{
						var  newPriceLabelId = "price_"+baseProductId;
						document.getElementById(newPriceLabelId).innerHTML  = calculatedCustomPrice.toFixed(2);
                                 
					}
					else
					{
						alert("Price is not defined");		
 						jQuery("#qty_"+baseProductId).val(0);
					}
				   
				 	 updateQtyPriceProteinFatFiberCarbs(productId);   
					   
					 
 				 
				   
			   }

		   }
		   
		  function updateQtyPriceProteinFatFiberCarbs(productId)
		   {
			           var Totalweight=0;
				       jQuery(".baseQty").each(function(index,el){
						     if(jQuery(el).val()!='' && !isNaN(jQuery(el).val()))
							 {
						  	   var tmpWeight = parseFloat(jQuery(el).val());
						       Totalweight= tmpWeight + parseFloat(Totalweight);
							 }
					   });
					   jQuery("#totalWeight_"+productId).text(Totalweight.toFixed(2));
					   
					   
					   var TotalPrice=0;
				       jQuery(".basePrice").each(function(index,el){
					   if(jQuery(el).text()!='' && !isNaN(jQuery(el).text()))
					   {
						      var tmpPrice = parseFloat(jQuery(el).text());
							  if(!isNaN(tmpPrice))
							  {
						        TotalPrice = parseFloat(TotalPrice) + tmpPrice;
						       }
						  }
					   });
					   jQuery("#totalPrice_"+productId).text(TotalPrice.toFixed(2)); 
					   
					   var TotalProtein=0;
				       jQuery(".baseProtein").each(function(index,el){
					   if(jQuery(el).text()!='' && !isNaN(jQuery(el).text()))
					   {
						      var tmpProtein = parseFloat(jQuery(el).text());
							  if(!isNaN(tmpProtein))
							  {
						        TotalProtein = parseFloat(TotalProtein) + tmpProtein;
						       }
						  }
					   });
					   jQuery("#totalProtein_"+productId).text(TotalProtein.toFixed(2));

                       var TotalFat=0;
				       jQuery(".baseFat").each(function(index,el){
					   if(jQuery(el).text()!='' && !isNaN(jQuery(el).text()))
					   {
						      var tmpFat = parseFloat(jQuery(el).text());
							  if(!isNaN(tmpFat))
							  {
						        TotalFat = parseFloat(TotalFat) + tmpFat;
						       }
						  }
					   });
					   jQuery("#totalFat_"+productId).text(TotalFat.toFixed(2));  	

                       var TotalFiber=0;
				       jQuery(".baseFiber").each(function(index,el){
					   if(jQuery(el).text()!='' && !isNaN(jQuery(el).text()))
					   {
						      var tmpFiber = parseFloat(jQuery(el).text());
							  if(!isNaN(tmpFiber))
							  {
						        TotalFiber = parseFloat(TotalFiber) + tmpFiber;
						       }
						  }
					   });
					   jQuery("#totalFiber_"+productId).text(TotalFiber.toFixed(2)); 

                       var TotalCarbs=0;
				       jQuery(".baseCarbs").each(function(index,el){
					   if(jQuery(el).text()!='' && !isNaN(jQuery(el).text()))
					   {
						      var tmpCarbs = parseFloat(jQuery(el).text());
							  if(!isNaN(tmpCarbs))
							  {
						        TotalCarbs = parseFloat(TotalCarbs) + tmpCarbs;
						       }
						  }
					   });
					   jQuery("#totalCarbs_"+productId).text(TotalCarbs.toFixed(2));  					   
                          					   
		   }
		   
		   
		  function saveSelectedItem(productid,selectItemId)
		  { 
		      var selectedBaseItemId =  jQuery("#"+selectItemId).val();
			  if(selectedBaseItemId==0)
			  {
				  alert("Please select a item");
				  return false;
			  }
			  else
			  {
				 SaveWeight(productid,selectedBaseItemId);
				 getBaseItems(productid);
									  
			  }
		  }
		  
		 function CancelandReset(productid)
		 {
			 getBaseItems(productid);
		 }
		  
		  function confirmCancel(productid)
	     {
			if(confirm("Do you want to cancel?"))
			{
				jQuery( "#selectResult" ).html('');
				return false;
			}
			
	     }	
		   
		  </script>
		  
		  
		    <table cellpadding="2" class="base_data_information table-responsive" cellspacing="2" border="1px;solid" FRAME=VOID RULES=ALL >
			
			
		    <?php
			   if(sizeof($baseAssociatedSkuWeightArray)>0){?>
		    
				<tr>
				<th>Recipe Item</th>
				<th>Recipe Item UOM</th>
				<th>Recipe Qty</th>
				<th>Price Of 1Kg</th>
				<th>Price Of Qty</th>
				<th>Wastage(%)</th>				
			    <th>Price After Wastage</th>
				<th>Protein Qty</th>
				<th>Fat Qty</th>
				<th>Fiber Qty</th>
				<th>Carbs Qty</th>
				<?php /*<th>Remove </th> */ ?>
				</tr>
			   <?php
			      $totalWeight=0;
				  $totalPrice=0;
				  $totalProtein=0;
				  $totalFat=0;
			   	  $totalFiber=0;
				  $totalCarbs=0;
				  
				  $countRow=0;
			       foreach($baseAssociatedSkuWeightArray as $key =>$value)
			       {
					    $baseSku ='';
						$baseItemQty='';
						$basePriceBeforeWastage=0;
						$baseWastage=0;
						$baseWastagePrice=0;
						$basePriceAfterWastage=0;
						
					    $skuWeightArray = explode("_",$value);
						
						$countRow++;
						
						if(sizeof($skuWeightArray)==3)
						{
					      $baseSku        =  $skuWeightArray[0];
						}
						else
						{
							$baseSku = $value;
						}
						
						$baseProduct        = Mage::getModel('catalog/product')->loadByAttribute("sku",$baseSku);
						
						if(is_object($baseProduct))
						{
						$defaultBaseItemQty    = $baseProduct->getBaseQty()*1000;
						$baseItemUOM  = $baseProduct->getBaseUom();
						$defaultUOM='';
						if($baseItemUOM=='Kgs')
						{$defaultUOM = 'gm';}
					    else if($baseItemUOM=='Lt')
						{$defaultUOM = 'ml';}
					
						$uomOptionsArray = array();
						$uomOptionsArray[$defaultUOM] = $defaultBaseItemQty;
						///////////////////////////////////////////////////
						
						
						$cupToGmOrMl  = $baseProduct->getCupToGmOrMl();
						$tspToGmOrMl  = $baseProduct->getTspToGmOrMl();
						$tbspToGmOrMl  = $baseProduct->getTbspToGmOrMl();
						$cloveToGm  = $baseProduct->getCloveToGm();
						$stemToGm  = $baseProduct->getStemToGm();
						$pcToGm  = $baseProduct->getPcToGm();
						$pinchToGm  = $baseProduct->getPinchToGm();
						
						
						
						
						if(isset($cupToGmOrMl) && $cupToGmOrMl>0)
						{ $uomOptionsArray['cup'] =   $cupToGmOrMl;   }
					
						if(isset($tspToGmOrMl) && $tspToGmOrMl>0)
						{ $uomOptionsArray['tsp'] =   $tspToGmOrMl;   }
					 
					    if(isset($tbspToGmOrMl) && $tbspToGmOrMl>0)
						{ $uomOptionsArray['tbsp'] =   $tbspToGmOrMl;   }
					
					   if(isset($cloveToGm) && $cloveToGm>0)
						{ $uomOptionsArray['clove'] =   $cloveToGm;   }
					
					   if(isset($stemToGm) && $stemToGm>0)
						{ $uomOptionsArray['stem'] =   $stemToGm;   }
					
					   if(isset($pcToGm) && $pcToGm>0)
						{ $uomOptionsArray['pc'] =   $pcToGm;   }
					
					   if(isset($pinchToGm) && $pinchToGm>0)
						{ $uomOptionsArray['pinch'] =   $pinchToGm;   }
					
					/////////////////////////////////////////////////
					
						
						$defaultBasePriceBeforeWastage = $baseProduct->getBasePrice1kg();
						$defaultBaseWastagePercent = $baseProduct->getBaseWastagePercent();
						$defaultBaseWastePrice = ($baseProduct->getBasePrice1kg() * $defaultBaseWastagePercent ) /100;
						$defaultBasePriceAfterWastage = $baseProduct->getBasePriceAfterWastage();
						
						$tmpBaseProtein       = $baseProduct->getBaseProtein();
						$tmpBaseFat           = $baseProduct->getBaseFat();
						$tmpBaseFiber         = $baseProduct->getBaseTotalfiber();
						$tmpBaseCarbohydrate  = $baseProduct->getBaseCarbohydrate();
												
						$baseProtein          = (isset($tmpBaseProtein)      && $tmpBaseProtein>0)? $tmpBaseProtein:0;
						$baseFat              = (isset($tmpBaseFat)          && $tmpBaseFat>0)? $tmpBaseFat:0;
						$baseFiber            = (isset($tmpBaseFiber)        && $tmpBaseFiber>0)?$tmpBaseFiber:0;
						$baseCarbohydrate     = (isset($tmpBaseCarbohydrate) && $tmpBaseCarbohydrate>0)?$tmpBaseCarbohydrate:0;
												
						$calculatdProtein=0;
						$calculatdFat=0;
						$calculatdFiber=0;
						$calculatdCarbs=0;
						
						$tmpWastagePercent = $baseProduct->getBaseWastagePercent();
						$baseWastagePercent = (isset($tmpWastagePercent) && ($tmpWastagePercent>0)) ?$tmpWastagePercent:'N/a';
						
						
					
						
						//echo "Size =".sizeof($skuWeightArray);
						if(sizeof($skuWeightArray)==3)
						{
					        $customQtyValue           = $skuWeightArray[1];
						    $unitOfMeasure            = $skuWeightArray[2];
											   
					if($unitOfMeasure == 'tsp' )
					{ $baseItemQty    =  ($tspToGmOrMl/$defaultBaseItemQty) * $customQtyValue;
   				      $baseItemQty    = number_format((float)$baseItemQty, 2, '.', '');
					 }  
					else if($unitOfMeasure == 'tbsp' )
					{  $baseItemQty    =   ($defaultBaseItemQty/$tbspToGmOrMl) * $customQtyValue;  
				       $baseItemQty    = number_format((float)$baseItemQty, 2, '.', '');
				     }  
					else  if($unitOfMeasure == 'cup' )
					{  $baseItemQty    =    (1/ $cupToGmOrMl)* $customQtyValue; 
                       $baseItemQty    = number_format((float)$baseItemQty, 2, '.', '');
 	                }  
					else if($unitOfMeasure == 'clove' ) 
					{ 
				      
				      $baseItemQty    =   (1/$cloveToGm) * $customQtyValue;
					 
                      $baseItemQty    = number_format((float)$baseItemQty, 2, '.', '');
                    }  
					else if($unitOfMeasure == 'stem' )
					{ $baseItemQty    =   (1/$stemToGm) *  $customQtyValue;
                      $baseItemQty    = number_format((float)$baseItemQty, 2, '.', '');			
					  }  
					else if($unitOfMeasure == 'pc' )
					{ $baseItemQty    =   (1/$pcToGm) * $customQtyValue; 
                      $baseItemQty    = number_format((float)$baseItemQty, 2, '.', '');
                    }  
					else if($unitOfMeasure == 'pinch' )
					{ $baseItemQty    =  (1/$pinchToGm) * $customQtyValue;
					  $baseItemQty    = number_format((float)$baseItemQty, 2, '.', '');		
				     }  
					else if(strtolower($unitOfMeasure) == 'gm' || strtolower($unitOfMeasure) == 'ml' )
					{ $baseItemQty    =   $customQtyValue  ;  }
					  
					  
					  
					  
					  
					  
					  
						   
						   if(isset($defaultBasePriceBeforeWastage) && $defaultBasePriceBeforeWastage>0)
						   {
														   
							 $basePriceBeforeWastage =   ($defaultBasePriceBeforeWastage/1000) * $baseItemQty;
							
						   }
						   if( (isset($defaultBaseWastagePercent) && $defaultBaseWastagePercent>0)
							   && ($basePriceBeforeWastage > 0 ) ) 
						   {
						      $baseWastagePrice =  ($basePriceBeforeWastage*$defaultBaseWastagePercent)/100;
						   }
						   
						   					   
						   
						   $basePriceAfterWastage =  ( $defaultBasePriceAfterWastage/1000) * $baseItemQty;
						  
						   if($baseProtein>0)
						   {
							   $calculatdProtein = ( $baseProtein/$defaultBaseItemQty) * $baseItemQty;
							   //$calculatdProtein.= "--( ".$baseProtein."/".$defaultBaseItemQty.") *".$baseItemQty;
							   
							  // echo $calculatdProtein;
						   }
						   if($baseFat>0)
						   {
							   $calculatdFat = ( $baseFat/$defaultBaseItemQty) * $baseItemQty;
						   }
						   if($baseFiber>0)
						   {
							   $calculatdFiber = ( $baseFiber/$defaultBaseItemQty) * $baseItemQty;
						   }
						   if($baseCarbohydrate>0)
						   {
							   $calculatdCarbs = ( $baseCarbohydrate/$defaultBaseItemQty) * $baseItemQty;
						   }
						}
						else
						{
							
							$baseItemQty           = $baseProduct->getBaseQty()*1000;
							$basePriceAfterWastage = $baseProduct->getBasePriceAfterWastage();
							$calculatdProtein      = $baseProtein;
						    $calculatdFat          = $baseFat;
						    $calculatdFiber        = $baseFiber;
						    $calculatdCarbs        = $baseCarbohydrate;
						}
						
						
						//echo $baseItemQty; echo "<br>";
						$totalWeight+=  $baseItemQty;
						$totalPrice+=   $basePriceAfterWastage;
						$totalProtein+= $calculatdProtein;
						$totalFat+=     $calculatdFat;
						$totalFiber+=   $calculatdFiber;
						$totalCarbs+=   $calculatdCarbs;
						
						$baseItemName  = $baseProduct->getName();
							
						$bgcolor="#ffffff";
						if($countRow%2==0)
						{
							$bgcolor="#D3D3D3";
						}
						?>
				   
				      <tr style="background-color:<?php echo $bgcolor;?>">
					      <td><?php echo $baseItemName;?><br> ( <?php echo $baseProduct->getSku();?>)</td>
						   <?php /* <td><?php echo $defaultUOM;?></td> 
						   <td><?php echo $defaultBaseItemQty;?></td>*/?>
						   
						   <?php if(sizeof($uomOptionsArray)>1){?>
  						    <td>
							     <select id="customUOM_<?php echo $baseProduct->getEntityId();?>"
		onchange="convertQtyToCustomUnit('<?php echo $baseProduct->getEntityId();?>');">
								 <?php foreach($uomOptionsArray as $key=>$value){
									$unitValue = (1/$value)*$customQtyValue;
									
									if($key=='gm' || $key=='ml')
									{
									 $unitValue = ($value/$defaultBaseItemQty)*$customQtyValue;
									}
									$unitValue = number_format((float)$unitValue, 2, '.', '');
									 $selected='';
									 if($skuWeightArray[2]==$key){$selected="selected";}
									 ?>
								         <option value="<?php echo $key;?>" unitValue="<?php echo $unitValue;?>" <?php echo $selected;?>><?php echo $key;?></option>
								 <?php } ?>    
							     </select>
							</td>
						   <?php } else { ?>
						   <td><?php echo $defaultUOM;;?></td>
						   <?php } ?>
						   
						   
						   <?php /*<td>
						        <input class="baseQty"  type="text" id="qty_<?php echo $baseProduct->getEntityId();?>"
								value="<?php echo $customQtyValue;?>" sku="<?php echo $baseProduct->getSku();?>" unitofmeasure="<?php echo  $defaultUOM;?>" 
								onchange="changePriceAfterWastage('<?php echo $defaultBaseItemQty;?>','<?php echo $defaultBasePriceBeforeWastage;?>','<?php echo $defaultBaseWastePrice;?>','<?php echo $baseProtein;?>','<?php echo $baseFat;?>','<?php echo $baseFiber;?>','<?php echo $baseCarbohydrate;?>','<?php echo $defaultBasePriceAfterWastage;?>',this.id,this.value,'<?php echo $productId;?>','<?php echo $baseProduct->getEntityId();?>','textbox');" />
						   </td>
						   */?>
						   
						   <td>
						        <label class="baseQty"  id="qty_<?php echo $baseProduct->getEntityId();?>" sku="<?php echo $baseProduct->getSku();?>" unitofmeasure="<?php echo  $defaultUOM;?>"  >
								<?php echo $customQtyValue;?></label>
						   </td>
						   <td>
						        <label  id="priceof1kg_<?php echo $baseProduct->getEntityId();?>" >
								<?php echo $defaultBasePriceBeforeWastage;?></label>
						   </td>
						   
						   <td>
						        <label  id="pricebeforewastage_<?php echo $baseProduct->getEntityId();?>" >
								<?php echo $basePriceBeforeWastage;?></label>
						   </td>
						   
						   <?php /*<td>
						        <label  id="wastageprice_<?php echo $baseProduct->getEntityId();?>" >
								<?php echo $baseWastagePrice;?></label>base_wastage_percent
						   </td> */?>
						   
						  <td><?php echo $baseWastagePercent;?> </td>
						  
						   <td>
						        <label class="basePrice" id="price_<?php echo $baseProduct->getEntityId();?>" >
								<?php echo $basePriceAfterWastage;?></label>
						   </td>
						   <td>
						        <label class="baseProtein" id="protein_<?php echo $baseProduct->getEntityId();?>" >
								<?php echo number_format((float)$calculatdProtein, 2, '.', '');?></label>
						   </td>
						   <td>
						        <label class="baseFat" id="fat_<?php echo $baseProduct->getEntityId();?>" >
								<?php echo number_format((float)$calculatdFat, 2, '.', '') ;?></label>
						   </td>
						   <td>
						        <label class="baseFiber" id="fiber_<?php echo $baseProduct->getEntityId();?>" >
								<?php echo number_format((float)$calculatdFiber, 2, '.', '') ; ?></label>
						   </td>
						   <td>
						        <label class="baseCarbs"id="carbs_<?php echo $baseProduct->getEntityId();?>" >
								<?php echo number_format((float)$calculatdCarbs, 2, '.', '');?></label>
						   </td>
						  <?php /* <td><span onclick="removeBaseItem('<?php echo $productId;?>','<?php echo $baseProduct->getSku();?>')"><img src="<?php echo Mage::getDesign()->getSkinUrl();?>images/remove_icon.png"  style="width:20px; margin: 0 auto; cursor:pointer;" /></span></td>
						 */ ?>
					  </tr>
			   <?php }
				   }			   ?>
			      <tr>     <td colspan="2">&nbsp;</td>
				           <td>Total Weight:<label id="totalWeight_<?php echo $productId;?>"><?php echo $totalWeight;?></label></td> 
				           <td colspan="3">&nbsp;</td>
				           
					   
						  <td>Total Price:<label   id="totalPrice_<?php echo $productId;?>">
						     <?php echo number_format((float)$totalPrice, 2, '.', '') ;?>
							 </label></td>
						  <td>Total Protein:<label id="totalProtein_<?php echo $productId;?>">
						   <?php echo number_format((float)$totalProtein, 2, '.', '');?>
						  </label></td>
						  <td>Total Fat:<label id="totalFat_<?php echo $productId;?>">
						    <?php echo number_format((float)$totalFat, 2, '.', '');?>
						  </label></td>
						  <td>Total Fiber:<label id="totalFiber_<?php echo $productId;?>">
						  <?php echo number_format((float)$totalFiber, 2, '.', '');?>
						  </label></td>
						  <td>Total Carbs:<label id="totalCarbs_<?php echo $productId;?>">
						  <?php echo number_format((float)$totalCarbs, 2, '.', '');?>
						  </label></td>
						  <?php /* <td>&nbsp;</td> */?>
				   </tr>
				   
				  <?php /* <tr>
				    <td colspan="11" style="text-align:center">
					    <input type="button" id="Savebtn_<?php echo $productId;?>" value="Save" onclick="SaveWeight('<?php echo $productId;?>','')"/> &nbsp; &nbsp;
					
					   <input type="button" id="Cancelbtn_<?php echo $productId;?>" value="Cancel And Reset" onclick="CancelandReset('<?php echo $productId;?>')" />
					 </td>
				  </tr>
				  <?php */?>
		  <?php }
		   else {?>
			       <tr>
					       <td colspan="2">No Item found.</td>
				   </tr>
		       <?php } ?>
			   
		   </table>
		   
		   
		  
		   </span>

        <?php		
	   }else
	   {  echo "No  Item found.";}
	   
   }
 
   public function sendemailAction()
	 {
          
		  $name = $this->getRequest()->getParam('name');
		  $email = $this->getRequest()->getParam('email');
		  $message = $this->getRequest()->getParam('message');
		  if($email=='' || $name=='' || $message=='')
		  {
			  echo "Please fill the required fields.";
		  }
		  else
		  {
				  if ( $email!='' && $name!='' && $message!='' ) 
				  {      
						 
						 if( eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email) )
						  { 
							 ////////////////////////////Send Email///////////////////////////////////////
							    $to ="diet@lifeheal.in,junior@lifeheal.in,jasmine.chanana@lifeheal.in,team@lifeheal.in";
								//$to ="st.homespice@gmail.com";
								$from =$email;

								   // Always set content-type when sending HTML email
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

								// More headers
								$headers .= "From: ".$from . "\r\n";
								$subject = "A new lead filled the contact form.";
								$customeMessage="Hi, a new lead ".$name.", filled the home page contact form on ".date("d-m-Y")."<br><br> His message is as below.<br><br>";
								$customeMessage.=$message;
								if(mail($to,$subject,$customeMessage,$headers) ) { echo "Thank you <b>".ucfirst($name)."</b> we will contact you soon"; }
								else { echo "Sorry, we did not get your email.";}
					
								
				
							 ///////////////////////////////////////////////////////////////////
						  }
						  else
						  {
							  echo "Please enter the correct email id.";
						  }
				  }
				  
		  }
	  
    }

}