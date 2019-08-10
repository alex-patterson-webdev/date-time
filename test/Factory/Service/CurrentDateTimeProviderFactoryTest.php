<?php

namespace ArpTest\DateTime\Factory\Service;

use Arp\DateTime\Factory\Service\CurrentDateTimeProviderFactory;
use Arp\DateTime\Service\CurrentDateTimeProvider;
use Arp\DateTime\Service\DateTimeFactory;
use Arp\DateTime\Service\DateTimeFactoryInterface;
use Arp\Stdlib\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * CurrentDateTimeProviderFactoryTest
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\DateTime\Factory\Service
 */
class CurrentDateTimeProviderFactoryTest extends TestCase
{
    /**
     * $container
     *
     * @var ContainerInterface|MockObject
     */
    protected $container;

    /**
     * setUp
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->container = $this->getMockForAbstractClass(ContainerInterface::class);
    }

    /**
     * testImplementsFactoryInterface
     *
     * Ensure that the CurrentDateTimeProviderFactory implements the FactoryInterface.
     *
     * @test
     */
    public function testImplementsFactoryInterface()
    {
        $factory = new CurrentDateTimeProviderFactory;

        $this->assertInstanceOf(FactoryInterface::class, $factory);
    }

    /**
     * testCreateWillReturnADateTimeProvider
     *
     * Ensure that create() will return a configured CurrentDateTimeProvider instance.
     *
     * @param array $config  The optional test configuration.
     *
     * @test
     */
    public function testCreateWillReturnADateTimeProvider(array $config = [])
    {
        $factory = new CurrentDateTimeProviderFactory;

        $requestedName = CurrentDateTimeProvider::class;

        /** @var DateTimeFactoryInterface|MockObject $dateTimeFactory */
        $dateTimeFactory = $this->getMockForAbstractClass(DateTimeFactoryInterface::class);

        $factoryName = isset($config['factory']) ? $config['factory'] : DateTimeFactory::class;

        $this->container->expects($this->once())
            ->method('get')
            ->with($factoryName)
            ->willReturn($dateTimeFactory);

        $this->assertInstanceOf(
            CurrentDateTimeProvider::class,
            $factory->create($this->container, $requestedName, $config, null)
        );
    }

}