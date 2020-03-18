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
     */
    public function testImplementsFactoryInterface(): void
    {
        $factory = new CurrentDateTimeProviderFactory();

        $this->assertInstanceOf(FactoryInterface::class, $factory);
    }

    /**
     * Assert that the create() method will throw a FactoryException if the provided 'factory' options is invalid.
     *
     * @param mixed $dateTimeFactory
     *
     * @dataProvider getCreateWillThrowFactoryExceptionIfProvidedDateTimeArgumentIsNotOfTypeDateTimeFactoryData
     *
     * @covers \Arp\DateTime\Factory\CurrentDateTimeProviderFactory::create
     */
    public function testCreateWillThrowFactoryExceptionIfProvidedDateTimeArgumentIsNotOfTypeDateTimeFactory(
        $dateTimeFactory
    ): void {
        $factory = new CurrentDateTimeProviderFactory();

        $config = [
            'factory' => $dateTimeFactory,
        ];

        $this->expectException(FactoryException::class);
        $this->expectExceptionMessage(sprintf(
            'The factory argument must be a class that implements \'%s\'; \'%s\' provided in \'%s\'',
            DateTimeFactory::class,
            is_string($dateTimeFactory) ? $dateTimeFactory : gettype($dateTimeFactory),
            CurrentDateTimeProviderFactory::class
        ));

        $factory->create($config);
    }

    /**
     * @return array
     */
    public function getCreateWillThrowFactoryExceptionIfProvidedDateTimeArgumentIsNotOfTypeDateTimeFactoryData(): array
    {
        return [
            [\stdClass::class],
            [new \stdClass()],
        ];
    }

    /**
     * Ensure that create() will return a configured CurrentDateTimeProvider instance.
     *
     * @param array $config The optional test configuration.
     */
    public function testCreateWillReturnADateTimeProvider(array $config = []): void
    {
        $factory = new CurrentDateTimeProviderFactory();

        $provider = $factory->create($config);

        $this->assertInstanceOf(DateTimeProviderInterface::class, $provider);
    }
}
