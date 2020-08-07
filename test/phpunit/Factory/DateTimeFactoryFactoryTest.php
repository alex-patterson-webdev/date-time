<?php

declare(strict_types=1);

namespace ArpTest\DateTime\Factory;

use Arp\DateTime\DateTimeFactory;
use Arp\DateTime\Factory\DateTimeFactoryFactory;
use Arp\Factory\FactoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Arp\DateTime\Factory\DateTimeFactoryFactory
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\DateTime\Factory
 */
final class DateTimeFactoryFactoryTest extends TestCase
{
    /**
     * Assert that the factory implements FactoryInterface.
     */
    public function testImplementsFactoryInterface(): void
    {
        $factory = new DateTimeFactoryFactory();

        $this->assertInstanceOf(FactoryInterface::class, $factory);
    }

    /**
     * Assert that the factory will return a DateTimeFactory instance when calling create().
     */
    public function testCreateWillReturnADateTimeFactory(): void
    {
        $factory = new DateTimeFactoryFactory();

        $this->assertInstanceOf(DateTimeFactory::class, $factory->create());
    }
}
