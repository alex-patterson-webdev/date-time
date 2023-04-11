<?php

declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateTimeZoneFactoryException;

final class DateTimeZoneFactory implements DateTimeZoneFactoryInterface
{
    /**
     * @var class-string<\DateTimeZone>
     */
    private string $dateTimeZoneClassName;

    /**
     * @throws DateTimeZoneFactoryException
     */
    public function __construct(string $dateTimeZoneClassName = null)
    {
        $dateTimeZoneClassName ??= \DateTimeZone::class;
        if (!is_a($dateTimeZoneClassName, \DateTimeZone::class, true)) {
            throw new DateTimeZoneFactoryException(
                sprintf(
                    'The \'dateTimeZoneClassName\' parameter must be a class name that implements \'%s\'',
                    \DateTimeZone::class
                )
            );
        }
        $this->dateTimeZoneClassName = $dateTimeZoneClassName;
    }

    /**
     * @throws DateTimeZoneFactoryException
     */
    public function createDateTimeZone(string $spec): \DateTimeZone
    {
        try {
            /** @throws \Exception */
            return new $this->dateTimeZoneClassName($spec);
        } catch (\Exception $e) {
            throw new DateTimeZoneFactoryException(
                sprintf('Failed to create a valid \DateTimeZone instance using \'%s\'', $spec),
                $e->getCode(),
                $e
            );
        }
    }
}
