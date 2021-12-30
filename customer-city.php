<?php 
    ini_set('max_execution_time', 300000);
    define('MAGENTO', realpath(dirname(__FILE__)));
	require_once MAGENTO . '/app/Mage.php';
	Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
       
	
          $customerCollection = Mage::getModel('customer/customer')
               ->getCollection()
               ->addAttributeToSelect('*');
              $customerFinalArray = array();          
          $readConnection = Mage::getSingleton('core/resource')->getConnection('core_read');    
          $writeConnection = Mage::getSingleton('core/resource')->getConnection('core_write');			  
          foreach($customerCollection as $tmpcustomer)
          {
            $city='';
            $billingAddress = $tmpcustomer->getDefaultBillingAddress(); 
            $shipingAddress = $tmpcustomer->getDefaultShipingAddress(); 
            
            if($billingAddress){
                  $city=$billingAddress->getCity();
             }  
            
            if($shipingAddress){
                  $city=$shipingAddress->getCity();
              }  
             $customerId= $tmpcustomer->getEntityId();
             $CustomerEmail = $tmpcustomer->getEmail();
             //$customerFinalArray['mobile']= $tmpcustomer->getPrimarymobileno();
            
          //  echo "CustomerId=".$customerId." Email=".$CustomerEmail." and City=".$city; echo "<br>";
            $query = "select * from healorder where email='".$tmpcustomer->getEmail()."'";
            $results = $readConnection->fetchAll($query);
           
           if(count($results)>0)
		   {
			   foreach($results as $row)
			   {
				  
				  
					  $orderId    =  $row['id'];
                      $healOrder  = Mage::getModel("heal/order")->load($orderId);
					  if(is_object($healOrder) && $healOrder->getEmail()!='' && $city!='')
					  {
						$updateCityQry = "update healorder set customerid=".$customerId.",city='".ucfirst($city)."' where id=".$orderId;  
				        $writeConnection->query($updateCityQry);
					    echo "Name=".$tmpcustomer->getFirstname()." ".$tmpcustomer->getLastname().", City= ".$city.", Email ".$CustomerEmail." ,Customerid=".$customerId; echo "<br>"; //die;
					  }
				  
				   
			   }
		   }
          
    }
	echo "Script complete for customer city update";			  
	
		
?>
