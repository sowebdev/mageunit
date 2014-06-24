<?php
class MageUnit_ConfigTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Mage::app()->getConfig()->unregisterModelMock('core/store');
    }

    public function testConfigHasBeenMocked()
    {
        $this->assertInstanceOf('MageUnit_Mock_Core_Model_Config', Mage::app()->getConfig());
    }

    public function testOriginalGetModelInstance()
    {
        $modelInstance = Mage::app()->getConfig()->getModelInstance('core/store');
        $this->assertInstanceOf('Mage_Core_Model_Store', $modelInstance);
    }

    public function testMockedModelInstance()
    {
        Mage::app()->getConfig()->registerModelMock('core/store', new stdClass());;
        $modelInstance = Mage::app()->getConfig()->getModelInstance('core/store');
        $this->assertInstanceOf('stdClass', $modelInstance);
    }
}