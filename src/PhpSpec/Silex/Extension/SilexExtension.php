<?php
namespace PhpSpec\Silex\Extension;

use PhpSpec\Extension\ExtensionInterface;
use PhpSpec\ServiceContainer;
use PhpSpec\Silex\Runner\Maintainer\AppMaintainer;


class SilexExtension implements ExtensionInterface
{
    /**
     * @param ServiceContainer $container
     */
    public function load(ServiceContainer $container)
    {
        $container->setShared(
            'silex.app',
            function ($c) {
                $config = $c->getParam('silex_extension');
                $path = __DIR__ . '/' . $config['bootstrap_path'];
                $realpath = realpath($path);
                $app = require_once $realpath;
                return $app;
            }
        );

        $container->setShared(
            'runner.maintainers.silex_app',
            function ($c) {
                return new AppMaintainer(
                    $c->get('silex.app')
                );
            }
        );
    }
}