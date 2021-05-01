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
 * @covers  \Arp\DateTime\DateFactory
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\DateTime
 */
final class DateFactoryTest extends TestCase
{
    /**
     * @var DateTimeFactoryInterface&MockObject
     */
    private $dateTimeFactory;

    /**
     * @var DateIntervalFactoryInterface&MockObject
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
     * Ensure that the factory implements DateFactoryInterface
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
        $spec = 'foo';
        $timeZone = null;
        $exceptionMessage = sprintf('Failed to create a valid \DateTime instance using \'%s\'', $spec);

        $dateTimeFactory = $this->createMockForCreateDateTime($exceptionMessage);

        $factory = new DateFactory($dateTimeFactory, $this->dateIntervalFactory);

        $this->expectException(DateFactoryException::class);
        $this->expectExceptionMessage($exceptionMessage);

        $factory->createDateTime($spec, $timeZone);
    }

    /**
     * Ensure that calls to createDateTime() will return the valid configured \DateTime instance
     *
     * @param string|null               $spec     The date and time specification
     * @param \DateTimeZone|string|null $timeZone The optional date time zone to test
     *
     * @dataProvider getCreateDateTimeData
     *
     * @throws DateFactoryException
     * @throws \Exception
     */
    public function testCreateDateTime(?string $spec, $timeZone = null): void
    {
        $factory = new DateFactory($this->dateTimeFactory, $this->dateIntervalFactory);

        /** @var \DateTimeInterface $expectedDateTime */
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
     * @return array[]
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
                'Europe/London',
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
                'Pacific/Nauru',
            ],
            [
                'now',
                new \DateTimeZone('America/New_York'),
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
        $exceptionMessage = sprintf(
            'Failed to create a valid \DateTime instance using \'%s\' and format \'%s\'',
            $spec,
            $format
        );

        // Note that DateTimeInterface cannot be mocked by PHPUnit, so we can manually create a stub
        $dateTimeFactory = $this->createMockForCreateFromFormat($exceptionMessage);

        $factory = new DateFactory($dateTimeFactory, $this->dateIntervalFactory);

        $this->expectException(DateFactoryException::class);
        $this->expectExceptionMessage($exceptionMessage);

        $factory->createFromFormat($spec, $format, $timeZone);
    }

    /**
     * @return array[]
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
     * Assert that if providing an invalid $spec to createDateTimeZone() a DateFactoryException is thrown
     *
     * @param string $spec
     *
     * @dataProvider getCreateDateTimeZoneWillThrowDateFactoryExceptionIfSpecIsInvalidData
     *
     * @throws DateFactoryException
     */
    public function testCreateDateTimeZoneWillThrowDateFactoryExceptionIfSpecIsInvalid(string $spec): void
    {
        $factory = new DateFactory($this->dateTimeFactory, $this->dateIntervalFactory);

        $exceptionCode = 456;
        $exceptionMessage = 'This is a test exception message';
        $exception = new DateTimeFactoryException($exceptionMessage, $exceptionCode);

        $this->dateTimeFactory->expects($this->once())
            ->method('createDateTimeZone')
            ->with($spec)
            ->willThrowException($exception);

        $this->expectException(DateFactoryException::class);
        $this->expectExceptionMessage($exceptionMessage);
        $this->expectExceptionCode($exceptionCode);

        $factory->createDateTimeZone($spec);
    }

    /**
     * @return array[]
     */
    public function getCreateDateTimeZoneWillThrowDateFactoryExceptionIfSpecIsInvalidData(): array
    {
        return [
            [
                'foo',
            ],
            [
                '123',
            ],
        ];
    }

    /**
     * @param string $spec
     *
     * @dataProvider getCreateDateTimeZoneData
     *
     * @throws DateFactoryException
     */
    public function testCreateDateTimeZone(string $spec): void
    {
        $factory = new DateFactory($this->dateTimeFactory, $this->dateIntervalFactory);

        $dateTimeZone = new \DateTimeZone($spec);

        $this->dateTimeFactory->expects($this->once())
            ->method('createDateTimeZone')
            ->with($spec)
            ->willReturn($dateTimeZone);

        $this->assertSame($dateTimeZone, $factory->createDateTimeZone($spec));
    }

