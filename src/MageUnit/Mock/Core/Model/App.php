<?php
class MageUnit_Mock_Core_Model_App extends Mage_Core_Model_App
{
    /**
     * Initializes test environment
     */
    public function initTestEnvironment()
    {
        $reflectionClass = new ReflectionClass('Mage');
        $reflectionProperty = $reflectionClass->getProperty('_config');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue(new MageUnit_Mock_Core_Model_Config());

        $this->init('', 'store');

        $this->loadAreaPart(Mage_Core_Model_App_Area::AREA_GLOBAL, Mage_Core_Model_App_Area::PART_EVENTS);
    }
} 