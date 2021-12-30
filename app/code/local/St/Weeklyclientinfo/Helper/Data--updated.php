<?php
class St_Weeklyclientinfo_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function checkDiseaseLevel()
	{
		$customer = Mage::getSingleton('customer/session')->getCustomer();
		$collection = Mage::getModel("weeklyclientinfo/weeklyclientinfo")->getCollection()
		              ->addFieldToFilter("customerid",$customer->getEntityId());
		$collection->setOrder('date','DESC');
					 
			
		$diseaseResult = Array();
		$finalUpperBp='';
		$finalLowerBp='';
		$finalTg='';
		$finalHdl='';
		$finalWaist='';
		$finalHeight='';
		$finalFastinggl='';
		$finalWaistToHeight='';
			
		$good='Good';
		$notgood = 'Not Good';
		$nodata  = 'No Data';
				
		if(count($collection)>0)
		{
				foreach($collection as $row) 
				{
					
					$id = $row->getGraphinfoId();
					
					$upperBP = $row->getUpperbp();
					  if($finalUpperBp=='' && $upperBP!=''){ $finalUpperBp = $upperBP;}
					
					$lowerBP = $row->getLowerbp();
					   if($finalLowerBp=='' && $lowerBP!=''){ $finalLowerBp = $lowerBP;}
					   
					$height = $row->getHeight();
						if($finalHeight=='' && $height!=''){ $finalHeight = (float)$height; }	   
					
					$waist = $row->getWaist();
					   if($finalWaist=='' && $waist!=''){ $finalWaist = (float)$waist; }
					
					
					$hdl = $row->getHdl();
					   if($finalHdl=='' && $hdl!=''){ $finalHdl = $hdl; }
					   
					$tg = $row->getTg();
						if($finalTg=='' && $tg!=''){ $finalTg = $tg; }   
								
					  
					$fastinggl = $row->getFastinggl();
					  if($finalFastinggl=='' && $fastinggl!=''){ $finalFastinggl =  $fastinggl; }
					  
					
					
					
				}
				if($finalHeight!='' && $finalWaist!='')
				{
					$finalWaistToHeight = $finalWaist/$finalHeight;
					$diseaseResult['height'] = $finalHeight;
				}
		
			//////////////////////////////// Calculate Blood Pressure /////////////////////
				
				
				
				
				
				
				if(( $finalUpperBp!='' && $finalUpperBp>0) && ($finalLowerBp!='' && $finalLowerBp >0 ))
				{
					//echo $finalUpperBp."--".$finalLowerBp; 
					if(  $finalUpperBp<120 && $finalLowerBp<80  )
					{
						$diseaseResult['bpresult']=$good; 
						$diseaseResult['bplabel']='Normal';
					}
					else if(  $finalUpperBp >=120 && $finalUpperBp<129  )
					{
						$diseaseResult['bpresult']=$good; 
						$diseaseResult['bplabel']='Borderline Hypertensive';
					}
					else if(  $finalUpperBp >=130 && $finalUpperBp<=139  )
					{
						$diseaseResult['bpresult']=$notgood; 
						$diseaseResult['bplabel']='Hypertension Stage1';
					}
					else if(  $finalUpperBp >=140 && $finalUpperBp<180  )
					{
						$diseaseResult['bpresult']=$notgood; 
						$diseaseResult['bplabel']='Hypertension Stage2';
					}
					else if(  $finalUpperBp >=180  )
					{
						$diseaseResult['bpresult']=$notgood; 
						$diseaseResult['bplabel']='Hypertensive Crisis';
					}
					$diseaseResult['lowerBP']       = $finalLowerBp;
				    $diseaseResult['upperBP']       = $finalUpperBp;
				}
				else
				{
					
					$diseaseResult['lowerBP']  = 'Na';
				    $diseaseResult['upperBP']  = 'Na';
				    $diseaseResult['bpresult'] = $nodata;
					$diseaseResult['bplabel']  =  $nodata;
				}
				
				
				////////////////////////////////// Calculate TG //////////////////////////////
				
				if($finalTg!='' && $finalTg>0)
				{
					if($finalTg <150 )
					{
						$diseaseResult['tgresult']=$good; 
						$diseaseResult['tglabel']= 'Normal';
					}
					elseif($finalTg >150 && $finalTg <199)
					{
						$diseaseResult['tgresult']=$notgood; 
						$diseaseResult['tglabel']= 'Elevated'; 
					}
					elseif($finalTg >200 && $finalTg <499)
					{
						$diseaseResult['tgresult']=$notgood; 
						$diseaseResult['tglabel']= 'High'; 
					}
					elseif($finalTg >499 )
					{
						$diseaseResult['tgresult']=$notgood; 
						$diseaseResult['tglabel']= 'Very High'; 
					}
					$diseaseResult['tg'] = $finalTg;
				}
				else
				{
					$diseaseResult['tg'] = 'Na';
					$diseaseResult['tgresult']= $nodata; 
                    $diseaseResult['tglabel']= $nodata; 					
				}
				
				
				////////////////////////////////// Calculate HDL //////////////////////////////
				
				if( $finalHdl!='' && $finalHdl >0)
				{					
					if( $finalHdl < 40 )
					{
						$diseaseResult['hdlresult']=$notgood;
						$diseaseResult['hdlabel']='Risky'; 
					}
					
					else if( $finalHdl >=40 && $finalHdl<60 )
					{
						$diseaseResult['hdlresult']=$good; 
						$diseaseResult['hdlabel']='Normal'; 
					}
					else if( $finalHdl >=60 )
					{
						$diseaseResult['hdlresult']=$good; 
						$diseaseResult['hdlabel']='Best'; 
					}
					
					$diseaseResult['hdl']    		= $finalHdl;
				}
				else
				{
					$diseaseResult['hdl']    	= 'Na';
					$diseaseResult['hdlresult'] = $nodata; 
					$diseaseResult['hdlabel'] =   $nodata; 
				}
				
				////////////////////////////////// Calculate Fasting Glucose //////////////////////////////
				if($finalFastinggl!='' && $finalFastinggl >0)
				{
					if( $finalFastinggl< 100 )
					{
						$diseaseResult['fastingglucoseresult']=$good; 
						$diseaseResult['fastinglabel']='Non Diabetic';
					}
					elseif( $finalFastinggl>=100 &&  $finalFastinggl<=125)
					{
						$diseaseResult['fastingglucoseresult']=$notgood; 
						$diseaseResult['fastinglabel']='Pre Diabetic';
					}
					elseif( $finalFastinggl>=126 )
					{
						$diseaseResult['fastingglucoseresult']=$notgood; 
						$diseaseResult['fastinglabel']='Diabetic';
					}
					$diseaseResult['fastinggl']=$finalFastinggl;
				}
				else
				{
					$diseaseResult['fastinggl']='Na';
					$diseaseResult['fastingglucoseresult']=$nodata;
					$diseaseResult['fastinglabel']=$nodata;
					
				}
				
				
				if($finalWaistToHeight!='' && $finalWaistToHeight>0)
				{
					if( $finalWaistToHeight < .34 )
					{
						 $diseaseResult['WaistToHeightResult']=$notgood;  
						 $diseaseResult['ratiolabel']='Extremely Slim';  
					}
					else if( $finalWaistToHeight > .35 && $finalWaistToHeight < .45)
					{
						 $diseaseResult['WaistToHeightResult']=$notgood;  
						 $diseaseResult['ratiolabel']='Slim';  
					}
					else if( $finalWaistToHeight > .46 && $finalWaistToHeight < .51)
					{
						 $diseaseResult['WaistToHeightResult']=$good;  
						 $diseaseResult['ratiolabel']='Healthy';  
					}
					else if( $finalWaistToHeight > .52 && $finalWaistToHeight < .63)
					{
						 $diseaseResult['WaistToHeightResult']=$notgood;  
						 $diseaseResult['ratiolabel']='Over Weight';  
					}
					else if( $finalWaistToHeight > .63)
					{
						 $diseaseResult['WaistToHeightResult']=$notgood;  
						 $diseaseResult['ratiolabel']='Obesity';  
					}
					
				   $diseaseResult['WaistToHeight'] = number_format($finalWaistToHeight,2);
				}
				else
				{
					$diseaseResult['WaistToHeight']='Na';
					$diseaseResult['WaistToHeightResult']=$nodata;
					$diseaseResult['ratiolabel']= $nodata;
				}
			   
			   
			   
			   
		}
		else
		{
			$diseaseResult['height']='Na';
			$diseaseResult['lowerBP']='Na';
			$diseaseResult['upperBP']='Na';
			$diseaseResult['bpresult']=$nodata;
			$diseaseResult['bplabel']=$nodata;
			$diseaseResult['tg']='Na';
			$diseaseResult['tgresult']=$nodata;
			$diseaseResult['tglabel']=$nodata;
			$diseaseResult['hdl']='Na';
			$diseaseResult['hdlresult']=$nodata;
			$diseaseResult['hdlabel']=$nodata;
			$diseaseResult['fastinggl']='Na';
			$diseaseResult['fastingglucoseresult']=$nodata;
			$diseaseResult['fastinglabel']=$nodata;
			$diseaseResult['WaistToHeight']='Na';
			$diseaseResult['WaistToHeightResult']=$nodata;
			$diseaseResult['ratiolabel']= $nodata;
			
			
			
		}
			return $diseaseResult;
	}
	 
	
	function getBPData()
	{
		$customer = Mage::getSingleton('customer/session')->getCustomer();
		$collection = Mage::getModel("weeklyclientinfo/weeklyclientinfo")->getCollection()
		              ->addFieldToFilter("customerid",$customer->getEntityId());
		$collection->setOrder('date','DESC');
		//echo "count collection=".count($collection); die;
		$bpData = array();
		if(count($collection)>0)
		{        
                $count=0; 	
				foreach($collection as $row) 
				{
					++$count;
					
					$date = date("Y-m-d",strtotime($row->getCreatedat()));
					$bpData[$count]['date']=$date;
					$tmpUpperBP = $row->getUpperbp();
					$upperBP = ($tmpUpperBP!='')?$tmpUpperBP:'Na';
					$bpData[$count]['upperBP'] = $upperBP;
					$tmpLowerBP = $row->getLowerbp();
					$lowerBP = ($tmpLowerBP!='')?$tmpLowerBP:'Na';
					$bpData[$count]['lowerBP']=$lowerBP;
					   
				}
		}
           //	print_r($bpData);	
		  return $bpData;
	}
	
