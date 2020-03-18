<?php

declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateTimeFactoryException;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime
 */
interface DateTimeFactoryInterface
{
    /**
     * Create a new \DateTime instance using the provided specification.
     *
     * @param null|string               $time     The optional date and time specification
     * @param \DateTimeZone|string|null $timeZone The date and time options
     *
     * @return \DateTime
     *
     * @throws DateTimeFactoryException  If the \DateTime instance cannot be created.
     */
    public function createDateTime(string $time = 'now', $timeZone = null): \DateTime;

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
    public function createFromFormat(string $format, string $time, $timeZone = null): \DateTime;

    /**
     * Create a new \DateTimeZone instance using the provided specification.
     *
     * @param string $timeZone The date time zone specification
     *
     * @return \DateTimeZone
     *
     * @throws DateTimeFactoryException If the \DateTimeZone cannot be created.
     */
    public function createDateTimeZone(string $timeZone): \DateTimeZone;
}
