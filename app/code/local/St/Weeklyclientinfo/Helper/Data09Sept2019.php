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
					else if(  ($finalUpperBp >=120 && $finalUpperBp<129) && $finalLowerBp<80  )
					{
						$diseaseResult['bpresult']=$good; 
						$diseaseResult['bplabel']='Elevated';
					}
					else if(  ($finalUpperBp >=130 && $finalUpperBp<139) || ($finalLowerBp >80 && $finalLowerBp<89 ) )
					{
						$diseaseResult['bpresult']=$notgood; 
						$diseaseResult['bplabel']='Hypertension Stage1';
					}
					else if(  ($finalUpperBp >=140 && $finalUpperBp<180) || ($finalLowerBp >90 && $finalLowerBp<=120 ) )
					{
						$diseaseResult['bpresult']=$notgood; 
						$diseaseResult['bplabel']='Hypertension Stage2';
					}
					else if(  $finalUpperBp >=180  || $finalLowerBp>=120 )
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
}
	 