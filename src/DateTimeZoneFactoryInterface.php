<?php

declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateTimeZoneFactoryException;

interface DateTimeZoneFactoryInterface
{
    /**
     * @throws DateTimeZoneFactoryException
     */
    public function createDateTimeZone(string $spec): \DateTimeZone;
}
