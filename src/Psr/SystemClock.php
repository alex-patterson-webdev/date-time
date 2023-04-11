<?php

declare(strict_types=1);

namespace Arp\DateTime\Psr;

use Arp\DateTime\DateTimeImmutableFactory;
use Psr\Clock\ClockInterface;

final class SystemClock implements ClockInterface
{
    private Clock $clock;

    public function __construct(DateTimeImmutableFactory $factory)
    {
        $this->clock = new Clock($factory, date_default_timezone_get());
    }

    /**
     * @throws \Exception
     */
    public function now(): \DateTimeImmutable
    {
        return $this->clock->now();
    }
}
