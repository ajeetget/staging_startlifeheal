<?php
class St_Weeklyclientinfo_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Weekly Client Information"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("titlename", array(
                "label" => $this->__("Weekly Report"),
                "title" => $this->__("Weekly Report")
		   ));

      $this->renderLayout(); 
	  
    }
	
	public function saveAction()
	{
	  $params      = $this->getRequest()->getParams(); 
	 //echo "<pre>";  print_r($params);
	  $name = htmlspecialchars($params['name'],ENT_QUOTES);
	  $mobile = htmlspecialchars($params['mobile'],ENT_QUOTES);
	 
	  $weight = htmlspecialchars($params['weight'],ENT_QUOTES);
	  $waist = htmlspecialchars($params['waist'],ENT_QUOTES);
	  $bpsystolic = htmlspecialchars($params['bpsystolic'],ENT_QUOTES);
	  $bpdiastloc = htmlspecialchars($params['bpdiastloc'],ENT_QUOTES);
	 
	  $rememberme=$params['rememberme']; 
	  
	  $db_write = Mage::getSingleton('core/resource')->getConnection('core_write');
	  $query = "insert into weeklyclientinfo(name,mobile,weight,waist,bpsystolic,bpdiastloc)";
	  $query.= "values('".$name."','".$mobile."','".$weight."','".$waist."','".$bpsystolic."','".$bpdiastloc."')";
	  $db_write->query($query); 
	  
	  if($rememberme=='true')
	  {
	   
	   $cookieName = 'clientinfo';
	   $value = $name."_".$mobile;
	   $period= (30 * 86400);
	   $cookie = Mage::getSingleton('core/cookie');
       $cookie->set($cookieName, $value,$period,'/');
	   
	  } 
	  
	  echo "inserted";		  
	}
	
	 public function videoAction()
	{
		
		$params = $this->getRequest()->getParams(); 
		$videoName = $params['file'];
	//	echo "1";
		    $skinAbsolutePath = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN); //echo "<br>";
			$videoAbsolutePath = $skinAbsolutePath.'frontend/rwd/default/media/'.$videoName;
			$videoRelativePath = Mage::getBaseDir('skin').DS.'frontend/rwd/default/media/'.$videoName;
			
		
		$videoPlayer='';
		if($videoName!='' && is_file($videoRelativePath))
		{
		  	$videoPlayer.='<video controls id="video" width="100%" height="100%" autoplay disablepictureinpicture  controlsList="nodownload" style="border: 1px solid #eee;">';
            $videoPlayer.='<source src="'.$videoAbsolutePath.'" type="video/mp4" /></video>';      
		// $videoPlayer.='<source src="/video/Video1.mp4" type="video/mp4" /></video>';    
            echo $videoPlayer;
		}
		
	}
	
	 public function downloadinventoryAction()
	  {
			   $params = $this->getRequest()->getParams();
				$pdfName = $params['filename'];
				$filepath = Mage::getBaseDir('media').DS.'pdf'.DS.$pdfName; 
								
				if(file_exists($filepath)) {
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($filepath));
					flush(); // Flush system output buffer
					readfile($filepath);
					echo "Image has been downloaded";
                    
                    }
		           
	  }
}