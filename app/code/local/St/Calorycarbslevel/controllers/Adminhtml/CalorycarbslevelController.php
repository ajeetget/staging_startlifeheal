<?php

class St_Calorycarbslevel_Adminhtml_CalorycarbslevelController extends Mage_Adminhtml_Controller_Action
{
		protected function _isAllowed()
		{
		//return Mage::getSingleton('admin/session')->isAllowed('calorycarbslevel/calorycarbslevel');
			return true;
		}

		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("calorycarbslevel/calorycarbslevel")->_addBreadcrumb(Mage::helper("adminhtml")->__("Calorycarbslevel  Manager"),Mage::helper("adminhtml")->__("Calorycarbslevel Manager"));
				return $this;
		}
		public function indexAction()
		{
			    $this->_title($this->__("Calorycarbslevel"));
			    $this->_title($this->__("Manager Calorycarbslevel"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{
			    $this->_title($this->__("Calorycarbslevel"));
				$this->_title($this->__("Calorycarbslevel"));
			    $this->_title($this->__("Edit Item"));

				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("calorycarbslevel/calorycarbslevel")->load($id);
				if ($model->getId()) {
					Mage::register("calorycarbslevel_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("calorycarbslevel/calorycarbslevel");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Calorycarbslevel Manager"), Mage::helper("adminhtml")->__("Calorycarbslevel Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Calorycarbslevel Description"), Mage::helper("adminhtml")->__("Calorycarbslevel Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("calorycarbslevel/adminhtml_calorycarbslevel_edit"))->_addLeft($this->getLayout()->createBlock("calorycarbslevel/adminhtml_calorycarbslevel_edit_tabs"));
					$this->renderLayout();
				}
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("calorycarbslevel")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Calorycarbslevel"));
		$this->_title($this->__("Calorycarbslevel"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("calorycarbslevel/calorycarbslevel")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
               
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("calorycarbslevel_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("calorycarbslevel/calorycarbslevel");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Calorycarbslevel Manager"), Mage::helper("adminhtml")->__("Calorycarbslevel Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Calorycarbslevel Description"), Mage::helper("adminhtml")->__("Calorycarbslevel Description"));


		$this->_addContent($this->getLayout()->createBlock("calorycarbslevel/adminhtml_calorycarbslevel_edit"))->_addLeft($this->getLayout()->createBlock("calorycarbslevel/adminhtml_calorycarbslevel_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();
 
				if ($post_data) {

					try {

						

						$model = Mage::getModel("calorycarbslevel/calorycarbslevel")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Calorycarbslevel was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setCalorycarbslevelData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					}
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setCalorycarbslevelData($this->getRequest()->getPost());
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
						$model = Mage::getModel("calorycarbslevel/calorycarbslevel");
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
				$ids = $this->getRequest()->getPost('levelids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("calorycarbslevel/calorycarbslevel");
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
			$fileName   = 'calorycarbslevel.csv';
			$grid       = $this->getLayout()->createBlock('calorycarbslevel/adminhtml_calorycarbslevel_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		}
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'calorycarbslevel.xml';
			$grid       = $this->getLayout()->createBlock('calorycarbslevel/adminhtml_calorycarbslevel_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
