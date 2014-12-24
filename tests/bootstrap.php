<?php
if (!getenv('MAGE')) {
    throw new Exception('Path to Mage.php has not been configured');
}
require getenv('MAGE');

require 'MageUnit' . DIRECTORY_SEPARATOR . 'Autoload.php';

MageUnit_Autoload::enable();

Mage::app();
Mage_Core_Model_Resource_Setup::applyAllUpdates();