<?php

declare(strict_types=1);

namespace ArpTest\DateTime;

use Arp\DateTime\DateFactoryInterface;
use Arp\DateTime\DateIntervalFactoryInterface;
use Arp\DateTime\DateTimeFactory;
use Arp\DateTime\DateTimeFactoryInterface;
use Arp\DateTime\Exception\DateIntervalFactoryException;
use Arp\DateTime\Exception\DateTimeFactoryException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\DateTime
 */
final class DateTimeFactoryTest extends TestCase
{
    /**
     * @var DateIntervalFactoryInterface|MockObject
     */
    private $dateIntervalFactory;

    /**
     * Prepare the test case dependencies
     */
    public function setUp(): void
    {
        $this->dateIntervalFactory = $this->getMockForAbstractClass(DateIntervalFactoryInterface::class);
    }

    /**
     * Ensure that the factory implements DateFactoryInterface.
     *
     * @covers \Arp\DateTime\DateTimeFactory
     */
    public function testImplementsDateFactoryInterface(): void
    {
        $factory = new DateTimeFactory($this->dateIntervalFactory);

        $this->assertInstanceOf(DateFactoryInterface::class, $factory);
    }

    /**
     * Ensure that the factory implements DateTimeFactoryInterface.
     *
     * @covers \Arp\DateTime\DateTimeFactory
     */
    public function testImplementsDateTimeFactoryInterface(): void
    {
        $factory = new DateTimeFactory($this->dateIntervalFactory);

        $this->assertInstanceOf(DateTimeFactoryInterface::class, $factory);
    }

    /**
     * Ensure that the factory implements DateIntervalFactoryInterface.
     *
     * @covers \Arp\DateTime\DateTimeFactory
     */
    public function testImplementsDateIntervalFactoryInterface(): void
    {
        $factory = new DateTimeFactory($this->dateIntervalFactory);

        $this->assertInstanceOf(DateIntervalFactoryInterface::class, $factory);
    }

    /**
     * Ensure that calls to createDateTime() will return the valid configured \DateTime instance.
     *
     * @param string                    $spec     The date and time specification.
     * @param \DateTimeZone|string|null $timeZone The optional date time zone to test.
     *
     * @dataProvider getCreateDateTimeData
     *
     * @covers       \Arp\DateTime\DateTimeFactory::createDateTime
     * @covers       \Arp\DateTime\DateTimeFactory::resolveDateTimeZone
     *
     * @throws DateTimeFactoryException
     */
    public function testCreateDateTime(string $spec, $timeZone = null): void
    {
        $factory = new DateTimeFactory($this->dateIntervalFactory);

        $dateTime = $factory->createDateTime($spec, $timeZone);

        $this->assertSame($spec, $dateTime->format('Y-m-d H:i:s'));
    }

    /**
     * @return array
     */
    public function getCreateDateTimeData(): array
    {
        return [
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
     * DateTimeFactoryException will be thrown.
     *
     * @covers \Arp\DateTime\DateTimeFactory::createDateTime
     *
     * @throws DateTimeFactoryException
     */
    public function testCreateDateTimeWillThrowDateTimeFactoryExceptionForInvalidDateTimeSpec(): void
    {
        $factory = new DateTimeFactory($this->dateIntervalFactory);

        $spec = 'foo'; // invalid argument

        $exceptionMessage = sprintf(
            'DateTime::__construct(): Failed to parse time string (%s) at position 0 (%s)',
            $spec,
            $spec[0]
        );

        $this->expectException(DateTimeFactoryException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Failed to create a valid \DateTime instance using \'%s\': %s',
                $spec,
                $exceptionMessage
            )
        );

        $factory->createDateTime($spec);
    }

    /**
     * Assert that a DateTimeFactoryException will be thrown if providing an invalid $spec
     * argument to createFromFormat().
     *
     * @param string                    $spec
     * @param string                    $format
     * @param \DateTimeZone|string|null $timeZone
     *
     * @dataProvider getCreateFromFormatWillThrowDateTimeFactoryExceptionForInvalidDateTimeData
     *
     * @covers       \Arp\DateTime\DateTimeFactory::createFromFormat
     *
     * @throws DateTimeFactoryException
     */
    public function testCreateFromFormatWillThrowDateTimeFactoryExceptionForInvalidDateTimeSpec(
        string $spec,
        string $format,
        $timeZone = null
    ): void {
        $factory = new DateTimeFactory($this->dateIntervalFactory);

        $this->expectException(DateTimeFactoryException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Failed to create a valid \DateTime instance using \'%s\' and format \'%s\'',
                $spec,
                $format
            )
        );

        $factory->createFromFormat($spec, $format, $timeZone);
    }

