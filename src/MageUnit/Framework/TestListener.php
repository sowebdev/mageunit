<?php
class MageUnit_Framework_TestListener extends PHPUnit_Framework_BaseTestListener
{
    /**
     * @var PHPUnit_Framework_TestSuite|null
     */
    protected $_testSuiteRoot;

    /**
     * Initialize test environment
     *
     * @param PHPUnit_Framework_TestSuite $suite
     */
    public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        //Ensures initialization runs only once in a test suite
        if ($this->_testSuiteRoot === null) {
            $reflectionClass = new ReflectionClass('Mage');
            $reflectionProperty = $reflectionClass->getProperty('_app');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue(new MageUnit_Mock_Core_Model_App());
            /**
             * @var $app MageUnit_Mock_Core_Model_App
             */
            $app = $reflectionProperty->getValue();
            $app->initTestEnvironment();

            $this->_testSuiteRoot = $suite;
        }
    }

    /**
     * Terminate test suite
     *
     * @param PHPUnit_Framework_TestSuite $suite
     */
    public function endTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        /**
         * @var MageUnit_Mock_Core_Model_App $app
         */
        $app = Mage::app();
        $app->resetHelperMocks();
        $app->resetConfig();

        /**
         * @var MageUnit_Mock_Core_Model_Config $config
         */
        $config = $app->getConfig();
        $config->resetModelMocks();

        /**
         * @var MageUnit_Mock_Core_Model_Layout $layout
         */
        $layout = $app->getLayout();
        $layout->resetBlockMocks();
    }
}