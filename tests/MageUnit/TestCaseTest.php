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
        $this->assertInstanceOf('Mage_Admin_Model_Resource_User', Mage::getResourceModel('admin/user'));
    }

    public function testSetAndResetConfig()
    {
        $this->_subject->setConfig('general/store_information/name', 'fake');
        $this->assertEquals('fake', Mage::getStoreConfig('general/store_information/name'));

        $this->_subject->setConfig('general/store_information/name', 'fake!!!', 1);
        $this->assertEquals('fake!!!', Mage::app()->getStore(1)->getConfig('general/store_information/name'));

        $this->_subject->resetConfig();
        $this->assertNotEquals('fake', Mage::getStoreConfig('general/store_information/name'));
        $this->assertNotEquals('fake!!!', Mage::app()->getStore(1)->getConfig('general/store_information/name'));
    }
}