    /**
     * @return array
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
     * Assert that a DateTimeFactoryException will be thrown when providing a invalid \DateTimeZone object to
     * createDateTime().
     *
     * @covers \Arp\DateTime\DateTimeFactory::createDateTime
     * @covers \Arp\DateTime\DateTimeFactory::resolveDateTimeZone
     *
     * @throws DateTimeFactoryException
     */
    public function testCreateDateTimeWillThrowDateTimeFactoryExceptionForInvalidDateTimeZone(): void
    {
        $factory = new DateTimeFactory($this->dateIntervalFactory);

        $spec = 'now';
        $timeZone = new \stdClass();

        $errorMessage = sprintf(
            'The \'timeZone\' argument must be a \'string\''
            . 'or an object of type \'%s\'; \'%s\' provided in \'%s\'',
            \DateTimeZone::class,
            is_object($timeZone) ? get_class($timeZone) : gettype($timeZone),
            'resolveDateTimeZone'
        );

        $this->expectException(DateTimeFactoryException::class);
        $this->expectExceptionMessage($errorMessage);

        $factory->createDateTime($spec, $timeZone);
    }

    /**
     * Ensure that a \DateTime instance can be created from the provided format.
     *
     * @param string                    $spec
     * @param string                    $format
     * @param string|\DateTimeZone|null $timeZone
     *
     * @dataProvider getCreateFromFormatData
     *
     * @covers       \Arp\DateTime\DateTimeFactory::createFromFormat
     * @covers       \Arp\DateTime\DateTimeFactory::resolveDateTimeZone
     *
     * @throws DateTimeFactoryException
     */
    public function testCreateFromFormat(string $spec, string $format, $timeZone = null): void
    {
        $factory = new DateTimeFactory($this->dateIntervalFactory);

        $dateTime = $factory->createFromFormat($spec, $format, $timeZone);

        $this->assertSame($spec, $dateTime->format($format));

        if (null !== $timeZone) {
            $this->assertSame($timeZone, $dateTime->getTimezone()->getName());
        }
    }

    /**
     * @see https://www.php.net/manual/en/timezones.europe.php
     *
     * @return array
     */
    public function getCreateFromFormatData(): array
    {
        return [
            [
                '2019-04-01',
                'Y-m-d',
            ],
            [
                '1976/01/14',
                'Y/m/d',
            ],
            [
                '2019-08-14 17:34:55',
                'Y-m-d H:i:s',
                'UTC',
            ],
            [
                '2010-10-26 11:19:32',
                'Y-m-d H:i:s',
                'Europe/London',
            ],
        ];
    }

    /**
     * Ensure a \DateTimeZone instance is returned according to the provided $spec and $options.
     *
     * @param string $spec
     *
     * @dataProvider getCreateDateTimeZoneData
     *
     * @covers       \Arp\DateTime\DateTimeFactory::createDateTimeZone
     *
     * @throws DateTimeFactoryException
     */
    public function testCreateDateTimeZone(string $spec): void
    {
        $factory = new DateTimeFactory($this->dateIntervalFactory);

        $dateTimeZone = $factory->createDateTimeZone($spec);

        $this->assertSame($spec, $dateTimeZone->getName());
    }

    /**
     * @see https://www.php.net/manual/en/timezones.europe.php
     *
     * @return array
     */
    public function getCreateDateTimeZoneData(): array
    {
        return [
            [
                'Europe/London',
            ],
            [
                'Europe/Amsterdam',
            ],
            [
                'Europe/Rome',
            ],
            [
                'Atlantic/Bermuda',
            ],
            [
                'Atlantic/Azores',
            ],
            [
                'Antarctica/DumontDUrville',
            ],
        ];
    }

    /**
     * Ensure that if providing an invalid $spec argument to createDateTimeZone() a new DateTimeFactoryException
     * is thrown.
     *
     * @param string $spec The invalid timezone specification.
     *
     * @throws DateTimeFactoryException
     *
     * @dataProvider getCreateDateTimeZoneWillThrowDateTimeFactoryExceptionIfSpecIsInvalidData
     *
     * @covers       \Arp\DateTime\DateTimeFactory::createDateTimeZone
     */
    public function testCreateDateTimeZoneWillThrowDateTimeFactoryExceptionIfSpecIsInvalid(string $spec): void
    {
        $factory = new DateTimeFactory($this->dateIntervalFactory);

        $exceptionMessage = sprintf('DateTimeZone::__construct(): Unknown or bad timezone (%s)', $spec);

        $this->expectException(DateTimeFactoryException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Failed to create a valid \DateTimeZone instance using \'%s\': %s',
                $spec,
                $exceptionMessage
            )
        );

