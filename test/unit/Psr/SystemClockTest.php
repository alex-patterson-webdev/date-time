<?php

declare(strict_types=1);

namespace ArpTest\DateTime\Psr;

use Arp\DateTime\DateTimeImmutableFactory;
use Arp\DateTime\Psr\SystemClock;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Clock\ClockInterface;

/**
 * @covers \Arp\DateTime\Psr\SystemClock
 */
final class SystemClockTest extends TestCase
{
    /**
     * @var DateTimeImmutableFactory&MockObject
     */
    private DateTimeImmutableFactory $factory;

    public function setUp(): void
    {
        $this->factory = $this->createMock(DateTimeImmutableFactory::class);
    }

    public function testImplementsClockInterface(): void
    {
        $this->assertInstanceOf(ClockInterface::class, new SystemClock($this->factory));
    }

    /**
     * @throws \Exception
     */
    public function testNow(): void
    {
        $clock = new SystemClock($this->factory);

        $systemTimeZone = date_default_timezone_get();
        $dateTimeImmutable = new \DateTimeImmutable('now', new \DateTimeZone($systemTimeZone));

        $this->factory->expects($this->once())
            ->method('createDateTime')
            ->with('now', $systemTimeZone)
            ->willReturn($dateTimeImmutable);

        $this->assertSame($dateTimeImmutable, $clock->now());
    }
}
