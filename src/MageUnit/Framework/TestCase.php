<?php
class MageUnit_Framework_TestCase extends PHPUnit_Framework_TestCase
{
    protected $_singletonRegistryPrefix = '_singleton/';

    /**
     * Mocks a singleton
     *
     * @param string $name
     * @param object $mockObject
     */
    public function setSingleton($name, $mockObject)
    {
        $registryKey = $this->_singletonRegistryPrefix . $name;
        Mage::unregister($registryKey);
        Mage::register($registryKey, $mockObject);
    }

    /**
     * Unsets currently registered singleton
     *
     * @param string $name
     */
    public function unsetSingleton($name)
    {
        $registryKey = $this->_singletonRegistryPrefix . $name;
        Mage::unregister($registryKey);
    }
}