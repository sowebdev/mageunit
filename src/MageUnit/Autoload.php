<?php

/**
 * Custom autoload which checks if file exists in include_path
 * before trying to include it.
 * This fixes an issue which may appear when Varien_Autoload
 * tries to include a PHPUnit extension which may not be installed.
 */
class MageUnit_Autoload
{
    /**
     * @var MageUnit_Autoload
     */
    protected static $_instance;

    /**
     * This class should be used as a singleton
     */
    private function __construct()
    {

    }

    /**
     * Returns the only instance of the class
     *
     * @return MageUnit_Autoload
     */
    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new MageUnit_Autoload();
        }
        return self::$_instance;
    }

    /**
     * Enables use of this autoloader class instead of Varien_Autoload
     */
    public static function enable()
    {
        spl_autoload_unregister(array(Varien_Autoload::instance(), 'autoload'));
        spl_autoload_register(array(self::getInstance(), 'autoload'));
    }

    /**
     * Removes current autoload class and
     * registers Varien_Autoload is the spl autoload queue
     */
    public static function disable()
    {
        spl_autoload_unregister(array(self::getInstance(), 'autoload'));
        spl_autoload_register(array(Varien_Autoload::instance(), 'autoload'));
    }

    /**
     * Tries to load a given class
     *
     * @param string $class
     * @return bool
     */
    public function autoload($class)
    {
        $classFile = str_replace(
            ' ',
            DIRECTORY_SEPARATOR,
            ucwords(str_replace('_', ' ', $class))
        );
        $classFile .= '.php';
        $includePaths = explode(PATH_SEPARATOR, get_include_path());
        foreach ($includePaths as $path) {
            if (file_exists($path . DIRECTORY_SEPARATOR . $classFile)) {
                require $path . DIRECTORY_SEPARATOR . $classFile;
                return true;
            }
        }
        return false;
    }
}