<?php

declare(strict_types=1);

namespace ArpTest\DateTime\Factory;

use Arp\DateTime\DateTimeFactory;
use Arp\DateTime\Factory\DateTimeFactoryFactory;
use Arp\Factory\Exception\FactoryException;
use Arp\Factory\FactoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers  \Arp\DateTime\Factory\DateTimeFactoryFactory
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\DateTime\Factory
 */
final class DateTimeFactoryFactoryTest extends TestCase
{
    /**
     * Assert that the factory implements FactoryInterface
     */
    public function testImplementsFactoryInterface(): void
    {
        $factory = new DateTimeFactoryFactory();

        $this->assertInstanceOf(FactoryInterface::class, $factory);
    }

    /**
     * Assert that FactoryException are thrown when providing invalid $config to create()
     *
     * @param array $config
     *
     * @dataProvider getCreateWillThrowFactoryExceptionWithInvalidConfigurationData
     *
     * @throws FactoryException
     */
    public function testCreateWillThrowFactoryExceptionWithInvalidConfiguration(array $config): void
    {
        $factory = new DateTimeFactoryFactory();

        $this->expectException(FactoryException::class);
        $this->expectExceptionMessage('Failed to create DateTimeFactory');

        $factory->create($config);
    }

    /**
     * @return array
     */
    public function getCreateWillThrowFactoryExceptionWithInvalidConfigurationData(): array
    {
        return [
            [
                [
                    'date_class_name' => \stdClass::class,
                ],
            ],
            [
                [
                    'time_zone_class_name' => \stdClass::class,
                ],
            ],
        ];
    }

    /**
     * Assert that the factory will return a DateTimeFactory instance when calling create()
     *
     * @param array $config
     *
     * @dataProvider getCreateWillReturnADateTimeFactoryData
     *
     * @throws FactoryException
     */
    public function testCreateWillReturnADateTimeFactory(array $config): void
    {
        $factory = new DateTimeFactoryFactory();

        $this->assertInstanceOf(DateTimeFactory::class, $factory->create($config));
    }

    /**
     * @return array
     */
    public function getCreateWillReturnADateTimeFactoryData(): array
    {
        return [
            [
                [],
            ],
            [
                [
                    'date_class_name' => \DateTime::class,
                ],
            ],
            [
                [
                    'date_class_name' => \DateTimeImmutable::class,
                ],
            ],
            [
                [
                    'time_zone_class_name' => \DateTimeZone::class,
                ],
            ],
        ];
    }
}
