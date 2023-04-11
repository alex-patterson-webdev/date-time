<?php

declare(strict_types=1);

namespace ArpTest\DateTime;

use Arp\DateTime\DateTimeZoneFactory;
use Arp\DateTime\DateTimeZoneFactoryInterface;
use Arp\DateTime\Exception\DateTimeZoneFactoryException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Arp\DateTime\DateTimeZoneFactory
 */
final class DateTimeZoneFactoryTest extends TestCase
{
    /**
     * Assert the factory implement DateTimeZoneFactoryInterface
     */
    public function testImplementsDateTimeZoneFactoryInterface(): void
    {
        $factory = new DateTimeZoneFactory();

        $this->assertInstanceOf(DateTimeZoneFactoryInterface::class, $factory);
    }

    /**
     * Assert that a DateTimeZoneFactoryException is thrown if trying to create the class without a valid
     * $dateTimeZoneClassName constructor argument
     *
     * @throws DateTimeZoneFactoryException
     */
    public function testDateTimeZoneFactoryExceptionIsThrownWhenProvidingInvalidDateTimeZoneClassName(): void
    {
        $dateTimeZoneClassName = \stdClass::class;

        $this->expectException(DateTimeZoneFactoryException::class);
        $this->expectExceptionMessage(
            sprintf(
                'The \'dateTimeZoneClassName\' parameter must be a class name that implements \'%s\'',
                \DateTimeZone::class
            )
        );

        new DateTimeZoneFactory($dateTimeZoneClassName);
    }

    /**
     * Assert that if providing an invalid $spec to createDateTimeZone() a DateTimeZoneFactoryException is thrown
     *
     * @dataProvider getCreateDateTimeZoneWillThrowDateTimeZoneFactoryExceptionIfSpecIsInvalidData
     *
     * @throws DateTimeZoneFactoryException
     */
    public function testCreateDateTimeZoneWillThrowDateTimeZoneFactoryExceptionIfSpecIsInvalid(string $spec): void
    {
        $factory = new DateTimeZoneFactory();

        $exceptionCode = 123;
        try {
            new \DateTimeZone($spec);
        } catch (\Exception $e) {
            $exceptionCode = $e->getCode();
        }

        $this->expectException(DateTimeZoneFactoryException::class);
        $this->expectExceptionCode($exceptionCode);
        $this->expectExceptionMessage(
            sprintf('Failed to create a valid \DateTimeZone instance using \'%s\'', $spec)
        );

        $factory->createDateTimeZone($spec);
    }

    /**
     * @return array<int, mixed>
     */
    public function getCreateDateTimeZoneWillThrowDateTimeZoneFactoryExceptionIfSpecIsInvalidData(): array
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
     * Ensure a \DateTimeZone instance is returned according to the provided $spec
     *
     * @dataProvider getCreateDateTimeZoneData
     *
     * @throws DateTimeZoneFactoryException
     */
    public function testCreateDateTimeZone(string $spec): void
    {
        $factory = new DateTimeZoneFactory();

        $dateTimeZone = $factory->createDateTimeZone($spec);

        $this->assertSame($spec, $dateTimeZone->getName());
    }

    /**
     * @see https://www.php.net/manual/en/timezones.europe.php
     *
     * @return array<int, mixed>
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
}
