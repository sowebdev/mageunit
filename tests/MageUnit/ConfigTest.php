<?php
class MageUnit_ConfigTest extends PHPUnit_Framework_TestCase
{
    public function testConfigHasBeenMocked()
    {
        $this->assertInstanceOf('MageUnit_Mock_Core_Model_Config', Mage::app()->getConfig());
    }
}