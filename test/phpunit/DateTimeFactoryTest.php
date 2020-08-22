<?php

declare(strict_types=1);

namespace ArpTest\DateTime;

use Arp\DateTime\DateIntervalFactoryInterface;
use Arp\DateTime\DateTimeFactory;
use Arp\DateTime\DateTimeFactoryInterface;
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
     * Ensure that the factory implements DateTimeFactoryInterface.
     *
     * @covers \Arp\DateTime\DateTimeFactory
     */
    public function testImplementsDateTimeTimeFactoryInterface(): void
    {
        $factory = new DateTimeFactory();

        $this->assertInstanceOf(DateTimeFactoryInterface::class, $factory);
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
        $factory = new DateTimeFactory();

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
     * Ensure that if the DateTime cannot be create a new DateTimeFactoryException will be thrown.
     *
     * @covers \Arp\DateTime\DateTimeFactory::createDateTime
     *
     * @throws DateTimeFactoryException
     */
    public function testCreateDateTimeWillThrowDateTimeFactoryException(): void
    {
        $factory = new DateTimeFactory();

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
     * Ensure that a createFromFormat() will throw a DateTimeFactoryException if a \DateTime instance cannot be created.
     *
     * @param string                    $spec
     * @param string                    $format
     * @param \DateTimeZone|string|null $timeZone
     *
     * @dataProvider getCreateFromFormatWillThrowDateTimeFactoryExceptionData
     *
     * @covers       \Arp\DateTime\DateTimeFactory::createFromFormat
     *
     * @throws DateTimeFactoryException
     */
    public function testCreateFromFormatWillThrowDateTimeFactoryException(
        string $spec,
        string $format,
        $timeZone = null
    ): void {
        $factory = new DateTimeFactory();

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
    public function getCreateFromFormatWillThrowDateTimeFactoryExceptionData(): array
    {
        return [
            [
                'test',
                'Y-m-d',
            ],
        ];
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
        $factory = new DateTimeFactory();

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
        $factory = new DateTimeFactory();

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
}
