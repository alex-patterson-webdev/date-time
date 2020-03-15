<?php

declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateIntervalFactoryException;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime
 */
interface DateIntervalFactoryInterface
{
    /**
     * Create a new DateInterval instance using the provided $spec.
     *
     * @param string $spec The specification of the interval.
     *
     * @return \DateInterval
     *
     * @throws DateIntervalFactoryException  If the date interval cannot be created.
     */
    public function createDateInterval(string $spec): \DateInterval;
}
