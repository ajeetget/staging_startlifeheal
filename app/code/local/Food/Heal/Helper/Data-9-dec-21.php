<?php
class Food_Heal_Helper_Data extends Mage_Core_Helper_Abstract {
	public function getAllergiesDislike($customerid) {
		$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
		$checkdataexist = "SELECT customerid,allergies,dislikename,notes FROM `heal_order_review` WHERE `customerid` = '".$customerid."' AND (`allergies` IS NOT NULL  OR `dislikename` IS NOT NULL OR `notes` IS NOT NULL) AND `productid` = '' ";
		$datacheck = $connection->query($checkdataexist);
        $check_fetch = $datacheck->fetch();
        return $check_fetch;
	}
	
	public function getUniqueCustomersJson()
	{
		
		$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
		 $customerEmailSql = "SELECT distinct email FROM healorder order by email";
		$datacheck = $connection->query($customerEmailSql);
                $result = $datacheck->fetchAll();
		$nameArray = array();
                $tmpNameArray = array();
                
                foreach($result as $resultArray) {
                     $customerEmail = $resultArray['email'];
                     $customer = Mage::getModel("customer/customer"); 
                     $customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
                     $customer->loadByEmail($customerEmail);
                  
                     $customerId = $customer->getEntityId();
                     $firstName = str_replace("Dear","",$customer->getFirstname());
					 $lastName  = str_replace("Dear","",$customer->getLastname());
					 
                     $name = trim($firstName). " ". trim($lastName);         
                      
			if($customer->getIsActive()==1 && trim($customerEmail)!='') {
			   $tmpNameArray[$customerEmail] = $name;
                          
			}
		}
                asort($tmpNameArray);
           //  echo "<pre>";   print_r($tmpNameArray); die;
                
		foreach($tmpNameArray as $key=>$value)	{
                    $nameArray[] = array('id'=>$key,'text'=>$value);               
		}
		
		return json_encode($nameArray);
	}
        
        
	public function updateItems($healOrder,$rowId,$cuisine,$typeData,$attributeName){
		
		
		     $count=0;
			 
		     $cuisine_total_protein=0;  
			 $cuisine_total_fat=0;  
			 $cuisine_total_carbohydrates=0;  
			 $cuisine_total_fiber=0;  
	         $cuisine_total_calories=0;
			   
			 $cuisine_protein_percent=0;
			 $cuisine_fat_percent=0;  
			 $cuisine_carbohydrate_percent=0; 
			 $cuisine_total_calory_for_percent=0;
			 
           if($typeData!='') {
           $itemsInfo = explode(",",$typeData);
           if(count($itemsInfo)>0)
		   {
               
              $totalCalculatedProtein=0;
              $totalCalculatedFat=0;
              $totalCalculatedCarbohiderate=0;
              $totalCalculatedEnergy=0;
              
            
			foreach($itemsInfo as $itemline)
			{ 
					if($itemline!=''){
					$itemInfo = explode("_",$itemline);

					$itemName = $itemInfo[0];
					$entityId = $itemInfo[1];
					$product  = Mage::getModel('catalog/product')->load($entityId);
					$unitofmeasure = $product->getUnitofmeasure();

					$unitofnutritionDatabase=100;
					//$healOrder  = Mage::getModel("heal/order")->load($rowId);
					$qty = $healOrder->getCusineItemQty($rowId,$entityId,$cuisine);
				 ///////////////////////////// Start  Calculation /////////////////////////  

					 $result= array();
					 $calculatedEnergyPercentArray =array();

					 $protein    = $product->getProtein();
					 $fat        = $product->getFat();
					 $carbohydrates = $product->getCarbohydrates();
					 $fiber      = $product->getFiber();
					 $calories   = $product->getCalories();

					 $calculatedProteinPercent =0;
					 $calculatedFatPercent =0;
					 $calculatedCarbohydratePercent =0;

					$calculatedProtein=0;
					$calculatedFat=0;
					$calculatedCarbohydrates=0;
					$calculatedFiber=0;
					$calculatedCalories=0;
					$totalEnery = 0;

					if($protein!='' && $protein>0 )
					{ 
						 $calculatedProtein = ($protein/$unitofnutritionDatabase )* $qty; 
						 $result['calculatedProtein']= round($calculatedProtein);
                                               //  $result["calculatedProteinGram"] = $protein* $qty ; 


					} 
					else
					{
						$result['calculatedProtein']='no';

					}

					if($fat!='' && $fat>0) 
					{   $calculatedFat = ($fat/$unitofnutritionDatabase )* $qty;  
						$result['calculatedFat']= round($calculatedFat);
                                              //  $result["calculatedFatGram"] = $fat* $qty ; 

					}
					else
					{
						$result['calculatedFat']='no';
					}

					if($carbohydrates!='' && $carbohydrates >0)
					{ 
						  $calculatedCarbohydrates = ($carbohydrates/$unitofnutritionDatabase )* $qty; 
						  $result['calculatedCarbohydrates']=round($calculatedCarbohydrates);
                                                  // $result["calculatedCarbsGram"] = $carbohydrates * $qty ; 

					}
					else
					{
						$result['calculatedCarbohydrates']='no';
					}



					if($fiber!='' && $fiber>0) 
					{   
						$calculatedFiber = ($fiber/$unitofnutritionDatabase )* $qty; 
						$result['calculatedFiber']=round($calculatedFiber);
                                              //  $result["calculatedFiberGram"] = $fiber* $qty ; 
					}
					else
					{
					   $result['calculatedFiber']='no';
					}

					if($calories!='' && $calories>0) 
					{ 
						$calculatedCalories = ($calories/$unitofnutritionDatabase )* $qty; 
						$result['calculatedCalories'] = round($calculatedCalories);
                                               // $result["calculatedCalGram"] = ($calories * $qty); 
					}
					else
					{
						 $result['calculatedCalories']='no';
					}


					$hiddenRowInfo= implode(",",$result);  // keeps info of protein,fat,carbohydrates,fiber,calories




			///////////////////////////// End Calculation /////////////////////////    



				if($itemName!='')
				{

						++$count;
						$backgroundColorForLikeDislike = $this->getStyleForLikeDislike($healOrder,$entityId);
                                                
						$cusineDetailResult.='<div class="formtr '.$rowId.'_'.$cuisine.'_'.$entityId.'">
					 <div class="formtd" style="text-align:left;text-align: justify;font-weight:normal;font-size: 13px;text-transform: Capitalize;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;'.$backgroundColorForLikeDislike.'" title="'.$itemName.'">'.$itemName.' </div>
					 <div class="formtd" style="width:27%;">
					
					<input type="button" id="plus_'.$rowId.'_'.$attributeName.'_'.$count.'" value="+"
				 onClick="operation(\'plus\',\''.$rowId.'\',\''.$entityId.'\',\''.$rowId.'_'.$attributeName.'_'.$count.'\',\'hiddenUOM_'.$rowId.'_'.$attributeName.'_'.$count.'\',\'hiddenRowInfo_'.$rowId.'_'.$attributeName.'_'.$count.'\',\'labelprotein_'.$rowId.'_'.$attributeName.'_'.$count.'\',\'labelfat_'.$rowId.'_'.$attributeName.'_'.$count.'\',\'labelcarbohydrate_'.$rowId.'_'.$attributeName.'_'.$count.'\',\'labelfiber_'.$rowId.'_'.$attributeName.'_'.$count.'\',\'labelcalories_'.$rowId.'_'.$attributeName.'_'.$count.'\',
					\'hiddenProtein-'.$rowId.'-'.$attributeName.'-'.$count.'\',\'hiddenFat-'.$rowId.'-'.$attributeName.'-'.$count.'\',\'hiddenCarbohydrates-'.$rowId.'-'.$attributeName.'-'.$count.'\',\'hiddenFiber-'.$rowId.'-'.$attributeName.'-'.$count.'\',\'hiddenCalories-'.$rowId.'-'.$attributeName.'-'.$count.'\',\''.$unitofnutritionDatabase.'\')" />       

				<input style="width: 20%" type="text" value="'.$qty.'"  id="'.$rowId.'_'.$attributeName.'_'.$count.'" class="'.$rowId.'_'.$attributeName.'_'.$count.'" /> 

				 
					<input type="button" id="minus_'.$rowId.'_'.$attributeName.'_'.$count.'" value="-"
				 onClick="operation(\'minus\',\''.$rowId.'\',\''.$entityId.'\',\''.$rowId.'_'.$attributeName.'_'.$count.'\',\'hiddenUOM_'.$rowId.'_'.$attributeName.'_'.$count.'\',\'hiddenRowInfo_'.$rowId.'_'.$attributeName.'_'.$count.'\',\'labelprotein_'.$rowId.'_'.$attributeName.'_'.$count.'\',\'labelfat_'.$rowId.'_'.$attributeName.'_'.$count.'\',\'labelcarbohydrate_'.$rowId.'_'.$attributeName.'_'.$count.'\',\'labelfiber_'.$rowId.'_'.$attributeName.'_'.$count.'\',\'labelcalories_'.$rowId.'_'.$attributeName.'_'.$count.'\',
					\'hiddenProtein-'.$rowId.'-'.$attributeName.'-'.$count.'\',\'hiddenFat-'.$rowId.'-'.$attributeName.'-'.$count.'\',\'hiddenCarbohydrates-'.$rowId.'-'.$attributeName.'-'.$count.'\',\'hiddenFiber-'.$rowId.'-'.$attributeName.'-'.$count.'\',\'hiddenCalories-'.$rowId.'-'.$attributeName.'-'.$count.'\',\''.$unitofnutritionDatabase.'\')" />       

			   
			   <div  id="showCalory1">
						<label id="labelprotein_'.$rowId.'_'.$attributeName.'_'.$count.'" ></label><br>
						 <label id="labelfat_'.$rowId.'_'.$attributeName.'_'.$count.'" ></label><br>
						 <label id="labelcarbohydrate_'.$rowId.'_'.$attributeName.'_'.$count.'" ></label><br>
						 <label id="labelfiber_'.$rowId.'_'.$attributeName.'_'.$count.'" ></label><br>
						 <br>
					 <input type="hidden" class="productid-'.$rowId."-".$attributeName."-".$count.'" id="productid-'.$rowId."-".$attributeName."-".$count.'"  value="'.$entityId.'" /> 

					<input type="hidden" class="hiddenProtein-'.$rowId."-".$attributeName."-".$count.'" id="hiddenProtein-'.$rowId."-".$attributeName."-".$count.'" value="'.$result["calculatedProtein"].'" />

					<input type="hidden" class="hiddenFat-'.$rowId."-".$attributeName."-".$count.'" id="hiddenFat-'.$rowId."-".$attributeName."-".$count.'" value="'.$result["calculatedFat"].'" />

					<input type="hidden" class="hiddenCarbohydrates-'.$rowId."-".$attributeName."-".$count.'" id="hiddenCarbohydrates-'.$rowId."-".$attributeName."-".$count.'" value="'.$result["calculatedCarbohydrates"].'" />

					<input type="hidden" class="hiddenFiber-'.$rowId."-".$attributeName."-".$count.'" id="hiddenFiber-'.$rowId."-".$attributeName."-".$count.'" value="'.$result["calculatedFiber"].'" />

					<input type="hidden" class="hiddenCalories-'.$rowId."-".$attributeName."-".$count.'" id="hiddenCalories-'.$rowId."-".$attributeName."-".$count.'" value="'.$result["calculatedCalories"].'" />


					<input type="hidden" class="hiddenUOM_'.$rowId.'_'.$attributeName.'_'.$count.'" id="hiddenUOM_'.$rowId.'_'.$attributeName.'_'.$count.'" value="'.$unitofmeasure.'" />

		 <input type="hidden" class="hiddenRowInfo_'.$rowId.'_'.$attributeName.'_'.$count.'" id="hiddenRowInfo_'.$rowId.'_'.$attributeName.'_'.$count.'" value="'.$hiddenRowInfo.'" />


					<input type="hidden" name="attributeName" value="'.$attributeName.'" />
					<input type="hidden" name="rowid" value="'.$rowId.'" />
				</div>

					</div> 
					<div class="formtd" style="text-align:justify;width:40%;padding-left: 5px;">Cal:<label class="labelcalories_'.$rowId.'_'.$attributeName.'_'.$count.'" 
						  id="labelcalories_'.$rowId.'_'.$attributeName.'_'.$count.'" >'.$result["calculatedCalories"].'</label>,
                                                   Carb: <label class="labelcarbohydrate_'.$rowId.'_'.$attributeName.'_'.$count.'" 
						  id="labelcarbohydrate_'.$rowId.'_'.$attributeName.'_'.$count.'" >'.$result["calculatedCarbohydrates"].' gm</label>
                                   </div>		
					 <span class="deleteImg" onclick="deleteItem(\''.$rowId.'\',\''.$cuisine.'\',\''.$entityId.'\',\''.$count.'\')"></span> 
					</div>';
						
					//	echo $cusineDetailResult; die;
				
			   }
			}
	  }
               
           
            }
			//echo "666666666666666";  
	
	         if($count>0){
			 
			   
			 if($cuisine=='dinner'){ 
				 $cuisine_total_protein		=  round($healOrder->getDinnerTotalProtein());
				 $cuisine_total_fat		= round($healOrder->getDinnerTotalFat());
				 $cuisine_total_carbohydrates   = round($healOrder->getDinnerTotalCarbohydrates());
				 $cuisine_total_fiber           = round($healOrder->getDinnerTotalFiber());
				 $cuisine_total_calories        = round($healOrder->getDinnerTotalCalories());
				 
			 }
			 else if($cuisine=='breakfast'){
				 $cuisine_total_protein		= round($healOrder->getBreakfastTotalProtein());
				 $cuisine_total_fat		= round($healOrder->getBreakfastTotalFat());
				 $cuisine_total_carbohydrates   = round($healOrder->getBreakfastTotalCarbohydrates());
				 $cuisine_total_fiber           = round($healOrder->getBreakfastTotalFiber());
				 $cuisine_total_calories        = round($healOrder->getBreakfastTotalCalories());
			 }  
			 else  if($cuisine=='lunch'){ 
				 $cuisine_total_protein	        = round($healOrder->getLunchTotalProtein());
				 $cuisine_total_fat		= round($healOrder->getLunchTotalFat());
				 $cuisine_total_carbohydrates   = round($healOrder->getLunchTotalCarbohydrates());
				 $cuisine_total_fiber           = round($healOrder->getLunchTotalFiber());
				 $cuisine_total_calories        = round($healOrder->getLunchTotalCalories());
			 }  
			 else  if($cuisine=='hightea'){ 
				 $cuisine_total_protein		= round($healOrder->getHighteaTotalProtein());
				 $cuisine_total_fat		= round($healOrder->getHighteaTotalFat());
				 $cuisine_total_carbohydrates   = round($healOrder->getHighteaTotalCarbohydrates());
				 $cuisine_total_fiber           = round($healOrder->getHighteaTotalFiber());
				 $cuisine_total_calories        = round($healOrder->getHighteaTotalCalories());
			 } 
			   
			   
		$cuisine_total_calory_for_percent = $cuisine_total_protein	+ $cuisine_total_fat + $cuisine_total_carbohydrates;
		$cuisine_protein_percent = 	 ($cuisine_total_protein/$cuisine_total_calory_for_percent)*100;  
		$cuisine_fat_percent = 	 ($cuisine_total_fat/$cuisine_total_calory_for_percent)*100;	
		$cuisine_carbohydrate_percent = 	 ($cuisine_total_carbohydrates/$cuisine_total_calory_for_percent)*100;	   
	 }
		   
	  }
	 // echo "9999999999999999999";  
	  $cusineDetailResult.=' <div class="'.$rowId.'-info-'.$cuisine.'">
	    <div><strong>'.ucfirst($cuisine).'  Total Cal:</strong><label class="'.$rowId.'_'.$cuisine.'_total_calories" >'.$cuisine_total_calories.'</label></div>
	    <div><strong> Protein:</strong><label class="'.$rowId.'_'.$cuisine.'_total_protein" >'.$cuisine_total_protein.' (Cal),'.round($cuisine_total_protein/4).'gm,'.(int)$cuisine_protein_percent.' %</label></div>
	    <div><strong> Fat:</strong><label class="'.$rowId.'_'.$cuisine.'_total_fat" >'.$cuisine_total_fat.' (Cal),'.round($cuisine_total_fat/9).'gm,'.(int)$cuisine_fat_percent.' %</label></div>
	    <div><strong> Carbohydrates:</strong><label class="'.$rowId.'_'.$cuisine.'_total_carbohydrates" >'.$cuisine_total_carbohydrates.' (Cal),'.round($cuisine_total_carbohydrates/4).'gm,'.(int)$cuisine_carbohydrate_percent.' %</label></div>
	    <div><strong> Fiber:</strong><label class="'.$rowId.'_'.$cuisine.'_total_fiber" >'.$cuisine_total_fiber.' gm</label></div>
     </div>
	 <div class="formtr"  style="display:none;">
					<div class="formtd" style="width:27%">
					<input type="text" class="'.$rowId.'_numberofrows_'.$attributeName.'" id="'.$rowId.'_numberofrows_'.$attributeName.'" value="'.$count.'"  />
		</div>
	 </div>
	  <div  class="buttonadditem" onclick="addNewMenuItem(\''.$rowId.'\',\''.$cuisine.'\',\''.$count.'\')"> <img title="Add New Item" src="'.Mage::getBaseUrl( Mage_Core_Model_Store::URL_TYPE_WEB, true ).'skin/frontend/rwd/default/images/additemimage.jpg"> </div>' ;
	  return  $cusineDetailResult;
	 // echo  $cusineDetailResult;
      } 
	 
   
	   public function getMealInfo($healOrder)
	   {
		   $customerMealInfo = array();
		   $customerEmail = $healOrder->getEmail();
		   $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
		  
		   $customerMealsql = "select count(*) as totalDeliveredMeals from healorder   where email='".$customerEmail."' and id < ".$healOrder->getId();
		   $data= $connection->query($customerMealsql);
		   $dataRow = $data->fetch($datacheck);
		   $customerMealInfo['totalDeliveredMeals'] = (int)($dataRow['totalDeliveredMeals']+1);
		  
		   
	       $customer = Mage::getModel("customer/customer"); 
           $customer->setWebsiteId(Mage::app()->getWebsite()->getId()); 
           $customer->loadByEmail($customerEmail);
		  
		   $gracePeriod = 3;
		   $customerMealInfo['target']= $gracePeriod;
		   $customerMealInfo['usingGracePeriod']='<span style="font-size:9px;color:green">No</span>'; 
	       $customerMealInfo['packageDays'] = ($customer->getPackageDays()!='')?($customer->getPackageDays()):'not defined';
	       $target = ($customer->getTarget()!='')?$customer->getTarget():'Not defined';	
		   $customerMealInfo['target']= $target;
		   $customerMealInfo['mobile']= Mage::getBaseUrl().'menuorder?id='.$healOrder->getMobile();
		   
		   
		   if($customerMealInfo['packageDays']=='not defined')
		   {
			  $customerMealInfo['allowMealDelivery']='yes';   
		   }
		   else 
		   {
				   if( $customerMealInfo['totalDeliveredMeals'] <= ($customerMealInfo['packageDays']+$gracePeriod) )
				   {
					   $customerMealInfo['allowMealDelivery']='yes';  
				   }
				   else
				   {
					   $customerMealInfo['allowMealDelivery']='no';  
					   $customerMealInfo['mobile']="javascript:void(0)";
					   
				   }	
		   }
		   
		   if( $customerMealInfo['packageDays']!='not defined' && ($customerMealInfo['totalDeliveredMeals'] > $customerMealInfo['packageDays']) )
		   {
			  $customerMealInfo['usingGracePeriod']='<span style="font-size:9px;color:red">Yes</span>'; 
		   }
		////////////////////////////////////////////////// Customer Leve of Carbs and calory ////////////////   
                     
         	$mealLevel = $customer->getMeallevel(); 
               // if(!isset($mealLevel)) {$mealLevel =2; }
              
               
                
               if(isset($mealLevel) && $mealLevel >0)
                {
                    $id=1;
                    $calorycarbsModel = Mage::getModel("calorycarbslevel/calorycarbslevel")->load($id);
                    
                    if($mealLevel==1)
                    {
                        $levelCarbs  = $calorycarbsModel->getLevel1Carbs();
                        $calory = $calorycarbsModel->getLevel1Calory();
                        $levelCalory = explode("-", $calory);
                        
                        $carbsCalArray['level'] =1 ;
                        $carbsCalArray['opr'] = 'below';
                        $carbsCalArray['carbs'] = $levelCarbs;
                        $carbsCalArray['calory-min'] =$levelCalory[0] ;
                        $carbsCalArray['calory-max'] =$levelCalory[1] ;
                       
                    }
                    if($mealLevel==2)
                    {
                        $levelCarbs  = $calorycarbsModel->getLevel2Carbs();
                        $calory = $calorycarbsModel->getLevel2Calory();
                        $levelCalory = explode("-", $calory);
                        
                        $carbsCalArray['level'] =2 ;
                        $carbsCalArray['opr'] ='below';
                        $carbsCalArray['carbs'] = $levelCarbs;
                        $carbsCalArray['calory-min'] = $levelCalory[0] ;
                        $carbsCalArray['calory-max'] = $levelCalory[1] ;
                       
                    }
                    if($mealLevel==3)
                    {
                        $levelCarbs  = $calorycarbsModel->getLevel3Carbs();
                        $calory = $calorycarbsModel->getLevel3Calory();
                        $levelCalory = explode("-", $calory);
                        
                        $carbsCalArray['level'] =3 ;
                        $carbsCalArray['opr'] ='below';
                        $carbsCalArray['carbs'] = $levelCarbs;
                        $carbsCalArray['calory-min'] = $levelCalory[0] ;
                        $carbsCalArray['calory-max'] = $levelCalory[1] ;
                        
                    }
                    if($mealLevel==4)
                    {
                       $levelCarbs  = $calorycarbsModel->getLevel4Carbs();
                        $calory = $calorycarbsModel->getLevel4Calory();
                        $levelCalory = explode("-", $calory);
               
                        $carbsCalArray['level'] =4 ;         
                        $carbsCalArray['opr'] ='below';
                        $carbsCalArray['carbs'] = $levelCarbs;
                        $carbsCalArray['calory-min'] = $levelCalory[0] ;
                        $carbsCalArray['calory-max'] = $levelCalory[1] ;
                         
                    }
                    if($mealLevel==5)
                    {
                        $levelCarbs  = $calorycarbsModel->getLevel5Carbs();
                        $calory = $calorycarbsModel->getLevel5Calory();
                        $levelCalory = explode("-", $calory);
               
                        $carbsCalArray['level'] =5 ;         
                        $carbsCalArray['opr'] ='below';
                        $carbsCalArray['carbs'] = $levelCarbs;
                        $carbsCalArray['calory-min'] = $levelCalory[0] ;
                        $carbsCalArray['calory-max'] = $levelCalory[1] ;
                       
                    }
                    if($mealLevel==6)
                    {
                        $levelCarbs  = $calorycarbsModel->getLevel6Carbs();
                        $calory = $calorycarbsModel->getLevel6Calory();
                        $levelCalory = explode("-", $calory);
               
                        $carbsCalArray['level'] =6 ;         
                        $carbsCalArray['opr'] ='below';
                        $carbsCalArray['carbs'] = $levelCarbs;
                        $carbsCalArray['calory-min'] = $levelCalory[0] ;
                        $carbsCalArray['calory-max'] = $levelCalory[1] ;
                         
                    }
                    
                    
                   $customerMealInfo['carbsCaloryInfo'] = implode("_",$carbsCalArray);
                    
                }
                
               ////////////////////////////////////////////  get customer allergy and dislike /////////////////
                $customerId = $customer->getId();
                $checkdataexist = "SELECT * FROM `heal_order_review` WHERE `customerid` = '".$customerId."' AND (`allergies` IS NOT NULL  OR `dislikename` IS NOT NULL) AND `productid` = '' ";
		$datacheck = $connection->query($checkdataexist);
                $check_fetch = $datacheck->fetch();
                if(isset($check_fetch) )
                {
                   $allergyArray= array('allergy'=>$check_fetch['allergies'],'dislike'=>$check_fetch['dislikename']);
                   $customerMealInfo['allergyDislike'] =   $allergyArray;
                   
                }
		   
		   return $customerMealInfo;
	   }
           
           
           
