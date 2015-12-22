<?php
class MageUnit_Mock_Core_Model_Store extends Mage_Core_Model_Store
{
    /**
     * Retrieve store configuration data
     *
     * @param   string $path
     * @return  string|null
     */
    public function getConfig($path)
    {
        if (is_array($this->_configCache) && array_key_exists($path, $this->_configCache)) {
            //null value is allowed
            return $this->_configCache[$path];
        }
        return parent::getConfig($path);
    }
}
