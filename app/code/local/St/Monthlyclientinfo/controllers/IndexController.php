<?php
class St_Monthlyclientinfo_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Monthly Client Report"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("monthly client report", array(
                "label" => $this->__("Monthly Report"),
                "title" => $this->__("Monthly Report")
		   ));

      $this->renderLayout(); 
	  
    }
	
	public function savemonthlyreportAction()
	{
	  $params      = $this->getRequest()->getParams(); 
	  
	  $name = htmlspecialchars(trim($params['name']),ENT_QUOTES);
	  $mobile = htmlspecialchars(trim($params['mobile']),ENT_QUOTES);
	  $hba1c = htmlspecialchars(trim($params['hba1c']),ENT_QUOTES);
	  $hscrp = htmlspecialchars(trim($params['hscrp']),ENT_QUOTES);
	  $hdl = htmlspecialchars(trim($params['hdl']),ENT_QUOTES);
	  $ldl = htmlspecialchars(trim($params['ldl']),ENT_QUOTES);
	  $vitamind = htmlspecialchars(trim($params['vitamind']),ENT_QUOTES);
	  $b12 = htmlspecialchars(trim($params['b12']),ENT_QUOTES);
	  $fasting = htmlspecialchars(trim($params['fasting']),ENT_QUOTES);
	  $pp = htmlspecialchars(trim($params['pp']),ENT_QUOTES);
	  $homair = htmlspecialchars(trim($params['homair']),ENT_QUOTES);
	  $homocysteine = htmlspecialchars(trim($params['homocysteine']),ENT_QUOTES);
	 
	  $rememberme=$params['rememberme']; 
	  
	  $db_write = Mage::getSingleton('core/resource')->getConnection('core_write');
	  $query ="INSERT INTO monthlyclientinfo (name, mobile, hba1c, hscrp, hdl, ldl, vitamind, b12, fasting, pp, homair, homocysteine) VALUES ('".$name."', '".$mobile."', '".$hba1c."', '".$hscrp."', '".$hdl."', '".$ldl."', '".$vitamind."', '".$b12."', '".$fasting."', '".$pp."', '".$homair."', '".$homocysteine."')";
	  $db_write->query($query);  
	 
	  if($rememberme=='true')
	  {
	   
	   $cookieName = 'monthlyclientinfo';
	   $value = $name."_".$mobile;
	   $period= (30 * 86400);
	   $cookie = Mage::getSingleton('core/cookie');
       $cookie->set($cookieName, $value,$period,'/');
	   
	  } 
	  
	   echo "inserted";
	
	}
}