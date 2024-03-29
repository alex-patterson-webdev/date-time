<?php

declare(strict_types=1);

namespace ArpTest\DateTime;

use Arp\DateTime\DateFactory;
use Arp\DateTime\DateFactoryInterface;
use Arp\DateTime\DateIntervalFactoryInterface;
use Arp\DateTime\DateTimeFactoryInterface;
use Arp\DateTime\DateTimeZoneFactoryInterface;
use Arp\DateTime\Exception\DateIntervalFactoryException;
use Arp\DateTime\Exception\DateTimeFactoryException;
use Arp\DateTime\Exception\DateTimeZoneFactoryException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Arp\DateTime\DateFactory
 */
final class DateFactoryTest extends TestCase
{
    /**
     * @var DateTimeFactoryInterface&MockObject
     */
    private DateTimeFactoryInterface $dateTimeFactory;

    /**
     * @var DateTimeZoneFactoryInterface&MockObject
     */
    private DateTimeZoneFactoryInterface $dateTimeZoneFactory;

    /**
     * @var DateIntervalFactoryInterface&MockObject
     */
    private DateIntervalFactoryInterface $dateIntervalFactory;

    public function setUp(): void
    {
        $this->dateTimeFactory = $this->createMock(DateTimeFactoryInterface::class);
        $this->dateTimeZoneFactory = $this->createMock(DateTimeZoneFactoryInterface::class);
        $this->dateIntervalFactory = $this->createMock(DateIntervalFactoryInterface::class);
    }

    /**
     * Ensure that the factory implements DateFactoryInterface
     *
     * @throws DateTimeFactoryException
     */
    public function testImplementsDateFactoryInterface(): void
    {
        $factory = new DateFactory($this->dateTimeFactory, $this->dateTimeZoneFactory, $this->dateIntervalFactory);

        $this->assertInstanceOf(DateFactoryInterface::class, $factory);
    }

    /**
     * Assert the calls to createDateTime() will proxy to the internal DateTimeFactory
     *
     * @throws DateTimeFactoryException
     * @throws \Exception
     */
    public function testCreateDateTimeWillProxyToDateTimeFactory(): void
    {
        $factory = new DateFactory($this->dateTimeFactory, $this->dateTimeZoneFactory, $this->dateIntervalFactory);

        $spec = '2021-05-01 23:29:33';
        $timeZone = new \DateTimeZone('UTC');

        $dateTime = new \DateTime($spec, $timeZone);

        $this->dateTimeFactory->expects($this->once())
            ->method('createDateTime')
            ->with($spec, $timeZone)
            ->willReturn($dateTime);

        $this->assertSame($dateTime, $factory->createDateTime($spec, $timeZone));
    }

    /**
     * Assert the calls to createFromFormat() will proxy to the internal DateTimeFactory
     *
     * @throws DateTimeFactoryException
     */
    public function testCreateFromFormatWillProxyToDateTimeFactory(): void
    {
        $factory = new DateFactory($this->dateTimeFactory, $this->dateTimeZoneFactory, $this->dateIntervalFactory);

        $spec = '2021-05-01 23:29:33';
        $format = 'Y-m-d H:i:s';
        $timeZone = new \DateTimeZone('UTC');

        $dateTime = \DateTime::createFromFormat($format, $spec, $timeZone);

        $this->dateTimeFactory->expects($this->once())
            ->method('createFromFormat')
            ->with($format, $spec, $timeZone)
            ->willReturn($dateTime);

        $this->assertSame($dateTime, $factory->createFromFormat($format, $spec, $timeZone));
    }

    /**
     * Assert the calls to createDateTimeZone() will proxy to the internal DateTimeZoneFactory
     *
     * @throws DateTimeZoneFactoryException
     * @throws DateTimeFactoryException
     * @throws \Exception
     */
    public function testCreateDateTimeZoneWillProxyToDateTimeZoneFactory(): void
    {
        $factory = new DateFactory($this->dateTimeFactory, $this->dateTimeZoneFactory, $this->dateIntervalFactory);

        $spec = 'UTC';
        $timeZone = new \DateTimeZone($spec);

        $this->dateTimeZoneFactory->expects($this->once())
            ->method('createDateTimeZone')
            ->with($spec)
            ->willReturn($timeZone);

        $this->assertSame($timeZone, $factory->createDateTimeZone($spec));
    }

    /**
     * Assert the calls to createDateInterval() will proxy to the internal DateTimeIntervalFactory
     *
     * @throws DateIntervalFactoryException
     * @throws DateTimeFactoryException
     */
    public function testCreateDateIntervalWillProxyToDateTimeIntervalFactory(): void
    {
        $factory = new DateFactory($this->dateTimeFactory, $this->dateTimeZoneFactory, $this->dateIntervalFactory);

        $spec = 'P1D';
        $dateInterval = new \DateInterval('P1D');

        $this->dateIntervalFactory->expects($this->once())
            ->method('createDateInterval')
            ->with($spec)
            ->willReturn($dateInterval);

        $this->assertSame($dateInterval, $factory->createDateInterval($spec));
    }
}
