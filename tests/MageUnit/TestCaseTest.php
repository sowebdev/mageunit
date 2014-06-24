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
}