<?php

declare(strict_types=1);

namespace ArpTest\DateTime\Factory;

use Arp\DateTime\DateTimeFactory;
use Arp\DateTime\DateTimeProviderInterface;
use Arp\DateTime\Factory\CurrentDateTimeProviderFactory;
use Arp\Factory\Exception\FactoryException;
use Arp\Factory\FactoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\DateTime\Factory
 */
final class CurrentDateTimeProviderFactoryTest extends TestCase
{
    /**
     * Ensure that the CurrentDateTimeProviderFactory implements the FactoryInterface.
     *
     * @covers \Arp\DateTime\Factory\CurrentDateTimeProviderFactory
     */
    public function testImplementsFactoryInterface(): void
    {
        $factory = new CurrentDateTimeProviderFactory();

        $this->assertInstanceOf(FactoryInterface::class, $factory);
    }

    /**
     * Assert that if provided with a 'factory' configuration option to create() a new FactoryException
     * will be thrown.
     *
     * @covers \Arp\DateTime\Factory\CurrentDateTimeProviderFactory::create
     */
    public function testCreateWillThrowFactoryExceptionIfConfigIsNotAValidDateTimeFactory(): void
    {
        $factory = new CurrentDateTimeProviderFactory();

        $factoryName = \stdClass::class;
        $config = [
            'factory' => $factoryName,
        ];

        $this->expectException(FactoryException::class);
        $this->expectExceptionMessage(
            sprintf(
                'The factory argument must be a class that implements \'%s\'; \'%s\' provided in \'%s\'',
                DateTimeFactory::class,
                $factoryName,
                CurrentDateTimeProviderFactory::class
            )
        );

        $factory->create($config);
    }

    /**
     * Ensure that create() will return a configured CurrentDateTimeProvider instance.
     *
     * @param array $config The optional test configuration.
     *
     * @covers \Arp\DateTime\Factory\CurrentDateTimeProviderFactory::create
     */
    public function testCreateWillReturnADateTimeProvider(array $config = []): void
    {
        $factory = new CurrentDateTimeProviderFactory();

        $provider = $factory->create($config);

        $this->assertInstanceOf(DateTimeProviderInterface::class, $provider);
    }
}
