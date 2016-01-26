<?php
namespace PhpSpec\Silex\Runner\Maintainer;

use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\Runner\CollaboratorManager;
use PhpSpec\Runner\MatcherManager;
use PhpSpec\Runner\Maintainer\MaintainerInterface;
use PhpSpec\SpecificationInterface;
use PhpSpec\Laravel\Util\Laravel;
use Silex\Application;

/**
 * @author Artur Lasota <lasota.artur@gmail.com>
 */
class AppMaintainer implements MaintainerInterface
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param ExampleNode $example
     * @return bool
     */
    public function supports(ExampleNode $example)
    {

        $specClassName = $example->getSpecification()->getClassReflection()->getName();
        return in_array('PhpSpec\\Silex\\SilexObjectBehavior', class_parents($specClassName));
    }

    /**
     * {@inheritdoc}
     */
    public function prepare(ExampleNode $example, SpecificationInterface $context,
                            MatcherManager $matchers, CollaboratorManager $collaborators)
    {
        $reflection =
            $example
                ->getSpecification()
                ->getClassReflection()
                ->getMethod('setApp');

        $reflection->invokeArgs($context, array($this->app));
    }

    /**
     * {@inheritdoc}
     */
    public function teardown(ExampleNode $example, SpecificationInterface $context,
                             MatcherManager $matchers, CollaboratorManager $collaborators)
    {
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return 1000;
    }
}
