<?php

class Food_Heal_Model_Order extends Mage_Core_Model_Abstract
{
    protected function _construct(){

       $this->_init("heal/order");

    }
	
	
		
	public function getCusineDetails($orderId,$cusine)
	{
		$dbRead      = Mage::getSingleton('core/resource')->getConnection('core_read');
		$QgetCuisineRows = "SELECT * FROM healitemdetails WHERE orderid =".$orderId." AND cuisine = '$cusine'"; 
		$cuisineResult = $dbRead->fetchAll($QgetCuisineRows);
		if(count($cuisineResult)>0)
		{
			return $cuisineResult;
		}
	}	
	
	
	public function getCusineItemQty($orderId,$entityId,$cusine)
	{
		
		$dbRead      = Mage::getSingleton('core/resource')->getConnection('core_read');
		$QgetCuisineRows = "SELECT qty FROM healitemdetails WHERE orderid ='".$orderId."' and productid='".$entityId."' and cuisine = '".$cusine."' limit 1"; 
		
		$qty = $dbRead->fetchOne($QgetCuisineRows);
		if($qty>0) { return $qty; }
		else {return 0;  } 
	}
	


	public function updaterowinfo($orderid)
	{
		
		
		$healOrder  = Mage::getModel("heal/order")->load($orderid);
		$dbWrite     = Mage::getSingleton('core/resource')->getConnection('core_write');
		$dbRead      = Mage::getSingleton('core/resource')->getConnection('core_read');
		
		$order_total_protein 	     = 0;
		$order_total_fat	         = 0;
		$order_total_carbohydrates   = 0;
		$order_total_fiber           = 0;
		$order_total_calories        = 0;
		$order_total_gram            = 0;
		
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
						
						if($row['qty']>0){ 		            $order_total_gram+=$row['qty'];	 }
                        
					}
				   
				   if( $cuisine_total_protein >0 )
				   {  
					   $healOrder->setData($cuisine.'_total_protein',$cuisine_total_protein);
					   $order_total_protein+= $cuisine_total_protein;
					  
				   }
				   else
				   {
				   
				   $healOrder->setData($cuisine.'_total_protein',0);
				   }
				
				   if( $cuisine_total_fat >0 )  
				   {   
					   $healOrder->setData($cuisine.'_total_fat',$cuisine_total_fat);
					   $order_total_fat+= $cuisine_total_fat;
				   }
				   else
				   {
				      $healOrder->setData($cuisine.'_total_fat',0);
				   }
				
				   if( $cuisine_total_carbohydrates>0 )
				   {   
					   $healOrder->setData($cuisine.'_total_carbohydrates',$cuisine_total_carbohydrates);
					   $order_total_carbohydrates+= $cuisine_total_carbohydrates; 
				   }
				
				   if( $cuisine_total_fiber>0 ) 
				   {   
					   $healOrder->setData($cuisine.'_total_fiber',$cuisine_total_fiber);
					   $order_total_fiber+= $cuisine_total_fiber;
				   }
				   else
				   {
				      $healOrder->setData($cuisine.'_total_fiber',0);
				   }
				
				   if( $cuisine_total_calories>0 )  
				   {  
					   $healOrder->setData($cuisine.'_total_calories',$cuisine_total_calories);
					   $order_total_calories+= $cuisine_total_calories;
				   }
				   else
				   {
				      $healOrder->setData($cuisine.'_total_calories',0);
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
		{
		   $healOrder->setData('total_calories',0);
		}
		
		if($order_total_gram>0)
		{
			$healOrder->setData('totalgram',$order_total_gram);
			
		}
		else
		{
		  $healOrder->setData('totalgram',$order_total_gram);
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
		
		if($calculateCaloriesForPercent>0)
		{
			$healOrder->save();
			//echo $dieticianName; 	
		
		}
		
			
			
		}
	
	

}
	 