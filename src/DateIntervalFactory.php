<?php

declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateIntervalFactoryException;

/**
 * Factory class used as a service to create \DateInterval instances.
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime
 */
class DateIntervalFactory implements DateIntervalFactoryInterface
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
    public function createDateInterval(string $spec): \DateInterval
    {
        try {
            return new \DateInterval($spec);
        } catch (\Throwable $e) {
            $exceptionMessage = sprintf(
                'Failed to create a valid \DateInterval instance using \'%s\': %s',
                $spec,
                $e->getMessage()
            );
            throw new DateIntervalFactoryException($exceptionMessage, $e->getCode(), $e);
        }
    }

    /**
     * Perform a diff of two dates and return the \DateInterval
     *
     * @param \DateTimeInterface $origin    The origin date
     * @param \DateTimeInterface $target    The date to compare to
     * @param bool               $absolute  If the interval is negative, should it be forced to be a positive value?
     *
     * @return \DateInterval
     *
     * @throws DateIntervalFactoryException If the date diff cannot be performed
     */
    public function diff(\DateTimeInterface $origin, \DateTimeInterface $target, bool $absolute = false): \DateInterval
    {
        $dateInterval = $origin->diff($target, $absolute);

        if (false === $dateInterval || !$dateInterval instanceof \DateInterval) {
            throw new DateIntervalFactoryException('Failed to create valid \DateInterval while performing date diff');
        }

        return $dateInterval;
    }
}
