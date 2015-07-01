<?php
class MageUnit_FirstTest extends PHPUnit_Framework_TestCase
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

    public function testModelMockWasRegistered()
    {
        $this->_subject->setModel('core/store', new stdClass());
        $this->assertInstanceOf('stdClass', Mage::getModel('core/store'));
    }

    public function testModelMockIsStillRegistered()
    {
        $this->assertInstanceOf('stdClass', Mage::getModel('core/store'));
    }

    public function testHelperMockWasRegistered()
    {
        $this->_subject->setHelper('core/data', new stdClass());
        $this->assertInstanceOf('stdClass', Mage::helper('core/data'));
    }

    public function testHelperMockIsStillRegistered()
    {
        $this->assertInstanceOf('stdClass', Mage::helper('core/data'));
    }

    public function testBlockMockWasRegistered()
    {
        $this->_subject->setBlock('core/template', new Varien_Object());
        $this->assertInstanceOf(
            'Varien_Object',
            Mage::app()->getLayout()->createBlock('core/template')
        );
    }

    public function testBlockMockIsStillRegistered()
    {
        $this->assertInstanceOf(
            'Varien_Object',
            Mage::app()->getLayout()->createBlock('core/template')
        );
    }

    public function testConfigWasRegistered()
    {
        $this->_subject->setConfig('general/store_information/name', 'fake');
        $this->assertEquals(
            'fake',
            Mage::getStoreConfig('general/store_information/name')
        );
    }

    public function testConfigIsStillRegistered()
    {
        $this->assertEquals(
            'fake',
            Mage::getStoreConfig('general/store_information/name')
        );
    }
}