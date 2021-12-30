<?php
class St_Foodpdf_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {

	  $this->loadLayout();
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Food Category and Items"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("food category and items", array(
                "label" => $this->__("Food Category and Items"),
                "title" => $this->__("Food Category and Items")
		   ));

      $this->renderLayout();

    }
	
	public function showAction() {

	  $this->loadLayout();
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Food Category and Items"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("food category and items", array(
                "label" => $this->__("Food Category and Items"),
                "title" => $this->__("Food Category and Items")
		   ));

      $this->renderLayout();

    }
	
	
	public function CategoryAction() {

	  $this->loadLayout();
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Food Category"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("food category", array(
                "label" => $this->__("Food Category"),
                "title" => $this->__("Food Category")
		   ));

      $this->renderLayout();

    }
	
	
	public function checkcategoryAction()
	{
		$params         = $this->getRequest()->getParams(); 
		$catname        = $params['catname'];
		$response='';
		if(isset($catname) && $catname!='')
		{
		
				$categoryCollection = Mage::getModel("foodpdf/foodcategory")->getCollection()
									  ->addFieldToFilter('name', $catname)
									  ->load();
				
				if(count($categoryCollection)>=1)
				{
					$response='exist';
				}
				else
				{
				    $response='notExist';
				}
			
		}
        echo $response;		
	}
	
	
	public function savecategoryAction()
	{
		$params         = $this->getRequest()->getParams(); 
		$catname        = $params['catname'];
		$status        = $params['status'];
		
		$response='';
		if(isset($catname) && $catname!='')
		{
		
				$categoryCollection = Mage::getModel("foodpdf/foodcategory")->getCollection()
									  ->addFieldToFilter('name', $catname)
									  
									  ->load();
				
				if(count($categoryCollection)>=1)
				{
					$response='exist';
				}
				else
				{
					$data = array('name'=>$catname,'status'=>$status);
					$catModel = Mage::getModel("foodpdf/foodcategory");
					$catModel->setData($data)->save();
				    $response='saved';
				}
			
		}
        echo $response;		
	}
	
	public function showcategoryAction()
	{ 
	   $categoryCollection = Mage::getModel("foodpdf/foodcategory")->getCollection()
									  //->addFieldToFilter('status', 1)
									  ->load();
		if($categoryCollection>0)
		{							  
			foreach($categoryCollection as $catInfo)
			{
			  $status = ($catInfo->getStatus()==1)?'Active':'Inactive';
			  ?>
			   <div >
				    <div><?php echo $catInfo->getName();?></div><div><?php echo $status;?></div>
			   </div>
					
										  
			<?php }
      
		}else {?>
		
		<div> There is no category.</div>
		
		<?php } } 
	
}