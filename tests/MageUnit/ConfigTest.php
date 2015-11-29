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
}
