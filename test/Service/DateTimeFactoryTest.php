<?php declare(strict_types=1);

namespace ArpTest\DateTime\Service;

use Arp\DateTime\Exception\DateTimeFactoryException;
use Arp\DateTime\Service\DateTimeFactory;
use Arp\DateTime\Service\DateTimeFactoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\DateTime\Service
 */
class DateTimeFactoryTest extends TestCase
{
    /**
     * Ensure that the factory implements DateTimeFactoryInterface.
     */
    public function testImplementsDateTimeTimeFactoryInterface() : void
    {
        $factory = new DateTimeFactory();

        $this->assertInstanceOf(DateTimeFactoryInterface::class, $factory);
    }

    /**
     * Ensure that calls to createDateTime() will return the valid configured \DateTime instance.
     *
     * @param string $spec       The date and time specification.
     * @param array  $options    Optional date time creation options.
     *
     * @dataProvider getCreateDateTimeData
     */
    public function testCreateDateTime(string $spec, array $options = []) : void
    {
        $factory = new DateTimeFactory();

        $dateTime = $factory->createDateTime($spec, $options);

        $this->assertSame($spec, $dateTime->format('Y-m-d H:i:s'));
    }

    /**
     * @return array
     */
    public function getCreateDateTimeData() : array
    {
        return [

            [
                '2019-05-14 12:33:00',
            ],

        ];
    }

    /**
     * Ensure that if the DateTime cannot be create a new DateTimeFactoryException will be thrown.
     */
    public function testCreateDateTimeWillThrowDateTimeFactoryException() : void
    {
        $factory = new DateTimeFactory();

        $spec    = 'foo'; // invalid argument
        $options = [];


        $this->expectException(DateTimeFactoryException::class);
        $this->expectExceptionMessage(sprintf(
            'Failed to create a valid \DateTime instance using specification \'%s\' in \'%s\'.',
            $spec,
            DateTimeFactory::class
        ));

        $factory->createDateTime($spec, $options);
    }

    /**
     * Ensure that a createFromFormat() will throw a DateTimeFactoryException if a \DateTime instance cannot be created.
     *
     * @param string $spec
     * @param string $format
     * @param array  $options
     *
     * @dataProvider getCreateFromFormatWillThrowDateTimeFactoryExceptionData
     */
    public function testCreateFromFormatWillThrowDateTimeFactoryException(
        string $spec,
        string $format,
        array $options = []
    ) : void {
        $factory = new DateTimeFactory;

        $this->expectException(DateTimeFactoryException::class);
        $this->expectExceptionMessage(sprintf(
            'Failed to create a valid \DateTime instance using specification \'%s\' in \'%s\'.',
            $spec,
            DateTimeFactory::class
        ));

        $factory->createFromFormat($spec, $format, $options);
    }

    /**
     * @return array
     */
    public function getCreateFromFormatWillThrowDateTimeFactoryExceptionData() : array
    {
        return [
            [
                'test',
                'Y-m-d'
            ]
        ];
    }

    /**
     * Ensure that a \DateTime instance can be created from the provided format.
     *
     * @param string $spec
     * @param string $format
     * @param array  $options
     *
     * @dataProvider getCreateFromFormatData
     */
    public function createFromFormat(string $spec, string $format, array $options = []) : void
    {
        /** @var DateTimeFactory|MockObject $factory */
        $factory = $this->getMockBuilder(DateTimeFactory::class)
            ->onlyMethods(['createDateTimeZone'])
            ->getMock();

        if (! empty($options['time_zone'])) {
            $dateTimeZone = new \DateTimeZone($options['time_zone']);

            $factory->expects($this->once())
                ->method('createDateTimeZone')
                ->with($options['time_zone'])
                ->willReturn($dateTimeZone);
        }

        $dateTime = $factory->createFromFormat($spec, $format, $options);

        $this->assertSame($spec, $dateTime->format($format));

        if (isset($dateTimeZone)) {
            $this->assertSame($options['time_zone'], $dateTimeZone->getName());
        }
    }

    /**
     * @see https://www.php.net/manual/en/timezones.europe.php
     *
     * @return array
     */
    public function getCreateFromFormatData() : array
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
                [
                    'time_zone' => 'UTC',
                ]
            ],

            [
                '2010-10-26 11:19:32',
                'Y-m-d H:i:s',
                [
                    'time_zone' => 'Europe/London',
                ]
            ],

        ];
    }

    /**
     * Ensure a \DateTimeZone instance is returned according to the provided $spec and $options.
     *
     * @param string $spec
     * @param array  $options
     *
     * @dataProvider getCreateDateTimeZoneData
     */
    public function testCreateDateTimeZone(string $spec, array $options = []) : void
    {
        $factory = new DateTimeFactory;

        $dateTimeZone = $factory->createDateTimeZone($spec, $options);

        $this->assertSame($spec, $dateTimeZone->getName());
    }

    /**
     * @see https://www.php.net/manual/en/timezones.europe.php
     *
     * @return array
     */
    public function getCreateDateTimeZoneData() : array
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
     */
    public function testCreateDateTimeZoneWillThrowDateTimeFactoryExceptionIfSpecIsInvalid(string $spec) : void
    {
        $factory = new DateTimeFactory;

        $this->expectException(DateTimeFactoryException::class);
        $this->expectExceptionMessage(sprintf(
            'Failed to create a valid \DateTimeZone instance using \'%s\' in \'%s\'.',
            $spec,
            DateTimeFactory::class
        ));


        $factory->createDateTimeZone($spec);
    }

    /**
     * @return array
     */
    public function getCreateDateTimeZoneWillThrowDateTimeFactoryExceptionIfSpecIsInvalidData() : array
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
