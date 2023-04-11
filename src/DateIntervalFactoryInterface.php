<?php

declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateIntervalFactoryException;

interface DateIntervalFactoryInterface
{
    /**
     * @throws DateIntervalFactoryException
     */
    public function createDateInterval(string $spec): \DateInterval;
}
