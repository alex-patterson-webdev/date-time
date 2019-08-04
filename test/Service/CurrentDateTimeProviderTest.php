<?php

namespace ArpTest\DateTime\Service;

use Arp\DateTime\Service\CurrentDateTimeProvider;
use Arp\DateTime\Service\DateTimeFactoryInterface;
use Arp\DateTime\Service\DateTimeProviderInterface;
use PHPUnit\Framework\TestCase;

/**
 * CurrentDateTimeProviderTest
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\DateTime\Service
 */
class CurrentDateTimeProviderTest extends TestCase
{
    /**
     * factory
     *
     * @var DateTimeFactoryInterface|MockObject
     */
    protected $factory;

    /**
     * setUp
     *
     * Set up the test case dependencies.
     *
     * @return void
     */
    public function setUp() : void
    {
        $this->factory = $this->getMockForAbstractClass(DateTimeFactoryInterface::class);
    }

    /**
     * testImplementsDateTimeProviderInterface
     *
     * Ensure that the provider implements DateTimeProviderInterface.
     *
     * @test
     */
    public function testImplementsDateTimeProviderInterface()
    {
        $provider = new CurrentDateTimeProvider($this->factory);

        $this->assertInstanceOf(DateTimeProviderInterface::class, $provider);
    }

}