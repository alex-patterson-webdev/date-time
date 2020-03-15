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
            throw new DateIntervalFactoryException(
                sprintf(
                    'Failed to create a valid \DateInterval instance using specification \'%s\' in \'%s\'.',
                    $spec,
                    static::class
                )
            );
        }
    }
}
