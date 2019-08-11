<?php

namespace ArpTest\DateTime\Service;

use Arp\DateTime\Exception\DateTimeFactoryException;
use Arp\DateTime\Service\DateTimeFactory;
use Arp\DateTime\Service\DateTimeFactoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * DateTimeFactoryTest
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\DateTime\Service
 */
class DateTimeFactoryTest extends TestCase
{
    /**
     * testImplementsDateTimeTimeFactoryInterface
     *
     * Ensure that the factory implements DateTimeFactoryInterface.
     *
     * @test
     */
    public function testImplementsDateTimeTimeFactoryInterface()
    {
        $factory = new DateTimeFactory();

        $this->assertInstanceOf(DateTimeFactoryInterface::class, $factory);
    }

    /**
     * testCreateDateTime
     *
     * Ensure that calls to createDateTime() will return the valid configured \DateTime instance.
     *
     * @param string $spec       The date and time specification.
     * @param array  $options    Optional date time creation options.
     *
     * @dataProvider getCreateDateTimeData
     * @test
     */
    public function testCreateDateTime(string $spec, array $options = [])
    {
        $factory = new DateTimeFactory();

        $dateTime = $factory->createDateTime($spec, $options);

        $this->assertInstanceOf(\DateTime::class, $dateTime);
        $this->assertSame($spec, $dateTime->format('Y-m-d H:i:s'));
    }

    /**
     * getCreateDateTimeData
     *
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
     * testCreateDateTimeWillThrowDateTimeFactoryException
     *
     * Ensure that if the DateTime cannot be create a new DateTimeFactoryException will be thrown.
     *
     * @test
     */
    public function testCreateDateTimeWillThrowDateTimeFactoryException()
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
     * testCreateFromFormatWillThrowDateTimeFactoryException
     *
     * Ensure that a createFromFormat() will throw a DateTimeFactoryException if a \DateTime instance cannot be created.
     *
     * @param string $spec
     * @param string $format
     * @param array  $options
     *
     * @dataProvider getCreateFromFormatWillThrowDateTimeFactoryExceptionData
     * @test
     */
    public function testCreateFromFormatWillThrowDateTimeFactoryException(string $spec, string $format, array $options = [])
    {
        $factory = new DateTimeFactory;

        $this->expectException(DateTimeFactoryException::class);
        $this->expectExceptionMessage(sprintf(
            'Failed to create a valid \DateTime instance using format \'%s\' in \'%s\'.',
            $format,
            DateTimeFactory::class
        ));

        $factory->createFromFormat($spec, $format, $options);
    }

    /**
     * getCreateFromFormatWillThrowDateTimeFactoryExceptionData
     *
     * @return array
     */
    public function getCreateFromFormatWillThrowDateTimeFactoryExceptionData()
    {
        return [
            [
                'test',
                'Y-m-d'
            ]
        ];
    }


    /**
     * createFromFormat
     *
     * Ensure that a \DateTime instance can be created from the provided format.
     *
     * @param string $spec
     * @param string $format
     * @param array  $options
     *
     * @dataProvider getCreateFromFormatData
     * @test
     */
    public function createFromFormat(string $spec, string $format, array $options = [])
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

        $this->assertInstanceOf(\DateTime::class, $dateTime);
        $this->assertSame($spec, $dateTime->format($format));

        if (isset($dateTimeZone)) {
            $this->assertSame($options['time_zone'], $dateTimeZone->getName());
        }
    }

    /**
     * getCreateDateTimeData
     *
     * @see https://www.php.net/manual/en/timezones.europe.php
     *
     * @return array
     */
    public function getCreateFromFormatData()
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


}