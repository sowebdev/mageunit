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
        $registerNames = $this->_getHelperNameWithAlias($name);
        foreach ($registerNames as $n) {
            $registerKey = $this->_helperRegistryPrefix . $n;
            Mage::unregister($registerKey);
            Mage::register($registerKey, $mockObject);
        }
    }

    /**
     * Unsets currently registered helper
     *
     * @param string $name
     */
    public function unsetHelper($name)
    {
        $unregisterNames = $this->_getHelperNameWithAlias($name);
        foreach ($unregisterNames as $n) {
            $registerKey = $this->_helperRegistryPrefix . $n;
            Mage::unregister($registerKey);
        }
    }

    /**
     * Checks if a helper name could have an alias (this happens with default "data" helpers)
     * and returns an array of valid names.
     *
     * @param string $name
     * @return array
     */
    protected function _getHelperNameWithAlias($name)
    {
        if (strpos($name, '/') === false) {
            $name .= '/data';
        }
        $helperNames = array($name);
        if (strpos($name, '/data') + 5 == strlen($name)) {
            $helperNames[] = substr($name, 0, strpos($name, '/data'));
        }
        return $helperNames;
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

    /**
     * Mocks a block
     *
     * @param string $name
     * @param object $mockObject
     */
    public function setBlock($name, $mockObject)
    {
        Mage::app()->getLayout()->registerBlockMock($name, $mockObject);
    }

    /**
     * Unsets currently registered block mock
     *
     * @param string $name
     */
    public function unsetBlock($name)
    {
        Mage::app()->getLayout()->unregisterBlockMock($name);
    }

    /**
     * Defines value of a given configuration path
     *
     * @param string $path
     * @param mixed $value
     * @param null|string|bool|int|Mage_Core_Model_Store $store
     */
    public function setConfig($path, $value, $store = null)
    {
        $store = Mage::app()->getStore($store);
        $reflectionProperty = new ReflectionProperty($store, '_configCache');
        $reflectionProperty->setAccessible(true);
        $currentCache = $reflectionProperty->getValue($store);
        if (!is_array($currentCache)) {
            $currentCache = array();
        }
        $currentCache = array_merge($currentCache, array($path => $value));
        $reflectionProperty->setValue($store, $currentCache);
        $reflectionProperty->setAccessible(false);
    }

    /**
     * Resets configuration cache
     *
     * @param null|string|bool|int|Mage_Core_Model_Store $store
     */
    public function resetConfig($store = null)
    {
        $store = Mage::app()->getStore($store);
        $reflectionProperty = new ReflectionProperty($store, '_configCache');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($store, array());
        $reflectionProperty->setAccessible(false);
    }
}