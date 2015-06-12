<?php
class MageUnit_Mock_Core_Model_Config extends Mage_Core_Model_Config
{
    /**
     * Used to register model mocks
     *
     * @var array
     */
    protected $_registeredModelMocks = array();

    /**
     * Get a model instance
     *
     * @param string $modelClass
     * @param array|object $constructArguments
     * @return Mage_Core_Model_Abstract|false
     */
    public function getModelInstance(
        $modelClass='', $constructArguments=array())
    {
        if (isset($this->_registeredModelMocks[$modelClass])) {
            return $this->_registeredModelMocks[$modelClass];
        }
        $className = $this->getModelClassName($modelClass);
        if (class_exists($className)) {
            Varien_Profiler::start('CORE::create_object_of::'.$className);
            $obj = new $className($constructArguments);
            Varien_Profiler::stop('CORE::create_object_of::'.$className);
            return $obj;
        } else {
            return false;
        }
    }

    /**
     * Register a model mock
     *
     * @param string $modelClass
     * @param object $mockObject
     */
    public function registerModelMock($modelClass, $mockObject)
    {
        $this->_registeredModelMocks[$modelClass] = $mockObject;
    }

    /**
     * Unregister a model mock
     *
     * @param string $modelClass
     */
    public function unregisterModelMock($modelClass)
    {
        if (isset($this->_registeredModelMocks[$modelClass])) {
            unset($this->_registeredModelMocks[$modelClass]);
        }
    }

    /**
     * Resets all model mocks
     */
    public function resetModelMocks()
    {
        $this->_registeredModelMocks = array();
    }
}