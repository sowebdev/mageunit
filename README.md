# MageUnit

MageUnit aims to be a simple unit testing framework for Magento 1.x.

##Usage

Clone this repository into a folder of your Magento project. 
The "src" folder contains all files required by the framework. 
The "tests" folder contains tests for the framework which will tell you if it is working as expected.
Copy content of phpunit.xml.dist to a phpunit.xml file and edit include paths and path to Mage.php to match your directory tree.
Launch the tests with PHPUnit.

All tests should pass. If not, there is a problem with your setup (or a bug in the framework).

##Write your own tests

You can create a new directory containing your tests anywhere you like. 
Make sure your PHPUnit configuration calls the frameworks test listener and that your include path is correct, so should be your path to Mage.php.
All your test classes should inherit from **MageUnit_Framework_TestCase** in order to have access to utility methods of the framework.

Your directory could look like the following, but you can totally separate your tests from those of the framework :

    Root
    |--app
    |--...
    |--tests
       |--mageunit
          |--src
          |--tests
             |--MageUnit
             |--YourTests
             |--bootstrap.php
             |--phpunit.xml

##API

Magento makes use of factory methods (Mage::getModel(), Mage::helper()...) to build new instances of a class.
Using the frameworks methods it is possible to easily configure objects that should be returned by such calls.

### Models

    $this->setModel('core/store', new stdClass());
    Mage::getModel('core/store');//returns an instance of stdClass
    
    $this->unsetModel('core/store');
    Mage::getModel('core/store');//returns an instance of Mage_Core_Model_Store

### Helpers

    $this->setHelper('core', new stdClass());
    Mage::helper('core');//returns an instance of stdClass
    
    $this->unsetHelper('core');
    Mage::helper('core');//returns an instance of Mage_Core_Helper_Data
    
### Singletons

    $this->setSingleton('core/store', new stdClass());
    Mage::getSingleton('core/store');//returns an instance of stdClass
    
    $this->unsetSingleton('core/store');
    Mage::getSingleton('core/store');//returns an instance of Mage_Core_Model_Store

