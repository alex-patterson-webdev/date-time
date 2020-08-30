<?php

declare(strict_types=1);

namespace ArpTest\DateTime;

use Arp\DateTime\DateTimeFactory;
use Arp\DateTime\DateTimeFactoryInterface;
use Arp\DateTime\Exception\DateTimeFactoryException;
use PHPUnit\Framework\TestCase;

/**
 * @covers  \Arp\DateTime\DateTimeFactory
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\DateTime
 */
final class DateTimeFactoryTest extends TestCase
{
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
                'The \'dateTimeClassName\' must the fully qualified class name'
                . ' of a class that implements \'%s\'; \'%s\' provided',
                \DateTimeInterface::class,
                $dateTimeClassName
            )
        );

        new DateTimeFactory($dateTimeClassName);
    }

    /**
     * Assert that a DateTimeFactoryException is thrown if trying to create the class without a valid
     * $dateTimeZoneClassName constructor argument
     *
     * @throws DateTimeFactoryException
     */
    public function testDateTimeFactoryExceptionIsThrownWhenProvidingInvalidDateTimeZoneClassName(): void
    {
        $dateTimeZoneClassName = \stdClass::class;

        $this->expectException(DateTimeFactoryException::class);
        $this->expectExceptionMessage(
            sprintf(
                'The \'dateTimeZoneClassName\' must the fully qualified class name'
                . ' of a class that implements \'%s\'; \'%s\' provided',
                \DateTimeZone::class,
                $dateTimeZoneClassName
            )
        );

        new DateTimeFactory(null, $dateTimeZoneClassName);
    }

    /**
     * Ensure that calls to createDateTime() will return the valid configured \DateTime instance.
     *
     * @param string|null               $spec     The date and time specification.
     * @param \DateTimeZone|string|null $timeZone The optional date time zone to test.
     *
     * @dataProvider getCreateDateTimeData
     *
     * @throws DateTimeFactoryException
     */
    public function testCreateDateTime(?string $spec, $timeZone = null): void
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
     * @return array
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
                'Europe/London'
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
     * DateTimeFactoryException will be thrown.
     *
     * @throws DateTimeFactoryException
     */
    public function testCreateDateTimeWillThrowDateTimeFactoryExceptionForInvalidDateTimeSpec(): void
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
     * Assert that a DateTimeFactoryException will be thrown if providing an invalid $spec
     * argument to createFromFormat().
     *
     * @param string                    $spec
     * @param string                    $format
     * @param \DateTimeZone|string|null $timeZone
     *
     * @dataProvider getCreateFromFormatWillThrowDateTimeFactoryExceptionForInvalidDateTimeData
     *
     * @throws DateTimeFactoryException
     */
    public function testCreateFromFormatWillThrowDateTimeFactoryExceptionForInvalidDateTimeSpec(
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
     * createDateTime()
     *
     * @throws DateTimeFactoryException
     */
    public function testCreateDateTimeWillThrowDateTimeFactoryExceptionForInvalidDateTimeZone(): void
    {
        $factory = new DateTimeFactory();

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

        $factory->createDateTime($spec, /** @scrutinizer ignore-type */ $timeZone);
    }

    /**
     * Ensure that a \DateTime instance can be created from the provided format
     *
     * @param string                    $spec
     * @param string                    $format
     * @param string|\DateTimeZone|null $timeZone
     *
     * @dataProvider getCreateFromFormatData
     *
     * @throws DateTimeFactoryException
     */
    public function testCreateFromFormat(string $spec, string $format, $timeZone = null): void
    {
        $factory = new DateTimeFactory();

        $expectedDateTime = \DateTime::createFromFormat(
            $format,
            $spec ?? 'now',
            is_string($timeZone) ? new \DateTimeZone($timeZone) : $timeZone
        );

        $dateTime = $factory->createFromFormat($spec, $format, $timeZone);

        $this->assertDateTime($expectedDateTime, $dateTime);
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
     * Ensure a \DateTimeZone instance is returned according to the provided $spec and $options
     *
     * @param string $spec
     *
     * @dataProvider getCreateDateTimeZoneData
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
                'UTC',
            ],
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
     * is thrown
     *
     * @param string $spec The invalid timezone specification
     *
     * @dataProvider getCreateDateTimeZoneWillThrowDateTimeFactoryExceptionIfSpecIsInvalidData
     *
     * @throws DateTimeFactoryException
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
