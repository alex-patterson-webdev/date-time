<?php

declare(strict_types=1);

namespace ArpTest\DateTime;

use Arp\DateTime\CurrentDateTimeProvider;
use Arp\DateTime\DateTimeFactoryInterface;
use Arp\DateTime\DateTimeProviderInterface;
use Arp\DateTime\Exception\DateTimeFactoryException;
use Arp\DateTime\Exception\DateTimeProviderException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\DateTime
 */
final class CurrentDateTimeProviderTest extends TestCase
{
    /**
     * @var DateTimeFactoryInterface|MockObject
     */
    protected $factory;

    /**
     * Set up the test case dependencies.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->factory = $this->getMockForAbstractClass(DateTimeFactoryInterface::class);
    }

    /**
     * Ensure that the provider implements DateTimeProviderInterface.
     *
     * @covers \Arp\DateTime\CurrentDateTimeProvider
     */
    public function testImplementsDateTimeProviderInterface(): void
    {
        $provider = new CurrentDateTimeProvider($this->factory);

        $this->assertInstanceOf(DateTimeProviderInterface::class, $provider);
    }

    /**
     * Ensure that a new \DateTime instance is returned when calling.
     *
     * @covers \Arp\DateTime\CurrentDateTimeProvider::getDateTime
     */
    public function testGetDateTimeWillReturnDateTimeInstance(): void
    {
        $provider = new CurrentDateTimeProvider($this->factory);

        $dateTime = new \DateTime();

        $this->factory->expects($this->once())
            ->method('createDateTime')
            ->willReturn($dateTime);

        $this->assertSame($dateTime, $provider->getDateTime());
    }

    /**
     * Ensure that calls to getDateTime that cannot create a new date time instance will throw
     * a DateTimeProviderException.
     *
     * @covers \Arp\DateTime\CurrentDateTimeProvider::getDateTime
     */
    public function testGetDateTimeWillThrowDateTimeProviderException(): void
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
