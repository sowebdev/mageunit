<?php
class MageUnit_TestCaseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MageUnit_Framework_TestCase
     */
    protected $_subject;

    protected function setUp()
    {
        $this->_subject = new MageUnit_Framework_TestCase();
    }

    public function testSetSingleton()
    {
        $this->_subject->setSingleton('core/store', new stdClass());
        $this->assertInstanceOf('stdClass', Mage::getSingleton('core/store'));
    }

    public function testUnsetSingleton()
    {
        $this->_subject->unsetSingleton('core/store');
        $this->assertInstanceOf('Mage_Core_Model_Store', Mage::getSingleton('core/store'));
    }

    public function testSetHelper()
    {
        $this->_subject->setHelper('core', new stdClass());
        $this->assertInstanceOf('stdClass', Mage::helper('core'));
    }

    public function testUnsetHelper()
    {
        $this->_subject->unsetHelper('core');
        $this->assertInstanceOf('Mage_Core_Helper_Data', Mage::helper('core'));
    }

    public function testSetModel()
    {
        $this->_subject->setModel('core/store', new stdClass());
        $this->assertInstanceOf('stdClass', Mage::getModel('core/store'));
    }

    public function testUnsetModel()
    {
        $this->_subject->unsetModel('core/store');
        $this->assertInstanceOf('Mage_Core_Model_Store', Mage::getModel('core/store'));
    }
}