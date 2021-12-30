<?php

class St_Monthlyclientinfo_Adminhtml_MonthlyclientinfoController extends Mage_Adminhtml_Controller_Action
{
		protected function _isAllowed()
		{
		//return Mage::getSingleton('admin/session')->isAllowed('monthlyclientinfo/monthlyclientinfo');
			return true;
		}

		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("monthlyclientinfo/monthlyclientinfo")->_addBreadcrumb(Mage::helper("adminhtml")->__("Monthlyclientinfo  Manager"),Mage::helper("adminhtml")->__("Monthlyclientinfo Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Monthlyclientinfo"));
			    $this->_title($this->__("Manager Monthlyclientinfo"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Monthlyclientinfo"));
				$this->_title($this->__("Monthlyclientinfo"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("monthlyclientinfo/monthlyclientinfo")->load($id);
				if ($model->getId()) {
					Mage::register("monthlyclientinfo_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("monthlyclientinfo/monthlyclientinfo");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Monthlyclientinfo Manager"), Mage::helper("adminhtml")->__("Monthlyclientinfo Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Monthlyclientinfo Description"), Mage::helper("adminhtml")->__("Monthlyclientinfo Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("monthlyclientinfo/adminhtml_monthlyclientinfo_edit"))->_addLeft($this->getLayout()->createBlock("monthlyclientinfo/adminhtml_monthlyclientinfo_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("monthlyclientinfo")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Monthlyclientinfo"));
		$this->_title($this->__("Monthlyclientinfo"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("monthlyclientinfo/monthlyclientinfo")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("monthlyclientinfo_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("monthlyclientinfo/monthlyclientinfo");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Monthlyclientinfo Manager"), Mage::helper("adminhtml")->__("Monthlyclientinfo Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Monthlyclientinfo Description"), Mage::helper("adminhtml")->__("Monthlyclientinfo Description"));


		$this->_addContent($this->getLayout()->createBlock("monthlyclientinfo/adminhtml_monthlyclientinfo_edit"))->_addLeft($this->getLayout()->createBlock("monthlyclientinfo/adminhtml_monthlyclientinfo_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {

						

						$model = Mage::getModel("monthlyclientinfo/monthlyclientinfo")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Monthlyclientinfo was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setMonthlyclientinfoData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setMonthlyclientinfoData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}



		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$model = Mage::getModel("monthlyclientinfo/monthlyclientinfo");
						$model->setId($this->getRequest()->getParam("id"))->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
						$this->_redirect("*/*/");
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}

		
		public function massRemoveAction()
		{
			try {
				$ids = $this->getRequest()->getPost('monthlyinfoids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("monthlyclientinfo/monthlyclientinfo");
					  $model->setId($id)->delete();
				}
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
			}
			catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			}
			$this->_redirect('*/*/');
		}
			
		/**
		 * Export order grid to CSV format
		 */
		public function exportCsvAction()
		{
			$fileName   = 'monthlyclientinfo.csv';
			$grid       = $this->getLayout()->createBlock('monthlyclientinfo/adminhtml_monthlyclientinfo_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'monthlyclientinfo.xml';
			$grid       = $this->getLayout()->createBlock('monthlyclientinfo/adminhtml_monthlyclientinfo_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
