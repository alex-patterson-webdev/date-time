<?php declare(strict_types=1);

namespace ArpTest\DateTime\Factory;

use Arp\DateTime\Factory\CurrentDateTimeProviderFactory;
use Arp\DateTime\DateTimeProviderInterface;
use Arp\Factory\FactoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\DateTime\Factory
 */
final class CurrentDateTimeProviderFactoryTest extends TestCase
{
    /**
     * Ensure that the CurrentDateTimeProviderFactory implements the FactoryInterface.
     */
    public function testImplementsFactoryInterface() : void
    {
        $factory = new CurrentDateTimeProviderFactory;

        $this->assertInstanceOf(FactoryInterface::class, $factory);
    }

    /**
     * Ensure that create() will return a configured CurrentDateTimeProvider instance.
     *
     * @param array $config  The optional test configuration.
     */
    public function testCreateWillReturnADateTimeProvider(array $config = []) : void
    {
        $factory = new CurrentDateTimeProviderFactory;

        $provider = $factory->create($config);

        $this->assertInstanceOf(DateTimeProviderInterface::class, $provider);
    }
}
