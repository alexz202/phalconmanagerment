<?php
namespace Zejicrm\Modules\Cli;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    /**
     * Registers an autoloader related to the module
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([
            'Zejicrm\Modules\Cli\Tasks' => __DIR__ . '/tasks/',
            'Zejicrm\Modules\Frontend\Models' => APP_PATH . '/modules/frontend/models/',
            'Zejicrm\Modules\Frontend\Services' => APP_PATH . '/modules/frontend/services/'
        ]);


        $loader->register();
    }



    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
    }
}
