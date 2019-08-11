<?php

namespace Arp\DateTime\Service;

use Arp\DateTime\Exception\DateTimeFactoryException;

/**
 * DateTimeFactoryInterface
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Service
 */
interface DateTimeFactoryInterface
{
    /**
     * createDateTime
     *
     * Create a new \DateTime instance using the provided specification.
     *
     * @param null|string  $spec     The optional date and time specification.
     * @param array        $options  The date and time options.
     *
     * @return \DateTime
     *
     * @throws DateTimeFactoryException  If the \DateTime instance cannot be created.
     */
    public function createDateTime(string $spec = null, array $options = []) : \DateTime;

    /**
     * createFromFormat
     *
     * Create a new \DateTime instance using the provided format.
     *
     * @param string $spec    The date and time specification.
     * @param string $format  The date and time format.
     * @param array  $options The date and time options.
     *
     * @return \DateTime
     *
     * @throws DateTimeFactoryException  If the \DateTime instance cannot be created.
     */
    public function createFromFormat(string $spec, string $format, array $options = []) : \DateTime;

    /**
     * createDateTimeZone
     *
     * Create a new \DateTimeZone instance using the provided specification.
     *
     * @param string $spec     The date time zone specification.
     * @param array  $options  The optional creation options.
     *
     * @return \DateTimeZone
     *
     * @throws DateTimeFactoryException If the \DateTimeZone cannot be created.
     */
    public function createDateTimeZone(string $spec, array $options = []) : \DateTimeZone;
}