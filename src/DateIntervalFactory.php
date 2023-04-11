<?php

declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateIntervalFactoryException;

final class DateIntervalFactory implements DateIntervalFactoryInterface
{
    /**
     * @throws DateIntervalFactoryException
     */
    public function createDateInterval(string $spec): \DateInterval
    {
        try {
            return new \DateInterval($spec);
        } catch (\Exception $e) {
            throw new DateIntervalFactoryException(
                sprintf('Failed to create a valid \DateInterval instance using \'%s\'', $spec),
                $e->getCode(),
                $e,
            );
        }
    }
}
