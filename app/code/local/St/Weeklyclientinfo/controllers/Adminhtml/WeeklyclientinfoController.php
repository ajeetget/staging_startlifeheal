<?php

class St_Weeklyclientinfo_Adminhtml_WeeklyclientinfoController extends Mage_Adminhtml_Controller_Action
{
		protected function _isAllowed()
		{
		//return Mage::getSingleton('admin/session')->isAllowed('weeklyclientinfo/weeklyclientinfo');
			return true;
		}

		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("weeklyclientinfo/weeklyclientinfo")->_addBreadcrumb(Mage::helper("adminhtml")->__("Weeklyclientinfo  Manager"),Mage::helper("adminhtml")->__("Weeklyclientinfo Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Weeklyclientinfo"));
			    $this->_title($this->__("Manager Weeklyclientinfo"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Weeklyclientinfo"));
				$this->_title($this->__("Weeklyclientinfo"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("weeklyclientinfo/weeklyclientinfo")->load($id);
				if ($model->getId()) {
					Mage::register("weeklyclientinfo_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("weeklyclientinfo/weeklyclientinfo");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Weeklyclientinfo Manager"), Mage::helper("adminhtml")->__("Weeklyclientinfo Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Weeklyclientinfo Description"), Mage::helper("adminhtml")->__("Weeklyclientinfo Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("weeklyclientinfo/adminhtml_weeklyclientinfo_edit"))->_addLeft($this->getLayout()->createBlock("weeklyclientinfo/adminhtml_weeklyclientinfo_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("weeklyclientinfo")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Weeklyclientinfo"));
		$this->_title($this->__("Weeklyclientinfo"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("weeklyclientinfo/weeklyclientinfo")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("weeklyclientinfo_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("weeklyclientinfo/weeklyclientinfo");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Weeklyclientinfo Manager"), Mage::helper("adminhtml")->__("Weeklyclientinfo Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Weeklyclientinfo Description"), Mage::helper("adminhtml")->__("Weeklyclientinfo Description"));


		$this->_addContent($this->getLayout()->createBlock("weeklyclientinfo/adminhtml_weeklyclientinfo_edit"))->_addLeft($this->getLayout()->createBlock("weeklyclientinfo/adminhtml_weeklyclientinfo_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {

						

						$model = Mage::getModel("weeklyclientinfo/weeklyclientinfo")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Weeklyclientinfo was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setWeeklyclientinfoData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setWeeklyclientinfoData($this->getRequest()->getPost());
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
						$model = Mage::getModel("weeklyclientinfo/weeklyclientinfo");
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
				$ids = $this->getRequest()->getPost('clientids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("weeklyclientinfo/weeklyclientinfo");
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
			$fileName   = 'weeklyclientinfo.csv';
			$grid       = $this->getLayout()->createBlock('weeklyclientinfo/adminhtml_weeklyclientinfo_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'weeklyclientinfo.xml';
			$grid       = $this->getLayout()->createBlock('weeklyclientinfo/adminhtml_weeklyclientinfo_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
