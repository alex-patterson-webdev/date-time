<?php declare(strict_types=1);

namespace ArpTest\DateTime\Factory\Service;

use Arp\DateTime\Factory\Service\CurrentDateTimeProviderFactory;
use Arp\DateTime\Service\DateTimeProviderInterface;
use Arp\Factory\FactoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\DateTime\Factory\Service
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
