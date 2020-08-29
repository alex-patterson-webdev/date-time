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
 * @covers  \Arp\DateTime\DateTimeFactory
 *
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
     * Assert that if the \DateTime instance cannot be created a DateTimeFactoryException will be thrown
     *
     * @throws DateFactoryException
     */
    public function testCreateDateTimeWillThrowDateFactoryExceptionIfNotAbleToCreateADateTime(): void
    {
        $dateTimeFactory = new class implements DateTimeFactoryInterface {
            public function createFromFormat(string $spec, string $format, $timeZone = null): \DateTimeInterface
            {
            }

            public function createDateTimeZone(string $spec): \DateTimeZone
            {
            }

            public function createDateTime(string $spec = null, $timeZone = null): \DateTimeInterface
            {
                throw new DateTimeFactoryException(
                    sprintf(
                        'Failed to create a valid \DateTime instance using \'%s\': %s',
                        $spec,
                        $timeZone
                    )
                );
            }
        };

        $factory = new DateFactory($dateTimeFactory, $this->dateIntervalFactory);

        $spec = 'foo';
        $timeZone = null;

        $this->expectException(DateFactoryException::class);
        $this->expectExceptionMessage(
            sprintf('Failed to create a valid \DateTime instance using \'%s\'', $spec)
        );

        $factory->createDateTime($spec, $timeZone);
    }

    /**
     * Ensure that calls to createDateTime() will return the valid configured \DateTime instance.
     *
     * @param string|null               $spec     The date and time specification.
     * @param \DateTimeZone|string|null $timeZone The optional date time zone to test.
     *
     * @dataProvider getCreateDateTimeData
     *
     * @throws DateFactoryException
     */
    public function testCreateDateTime(?string $spec, $timeZone = null): void
    {
        $factory = new DateFactory($this->dateTimeFactory, $this->dateIntervalFactory);

        $expectedDateTime = new \DateTime(
            $spec ?? 'now',
            is_string($timeZone) ? new \DateTimeZone($timeZone) : $timeZone
        );

        $this->dateTimeFactory->expects($this->once())
            ->method('createDateTime')
            ->with($spec, $timeZone)
            ->willReturn($expectedDateTime);

        $dateTime = $factory->createDateTime($spec, $timeZone);

        $this->assertSame($expectedDateTime, $dateTime);
    }

    /**
     * @return array
     */
    public function getCreateDateTimeData(): array
    {
        return [
            [
                null,
            ],
            [
                'now',
            ],
            [
                'now',
                'Europe/London'
            ],
            [
                '2019-05-14 12:33:00',
            ],
            [
                '2019-08-14 17:34:55',
                'UTC',
            ],
            [
                '2020-08-22 14:43:12',
                null,
            ],
            [
                '2020-08-22 14:44:37',
                new \DateTimeZone('Europe/London'),
            ],
            [
                '2000-01-01',
                'Pacific/Nauru'
            ],
            [
                'now',
                new \DateTimeZone('America/New_York')
            ],
        ];
    }

    /**
     * Assert that if the \DateTime instance cannot be created a DateTimeFactoryException will be thrown
     *
     * @param string                    $spec
     * @param string                    $format
     * @param null|string|\DateTimeZone $timeZone
     *
     * @dataProvider getCreateFromFormatWillThrowDateFactoryExceptionIfNotAbleToCreateADateTimeData
     *
     * @throws DateFactoryException
     */
    public function testCreateFromFormatWillThrowDateFactoryExceptionIfNotAbleToCreateADateTime(
        string $spec,
        string $format,
        $timeZone = null
    ): void {
        $dateTimeFactory = new class implements DateTimeFactoryInterface {
            public function createFromFormat(string $spec, string $format, $timeZone = null): \DateTimeInterface
            {
                throw new DateTimeFactoryException(
                    sprintf(
                        'Failed to create a valid \DateTime instance using \'%s\' and format \'%s\'',
                        $spec,
                        $format
                    )
                );
            }

            public function createDateTimeZone(string $spec): \DateTimeZone
            {
            }

            public function createDateTime(string $spec = null, $timeZone = null): \DateTimeInterface
            {
            }
        };

        $factory = new DateFactory($dateTimeFactory, $this->dateIntervalFactory);

        $this->expectException(DateFactoryException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Failed to create a valid \DateTime instance using \'%s\' and format \'%s\'',
                $spec,
                $format
            )
        );

        $factory->createFromFormat($spec, $format, $timeZone);
    }

    /**
     * @return array
     */
    public function getCreateFromFormatWillThrowDateFactoryExceptionIfNotAbleToCreateADateTimeData(): array
    {
        return [
            [
                'foo',
                'xyz',
            ],
        ];
    }

    /**
     * Assert that calls to creatDateInterval() will return the expected DateInterval instance
     *
     * @param string $spec
     *
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
     * Assert that an invalid $spec passed to createDateInterval() will raise a DateTimeFactoryException
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
     * Assert that the calls to diff will return a valid DateInterval
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
     * Assert that a DateTimeFactoryException is thrown when unable to diff the provided dates
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
