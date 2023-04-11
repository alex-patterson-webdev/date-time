<?php

declare(strict_types=1);

namespace ArpTest\DateTime;

use Arp\DateTime\DateTimeFactory;
use Arp\DateTime\DateTimeFactoryInterface;
use Arp\DateTime\DateTimeZoneFactoryInterface;
use Arp\DateTime\Exception\DateTimeFactoryException;
use Arp\DateTime\Exception\DateTimeZoneFactoryException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Arp\DateTime\DateTimeFactory
 */
final class DateTimeFactoryTest extends TestCase
{
    /**
     * @var DateTimeZoneFactoryInterface&MockObject
     */
    private DateTimeZoneFactoryInterface $dateTimeZoneFactory;

    public function setUp(): void
    {
        $this->dateTimeZoneFactory = $this->createMock(DateTimeZoneFactoryInterface::class);
    }

    /**
     * Ensure that the factory implements DateTimeFactoryInterface
     */
    public function testImplementsDateTimeFactoryInterface(): void
    {
        $factory = new DateTimeFactory();

        $this->assertInstanceOf(DateTimeFactoryInterface::class, $factory);
    }

    /**
     * Assert that a DateTimeFactoryException is thrown if trying to create the class without a valid
     * $dateTimeClassName constructor argument
     *
     * @throws DateTimeFactoryException
     */
    public function testDateTimeFactoryExceptionIsThrownWhenProvidingInvalidDateTimeClassName(): void
    {
        $dateTimeClassName = \stdClass::class;

        $this->expectException(DateTimeFactoryException::class);
        $this->expectExceptionMessage(
            sprintf(
                'The \'dateTimeClassName\' parameter must be a class that implements \'%s\'',
                \DateTimeInterface::class
            )
        );

        /* @phpstan-ignore-next-line */
        new DateTimeFactory($this->dateTimeZoneFactory, $dateTimeClassName);
    }

    /**
     * Ensure that calls to createDateTime() will return the valid configured \DateTime instance.
     *
     * @dataProvider getCreateDateTimeData
     *
     * @throws DateTimeFactoryException
     * @throws \Exception
     */
    public function testCreateDateTime(?string $spec, string|\DateTimeZone|null $timeZone = null): void
    {
        $factory = new DateTimeFactory();

        $expectedDateTime = new \DateTime(
            $spec ?? 'now',
            is_string($timeZone) ? new \DateTimeZone($timeZone) : $timeZone
        );

        $dateTime = $factory->createDateTime($spec, $timeZone);

        $this->assertDateTime($expectedDateTime, $dateTime);
    }

    /**
     * @return array<int, mixed>
     */
    public function getCreateDateTimeData(): array
    {
        return [
            [
                null,
            ],

            [
                'now',
            ],

            [
                'now',
                'Europe/London',
            ],

            [
                '2019-05-14 12:33:00',
            ],

            [
                '2019-08-14 17:34:55',
                'UTC',
            ],

            [
                '2020-08-22 14:43:12',
                null,
            ],

            [
                '2020-08-22 14:44:37',
                new \DateTimeZone('Europe/London'),
            ],
        ];
    }

    /**
     * Ensure that if the DateTime cannot be created because the provided $spec is invalid, a new
     * DateTimeFactoryException will be thrown
     *
     * @throws DateTimeFactoryException
     */
    public function testCreateDateTimeWillThrowDateTimeFactoryExceptionForInvalidDateTimeSpec(): void
    {
        $factory = new DateTimeFactory($this->dateTimeZoneFactory);

        $spec = 'foo'; // invalid argument

        $this->expectException(DateTimeFactoryException::class);
        $this->expectExceptionMessage(
            sprintf('Failed to create a valid \DateTime instance using \'%s\'', $spec),
        );

        $factory->createDateTime($spec);
    }

    /**
     * Assert that a DateTimeFactoryException will be thrown when providing an invalid \DateTimeZone object to
     * createFromFormat()
     *
     * @throws DateTimeFactoryException
     */
    public function testCreateFromFormatWillCatchAndReThrowException(): void
    {
        $factory = new DateTimeFactory($this->dateTimeZoneFactory);

        $spec = '2021-05-01 23:38:12';
        $format = 'Y-m-d H:i:s';
        $timeZone = 'UTC';

        $exceptionCode = 123;
        $exception = new DateTimeZoneFactoryException('Test exception message', $exceptionCode);

        $this->dateTimeZoneFactory->expects($this->once())
            ->method('createDateTimeZone')
            ->with($timeZone)
            ->willThrowException($exception);

        $this->expectException(DateTimeFactoryException::class);
        $this->expectExceptionCode($exceptionCode);
        $this->expectExceptionMessage('Failed to create date time zone');

        $factory->createFromFormat($format, $spec, $timeZone);
    }