public function getTgdata()
	{
		$customer = Mage::getSingleton('customer/session')->getCustomer();
		$collection = Mage::getModel("weeklyclientinfo/weeklyclientinfo")->getCollection()
		              ->addFieldToFilter("customerid",$customer->getEntityId());
		$collection->setOrder('date','DESC');
		//echo "count collection=".count($collection);
		$tgData = array();
		if(count($collection)>0)
		{        
                $count=0; 	
				foreach($collection as $row) 
				{
					++$count;
									
					$date = date("Y-m-d",strtotime($row->getCreatedat())); 
					$tgData[$count]['date']=$date;
					$tmpTg = $row->getTg();
					$tg = (isset($tmpTg) && $tmpTg!='')?$tmpTg:'Na';
					$tgData[$count]['tg']=$tg;
					
					   
				}
		}
       		
		 return $tgData; 
	}
	
	public function getHDLdata()
	{
		$customer = Mage::getSingleton('customer/session')->getCustomer();
		$collection = Mage::getModel("weeklyclientinfo/weeklyclientinfo")->getCollection()
		              ->addFieldToFilter("customerid",$customer->getEntityId());
		$collection->setOrder('date','DESC');
		//echo "count collection=".count($collection);
		$hdlData = array();
		if(count($collection)>0)
		{        
                $count=0; 	
				foreach($collection as $row) 
				{
					++$count;
									
					$date = date("Y-m-d",strtotime($row->getCreatedat())); 
					$hdlData[$count]['date']=$date;
					$tmpHDL = $row->getHdl();
					$hdl = (isset($tmpHDL) && $tmpHDL!='')?$tmpHDL:'Na';
					$hdlData[$count]['hdl']=$hdl;
					
					   
				}
		}
       		
		 return $hdlData; 
	}
	
	public function getWaistToHeightRatio()
	{
		$customer = Mage::getSingleton('customer/session')->getCustomer();
		$collection = Mage::getModel("weeklyclientinfo/weeklyclientinfo")->getCollection()
		              ->addFieldToFilter("customerid",$customer->getEntityId());
		$collection->setOrder('date','DESC');
		//echo "count collection=".count($collection);
		$ratio = array();
		if(count($collection)>0)
		{        
                $count=0; 	
				foreach($collection as $row) 
				{
					++$count;
					$finalWaist='';	
                    $finalHeight='';
                    $finalRatio='Na';				
					$date = date("Y-m-d",strtotime($row->getCreatedat())); 
					$ratio[$count]['date']=$date;
					
					$height = $row->getHeight();
					if($height!=''){ $finalHeight = (float)$height; }	   
					
					$waist = $row->getWaist();
					if($waist!=''){ $finalWaist = (float)$waist; }
					
					if($finalHeight!='' && $finalWaist!='')
				    {
					   $finalRatio = number_format((float)$finalWaist/$finalHeight,2);
					   
					  $ratio[$count]['waist']=$finalWaist;
                      $ratio[$count]['height']=$finalHeight;  
					  $ratio[$count]['waistToHeightRatio']=$finalRatio;
					}
                    else
					{
						$ratio[$count]['waist']='Na';
                        $ratio[$count]['height']='Na';  
					    $ratio[$count]['waistToHeightRatio']='Na';
						
					}						
                    
					
				}
		}
       		
		 return $ratio; 
	}
	
	public function getFastingData()
	{
		$customer = Mage::getSingleton('customer/session')->getCustomer();
		$collection = Mage::getModel("weeklyclientinfo/weeklyclientinfo")->getCollection()
		              ->addFieldToFilter("customerid",$customer->getEntityId());
		$collection->setOrder('date','DESC');
		//echo "count collection=".count($collection);
		$FastingData = array();
		if(count($collection)>0)
		{        
                $count=0; 	
				foreach($collection as $row) 
				{
					++$count;
									
					$date = date("Y-m-d",strtotime($row->getCreatedat())); 
					$FastingData[$count]['date']=$date;
					$tmpFastingGL = $row->getFastinggl();
					$fastingGl = (isset($tmpFastingGL) && $tmpFastingGL!='')?$tmpFastingGL:'Na';
					$FastingData[$count]['fastinggl']=$fastingGl;
					
					   
				}
		}
       		
		 return $FastingData; 
	}
	
}
	 