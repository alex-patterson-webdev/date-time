<?php

declare(strict_types=1);

namespace ArpTest\DateTime\Psr;

use Arp\DateTime\Psr\FixedClock;
use PHPUnit\Framework\TestCase;
use Psr\Clock\ClockInterface;

/**
 * @covers \Arp\DateTime\Psr\FixedClock
 */
final class FixedClockTest extends TestCase
{
    public function testImplementsClockInterface(): void
    {
        $this->assertInstanceOf(ClockInterface::class, new FixedClock(new \DateTimeImmutable()));
    }

    public function testNow(): void
    {
        $dateTimeImmutable = new \DateTimeImmutable();

        $clock = new FixedClock($dateTimeImmutable);

        $this->assertSame($dateTimeImmutable, $clock->now());
    }
}
