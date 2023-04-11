<?php

declare(strict_types=1);

namespace ArpTest\DateTime;

use Arp\DateTime\DateTimeFactoryInterface;
use Arp\DateTime\DateTimeImmutableFactory;
use Arp\DateTime\Exception\DateTimeFactoryException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Arp\DateTime\DateTimeImmutableFactory
 */
final class DateTimeImmutableFactoryTest extends TestCase
{
    /**
     * Assert the class implements DateTimeFactoryInterface
     */
    public function testImplementsDateTimeFactoryInterface(): void
    {
        $factory = new DateTimeImmutableFactory();

        $this->assertInstanceOf(DateTimeFactoryInterface::class, $factory);
    }

    /**
     * Assert that an exception will be thrown if the provided $dateTimeClassName option is a class that does not
     * implement \DateTimeInterface
     */
    public function testCreateDateTimeWillThrowDateTimeFactoryExceptionIfDateTimeClassNameIsNotDateTimeImmutable(): void
    {
        $this->expectException(DateTimeFactoryException::class);
        $this->expectExceptionMessage(
            sprintf(
                'The \'dateTimeClassName\' parameter must be a class name that implements \'%s\'',
                \DateTimeImmutable::class
            )
        );

        new DateTimeImmutableFactory(\DateTime::class);
    }

    /**
     * Assert that calls to createDateTime() will return a DateTimeImmutable instance, matching the
     * provided $spec and $timeZone
     *
     * @dataProvider getCreatDateTimeWillReturnDateTimeImmutableData
     *
     * @throws DateTimeFactoryException
     * @throws \Exception
     */
    public function testCreatDateTimeWillReturnDateTimeImmutable(
        ?string $spec,
        string|\DateTimeZone|null $timeZone = null
    ): void {
        $factory = new DateTimeImmutableFactory();

        $immutableDateTime = $factory->createDateTime($spec, $timeZone);

        $this->assertInstanceOf(\DateTimeImmutable::class, $immutableDateTime);
    }

    /**
     * @return array<mixed>
     */
    public function getCreatDateTimeWillReturnDateTimeImmutableData(): array
    {
        return [
            [
                null,
            ],
            [
                'now',
                'UTC',
            ],
            [
                '2021-05-01',
            ],
        ];
    }

    /**
     * @dataProvider getCreatFromFormatWillReturnDateTimeImmutableData
     *
     * @throws DateTimeFactoryException
     */
    public function testCreatFromFormatWillReturnDateTimeImmutable(
        string $format,
        string $spec,
        string|\DateTimeZone|null $timeZone = null
    ): void {
        $factory = new DateTimeImmutableFactory();

        $this->assertInstanceOf(\DateTimeImmutable::class, $factory->createFromFormat($format, $spec, $timeZone));
    }

    /**
     * @return array<mixed>
     */
    public function getCreatFromFormatWillReturnDateTimeImmutableData(): array
    {
        return [
            [
                'Y/m/d H:i:s',
                '2021/05/03 14:36:47',
            ],
            [
                'Y-d-m H:i:s',
                '1999-01-12 11:06:01',
                'UTC',
            ],
        ];
    }
}
