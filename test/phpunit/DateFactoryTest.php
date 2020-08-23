<?php

declare(strict_types=1);

namespace ArpTest\DateTime;

use Arp\DateTime\DateFactory;
use Arp\DateTime\DateFactoryInterface;
use Arp\DateTime\DateIntervalFactoryInterface;
use Arp\DateTime\DateTimeFactoryInterface;
use Arp\DateTime\Exception\DateFactoryException;
use Arp\DateTime\Exception\DateIntervalFactoryException;
use Arp\DateTime\Exception\DateTimeFactoryException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\DateTime
 */
final class DateFactoryTest extends TestCase
{
    /**
     * @var DateTimeFactoryInterface|MockObject
     */
    private $dateTimeFactory;

    /**
     * @var DateIntervalFactoryInterface|MockObject
     */
    private $dateIntervalFactory;

    /**
     * Set up the test case dependencies
     */
    public function setUp(): void
    {
        $this->dateTimeFactory = $this->createMock(DateTimeFactoryInterface::class);

        $this->dateIntervalFactory = $this->createMock(DateIntervalFactoryInterface::class);
    }

    /**
     * Ensure that the factory implements DateFactoryInterface.
     *
     * @covers \Arp\DateTime\DateFactory
     */
    public function testImplementsDateFactoryInterface(): void
    {
        $factory = new DateFactory($this->dateTimeFactory, $this->dateIntervalFactory);

        $this->assertInstanceOf(DateFactoryInterface::class, $factory);
    }

    /**
     * Assert that calls to creatDateInterval() will return the expected DateInterval instance.
     *
     * @param string $spec
     *
     * @covers       \Arp\DateTime\DateFactory::createDateInterval
     * @dataProvider getCreateDateIntervalWillReturnANewDateIntervalToSpecData
     *
     * @throws DateFactoryException
     */
    public function testCreateDateIntervalWillReturnANewDateIntervalToSpec(string $spec): void
    {
        $factory = new DateFactory($this->dateTimeFactory, $this->dateIntervalFactory);

        /** @var \DateInterval|MockObject $dateInterval */
        $dateInterval = $this->createMock(\DateInterval::class);

        $this->dateIntervalFactory->expects($this->once())
            ->method('createDateInterval')
            ->willReturn($dateInterval);

        $this->assertSame($dateInterval, $factory->createDateInterval($spec));
    }

    /**
     * @return array
     */
    public function getCreateDateIntervalWillReturnANewDateIntervalToSpecData(): array
    {
        return [
            ['P100D'],
            ['P4Y1DT9H11M3S'],
            ['P2Y4DT6H8M'],
            ['P7Y8M'],
        ];
    }


    /**
     * Assert that an invalid $spec passed to createDateInterval() will raise a DateTimeFactoryException.
     *
     * @covers \Arp\DateTime\DateFactory::createDateInterval
     *
     * @throws DateFactoryException
     */
    public function testDateIntervalWillThrowDateTimeFactoryExceptionIfUnableToCreateADateInterval(): void
    {
        $spec = 'Hello';

        $factory = new DateFactory($this->dateTimeFactory, $this->dateIntervalFactory);

        $exceptionCode = 123;
        $exceptionMessage = 'This is a test exception message';
        $exception = new DateIntervalFactoryException($exceptionMessage, $exceptionCode);

        $this->dateIntervalFactory->expects($this->once())
            ->method('createDateInterval')
            ->willThrowException($exception);

        $errorMessage = sprintf(
            'Failed to create date interval \'%s\': %s',
            $spec,
            $exceptionMessage
        );

        $this->expectDeprecationMessage(DateTimeFactoryException::class);
        $this->expectExceptionMessage($errorMessage);
        $this->expectExceptionCode($exceptionCode);

        $factory->createDateInterval($spec);
    }

    /**
     * Assert that the calls to diff will return a valid DateInterval.
     *
     * @covers \Arp\DateTime\DateFactory::diff
     *
     * @throws DateFactoryException
     */
    public function testDiffWillReturnDateInterval(): void
    {
        // @todo Data provider
        $origin = new \DateTime();
        $target = new \DateTime();
        $absolute = false;

        $dateInterval = $origin->diff($target);

        $factory = new DateFactory($this->dateTimeFactory, $this->dateIntervalFactory);

        $this->dateIntervalFactory->expects($this->once())
            ->method('diff')
            ->with($origin, $target, $absolute)
            ->willReturn($dateInterval);

        $this->assertSame($dateInterval, $factory->diff($origin, $target, $absolute));
    }

    /**
     * Assert that a DateTimeFactoryException is thrown when unable to diff the provided dates.
     *
     * @covers \Arp\DateTime\DateFactory::diff
     *
     * @throws DateFactoryException
     */
    public function testDateTimeFactoryExceptionWillBeThrownIfDiffFails(): void
    {
        $factory = new DateFactory($this->dateTimeFactory, $this->dateIntervalFactory);

        $origin = new \DateTime();
        $target = new \DateTime();

        $exceptionCode = 123;
        $exceptionMessage = 'This is a test exception message';
        $exception = new DateIntervalFactoryException($exceptionMessage, $exceptionCode);

        $this->dateIntervalFactory->expects($this->once())
            ->method('diff')
            ->with($origin, $target, false)
            ->willThrowException($exception);

        $this->expectException(DateFactoryException::class);
        $this->expectExceptionMessage(sprintf('Failed to perform date diff: %s', $exceptionMessage));
        $this->expectExceptionCode($exceptionCode);

        $factory->diff($origin, $target);
    }

}