        $factory->createDateTimeZone($spec);
    }

    /**
     * @return array
     */
    public function getCreateDateTimeZoneWillThrowDateTimeFactoryExceptionIfSpecIsInvalidData(): array
    {
        return [
            [
                'skjdvbnksd',
            ],
            [
                '2345234',
            ],
            [
                'Europe/MyEmpire',
            ],
        ];
    }

    /**
     * Assert that calls to creatDateInterval() will return the expected DateInterval instance.
     *
     * @param string $spec
     *
     * @covers       \Arp\DateTime\DateTimeFactory::createDateInterval
     * @dataProvider getCreateDateIntervalWillReturnANewDateIntervalToSpecData
     *
     * @throws DateTimeFactoryException
     */
    public function testCreateDateIntervalWillReturnANewDateIntervalToSpec(string $spec): void
    {
        $factory = new DateTimeFactory($this->dateIntervalFactory);

        /** @var \DateInterval|MockObject $dateInterval */
        $dateInterval = $this->createMock(\DateInterval::class);

        $this->dateIntervalFactory->expects($this->once())
            ->method('createDateInterval')
            ->willReturn($dateInterval);

        $this->assertSame($dateInterval, $factory->createDateInterval($spec));
    }

    /**
     * @return array
     */
    public function getCreateDateIntervalWillReturnANewDateIntervalToSpecData(): array
    {
        return [
            ['P100D'],
            ['P4Y1DT9H11M3S'],
            ['P2Y4DT6H8M'],
            ['P7Y8M'],
        ];
    }

    /**
     * Assert that an invalid $spec passed to createDateInterval() will raise a DateTimeFactoryException.
     *
     * @covers \Arp\DateTime\DateTimeFactory::createDateInterval
     *
     * @throws DateTimeFactoryException
     */
    public function testDateIntervalWillThrowDateTimeFactoryExceptionIfUnableToCreateADateInterval(): void
    {
        $spec = 'Hello';

        $factory = new DateTimeFactory($this->dateIntervalFactory);

        $exceptionCode = 123;
        $exceptionMessage = 'This is a test exception message';
        $exception = new DateIntervalFactoryException($exceptionMessage, $exceptionCode);

        $this->dateIntervalFactory->expects($this->once())
            ->method('createDateInterval')
            ->willThrowException($exception);

        $errorMessage = sprintf(
            'Failed to create date interval \'%s\': %s',
            $spec,
            $exceptionMessage
        );

        $this->expectDeprecationMessage(DateTimeFactoryException::class);
        $this->expectExceptionMessage($errorMessage);
        $this->expectExceptionCode($exceptionCode);

        $factory->createDateInterval($spec);
    }

    /**
     * Assert that the calls to diff will return a valid DateInterval.
     *
     * @covers \Arp\DateTime\DateTimeFactory::diff
     *
     * @throws DateTimeFactoryException
     */
    public function testDiffWillReturnDateInterval(): void
    {
        // @todo Data provider
        $origin = new \DateTime();
        $target = new \DateTime();
        $absolute = false;

        $dateInterval = $origin->diff($target);

        $factory = new DateTimeFactory($this->dateIntervalFactory);

        $this->dateIntervalFactory->expects($this->once())
            ->method('diff')
            ->with($origin, $target, $absolute)
            ->willReturn($dateInterval);

        $this->assertSame($dateInterval, $factory->diff($origin, $target, $absolute));
    }

    /**
     * Assert that a DateTimeFactoryException is thrown when unable to diff the provided dates.
     *
     * @covers \Arp\DateTime\DateTimeFactory::diff
     *
     * @throws DateTimeFactoryException
     */
    public function testDateTimeFactoryExceptionWillBeThrownIfDiffFails(): void
    {
        $factory = new DateTimeFactory($this->dateIntervalFactory);

        $origin = new \DateTime();
        $target = new \DateTime();

        $exceptionCode = 123;
        $exceptionMessage = 'This is a test exception message';
        $exception = new DateIntervalFactoryException($exceptionMessage, $exceptionCode);

        $this->dateIntervalFactory->expects($this->once())
            ->method('diff')
            ->with($origin, $target, false)
            ->willThrowException($exception);

        $this->expectException(DateTimeFactoryException::class);
        $this->expectExceptionMessage(sprintf('Failed to perform date diff: %s', $exceptionMessage));
        $this->expectExceptionCode($exceptionCode);

        $factory->diff($origin, $target);
    }
}
