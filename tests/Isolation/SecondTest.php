<?php
class MageUnit_SecondTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MageUnit_Framework_TestCase
     */
    protected $_subject;

    /**
     * Initialize test
     */
    protected function setUp()
    {
        $this->_subject = new MageUnit_Framework_TestCase();
    }

    public function testModelMockWasCleared()
    {
        $this->assertInstanceOf(
            'Mage_Core_Model_Store',
            Mage::getModel('core/store')
        );
    }

    public function testHelperMockWasCleared()
    {
        $this->assertInstanceOf(
            'Mage_Core_Helper_Data',
            Mage::helper('core/data')
        );
    }

    public function testBlockMockWasCleared()
    {
        $this->assertInstanceOf(
            'Mage_Core_Block_Template',
            Mage::app()->getLayout()->createBlock('core/template')
        );
    }

    public function testConfigReplacementWasCleared()
    {
        $this->assertNotEquals(
            'fake',
            Mage::getStoreConfig('general/store_information/name')
        );
    }
}