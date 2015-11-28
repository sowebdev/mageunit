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
            if (is_object($this->_registeredModelMocks[$modelClass])) {
                return $this->_registeredModelMocks[$modelClass];
            } elseif (is_string($this->_registeredModelMocks[$modelClass])) {
                return new $this->_registeredModelMocks[$modelClass];
            }
            return false;
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
     * Register a model replacement
     *
     * @param string $alias eg : 'core/store'
     * @param mixed $replacement an object when using it as singleton, the name of a class otherwise
     */
    public function registerModelMock($alias, $replacement)
    {
        $this->_registeredModelMocks[$alias] = $replacement;
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