<?php

declare(strict_types=1);

namespace ArpTest\DateTime\Factory;

use Arp\DateTime\Factory\DateIntervalFactoryFactory;
use Arp\Factory\FactoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Arp\DateTime\Factory\DateIntervalFactoryFactory
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\DateTime\Factory
 */
final class DateIntervalFactoryFactoryTest extends TestCase
{
    /**
     * Assert that the factory implements FactoryInterface
     */
    public function testImplementsFactoryInterface(): void
    {
        $factory = new DateIntervalFactoryFactory();

        $this->assertInstanceOf(FactoryInterface::class, $factory);
    }
}
