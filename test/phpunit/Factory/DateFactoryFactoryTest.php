<?php

declare(strict_types=1);

namespace ArpTest\DateTime\Factory;

use Arp\DateTime\Factory\DateFactoryFactory;
use Arp\Factory\FactoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers  \Arp\DateTime\Factory\DateFactoryFactory
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\DateTime\Factory
 */
final class DateFactoryFactoryTest extends TestCase
{
    /**
     * Assert that the class implements FactoryInterface
     */
    public function testImplementsFactoryInterface(): void
    {
        $factory = new DateFactoryFactory();

        $this->assertInstanceOf(FactoryInterface::class, $factory);
    }
}