           public function checkCustomerCarbsCalory($customerEmail)
           {
               
                $customer = Mage::getModel("customer/customer"); 
		$customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
		$customer->loadByEmail($customerEmail);
               
                $mealLevel = $customer->getMeallevel(); //die;
                $carbsCalArray = array();
                if(isset($mealLevel) && $mealLevel >0)
                {
                    $id=1;
                    $calorycarbsModel = Mage::getModel("calorycarbslevel/calorycarbslevel")->load($id);
                    
                    if($mealLevel==1)
                    {
                        $levelCarbs  = $calorycarbsModel->getLevel1Carbs();
                        $calory = $calorycarbsModel->getLevel1Calory();
                        $levelCalory = explode("-", $calory);
                        
                        $carbsCalArray['opr'] = 'below';
                        $carbsCalArray['carbs'] = $levelCarbs;
                        $carbsCalArray['calory-min'] =$levelCalory[0] ;
                        $carbsCalArray['calory-max'] =$levelCalory[1] ;
                        $carbsCalArray['level'] =1 ;
                    }
                    if($mealLevel==2)
                    {
                        $levelCarbs  = $calorycarbsModel->getLevel2Carbs();
                        $calory = $calorycarbsModel->getLevel2Calory();
                        $levelCalory = explode("-", $calory);
                        
                        $carbsCalArray['opr'] ='below';
                        $carbsCalArray['carbs'] = $levelCarbs;
                        $carbsCalArray['calory-min'] = $levelCalory[0] ;
                        $carbsCalArray['calory-max'] = $levelCalory[1] ;
                         $carbsCalArray['level'] =2 ;
                    }
                    if($mealLevel==3)
                    {
                        $levelCarbs  = $calorycarbsModel->getLevel3Carbs();
                        $calory = $calorycarbsModel->getLevel3Calory();
                        $levelCalory = explode("-", $calory);
                        
                        $carbsCalArray['opr'] ='below';
                        $carbsCalArray['carbs'] = $levelCarbs;
                        $carbsCalArray['calory-min'] = $levelCalory[0] ;
                        $carbsCalArray['calory-max'] = $levelCalory[1] ;
                        $carbsCalArray['level'] =3 ;
                    }
                    if($mealLevel==4)
                    {
                       $levelCarbs  = $calorycarbsModel->getLevel4Carbs();
                        $calory = $calorycarbsModel->getLevel4Calory();
                        $levelCalory = explode("-", $calory);
                        
                        $carbsCalArray['opr'] ='below';
                        $carbsCalArray['carbs'] = $levelCarbs;
                        $carbsCalArray['calory-min'] = $levelCalory[0] ;
                        $carbsCalArray['calory-max'] = $levelCalory[1] ;
                         $carbsCalArray['level'] =4 ;
                    }
                    if($mealLevel==5)
                    {
                        $levelCarbs  = $calorycarbsModel->getLevel5Carbs();
                        $calory = $calorycarbsModel->getLevel5Calory();
                        $levelCalory = explode("-", $calory);
                        
                        $carbsCalArray['opr'] ='below';
                        $carbsCalArray['carbs'] = $levelCarbs;
                        $carbsCalArray['calory-min'] = $levelCalory[0] ;
                        $carbsCalArray['calory-max'] = $levelCalory[1] ;
                         $carbsCalArray['level'] =5 ;
                    }
                    if($mealLevel==6)
                    {
                        $levelCarbs  = $calorycarbsModel->getLevel6Carbs();
                        $calory = $calorycarbsModel->getLevel6Calory();
                        $levelCalory = explode("-", $calory);
                        
                        $carbsCalArray['opr'] ='below';
                        $carbsCalArray['carbs'] = $levelCarbs;
                        $carbsCalArray['calory-min'] = $levelCalory[0] ;
                        $carbsCalArray['calory-max'] = $levelCalory[1] ;
                         $carbsCalArray['level'] =6 ;
                    }
                    
                }
                return $carbsCalArray;
               
           }
	   
	   
	  public function getStyleForLikeDislike($healOrder,$entityId)
           {
               $customer = Mage::getModel("customer/customer"); 
		$customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
		$customer->loadByEmail($healOrder->getEmail());
                $customerId = $customer->getEntityId();
             //   $customerId=14;
               
               $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
	      //echo $checkdataexist = "SELECT * FROM `heal_order_review` WHERE `customerid` = '".$customerId."' AND `productid` = '".$entityId."' ";
	       $checkdataexist = "SELECT * FROM `heal_order_review`  WHERE `customerid` = '".$customerId."' AND `productid` = '".$entityId."' ";
               $dataRow = $connection->fetchRow($checkdataexist);
              
               $style='';
               if(isset($dataRow)  && $dataRow['customerid']!='')
               {
                  
                     $like =  $dataRow['like'];
                     $dislike = $dataRow['dislike'];
                     
                     if($like==1)
                     {
                         $style=";color:green";
                     }
                     else if($dislike==1)
                     {
                        $style=";color:red"; 
                     }
                     return $style;   
               }
               
           }
		   
