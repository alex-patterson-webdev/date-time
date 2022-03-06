<?php

declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateTimeZoneFactoryException;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime
 */
final class DateTimeZoneFactory implements DateTimeZoneFactoryInterface
{
    /**
     * @var string
     */
    private string $dateTimeZoneClassName;

    /**
     * @param string|null $dateTimeZoneClassName
     *
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
     * @param string $spec The date time zone specification
     *
     * @return \DateTimeZone
     *
     * @throws DateTimeZoneFactoryException If the \DateTimeZone cannot be created
     */
    public function createDateTimeZone(string $spec): \DateTimeZone
    {
        try {
            /** @var \DateTimeZone $dateTimeZone */
            /** @noinspection PhpUnnecessaryLocalVariableInspection */
            /** @noinspection OneTimeUseVariablesInspection */
            $dateTimeZone = new $this->dateTimeZoneClassName($spec);
            return $dateTimeZone;
        } catch (\Exception $e) {
            throw new DateTimeZoneFactoryException(
                sprintf(
                    'Failed to create a valid \DateTimeZone instance using \'%s\': %s',
                    $spec,
                    $e->getMessage()
                ),
                $e->getCode(),
                $e
            );
        }
    }
}
