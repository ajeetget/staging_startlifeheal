<?php 
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('max_execution_time', -1);
	ini_set('memory_limit', -1);

	   define('MAGENTO', realpath(dirname(__FILE__)));
	   require_once MAGENTO . '/app/Mage.php';
	   Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
           
           ////////////  Start CHECK CSV  ////////////
           
	
$dbRead      = Mage::getSingleton('core/resource')->getConnection('core_read');
$selectDatewiseOrders='';
$start_formattedOrderdate='';
    $end_formattedOrderdate='';
  //$customerEmail = 'aanchallalchandani@cmd.com';
   $cid = Mage::app()->getRequest()->getParam('cid'); 
   $start_formattedOrderdate = Mage::app()->getRequest()->getParam('start_date'); 
   $end_formattedOrderdate = Mage::app()->getRequest()->getParam('end_date'); 
      
             $customer = Mage::getModel('customer/customer')->load($cid);
             $customerEmail = $customer->getEmail();
              $name = $customer->getFirstname(). "-".  $customer->getLastname();   //die;
    
    
       if($cid!='' && $start_formattedOrderdate=='' &&  $end_formattedOrderdate=='')
        {
           $selectDatewiseOrders= "select * from healorder where email='".$customerEmail."' order by formatted_orderdate asc";
        }
        else if( $cid!='' && $start_formattedOrderdate!=''  &&  $end_formattedOrderdate=='')
        {
           $selectDatewiseOrders= "select * from healorder where email='".$customerEmail."' and formatted_orderdate>='".$start_formattedOrderdate."' order by formatted_orderdate asc";
          
        }
        
         else if( $cid!='' && $start_formattedOrderdate==''  &&  $end_formattedOrderdate!='')
        {
           $selectDatewiseOrders= "select * from healorder where email='".$customerEmail."' and formatted_orderdate<='".$end_formattedOrderdate."' order by formatted_orderdate asc";
          
        }
        
        else if( $cid!='' && $start_formattedOrderdate!=''  &&  $end_formattedOrderdate!='')
        {
           $selectDatewiseOrders= "select * from healorder where email='".$customerEmail."' and formatted_orderdate>='".$start_formattedOrderdate."' and formatted_orderdate<='".$end_formattedOrderdate."' order by formatted_orderdate asc";
          
        }
        
        if($selectDatewiseOrders!='')
        {
         // echo $selectDatewiseOrders; 
          $customerResultForDownload = $dbRead->fetchAll($selectDatewiseOrders);
          if( count($customerResultForDownload)>0)
          { //echo "3333"; //die;
               
        header('Content-Type: text/csv; charset=utf-8');
              header('Content-Disposition: attachment; filename='.$name.'.csv');

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');
//echo "1";
// output the column headings
fputcsv($output, array('order Date','order Id','Dinner','Breakfast','Lunch','Hightea'));
//echo "2";

//////////////////////// start CSV /////////////////
         foreach($customerResultForDownload as $row)
         { 
                 $orderId   =  $row['id'];  
                 $orderInfo =  Mage::getModel("heal/order")->load($orderId);
                 $customerEmail = $orderInfo->getEmail();
               
                $orderDate = $orderInfo->getFormattedOrderdate(); 
                $formattedDate = date("d M Y",strtotime($orderDate)); 
                $breakfastCollection = $orderInfo->getCusineDetails($orderId,$cusine='breakfast');
                $lunchCollection = $orderInfo->getCusineDetails($orderId,$cusine='lunch');
                $dinnerCollection = $orderInfo->getCusineDetails($orderId,$cusine='dinner');
                $highteaCollection = $orderInfo->getCusineDetails($orderId,$cusine='hightea ');
                $dinner='';
                $breakfast='';
                $lunch='';
                $hightea='';
                
           
    
        /////////////Dinner Starts/////////////
        if(count($dinnerCollection)>0) {           
                foreach($dinnerCollection as $iteminfo)
                { 
                   $dinner.=  $iteminfo['itemname']."\n"; 
                 } 
          
            } 
             //////////Dinner Ends//////
      
      
         /////// Breakfast Starts /////////
       if(count($breakfastCollection)>0) {           
                foreach($breakfastCollection as $iteminfo) { 
                  $breakfast.= $iteminfo['itemname']."\n";
                     
          } 
          
            } 
            ///////////-- Breakfast Ends -->
      
     
       ////////////-- Lunch Starts -->
        if(count($lunchCollection)>0) {           
                foreach($lunchCollection as $iteminfo) { 
                   $lunch.= $iteminfo['itemname']."\n";
                     
                  } 
           } 
            ///////// Lunch Ends -->
       
     
    
            ///////// Hightea Starts -->
       if(count($highteaCollection)>0) {           
                foreach($highteaCollection as $iteminfo)
                    { 
                      $hightea.= $iteminfo['itemname']."\n";
                    } 
           } 
            ///////- Hightea Ends -->
           
     
       $row =  array($formattedDate,$orderId,$dinner,$breakfast,$lunch,$hightea); 
      // print_r( $row ); die;
       fputcsv($output, $row); 
            
   }
   
    
 
 
 
//////////////////////////End CSV ///////////////////

          }
        }
      
           /////////////// End CHECK CSV ////////////////
           
           
           
     