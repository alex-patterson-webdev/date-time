<?php

declare(strict_types=1);

namespace ArpTest\DateTime;

use Arp\DateTime\DateIntervalFactory;
use Arp\DateTime\DateIntervalFactoryInterface;
use Arp\DateTime\Exception\DateIntervalFactoryException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Arp\DateTime\DateIntervalFactory
 */
final class DateIntervalFactoryTest extends TestCase
{
    /**
     * Ensure that the DateIntervalFactory implements the DateIntervalFactoryInterface
     */
    public function testImplementsDateIntervalFactoryInterface(): void
    {
        $factory = new DateIntervalFactory();

        $this->assertInstanceOf(DateIntervalFactoryInterface::class, $factory);
    }

    /**
     * Ensure that the DateInterval is created in accordance with the provided $spec
     *
     * @dataProvider getCreateDateIntervalData
     *
     * @throws DateIntervalFactoryException
     * @throws \Exception
     */
    public function testCreateDateInterval(string $spec): void
    {
        $factory = new DateIntervalFactory();

        $dateInterval = $factory->createDateInterval($spec);

        $test = new \DateInterval($spec);

        $this->assertSame($test->y, $dateInterval->y);
        $this->assertSame($test->m, $dateInterval->m);
        $this->assertSame($test->d, $dateInterval->d);
        $this->assertSame($test->h, $dateInterval->h);
        $this->assertSame($test->i, $dateInterval->i);
        $this->assertSame($test->f, $dateInterval->f);
    }

    /**
     * @see https://www.php.net/manual/en/class.dateinterval.php
     *
     * @return array<mixed>
     */
    public function getCreateDateIntervalData(): array
    {
        return [
            ['P100D'],
            ['P4Y1DT9H11M3S'],
            ['P2Y4DT6H8M'],
            ['P7Y8M'],
        ];
    }

    /**
     * Ensure that createDateInterval() will throw a DateIntervalFactoryException if the provided $spec is invalid
     *
     * @dataProvider getCreateDateIntervalWillThrowDateIntervalFactoryExceptionData
     *
     * @throws DateIntervalFactoryException
     */
    public function testCreateDateIntervalWillThrowDateIntervalFactoryException(string $spec): void
    {
        $factory = new DateIntervalFactory();

        $this->expectException(DateIntervalFactoryException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Failed to create a valid \DateInterval instance using \'%s\'',
                $spec
            )
        );

        $factory->createDateInterval($spec);
    }

    /**
     * @return array<mixed>
     */
    public function getCreateDateIntervalWillThrowDateIntervalFactoryExceptionData(): array
    {
        return [
            ['test'],
            ['invalid'],
        ];
    }
}
