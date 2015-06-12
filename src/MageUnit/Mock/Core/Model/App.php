<?php
class MageUnit_Mock_Core_Model_App extends Mage_Core_Model_App
{
    protected $_singletonRegistryPrefix = '_singleton/';
    protected $_helperRegistryPrefix = '_helper/';

    protected $_registeredSingletonMocks = array();
    protected $_registeredHelperMocks = array();
    protected $_registeredConfigMocks = array();

    /**
     * Initializes test environment
     */
    public function initTestEnvironment()
    {
        $reflectionClass = new ReflectionClass('Mage');
        $reflectionProperty = $reflectionClass->getProperty('_config');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue(new MageUnit_Mock_Core_Model_Config());

        $this->init('', 'store');

        $this->loadAreaPart(
            Mage_Core_Model_App_Area::AREA_GLOBAL,
            Mage_Core_Model_App_Area::PART_EVENTS
        );

        Mage::register(
            '_singleton/core/layout',
            new MageUnit_Mock_Core_Model_Layout()
        );
    }

    /**
     * Defines a singleton mock
     *
     * @param string $name
     * @param object $mockObject
     */
    public function setSingleton($name, $mockObject)
    {
        $this->_registeredSingletonMocks[$name] = $mockObject;
        $registryKey = $this->_singletonRegistryPrefix . $name;
        Mage::unregister($registryKey);
        Mage::register($registryKey, $mockObject);
    }

    /**
     * Unset currently registered singleton mock
     *
     * @param string $name
     */
    public function unsetSingleton($name)
    {
        unset($this->_registeredSingletonMocks[$name]);
        $registryKey = $this->_singletonRegistryPrefix . $name;
        Mage::unregister($registryKey);
    }

    /**
     * Reset all registered singletons
     */
    public function resetSingletonMocks()
    {
        $names = array_keys($this->_registeredSingletonMocks);
        foreach ($names as $n) {
            $this->unsetSingleton($n);
        }
    }

    /**
     * Defines a helper mock
     *
     * @param string $name
     * @param object $mockObject
     */
    public function setHelper($name, $mockObject)
    {
        $registerNames = $this->_getHelperNameWithAlias($name);
        foreach ($registerNames as $n) {
            $this->_registeredHelperMocks[$n] = $mockObject;
            $registerKey = $this->_helperRegistryPrefix . $n;
            Mage::unregister($registerKey);
            Mage::register($registerKey, $mockObject);
        }
    }

    /**
     * Unset currently registered helper mock
     *
     * @param string $name
     */
    public function unsetHelper($name)
    {
        $unregisterNames = $this->_getHelperNameWithAlias($name);
        foreach ($unregisterNames as $n) {
            unset($this->_registeredHelperMocks[$n]);
            $registerKey = $this->_helperRegistryPrefix . $n;
            Mage::unregister($registerKey);
        }
    }

    /**
     * Reset all registered helpers
     */
    public function resetHelperMocks()
    {
        $names = array_keys($this->_registeredHelperMocks);
        foreach ($names as $n) {
            $this->unsetHelper($n);
        }
    }

    /**
     * Checks if a helper name could have an alias
     * (this happens with default "data" helpers)
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
     * Defines value of a given configuration path
     *
     * @param string $path
     * @param mixed $value
     * @param null|string|bool|int|Mage_Core_Model_Store $store
     */
    public function setConfig($path, $value, $store = null)
    {
        $store = $this->getStore($store);
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
     * Resets value of a given configuration path
     *
     * @param string $path
     * @param null|string|bool|int|Mage_Core_Model_Store $store
     */
    public function unsetConfig($path, $store = null)
    {
        $store = $this->getStore($store);
        $reflectionProperty = new ReflectionProperty($store, '_configCache');
        $reflectionProperty->setAccessible(true);
        $currentCache = $reflectionProperty->getValue($store);
        if (!is_array($currentCache)) {
            $currentCache = array();
        }
        if (isset($currentCache[$path])) {
            unset($currentCache[$path]);
        }
        $reflectionProperty->setValue($store, $currentCache);
        $reflectionProperty->setAccessible(false);
    }

    /**
     * Resets configuration cache
     *
     * @param null|string|bool|int|Mage_Core_Model_Store $store
     *   if null, resets config of all stores
     */
    public function resetConfig($store = null)
    {
        if (!$store) {
            $stores = $this->getStores(true);
        } else {
            $stores = array($store);
        }
        foreach ($stores as $s) {
            $s = $this->getStore($s);
            $reflectionProperty = new ReflectionProperty($s, '_configCache');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($s, array());
            $reflectionProperty->setAccessible(false);
        }
    }
} 