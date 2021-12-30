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
}