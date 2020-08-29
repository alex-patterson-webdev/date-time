<?php

declare(strict_types=1);

namespace ArpTest\DateTime\Factory;

use Arp\DateTime\DateFactoryInterface;
use Arp\DateTime\DateIntervalFactoryInterface;
use Arp\DateTime\DateTimeFactoryInterface;
use Arp\DateTime\Factory\DateFactoryFactory;
use Arp\Factory\Exception\FactoryException;
use Arp\Factory\FactoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers  \Arp\DateTime\Factory\DateFactoryFactory
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\DateTime\Factory
 */
final class DateFactoryFactoryTest extends TestCase
{
    /**
     * @var FactoryInterface|MockObject
     */
    private $dateTimeFactoryFactory;

    /**
     * @var FactoryInterface|MockObject
     */
    private $dateIntervalFactoryFactory;

    /**
     * Prepare test case dependencies
     */
    public function setUp(): void
    {
        $this->dateTimeFactoryFactory = $this->createMock(FactoryInterface::class);

        $this->dateIntervalFactoryFactory = $this->createMock(FactoryInterface::class);
    }

    /**
     * Assert that the class implements FactoryInterface
     */
    public function testImplementsFactoryInterface(): void
    {
        $factory = new DateFactoryFactory($this->dateTimeFactoryFactory, $this->dateIntervalFactoryFactory);

        $this->assertInstanceOf(FactoryInterface::class, $factory);
    }

    /**
     * Assert that a FactoryException is thrown then providing invalid 'date_time_factory' configuration.
     *
     * @throws FactoryException
     */
    public function testCreateWillThrowFactoryExceptionIfDateTimeFactoryConfigIsInvalid(): void
    {
        $factory = new DateFactoryFactory($this->dateTimeFactoryFactory, $this->dateIntervalFactoryFactory);

        $config = [
            'date_time_factory' => new \stdClass(),
        ];

        $this->expectException(FactoryException::class);
        $this->expectExceptionMessage(
            sprintf(
                'The \'date_time_factory\' argument could not be resolved to an object of type \'%s\'',
                DateTimeFactoryInterface::class
            )
        );

        $factory->create($config);
    }

    /**
     * Assert that a FactoryException is thrown then providing invalid 'date_interval_factory' configuration.
     *
     * @throws FactoryException
     */
    public function testCreateWillThrowFactoryExceptionIfDateIntervalFactoryConfigIsInvalid(): void
    {
        $factory = new DateFactoryFactory($this->dateTimeFactoryFactory, $this->dateIntervalFactoryFactory);

        $config = [
            'date_interval_factory' => new \stdClass(),
        ];

        $this->dateTimeFactoryFactory->expects($this->once())
            ->method('create')
            ->with([])
            ->willReturn($this->createMock(DateTimeFactoryInterface::class));

        $this->expectException(FactoryException::class);
        $this->expectExceptionMessage(
            sprintf(
                'The \'date_interval_factory\' argument could not be resolved to an object of type \'%s\'',
                DateIntervalFactoryInterface::class
            )
        );

        $factory->create($config);
    }

    /**
     * @param array $config
     *
     * @dataProvider getCreateData
     *
     * @throws \Arp\Factory\Exception\FactoryException
     */
    public function testCreate(array $config): void
    {
        $factory = new DateFactoryFactory($this->dateTimeFactoryFactory, $this->dateIntervalFactoryFactory);

        $dateTimeFactoryConfig = $config['date_time_factory'] ?? [];
        if (is_array($dateTimeFactoryConfig)) {
            $dateTimeFactory = $this->createMock(DateTimeFactoryInterface::class);
            $this->dateTimeFactoryFactory->expects($this->once())
                ->method('create')
                ->with($dateTimeFactoryConfig)
                ->willReturn($dateTimeFactory);
        }

        $dateIntervalFactoryConfig = $config['date_interval_factory'] ?? [];
        if (is_array($dateIntervalFactoryConfig)) {
            $dateIntervalFactory = $this->createMock(DateIntervalFactoryInterface::class);
            $this->dateIntervalFactoryFactory->expects($this->once())
                ->method('create')
                ->with($dateIntervalFactoryConfig)
                ->willReturn($dateIntervalFactory);
        }

        $this->assertInstanceOf(DateFactoryInterface::class, $factory->create($config));
    }

    /**
     * @return array
     */
    public function getCreateData(): array
    {
        return [
            [
                []
            ],
            [
                [
                    'date_time_factory' => []
                ],
            ],
            [
                [
                    'date_interval_factory' => []
                ],
            ],
            [
                [
                    'date_time_factory' => [],
                    'date_interval_factory' => []
                ],
            ],
        ];
    }
}
