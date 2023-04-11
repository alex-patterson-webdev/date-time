<?php

declare(strict_types=1);

namespace ArpTest\DateTime\Psr;

use Arp\DateTime\DateTimeImmutableFactory;
use Arp\DateTime\Psr\Clock;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Clock\ClockInterface;

/**
 * @covers \Arp\DateTime\Psr\Clock
 */
final class ClockTest extends TestCase
{
    /**
     * @var DateTimeImmutableFactory&MockObject
     */
    private DateTimeImmutableFactory $dateTimeImmutableFactory;

    public function setUp(): void
    {
        $this->dateTimeImmutableFactory = $this->createMock(DateTimeImmutableFactory::class);
    }

    public function testImplementsClockInterface(): void
    {
        $this->assertInstanceOf(ClockInterface::class, new Clock($this->dateTimeImmutableFactory));
    }

    /**
     * @dataProvider getNowData
     *
     * @throws \Exception
     */
    public function testNow(string|\DateTimeZone|null $timeZone): void
    {
        $clock = new Clock($this->dateTimeImmutableFactory, $timeZone);

        $dateTimeImmutable = new \DateTimeImmutable(
            'now',
            is_string($timeZone) ? new \DateTimeZone($timeZone) : $timeZone
        );

        $this->dateTimeImmutableFactory->expects($this->once())
            ->method('createDateTime')
            ->with('now', $timeZone)
            ->willReturn($dateTimeImmutable);

        $this->assertSame($dateTimeImmutable, $clock->now());
    }

    /**
     * @return array<int, array<mixed>>
     */
    public function getNowData(): array
    {
        return [
            [null],
            ['UTC'],
            ['Europe/London'],
            ['Europe/Rome'],
            ['America/New_York'],
            ['America/Los_Angeles'],
            [new \DateTimeZone('UTC')],
            [new \DateTimeZone('Europe/London')],
            [new \DateTimeZone('America/Los_Angeles')],
            [new \DateTimeZone('Europe/Paris')],
        ];
    }
}
