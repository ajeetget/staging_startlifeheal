<?php
class St_Customecustomattribute_Model_Eav_Entity_Attribute_Source_Customeroptions15758754841 extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    /**
     * Retrieve all options array
     *
     * @return array
     */
    public function getAllOptions()
    {
        if (is_null($this->_options)) {
            $this->_options = array(
			
                array(
                    "label" => Mage::helper("eav")->__("Lunch"),
                    "value" =>  1
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Lunch and High tea in Office"),
                    "value" =>  2
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Mon to Sat at cloud 9 Hospital, Sunday At Home"),
                    "value" =>  3
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("No Capsicum"),
                    "value" =>  4
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("No Sprout kabab"),
                    "value" =>  5
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Only lunch and High Tea"),
                    "value" =>  6
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Only Lunch Or Breakfast or Both (Not on Sunday)"),
                    "value" =>  7
                ),
	
                array(
                    "label" => Mage::helper("eav")->__("Send Extra Kefir and Health Shot"),
                    "value" =>  8
                ),
	
            );
        }
        return $this->_options;
    }

    /**
     * Retrieve option array
     *
     * @return array
     */
    public function getOptionArray()
    {
        $_options = array();
        foreach ($this->getAllOptions() as $option) {
            $_options[$option["value"]] = $option["label"];
        }
        return $_options;
    }

    /**
     * Get a text for option value
     *
     * @param string|integer $value
     * @return string
     */
    public function getOptionText($value)
    {
        $options = $this->getAllOptions();
        foreach ($options as $option) {
            if ($option["value"] == $value) {
                return $option["label"];
            }
        }
        return false;
    }

    /**
     * Retrieve Column(s) for Flat
     *
     * @return array
     */
    public function getFlatColums()
    {
        $columns = array();
        $columns[$this->getAttribute()->getAttributeCode()] = array(
            "type"      => "tinyint(1)",
            "unsigned"  => false,
            "is_null"   => true,
            "default"   => null,
            "extra"     => null
        );

        return $columns;
    }

    /**
     * Retrieve Indexes(s) for Flat
     *
     * @return array
     */
    public function getFlatIndexes()
    {
        $indexes = array();

        $index = "IDX_" . strtoupper($this->getAttribute()->getAttributeCode());
        $indexes[$index] = array(
            "type"      => "index",
            "fields"    => array($this->getAttribute()->getAttributeCode())
        );

        return $indexes;
    }

    /**
     * Retrieve Select For Flat Attribute update
     *
     * @param int $store
     * @return Varien_Db_Select|null
     */
    public function getFlatUpdateSelect($store)
    {
        return Mage::getResourceModel("eav/entity_attribute")
            ->getFlatUpdateSelect($this->getAttribute(), $store);
    }
}

			 