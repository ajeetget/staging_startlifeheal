<?php
class Advanced_Onestepcheckout_Block_Adminhtml_Fields_Survey extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    public function __construct()
    {
        $this->addColumn('value', array(
            'label' => Mage::helper('onestepcheckout')->__('Label'),
            'style' => 'width:250px',
        ));
        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('onestepcheckout')->__('Add label');
        parent::__construct();
    }
}