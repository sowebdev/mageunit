# MageUnit

MageUnit aims to be a simple unit testing framework for Magento 1.x.

## Usage

The simplest way to install this framework is to use Composer. Create a composer.json file in your project's root directory having at least following content :

	{
	    "repositories": [
	        {
	            "type": "vcs",
	            "url": "https://github.com/sowebdev/mageunit"
	        }
	    ],
	    "require": {
	        "sowebdev/mageunit": "dev-master"
	    }
	}

By default, this will install the framework in Magento's lib folder.

The "src" folder contains all files required by the framework. 
The "tests" folder contains tests for the framework which will tell you if it is working as expected.
Launch the tests with PHPUnit.

All tests should pass. If not, there is a problem with your setup (or a bug in the framework).

## Write your own tests

You can create a new directory containing your tests anywhere you like. 
Make sure your PHPUnit configuration calls the frameworks test listener and that your include path is correct, so should be your path to Mage.php.
To do so, copy content of phpunit.xml.dist to a phpunit.xml file and edit include paths and path to Mage.php to match your directory tree.
You can create your own bootstrap file, but keep in mind that you need to include Mage.php first, then MageUnit_Autoload.php and call `MageUnit_Autoload::enable()`.
All your test classes should inherit from **MageUnit_Framework_TestCase** in order to have access to utility methods of the framework.

By default, the directory structure looks like the following, but you can totally separate your tests from those of the framework :

    Root
    |--app
    |--...
    |--lib
       |--mageunit
          |--src
          |--tests
             |--MageUnit
             |--bootstrap.php
             |--phpunit.xml

## API

### Factory methods

Magento makes use of factory methods (Mage::getModel(), Mage::helper()...) to build new instances of a class.
Using the frameworks methods it is possible to easily configure objects that should be returned by such calls.

#### Models

    $this->setModel('core/store', new stdClass());
    Mage::getModel('core/store');//returns an instance of stdClass
    
    $this->unsetModel('core/store');
    Mage::getModel('core/store');//returns an instance of Mage_Core_Model_Store

#### Helpers

    $this->setHelper('core', new stdClass());
    Mage::helper('core');//returns an instance of stdClass
    
    $this->unsetHelper('core');
    Mage::helper('core');//returns an instance of Mage_Core_Helper_Data
    
#### Singletons

    $this->setSingleton('core/store', new stdClass());
    Mage::getSingleton('core/store');//returns an instance of stdClass
    
    $this->unsetSingleton('core/store');
    Mage::getSingleton('core/store');//returns an instance of Mage_Core_Model_Store
    
#### Blocks

    $this->setBlock('core/template', new Varien_Object());
    Mage::app()->getLayout()->createBlock('core/template');//returns an instance of Varien_Object
    
    $this->unsetBlock('core/template');
    Mage::app()->getLayout()->createBlock('core/template');//returns an instance of Mage_Core_Block_Template

### Store Configuration

You can set and reset any store configuration like this :

    $this->setConfig('general/store_information/name', 'my value');
    Mage::getStoreConfig('general/store_information/name');//Will return 'my value'
    
    $this->resetConfig();
    Mage::getStoreConfig('general/store_information/name');//Will return real value