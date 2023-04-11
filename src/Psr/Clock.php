<?php

declare(strict_types=1);

namespace Arp\DateTime\Psr;

use Arp\DateTime\DateTimeImmutableFactory;
use Psr\Clock\ClockInterface;

final class Clock implements ClockInterface
{
    public function __construct(
        private readonly DateTimeImmutableFactory $factory,
        private readonly string|\DateTimeZone|null $dateTimeZone = null,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function now(): \DateTimeImmutable
    {
        return $this->factory->createDateTime('now', $this->dateTimeZone);
    }
}