    /**
     * Assert that a DateTimeFactoryException will be thrown if providing an invalid $spec
     * argument to createFromFormat()
     *
     * @dataProvider getCreateFromFormatWillThrowDateTimeFactoryExceptionForInvalidDateTimeData
     *
     * @throws DateTimeFactoryException
     */
    public function testCreateFromFormatWillThrowDateTimeFactoryExceptionForInvalidDateTimeSpec(
        string $format,
        string $spec,
        string|\DateTimeZone|null $timeZone = null
    ): void {
        $factory = new DateTimeFactory($this->dateTimeZoneFactory);

        $this->expectException(DateTimeFactoryException::class);
        $this->expectExceptionMessage(
            sprintf('Failed to create a valid \DateTime instance using \'%s\' and format \'%s\'', $spec, $format)
        );

        $factory->createFromFormat($format, $spec, $timeZone);
    }

    /**
     * @return array<int, mixed>
     */
    public function getCreateFromFormatWillThrowDateTimeFactoryExceptionForInvalidDateTimeData(): array
    {
        return [
            [
                'test',
                'Y-m-d',
            ],
        ];
    }

    /**
     * Assert that a DateTimeFactoryException will be thrown when providing an invalid \DateTimeZone object to
     * createDateTime()
     *
     * @throws DateTimeFactoryException
     */
    public function testCreateDateTimeWillThrowDateTimeFactoryExceptionForInvalidDateTimeZone(): void
    {
        $factory = new DateTimeFactory($this->dateTimeZoneFactory);

        $spec = 'now';
        $timeZone = 'UTC';

        $exceptionCode = 123;
        $exception = new DateTimeZoneFactoryException('This is a test exception', $exceptionCode);

        $this->dateTimeZoneFactory->expects($this->once())
            ->method('createDateTimeZone')
            ->with($timeZone)
            ->willThrowException($exception);

        $this->expectException(DateTimeFactoryException::class);
        $this->expectExceptionCode($exceptionCode);
        $this->expectExceptionMessage('Failed to create date time zone');

        $factory->createDateTime($spec, $timeZone);
    }

    /**
     * Ensure that a \DateTime instance can be created from the provided format
     *
     * @dataProvider getCreateFromFormatData
     *
     * @throws DateTimeFactoryException
     * @throws \Exception
     */
    public function testCreateFromFormat(string $format, string $spec, string|\DateTimeZone|null $timeZone = null): void
    {
        $factory = new DateTimeFactory($this->dateTimeZoneFactory);

        $dateTimeZone = is_string($timeZone) ? new \DateTimeZone($timeZone) : $timeZone;

        if (is_string($timeZone)) {
            $dateTimeZone = new \DateTimeZone($timeZone);
            $this->dateTimeZoneFactory->expects($this->once())
                ->method('createDateTimeZone')
                ->with($timeZone)
                ->willReturn($dateTimeZone);
        }

        /** @var \DateTimeInterface $expectedDateTime */
        $expectedDateTime = \DateTime::createFromFormat(
            $format,
            $spec,
            $dateTimeZone
        );

        $this->assertDateTime($expectedDateTime, $factory->createFromFormat($format, $spec, $timeZone));
    }

    /**
     * @see https://www.php.net/manual/en/timezones.europe.php
     *
     * @return array<int, mixed>
     */
    public function getCreateFromFormatData(): array
    {
        return [
            [
                'Y-m-d',
                '2019-04-01',
            ],
            [
                'Y/m/d',
                '1976/01/14',
            ],
            [
                'Y-m-d H:i:s',
                '2019-08-14 17:34:55',
                'UTC',
            ],
            [
                'Y-m-d H:i:s',
                '2010-10-26 11:19:32',
                'Europe/London',
            ],
        ];
    }

    /**
     * @param \DateTimeInterface $expectedDateTime
     * @param \DateTimeInterface $dateTime
     */
    private function assertDateTime(\DateTimeInterface $expectedDateTime, \DateTimeInterface $dateTime): void
    {
        $this->assertSame($expectedDateTime->format('Y'), $dateTime->format('Y'), 'Years do not match');
        $this->assertSame($expectedDateTime->format('M'), $dateTime->format('M'), 'Months do not match');
        $this->assertSame($expectedDateTime->format('d'), $dateTime->format('d'), 'Days do not match');
        $this->assertSame($expectedDateTime->format('H'), $dateTime->format('H'), 'Hours do not match');
        $this->assertSame($expectedDateTime->format('i'), $dateTime->format('i'), 'Minuets do not match');
        $this->assertSame($expectedDateTime->format('s'), $dateTime->format('s'), 'Seconds do not match');
        $this->assertSame($expectedDateTime->format('f'), $dateTime->format('f'), 'Milliseconds do not match');

        $this->assertSame(
            $expectedDateTime->getTimezone()->getName(),
            $dateTime->getTimezone()->getName(),
            'Timezones do not match'
        );
    }
}
