<?php
namespace AppBundle\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Doctrine\ORM\EntityManager;

class DbLoader extends Loader
{
    protected $loaded = false;

    /**
     * @var EntityManager
     */
    private $objectManager;

    /**
     * @param EntityManager $objectManager
     */
    public function __construct(EntityManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add the "db" loader twice');
        }

        $routes = new RouteCollection();

        // all routes comes from db
        $systemRoutes = $this->objectManager->getRepository('AppBundle:SystemRoute')->findAll();

        foreach ($systemRoutes as $systemRoute) {
            // prepare a new route
            $defaults = [
                '_controller' => $systemRoute->getController(),
            ];

            $route = new Route($systemRoute->getPath(), $defaults);

            $routes->add($systemRoute->getName(), $route);
        }

        $this->setLoaded(true);

        return $routes;
    }

    public function supports($resource, $type = null)
    {
        return 'db' === $type;
    }

    public function setLoaded($loaded)
    {
        $this->loaded = $loaded;
    }
}
