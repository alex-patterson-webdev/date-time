<?php

namespace Arp\DateTime\Service;

/**
 * DateTimeFactory
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Service
 */
class DateTimeFactory implements DateTimeFactoryInterface
{
    /**
     * createDateTime
     *
     * @param null|string $spec    The optional date and time specification.
     * @param array       $options The date and time options.
     *
     * @return \DateTime|boolean
     */
    public function createDateTime($spec = null, array $options = [])
    {
        $timeZone = isset($options['time_zone']) ? $options['time_zone'] : null;

        return new \DateTime($spec, $timeZone);
    }

    /**
     * createFromFormat
     *
     * @param string $spec    The date and time specification.
     * @param string $format  The date and time format.
     * @param array  $options The date and time options.
     *
     * @return \DateTime|boolean
     */
    public function createFromFormat($spec, $format, array $options = [])
    {
        $timeZone = isset($options['time_zone']) ? $options['time_zone'] : null;

        if (! empty($timeZone) && is_string($timeZone)) {
            $timeZone = $this->createDateTimeZone($timeZone);
        }

        return \DateTime::createFromFormat($format, $spec, $timeZone);
    }

    /**
     * createDateTimeZone
     *
     * Create a new \DateTimeZone instance using the provided specification.
     *
     * @param string $spec     The date time zone specification.
     * @param array  $options  The optional creation options.
     *
     * @return \DateTimeZone
     */
    public function createDateTimeZone($spec, array $options = [])
    {
        return new \DateTimeZone($spec);
    }

}