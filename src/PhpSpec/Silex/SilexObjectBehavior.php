<?php
namespace PhpSpec\Silex;

use PhpSpec\ObjectBehavior;
use PhpSpec\Wrapper\Subject;
use Silex\Application;

/**
 * @author Artur Lasota <lasota.artur@gmail.com>
 */
class SilexObjectBehavior extends ObjectBehavior
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     */
    public function setApp(Application $app)
    {
        $this->app = $app;
    }
}
