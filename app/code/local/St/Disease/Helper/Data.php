<?php
class St_Disease_Helper_Data extends Mage_Core_Helper_Abstract
{
	
   public function getDiseaseLabel($diseaseName,$value)
  {
       //echo $diseaseName."------".$value;echo '<br>';   	
	 if($value!='')
	  {
	    $optionsArray = St_Disease_Block_Adminhtml_Disease_Grid::getOptionArray0();
	
	     $diseaseArray = preg_grep ("%$diseaseName%", $optionsArray);
	     $diseaseIndex =  array_keys($diseaseArray)[0];
	 
	     $collection = Mage::getModel("disease/disease")->getCollection()
            	   ->addFieldToFilter("disease",$diseaseIndex);
		        	// echo "collection size =".sizeof($collection); echo '<br>';   	
				
			 if(sizeof($collection)>0 && $value!='')
			 {  
				 
				  $count=0;
				  $row='';
				  foreach($collection as $rowinfo)
				  {
					 
						  $count++;					 
						//  echo $count."--loop"; 	echo '<br>';
						  $lowRange =  $rowinfo->getLowrange();
						  $highRange =  $rowinfo->getHighrange();
						  
						 // echo $lowRange."---".$highRange; echo '<br>';
						 
						  
						 
							  if(  ( $lowRange!='' && $value >= $lowRange) && ($highRange!='' && $value <=$highRange) )
							  {
								$row = $rowinfo;
								  
							  }
							  elseif(  ( $lowRange!='' && $value >= $lowRange) && ($highRange=='') )
							  {
								$row = $rowinfo;
								  
							  }
							 
						  
					
				  } 
				  
				 
				  if($row!='' )
				  {
				     return $row->getComment(); 
				  }
			}
		}
    }	
}
	 