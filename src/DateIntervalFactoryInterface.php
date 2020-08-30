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
     * Create a new DateInterval instance using the provided $spec
     *
     * @param string $spec The specification of the interval
     *
     * @return \DateInterval
     *
     * @throws DateIntervalFactoryException  If the date interval cannot be created
     */
    public function createDateInterval(string $spec): \DateInterval;

    /**
     * Perform a diff of two dates and return the \DateInterval
     *
     * @param \DateTimeInterface $origin   The origin date
     * @param \DateTimeInterface $target   The date to compare to
     * @param bool               $absolute If the interval is negative force it to be a positive value
     *
     * @return \DateInterval
     *
     * @throws DateIntervalFactoryException If the date diff cannot be performed
     */
    public function diff(\DateTimeInterface $origin, \DateTimeInterface $target, bool $absolute = false): \DateInterval;
}