    /**
     * @return array[]
     */
    public function getCreateDateTimeZoneData(): array
    {
        return [
            [
                'UTC',
            ],
            [
                'Europe/London',
            ],
            [
                'Europe/Amsterdam',
            ],
            [
                'Europe/Rome',
            ],
            [
                'Atlantic/Bermuda',
            ],
            [
                'Atlantic/Azores',
            ],
            [
                'Antarctica/DumontDUrville',
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
     * @return array[]
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

        $this->expectDeprecationMessage(DateTimeFactoryException::class);
        $this->expectExceptionMessage($exceptionMessage);
        $this->expectExceptionCode($exceptionCode);

        $factory->createDateInterval($spec);
    }

    /**
     * Assert that the calls to diff will return a valid DateInterval
     *
     * @param \DateTime $origin
     * @param \DateTime $target
     * @param bool      $absolute
     *
     * @dataProvider getDiffWillReturnDateIntervalData
     *
     * @throws DateFactoryException
     */
    public function testDiffWillReturnDateInterval(\DateTime $origin, \DateTime $target, bool $absolute = false): void
    {
        $dateInterval = $origin->diff($target);

        $factory = new DateFactory($this->dateTimeFactory, $this->dateIntervalFactory);

        $this->dateIntervalFactory->expects($this->once())
            ->method('diff')
            ->with($origin, $target, $absolute)
            ->willReturn($dateInterval);

        $this->assertSame($dateInterval, $factory->diff($origin, $target, $absolute));
    }

    /**
     * @return array[]
     */
    public function getDiffWillReturnDateIntervalData(): array
    {
        return [
            [
                new \DateTime('1984-01-01'),
                new \DateTime('2020-01-01'),
            ],
            [
                new \DateTime('2017-08-12'),
                new \DateTime('2019-01-19'),
                true,
            ],
            [
                new \DateTime('2020-01-01 13:33:47'),
                new \DateTime('2020-08-30 01:25:33'),
                false,
            ],
        ];
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
        $this->expectExceptionMessage($exceptionMessage);
        $this->expectExceptionCode($exceptionCode);

        $factory->diff($origin, $target);
    }

    /**
     * @param string $exceptionMessage
     *
     * @return DateTimeFactoryInterface
     */
    private function createMockForCreateDateTime(string $exceptionMessage): DateTimeFactoryInterface
    {
        return new class ($exceptionMessage) implements DateTimeFactoryInterface {
            private string $exceptionMessage;

            public function __construct(string $exceptionMessage)
            {
                $this->exceptionMessage = $exceptionMessage;
            }

            public function createFromFormat(string $spec, string $format, $timeZone = null): \DateTimeInterface
            {
                /** @phpstan-ignore-next-line */
                return \DateTime::createFromFormat($spec, $format);
            }

            public function createDateTimeZone(string $spec): \DateTimeZone
            {
                return new \DateTimeZone($spec);
            }

            public function createDateTime(string $spec = null, $timeZone = null): \DateTimeInterface
            {
                throw new DateTimeFactoryException($this->exceptionMessage);
            }
        };
    }

    /**
     * @param string $exceptionMessage
     *
     * @return DateTimeFactoryInterface
     */
    private function createMockForCreateFromFormat(string $exceptionMessage): DateTimeFactoryInterface
    {
        return new class ($exceptionMessage) implements DateTimeFactoryInterface {
            private string $exceptionMessage;

            public function __construct(string $exceptionMessage)
            {
                $this->exceptionMessage = $exceptionMessage;
            }

            public function createFromFormat(string $spec, string $format, $timeZone = null): \DateTimeInterface
            {
                throw new DateTimeFactoryException($this->exceptionMessage);
            }

            public function createDateTimeZone(string $spec): \DateTimeZone
            {
                return new \DateTimeZone($spec);
            }

            public function createDateTime(string $spec = null, $timeZone = null): \DateTimeInterface
            {
                /** @phpstan-ignore-next-line */
                return new \DateTime($spec, $timeZone);
            }
        };
    }
}
