<?php
class MageUnit_LayoutTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Mage::app()->getLayout()->unregisterBlockMock('core/template');
    }

    public function testLayoutHasBeenMocked()
    {
        $this->assertInstanceOf('MageUnit_Mock_Core_Model_Layout', Mage::app()->getLayout());
    }

    public function testOriginalGetBlockInstance()
    {
        $blockInstance = Mage::app()->getLayout()->createBlock('core/template');
        $this->assertInstanceOf('Mage_Core_Block_Template', $blockInstance);
    }

    public function testMockedBlockInstance()
    {
        Mage::app()->getLayout()->registerBlockMock('core/template', new Varien_Object());;
        $blockInstance = Mage::app()->getLayout()->createBlock('core/template');
        $this->assertInstanceOf('Varien_Object', $blockInstance);
    }
}