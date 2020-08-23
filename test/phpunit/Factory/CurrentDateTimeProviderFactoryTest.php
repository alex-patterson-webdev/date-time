<?php

declare(strict_types=1);

namespace ArpTest\DateTime\Factory;

use Arp\DateTime\DateTimeFactoryInterface;
use Arp\DateTime\DateTimeProviderInterface;
use Arp\DateTime\Factory\CurrentDateTimeProviderFactory;
use Arp\Factory\Exception\FactoryException;
use Arp\Factory\FactoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\DateTime\Factory
 */
final class CurrentDateTimeProviderFactoryTest extends TestCase
{
    /**
     * @var FactoryInterface|MockObject
     */
    private $dateTimeFactoryFactory;

    /**
     * Set up the test case dependencies
     */
    public function setUp(): void
    {
        $this->dateTimeFactoryFactory = $this->createMock(FactoryInterface::class);
    }

    /**
     * Ensure that the CurrentDateTimeProviderFactory implements the FactoryInterface.
     *
     * @covers \Arp\DateTime\Factory\CurrentDateTimeProviderFactory
     */
    public function testImplementsFactoryInterface(): void
    {
        $factory = new CurrentDateTimeProviderFactory($this->dateTimeFactoryFactory);

        $this->assertInstanceOf(FactoryInterface::class, $factory);
    }

    /**
     * Ensure that create() will return a configured CurrentDateTimeProvider instance.
     *
     * @param array $config The optional test configuration.
     *
     * @dataProvider getCreateWillReturnADateTimeProviderData
     * @covers \Arp\DateTime\Factory\CurrentDateTimeProviderFactory::create
     *
     * @throws FactoryException
     */
    public function testCreateWillReturnADateTimeProvider(array $config = []): void
    {
        $factory = new CurrentDateTimeProviderFactory($this->dateTimeFactoryFactory);

        $dateTimeFactoryConfig = $config['date_time_factory'] ?? [];
        if (is_array($dateTimeFactoryConfig)) {
            /** @var DateTimeFactoryInterface|MockObject $dateTimeFactory */
            $this->dateTimeFactoryFactory->expects($this->once())
                ->method('create')
                ->with($dateTimeFactoryConfig)
                ->willReturn($this->createMock(DateTimeFactoryInterface::class));
        }

        $this->assertInstanceOf(DateTimeProviderInterface::class, $factory->create($config));
    }

    /**
     * @return array
     */
    public function getCreateWillReturnADateTimeProviderData(): array
    {
        return [
            [
                [],
            ],
            [
                [
                    'date_time_factory' => $this->createMock(DateTimeFactoryInterface::class)
                ],
            ],
        ];
    }
}
