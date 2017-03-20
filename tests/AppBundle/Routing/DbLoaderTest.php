<?php

namespace Tests\AppBundle\Routing;

use AppBundle\Routing\DbLoader;
use Doctrine\Common\Collections\ArrayCollection;

class DbLoaderTest extends \PHPUnit_Framework_TestCase
{
    protected $objectManager;
    protected $sut;
    protected $repository;

    public function __construct()
    {
        $this->objectManager = $this->createMock('Doctrine\ORM\EntityManager');
        $this->repository = $this->createMock('\Doctrine\Common\Persistence\ObjectRepository');
        $this->sut = new DbLoader($this->objectManager);

        $this->objectManager
            ->expects($this->any())
            ->method('getRepository')
            ->with('AppBundle:SystemRoute')
            ->willReturn($this->repository);
    }

    /**
      * @expectedException        RuntimeException
      * @expectedExceptionMessage Do not add the "db" loader twice
      */
    public function testItShouldNotLoadAlreadyLoadedRoutes()
    {
        $this->sut->setLoaded(true);

        $this->sut->load([]);
    }

    public function testItShouldNotAddRoutesWhenWhereIsNothingToLoad()
    {
        $this->repository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([]);

        $result = $this->sut->load([]);
        $this->assertEquals(0, $result->count());
    }

    public function testItLoadsRoutesFromDatabase()
    {
        $route1 = $this->createMock('AppBundle\Entity\SystemRoute');

        $route1
            ->expects($this->once())
            ->method('getName')
            ->willReturn('name1');

        $route2 = $this->createMock('AppBundle\Entity\SystemRoute');
        $route2
            ->expects($this->once())
            ->method('getName')
            ->willReturn('name2');

        $routes = [$route1, $route2];

        $this->repository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn($routes);

        $result = $this->sut->load([]);

        $this->assertEquals(2, $result->count());
    }

    public function testItOnlySupportsDbRouter()
    {
        $this->assertTrue($this->sut->supports([], 'db'));
        $this->assertFalse($this->sut->supports([], 'other'));
    }
}
