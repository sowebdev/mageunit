<?php
class MageUnit_Framework_TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Returns application mock
     *
     * @return MageUnit_Mock_Core_Model_App
     */
    protected function _getApp()
    {
        return Mage::app();
    }

    /**
     * Defines a singleton mock
     *
     * @param string $name
     * @param object $mockObject
     */
    public function setSingleton($name, $mockObject)
    {
        $this->_getApp()->setSingleton($name, $mockObject);
    }

    /**
     * Unset currently registered singleton mock
     *
     * @param string $name
     */
    public function unsetSingleton($name)
    {
        $this->_getApp()->unsetSingleton($name);
    }

    /**
     * Reset all registered singletons
     */
    public function resetSingletons()
    {
        $this->_getApp()->resetSingletonMocks();
    }

    /**
     * Defines a helper mock
     *
     * @param string $name
     * @param object $mockObject
     */
    public function setHelper($name, $mockObject)
    {
        $this->_getApp()->setHelper($name, $mockObject);
    }

    /**
     * Unset currently registered helper mock
     *
     * @param string $name
     */
    public function unsetHelper($name)
    {
        $this->_getApp()->unsetHelper($name);
    }

    /**
     * Reset all registered helpers
     */
    public function resetHelpers()
    {
        $this->_getApp()->resetHelperMocks();
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
     * Defines a model mock
     *
     * @param string $name
     * @param mixed $replacement an object when using it as singleton, the name of a class otherwise
     */
    public function setModel($name, $replacement)
    {
        $this->_getApp()->getConfig()->registerModelMock($name, $replacement);
    }

    /**
     * Unset currently registered model mock
     *
     * @param string $name
     */
    public function unsetModel($name)
    {
        $this->_getApp()->getConfig()->unregisterModelMock($name);
    }

    /**
     * Reset all registered models
     */
    public function resetModels()
    {
        $this->_getApp()->getConfig()->resetModelMocks();
    }

    /**
     * Defines a block mock
     *
     * @param string $name
     * @param mixed $replacement an object when using it as singleton, the name of a class otherwise
     */
    public function setBlock($name, $replacement)
    {
        $this->_getApp()->getLayout()->registerBlockMock($name, $replacement);
    }

    /**
     * Unset currently registered block mock
     *
     * @param string $name
     */
    public function unsetBlock($name)
    {
        $this->_getApp()->getLayout()->unregisterBlockMock($name);
    }

    /**
     * Reset all registered blocks
     */
    public function resetBlocks()
    {
        $this->_getApp()->getLayout()->resetBlockMocks();
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
        $this->_getApp()->setConfig($path, $value, $store);
    }

    /**
     * Resets value of a given configuration path
     *
     * @param string $path
     * @param null|string|bool|int|Mage_Core_Model_Store $store
     */
    public function unsetConfig($path, $store = null)
    {
        $this->_getApp()->unsetConfig($path, $store);
    }

    /**
     * Resets configuration cache
     *
     * @param null|string|bool|int|Mage_Core_Model_Store $store
     *   if null, resets config of all stores
     */
    public function resetConfig($store = null)
    {
        $this->_getApp()->resetConfig($store);
    }
}