		   public function generate_Zoho_access_token()
		 {
				$post = [
						  'refresh_token'=>'1000.1a7133be900c641b3ac8ddeb05bcbf0d.c1d63d9bf306de654bc79a45e0f3d7af',
						  
						  'client_id'=>'1000.QG6I1UVFV6A4AICNPNEZLEBCJMNCTL',
						  'client_secret'=>'e6e4ffcfeb851f261a3cdfaba08d1598a994e4aeda',
						  'grant_type'=>'refresh_token'
						  ];

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,"https://accounts.zoho.in/oauth/v2/token");
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);  
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded'));

				$response = curl_exec($ch);
				$decodedText = html_entity_decode($response);
				$accessTokenArray = json_decode($decodedText, true);
				//var_dump($response);
				
				return  $accessTokenArray['access_token'];
		 }
		 
		 

    public function getDishItemsWeight($product,$customDishTotalQty)
	{
	   $dishWeightAndPrice =  $this->getDishPrice($product);
	   $dishTotalWeight = $dishWeightAndPrice['totalWeightOfDish'];
	   $dishTotalPrice = $dishWeightAndPrice['totalPriceOfDish'];
	   $baseAssociatedSkus =  $product->getBaseAssociatedSku(); 
	   $baseAssociatedSkuWeightArray = array();
	   if($baseAssociatedSkus!='')
	   {
		   $baseAssociatedSkuWeightArray = explode(",",$baseAssociatedSkus);
	   }
	   $result.='<table cellpadding="2" cellspacing="2" width="100%"  style="margin-top:0px!important">
				 <tr><td style="width:47%;valign:top"><strong>Total</strong></td><td><strong>'.$customDishTotalQty.'</strong></td></tr>';
	   foreach($baseAssociatedSkuWeightArray as $key =>$value)
	   {
			
			$skuWeightArray = explode("_",$value);
			$baseSku        =  $skuWeightArray[0];
			$baseProduct    = Mage::getModel('catalog/product')->loadByAttribute("sku",$baseSku);
			if(is_object($baseProduct) && sizeof($skuWeightArray)==3 )
			{
				       
				$tmpCustomQtyValue = ($skuWeightArray[1]/$dishTotalWeight)*$customDishTotalQty;
				$customQtyValue = number_format((float)$tmpCustomQtyValue, 1, '.', '');
				$name= $baseProduct->getName();	
				$result.='<tr><td style="valign:top">'.$name.'</td><td>'.$customQtyValue.'</td></tr>';
											
											
					
			}
		}
		$result.='</table>';
		return $result;
	}




         public function getDishPrice($product)
		 {
			 if(is_object($product))
			 {
				 $completeDish = $product->getCompleteDish();
				 if(isset($completeDish) && $completeDish==1)
				 {
					 			 
					 $baseAssociatedSkus='';
					 $totalWeight=0;
					 $totalPrice=0;
					 $defaultUOM = 'gm';
					 $baseAssociatedSkus =  $product->getBaseAssociatedSku(); 
					 $customeQtyPrice=0;
					 
					 $dishInfo = array();
						
					 if($baseAssociatedSkus!='')
					 {
						$baseAssociatedSkuWeightArray = explode(",",$baseAssociatedSkus);
						if(sizeof($baseAssociatedSkuWeightArray)>0)
						{
							///////////////////////Start Calculate Total Weight And Price //////////////////
							  
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
													
													if($baseItemUOM=='Kgs')
													{$defaultUOM = 'gm';}
													else if($baseItemUOM=='Lt')
													{$defaultUOM = 'ml';}
												
																	
													
													$defaultBasePriceBeforeWastage = $baseProduct->getBasePrice1kg();
													$defaultBaseWastagePercent = $baseProduct->getBaseWastagePercent();
													$defaultBaseWastePrice = ($baseProduct->getBasePrice1kg() * $defaultBaseWastagePercent ) /100;
													$defaultBasePriceAfterWastage = $baseProduct->getBasePriceAfterWastage();
													
																		
													$tmpWastagePercent = $baseProduct->getBaseWastagePercent();
													$baseWastagePercent = (isset($tmpWastagePercent) && ($tmpWastagePercent>0)) ?$tmpWastagePercent:'N/a';
													
													
												
													
													//echo "Size =".sizeof($skuWeightArray);
													if(sizeof($skuWeightArray)==3)
													{
														$customQtyValue           = $skuWeightArray[1];
														$unitOfMeasure            = $skuWeightArray[2];
																		   
												
													  if(strtolower($unitOfMeasure) == 'gm' || strtolower($unitOfMeasure) == 'ml' )
													  { $baseItemQty    =   $customQtyValue  ;  }
																		   
													   if(isset($defaultBasePriceBeforeWastage) && $defaultBasePriceBeforeWastage>0)
													   {
																					   
														 $basePriceBeforeWastage =   ($defaultBasePriceBeforeWastage/1000) * $baseItemQty;
														
													   }
													   
																		   
													   
													   $basePriceAfterWastage =  ( $defaultBasePriceAfterWastage/1000) * $baseItemQty;
													  
													   
													}
													else
													{
														
														$baseItemQty           = $baseProduct->getBaseQty()*1000;
														$basePriceAfterWastage = $baseProduct->getBasePriceAfterWastage();
														
													}
													
													
													//echo $baseItemQty; echo "<br>";
													$totalWeight+=  $baseItemQty;
													$totalPrice+=   $basePriceAfterWastage;
													
													$baseItemName  = $baseProduct->getName();
														
													
											   
												  
											}
										}
							
							///////////////////////End Calculate Total Weight And Price //////////////////
						}
					 }
					 
					  $dishInfo['totalWeightOfDish'] = $totalWeight;
					  $dishInfo['totalPriceOfDish'] =  $totalPrice;
					  return $dishInfo;
		 }
		 
	  }
	}
	  

    public function getProductsQtyOfOrderDate($orderdate,$city) {
		$dbRead  = Mage::getSingleton('core/resource')->getConnection('core_read');
		$selectDatewiseOrders= "select * from healorder where  city='".ucfirst($city)."' and orderdate='$orderdate'";  
		$cuisineResult = $dbRead->fetchAll($selectDatewiseOrders);
		$orderItemsArray = array();	
		
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
							  
							  
							  if(!array_key_exists($healitemProductid,$orderItemsArray) )
									{
									   $orderItemsArray[$healitemProductid] = $qty;
									}
									else 
									{    $itemAlreadyInArrayQty=0;
										 $itemAlreadyInArrayQty = $orderItemsArray[$healitemProductid];
										 $newQty = $itemAlreadyInArrayQty + $orderdetailitem['qty'];
										 $orderItemsArray[$healitemProductid] = $newQty;

									}							
						  	}

					 	}
					 
				  	}
			    }
			  }
			
			}			
		}
		return $orderItemsArray;
	}



	public function getProductsQtyBetweenOrderDate($orderdate,$orderdate2,$city) {
		$dbRead  = Mage::getSingleton('core/resource')->getConnection('core_read');	
		
		$selectDatewiseOrders = "SELECT * FROM healorder WHERE city='".ucfirst($city)."' and orderdate >= '" . $orderdate . "' AND  orderdate <= '" . $orderdate2 . "'";
		
		$cuisineResult = $dbRead->fetchAll($selectDatewiseOrders);
		$orderItemsArray = array();	
		
		if(count($cuisineResult)>0)
		{
			$cuisineItemsDesc = array();
			
			foreach($cuisineResult as $row)	{
			  $orderId               =  $row['id'];	
			  $dinner_items_desc     = 	$row['dinner_items_desc'];    $cuisineItemsDesc['dinner'] = $dinner_items_desc;
			  $breakfast_items_desc  = 	$row['breakfast_items_desc']; $cuisineItemsDesc['breakfast'] = $breakfast_items_desc;
			  $lunch_items_desc      = 	$row['lunch_items_desc'];     $cuisineItemsDesc['lunch'] = $lunch_items_desc;
			  $hightea_items_desc    = 	$row['hightea_items_desc'];	  $cuisineItemsDesc['hightea'] = $hightea_items_desc;
				
			foreach($cuisineItemsDesc as $cuisine=>$itemDesc) {				 
				 $cuisineDescItems = explode(",",$itemDesc);
				  
				if(count($cuisineDescItems)>0) {	 
				   foreach($cuisineDescItems as $singleItem) {
						$singleItemInfo = explode("_",$singleItem);				  
						$productid = $singleItemInfo[1]; 
						$QgetOrderItemsDetails = "select * from  healitemdetails where orderid='$orderId' and cuisine='$cuisine' and productid='$productid'" ; 
					  
						$orderItems='';
					 	$orderItems = $dbRead->fetchAll($QgetOrderItemsDetails);
					  	if(count($orderItems) >0) {                         
						  foreach($orderItems as $orderdetailitem)	{
							$healitemProductid = trim($orderdetailitem['productid']);
							  $qty               =  trim($orderdetailitem['qty']);
							  
							  
							  if(!array_key_exists($healitemProductid,$orderItemsArray) ){
									   $orderItemsArray[$healitemProductid] = $qty;
									} else {    
										$itemAlreadyInArrayQty=0;
										$itemAlreadyInArrayQty = $orderItemsArray[$healitemProductid];
										$newQty = $itemAlreadyInArrayQty + $orderdetailitem['qty'];
										$orderItemsArray[$healitemProductid] = $newQty;

									}						
						  }
					 }					 
				  }
			    }
			  }			
			}			
		}
		return $orderItemsArray;
	}
/*========================End of function ==================*/

}
	 