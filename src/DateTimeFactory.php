<?php

declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateTimeFactoryException;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime
 */
class DateTimeFactory implements DateTimeFactoryInterface
{
    /**
     * Create a new \DateTime instance using the provided $time.
     *
     * @param null|string               $time     The optional date and time specification
     * @param \DateTimeZone|string|null $timeZone The date timezone object or string
     *
     * @return \DateTime
     *
     * @throws DateTimeFactoryException  If the \DateTime instance cannot be created.
     */
    public function createDateTime(string $time = 'now', $timeZone = null): \DateTime
    {
        try {
            return new \DateTime($time, $this->resolveDateTimeZone($timeZone));
        } catch (\Throwable $e) {
            throw new DateTimeFactoryException(
                sprintf(
                    'Failed to create a valid \DateTime instance using time \'%s\' in \'%s\'.',
                    $time,
                    static::class
                )
            );
        }
    }

    /**
     * Create a new \DateTimeZone instance using the provided specification.
     *
     * @param string $timeZone The date time zone specification
     *
     * @return \DateTimeZone
     *
     * @throws DateTimeFactoryException If the \DateTimeZone cannot be created.
     */
    public function createDateTimeZone(string $timeZone): \DateTimeZone
    {
        try {
            return new \DateTimeZone($timeZone);
        } catch (\Throwable $e) {
            throw new DateTimeFactoryException(
                sprintf(
                    'Failed to create a valid \DateTimeZone instance using \'%s\' in \'%s\'.',
                    $timeZone,
                    static::class
                )
            );
        }
    }

    /**
     * Create a new \DateTime instance using the provided format.
     *
     * @param string                    $format   The date and time format
     * @param string                    $time     The date and time
     * @param \DateTimeZone|string|null $timeZone The date time zone.
     *
     * @return \DateTime
     *
     * @throws DateTimeFactoryException  If the \DateTime instance cannot be created.
     */
    public function createFromFormat(string $format, string $time, $timeZone = null): \DateTime
    {
        $dateTime = \DateTime::createFromFormat($format, $time, $this->resolveDateTimeZone($timeZone));

        if (empty($dateTime) || (! $dateTime instanceof \DateTime)) {
            throw new DateTimeFactoryException(
                sprintf(
                    'Failed to create a valid \DateTime instance using format \'%s\' for time \'%s\' in \'%s\'.',
                    $format,
                    $time,
                    static::class
                )
            );
        }

        return $dateTime;
    }

    /**
     * Resolve a date time zone from the provided $timeZone argument.
     *
     * @param string|\DateTimeZone|null $timeZone
     *
     * @return \DateTimeZone|null
     *
     * @throws DateTimeFactoryException
     */
    private function resolveDateTimeZone($timeZone): ?\DateTimeZone
    {
        if (is_string($timeZone) && ! empty($timeZone)) {
            $timeZone = $this->createDateTimeZone($timeZone);
        } elseif (empty($timeZone) || (! $timeZone instanceof \DateTimeZone)) {
            $timeZone = null;
        }

        return $timeZone;
    }
}
