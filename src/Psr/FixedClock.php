<?php

declare(strict_types=1);

namespace Arp\DateTime\Psr;

use Psr\Clock\ClockInterface;

final class FixedClock implements ClockInterface
{
    public function __construct(private readonly \DateTimeImmutable $dateTimeImmutable)
    {
    }

    public function now(): \DateTimeImmutable
    {
        return $this->dateTimeImmutable;
    }
}
