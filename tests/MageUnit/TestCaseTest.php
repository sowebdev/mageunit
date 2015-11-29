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

    public function testSetHelperWithDataSuffix()
    {
        $this->_subject->setHelper('core/data', new stdClass());
        $this->assertInstanceOf('stdClass', Mage::helper('core/data'));
    }

    public function testSetHelperWithDataSuffixAndCalledWithout()
    {
        $this->_subject->setHelper('core/data', new stdClass());
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

    public function testSetModelWithResource()
    {
        $this->_subject->setModel('admin/resource_user', new stdClass());
        $this->assertInstanceOf('Mage_Core_Model_Resource_Abstract', Mage::getResourceModel('admin/user'));
    }

    public function testSetBlock()
    {
        $this->_subject->setBlock('core/template', new Varien_Object());
        $block = Mage::app()->getLayout()->createBlock('core/template');
        $this->assertInstanceOf('Varien_Object', $block);
        $this->assertNotInstanceOf('Mage_Core_Block_Template', $block);
    }

    public function testUnsetBlock()
    {
        $this->_subject->unsetBlock('core/template');
        $this->assertInstanceOf('Mage_Core_Block_Template', Mage::app()->getLayout()->createBlock('core/template'));
    }

    public function testSetConfig()
    {
        $this->_subject->setConfig('general/store_information/name', 'fake');
        $this->assertEquals('fake', Mage::getStoreConfig('general/store_information/name'));
    }

    public function testUnsetConfig()
    {
        $this->_subject->unsetConfig('general/store_information/name');
        $this->assertNotEquals('fake', Mage::getStoreConfig('general/store_information/name'));
    }

    public function testResetConfig()
    {
        $this->_subject->setConfig('general/store_information/name', 'fake');
        $this->_subject->setConfig('general/store_information/name', 'fake!!!', 0);

        $this->assertEquals('fake', Mage::getStoreConfig('general/store_information/name'));
        $this->assertEquals('fake!!!', Mage::app()->getStore(0)->getConfig('general/store_information/name'));

        $this->_subject->resetConfig();

        $this->assertNotEquals('fake', Mage::getStoreConfig('general/store_information/name'));
        $this->assertNotEquals('fake!!!', Mage::app()->getStore(0)->getConfig('general/store_information/name'));
    }

    /**
     * Model factories should be able to return either new instances or singletons
     *
     * @ticket #3
     */
    public function testGetModelCanReturnNewInstanceOnEachCall()
    {
        $this->_subject->setModel('core/store', 'stdClass');
        $modelInstance = Mage::getModel('core/store');
        $this->assertInstanceOf('stdClass', $modelInstance);
        $modelInstance->id = 'something';
        $anotherModelInstance = Mage::getModel('core/store');
        $this->assertInstanceOf('stdClass', $anotherModelInstance);
        $this->assertObjectNotHasAttribute('id', $anotherModelInstance);
    }

    /**
     * It should be possible to set the value of a configuration path to null
     *
     * @ticket #1
     */
    public function testSetConfigCanBeNull()
    {
        $this->_subject->setConfig('general/store_information/name', null);
        $this->assertNull(Mage::getStoreConfig('general/store_information/name'));
    }

    /**
     * Block factories should be able to return either new instances or singletons
     *
     * @ticket #4
     */
    public function testCreateBlockCanReturnNewInstanceOnEachCall()
    {
        $this->_subject->setBlock('core/template', 'Varien_Object');
        $blockInstance = Mage::app()->getLayout()->createBlock('core/template');
        $this->assertInstanceOf('Varien_Object', $blockInstance);
        $this->assertNotInstanceOf('Mage_Core_Block_Abstract', $blockInstance);
        $blockInstance->setData('mykey', 'myvalue');

        $anotherBlockInstance = Mage::app()->getLayout()->createBlock('core/template');
        $this->assertInstanceOf('Varien_Object', $anotherBlockInstance);
        $this->assertNotInstanceOf('Mage_Core_Block_Abstract', $anotherBlockInstance);
        $this->assertNull($anotherBlockInstance->getData('mykey'));
    }
}
