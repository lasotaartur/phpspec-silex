<?php
namespace PhpSpec\Silex\Extension;

use InvalidArgumentException;
use PhpSpec\Extension\ExtensionInterface;
use PhpSpec\ServiceContainer;
use PhpSpec\Silex\Runner\Maintainer\AppMaintainer;

/**
 * @author Artur Lasota <lasota.artur@gmail.com>
 */
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
                $path = $this->getBootstrapPath(isset($config['bootstrap_path']) ? $config['bootstrap_path'] : 'app/boostrap.php');

                if (!is_file($path)) {
                    throw new InvalidArgumentException("App bootstrap at `{$path}` not found.");
                }
                $realpath = realpath($path);

                $app = require_once $realpath;
                $this->removeSilexExceptionAndErrorHandler();
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

    /**
     * @param $path
     * @return string
     */
    private function getBootstrapPath($path)
    {
        $path = $this->getRootPath() . $path;
        if (!is_file($path)) {
            throw new InvalidArgumentException("App bootstrap at `{$path}` not found.");
        }

        return $path;
    }


    /**
     * @return string
     */
    private function getRootPath()
    {
        return realpath(__DIR__ . '/../../../../../../..');
    }

    /**
     * @param Application $app
     */
    private function removeSilexExceptionAndErrorHandler(Application $app)
    {
        unset($app['exception_handler']);
    }
}
