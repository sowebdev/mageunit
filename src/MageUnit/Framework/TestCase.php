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
}