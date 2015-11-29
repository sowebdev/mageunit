<?php
class MageUnit_Mock_Core_Model_Layout extends Mage_Core_Model_Layout
{
    /**
     * Used to register block mocks
     *
     * @var array
     */
    protected $_registeredBlockMocks = array();
    
    /**
     * Create block object instance based on block type
     *
     * @param string $block
     * @param array $attributes
     * @return Mage_Core_Block_Abstract
     */
    protected function _getBlockInstance($block, array $attributes=array())
    {
        if (isset($this->_registeredBlockMocks[$block])) {
            if (is_object($this->_registeredBlockMocks[$block])) {
                return $this->_registeredBlockMocks[$block];
            } elseif (is_string($this->_registeredBlockMocks[$block])) {
                return new $this->_registeredBlockMocks[$block]($attributes);
            }
        }
        if (is_string($block)) {
            if (strpos($block, '/')!==false) {
                if (!$block = Mage::getConfig()->getBlockClassName($block)) {
                    Mage::throwException(
                        Mage::helper('core')->__(
                            'Invalid block type: %s', $block
                        )
                    );
                }
            }
            if (class_exists($block, false) || mageFindClassFile($block)) {
                $block = new $block($attributes);
            }
        }
        if (!$block instanceof Mage_Core_Block_Abstract) {
            Mage::throwException(
                Mage::helper('core')->__('Invalid block type: %s', $block)
            );
        }
        return $block;
    }

    /**
     * Register a block replacement
     *
     * @param string $blockClass eg : 'core/template'
     * @param mixed $replacement an object when using it as singleton, the name of a class otherwise
     */
    public function registerBlockMock($blockClass, $replacement)
    {
        $this->_registeredBlockMocks[$blockClass] = $replacement;
    }

    /**
     * Unregister a block mock
     *
     * @param string $blockClass
     */
    public function unregisterBlockMock($blockClass)
    {
        if (isset($this->_registeredBlockMocks[$blockClass])) {
            unset($this->_registeredBlockMocks[$blockClass]);
        }
    }

    /**
     * Resets all block mocks
     */
    public function resetBlockMocks()
    {
        $this->_registeredBlockMocks = array();
    }
}
