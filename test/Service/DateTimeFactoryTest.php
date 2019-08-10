<?php

namespace ArpTest\DateTime\Service;

use Arp\DateTime\Exception\DateTimeFactoryException;
use Arp\DateTime\Service\DateTimeFactory;
use Arp\DateTime\Service\DateTimeFactoryInterface;
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
    public function testCreateDateTime($spec, array $options = [])
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
    public function getCreateDateTimeData()
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


}