<?php

namespace ArpTest\DateTime\Service;

use Arp\DateTime\Exception\DateTimeFactoryException;
use Arp\DateTime\Exception\DateTimeProviderException;
use Arp\DateTime\Service\CurrentDateTimeProvider;
use Arp\DateTime\Service\DateTimeFactoryInterface;
use Arp\DateTime\Service\DateTimeProviderInterface;
use PHPUnit\Framework\MockObject\MockObject;
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

    /**
     * testGetDateTimeWillReturnDateTimeInstance
     *
     * Ensure that a new \DateTime instance is returned when calling
     *
     * @test
     */
    public function testGetDateTimeWillReturnDateTimeInstance()
    {
        $provider = new CurrentDateTimeProvider($this->factory);

        $dateTime = new \DateTime;

        $this->factory->expects($this->once())
            ->method('createDateTime')
            ->willReturn($dateTime);

        $this->assertSame($dateTime, $provider->getDateTime());
    }

    /**
     * testGetDateTimeWillThrowDateTimeProviderException
     *
     * Ensure that calls to getDateTime that cannot create a new date time instance will throw
     * a DateTimeProviderException.
     *
     * @test
     */
    public function testGetDateTimeWillThrowDateTimeProviderException()
    {
        $provider = new CurrentDateTimeProvider($this->factory);

        $exceptionMessage = 'This is a test exception message.';
        $exception = new DateTimeFactoryException($exceptionMessage);

        $this->factory->expects($this->once())
            ->method('createDateTime')
            ->willThrowException($exception);

        $this->expectException(DateTimeProviderException::class);
        $this->expectExceptionMessage($exceptionMessage);
        $this->expectExceptionCode($exception->getCode());

        $provider->getDateTime();
    }

}