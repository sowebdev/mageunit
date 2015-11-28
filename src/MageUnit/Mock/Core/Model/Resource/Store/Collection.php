<?php
class MageUnit_Mock_Core_Model_Resource_Store_Collection extends Mage_Core_Model_Resource_Store_Collection
{
    /**
     *  Define resource model
     */
    protected function _construct()
    {
        $this->setFlag('load_default_store', false);
        $this->_init('core/store');
        $this->_itemObjectClass = 'MageUnit_Mock_Core_Model_Store';
    }
}
