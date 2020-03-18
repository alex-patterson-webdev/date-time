<?php

declare(strict_types=1);

namespace ArpTest\DateTime;

use Arp\DateTime\DateTimeFactory;
use Arp\DateTime\DateTimeFactoryInterface;
use Arp\DateTime\Exception\DateTimeFactoryException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\DateTime
 */
class DateTimeFactoryTest extends TestCase
{
    /**
     * Ensure that the factory implements DateTimeFactoryInterface.
     */
    public function testImplementsDateTimeTimeFactoryInterface(): void
    {
        $factory = new DateTimeFactory();

        $this->assertInstanceOf(DateTimeFactoryInterface::class, $factory);
    }

    /**
     * Ensure that calls to createDateTime() will return the valid configured \DateTime instance.
     *
     * @param string      $time     The date and time
     * @param string|null $timeZone The date and time timezone
     *
     * @dataProvider getCreateDateTimeData
     *
     * @covers       \Arp\DateTime\DateTimeFactory::createDateTime
     */
    public function testCreateDateTime(string $time, $timeZone = null): void
    {
        $factory = new DateTimeFactory();

        $dateTime = $factory->createDateTime($time, $timeZone);

        $this->assertSame($time, $dateTime->format('Y-m-d H:i:s'));
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
        ];
    }

    /**
     * Ensure that if the DateTime cannot be create a new DateTimeFactoryException will be thrown.
     *
     * @covers \Arp\DateTime\DateTimeFactory::createDateTime
     */
    public function testCreateDateTimeWillThrowDateTimeFactoryException(): void
    {
        $factory = new DateTimeFactory();

        $time = 'foo'; // invalid argument

        $this->expectException(DateTimeFactoryException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Failed to create a valid \DateTime instance using time \'%s\' in \'%s\'.',
                $time,
                DateTimeFactory::class
            )
        );

        $factory->createDateTime($time);
    }

    /**
     * Ensure that a createFromFormat() will throw a DateTimeFactoryException if a \DateTime instance cannot be created.
     *
     * @param string                    $format
     * @param string                    $time
     * @param string|\DateTimeZone|null $timeZone
     *
     * @dataProvider getCreateFromFormatWillThrowDateTimeFactoryExceptionData
     *
     * @covers       \Arp\DateTime\DateTimeFactory::createFromFormat
     */
    public function testCreateFromFormatWillThrowDateTimeFactoryException(
        string $format,
        string $time,
        $timeZone = null
    ): void {
        $factory = new DateTimeFactory();

        $this->expectException(DateTimeFactoryException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Failed to create a valid \DateTime instance using format \'%s\' for time \'%s\' in \'%s\'.',
                $format,
                $time,
                DateTimeFactory::class
            )
        );

        $factory->createFromFormat($format, $time, $timeZone);
    }

    /**
     * @return array
     */
    public function getCreateFromFormatWillThrowDateTimeFactoryExceptionData(): array
    {
        return [
            [
                'Y-m-d',
                'test',
            ],
        ];
    }

    /**
     * Ensure that a \DateTime instance can be created from the provided format.
     *
     * @param string                    $format
     * @param string                    $time
     * @param string|\DateTimeZone|null $timeZone
     *
     * @dataProvider getCreateFromFormatData
     *
     * @covers       \Arp\DateTime\DateTimeFactory::createFromFormat
     * @covers       \Arp\DateTime\DateTimeFactory::resolveDateTimeZone
     */
    public function testCreateFromFormat(string $format, string $time, $timeZone = null): void
    {
        /** @var DateTimeFactory|MockObject $factory */
        $factory = $this->getMockBuilder(DateTimeFactory::class)
                        ->onlyMethods(['createDateTimeZone'])
                        ->getMock();

        if (! empty($timeZone) && is_string($timeZone)) {
            $dateTimeZone = new \DateTimeZone($timeZone);

            $factory->expects($this->once())
                    ->method('createDateTimeZone')
                    ->with($timeZone)
                    ->willReturn($dateTimeZone);
        }

        $dateTime = $factory->createFromFormat($format, $time, $timeZone);

        $this->assertSame($time, $dateTime->format($format));

        if (isset($timeZone)) {
            if (is_string($timeZone)) {
                $this->assertSame($timeZone, $dateTime->getTimezone()->getName());
            } else {
                $this->assertEquals($timeZone, $dateTime->getTimezone());
            }
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

            [
                'Y-m-d H:i:s',
                '2020-03-17 16:33:33',
                new \DateTimeZone('Europe/London'),
            ],

        ];
    }

    /**
     * Ensure a \DateTimeZone instance is returned according to the provided $spec and $options.
     *
     * @param string $timeZone
     *
     * @dataProvider getCreateDateTimeZoneData
     */
    public function testCreateDateTimeZone($timeZone): void
    {
        $factory = new DateTimeFactory();

        $dateTimeZone = $factory->createDateTimeZone($timeZone);

        $this->assertSame($timeZone, $dateTimeZone->getName());
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
     * @param string $timeZone The invalid timezone specification.
     *
     * @throws DateTimeFactoryException
     *
     * @dataProvider getCreateDateTimeZoneWillThrowDateTimeFactoryExceptionIfSpecIsInvalidData
     */
    public function testCreateDateTimeZoneWillThrowDateTimeFactoryExceptionIfSpecIsInvalid(string $timeZone): void
    {
        $factory = new DateTimeFactory();

        $this->expectException(DateTimeFactoryException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Failed to create a valid \DateTimeZone instance using \'%s\' in \'%s\'.',
                $timeZone,
                DateTimeFactory::class
            )
        );


        $factory->createDateTimeZone($timeZone);
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
