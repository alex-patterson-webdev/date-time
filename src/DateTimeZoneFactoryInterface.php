<?php

declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateTimeZoneFactoryException;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime
 */
interface DateTimeZoneFactoryInterface
{
    /**
     * Create a new \DateTimeZone instance using the provided specification.
     *
     * @param string $spec The date time zone specification.
     *
     * @return \DateTimeZone
     *
     * @throws DateTimeZoneFactoryException If the \DateTimeZone cannot be created.
     */
    public function createDateTimeZone(string $spec): \DateTimeZone;
}
