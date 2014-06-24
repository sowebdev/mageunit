<?php
class MageUnit_AppTest extends PHPUnit_Framework_TestCase
{
    public function testAppHasBeenMocked()
    {
        $this->assertInstanceOf('MageUnit_Mock_Core_Model_App', Mage::app());
    }
}