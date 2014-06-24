<?php
class MageUnit_Framework_TestListener extends PHPUnit_Framework_BaseTestListener
{
    /**
     * Initialize test environment
     *
     * @param PHPUnit_Framework_TestSuite $suite
     */
    public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        $reflectionClass = new ReflectionClass('Mage');
        $reflectionProperty = $reflectionClass->getProperty('_app');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue(new MageUnit_Mock_Core_Model_App());
        /**
         * @var $app MageUnit_Mock_Core_Model_App
         */
        $app = $reflectionProperty->getValue();
        $app->initTestEnvironment();
    }
}