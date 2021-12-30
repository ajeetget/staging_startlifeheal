<?php

class St_Disease_Adminhtml_DiseaseController extends Mage_Adminhtml_Controller_Action
{
		protected function _isAllowed()
		{
		//return Mage::getSingleton('admin/session')->isAllowed('disease/disease');
			return true;
		}

		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("disease/disease")->_addBreadcrumb(Mage::helper("adminhtml")->__("Disease  Manager"),Mage::helper("adminhtml")->__("Disease Manager"));
				return $this;
		}
		public function indexAction()
		{
			    $this->_title($this->__("Disease"));
			    $this->_title($this->__("Manager Disease"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{
			    $this->_title($this->__("Disease"));
				$this->_title($this->__("Disease"));
			    $this->_title($this->__("Edit Item"));

				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("disease/disease")->load($id);
				if ($model->getId()) {
					Mage::register("disease_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("disease/disease");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Disease Manager"), Mage::helper("adminhtml")->__("Disease Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Disease Description"), Mage::helper("adminhtml")->__("Disease Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("disease/adminhtml_disease_edit"))->_addLeft($this->getLayout()->createBlock("disease/adminhtml_disease_edit_tabs"));
					$this->renderLayout();
				}
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("disease")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Disease"));
		$this->_title($this->__("Disease"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("disease/disease")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("disease_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("disease/disease");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Disease Manager"), Mage::helper("adminhtml")->__("Disease Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Disease Description"), Mage::helper("adminhtml")->__("Disease Description"));


		$this->_addContent($this->getLayout()->createBlock("disease/adminhtml_disease_edit"))->_addLeft($this->getLayout()->createBlock("disease/adminhtml_disease_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {

						

						$model = Mage::getModel("disease/disease")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Disease was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setDiseaseData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					}
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setDiseaseData($this->getRequest()->getPost());
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
						$model = Mage::getModel("disease/disease");
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
				$ids = $this->getRequest()->getPost('disease_ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("disease/disease");
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
			$fileName   = 'disease.csv';
			$grid       = $this->getLayout()->createBlock('disease/adminhtml_disease_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		}
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'disease.xml';
			$grid       = $this->getLayout()->createBlock('disease/adminhtml_disease_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
