<?php
class MageUnit_Framework_TestCase extends PHPUnit_Framework_TestCase
{
    protected $_singletonRegistryPrefix = '_singleton/';
    protected $_helperRegistryPrefix = '_helper/';

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

    /**
     * Mocks a helper
     *
     * @param string $name
     * @param object $mockObject
     */
    public function setHelper($name, $mockObject)
    {
        if (strpos($name, '/') === false) {
            $name .= '/data';
        }
        $registryKey = $this->_helperRegistryPrefix . $name;
        Mage::unregister($registryKey);
        Mage::register($registryKey, $mockObject);
    }

    /**
     * Unsets currently registered helper
     *
     * @param string $name
     */
    public function unsetHelper($name)
    {
        if (strpos($name, '/') === false) {
            $name .= '/data';
        }
        $registryKey = $this->_helperRegistryPrefix . $name;
        Mage::unregister($registryKey);
    }

    /**
     * Mocks a model
     *
     * @param string $name
     * @param object $mockObject
     */
    public function setModel($name, $mockObject)
    {
        Mage::app()->getConfig()->registerModelMock($name, $mockObject);
    }

    /**
     * Unsets currently registered model mock
     *
     * @param string $name
     */
    public function unsetModel($name)
    {
        Mage::app()->getConfig()->unregisterModelMock($name);
    }
}