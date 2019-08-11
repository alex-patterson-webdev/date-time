<?php

namespace ArpTest\DateTime\Service;

use Arp\DateTime\Exception\DateIntervalFactoryException;
use Arp\DateTime\Service\DateIntervalFactory;
use Arp\DateTime\Service\DateIntervalFactoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * DateInterfaceFactoryTest
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\DateTime\Service
 */
class DateInterfaceFactoryTest extends TestCase
{
    /**
     * testImplementsDateIntervalFactoryInterface
     *
     * Ensure that the DateIntervalFactory implements the DateIntervalFactoryInterface.
     *
     * @test
     */
    public function testImplementsDateIntervalFactoryInterface()
    {
        $factory = new DateIntervalFactory;

        $this->assertInstanceOf(DateIntervalFactoryInterface::class, $factory);
    }

    /**
     * testCreateDateInterval
     *
     * Ensure that the DateInterval is created in accordance with the provided $spec.
     *
     * @param string $spec The \DateInterval specification.
     *
     * @dataProvider getCreateDateIntervalData
     * @test
     */
    public function testCreateDateInterval(string $spec)
    {
        $factory = new DateIntervalFactory;

        $dateInterval = $factory->createDateInterval($spec);

        $this->assertInstanceOf(\DateInterval::class, $dateInterval);

        $test = new \DateInterval($spec);

        $this->assertSame($test->y, $dateInterval->y);
        $this->assertSame($test->m, $dateInterval->m);
        $this->assertSame($test->d, $dateInterval->d);
        $this->assertSame($test->h, $dateInterval->h);
        $this->assertSame($test->i, $dateInterval->i);
        $this->assertSame($test->f, $dateInterval->f);
    }

    /**
     * getCreateDateIntervalData
     *
     * @see https://www.php.net/manual/en/class.dateinterval.php
     *
     * @return array
     */
    public function getCreateDateIntervalData()
    {
        return [
            ['P100D'],
            ['P4Y1DT9H11M3S'],
            ['P2Y4DT6H8M'],
            ['P7Y8M']
        ];
    }

    /**
     * testCreateDateIntervalWillThrowDateIntervalFactoryException
     *
     * Ensure that createDateInterval() will throw a DateIntervalFactoryException if the provided $spec is invalid.
     *
     * @param string $spec
     *
     * @dataProvider getCreateDateIntervalWillThrowDateIntervalFactoryExceptionData
     * @test
     */
    public function testCreateDateIntervalWillThrowDateIntervalFactoryException(string $spec)
    {
        $factory = new DateIntervalFactory;

        $this->expectException(DateIntervalFactoryException::class);
        $this->expectExceptionMessage(sprintf(
            'Failed to create a valid \DateInterval instance using specification \'%s\' in \'%s\'.',
            $spec,
            DateIntervalFactory::class
        ));

        $factory->createDateInterval($spec);
    }

    /**
     * getCreateDateIntervalWillThrowDateIntervalFactoryExceptionData
     *
     * @return array
     */
    public function getCreateDateIntervalWillThrowDateIntervalFactoryExceptionData()
    {
        return [
            ['test'],
            ['invalid']
        ];
    }

}