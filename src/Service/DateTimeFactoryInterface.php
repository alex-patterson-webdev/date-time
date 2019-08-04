<?php

namespace Arp\DateTime\Service;

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
     * @param null|string  $spec     The optional date and time specification.
     * @param array        $options  The date and time options.
     *
     * @return \DateTime|boolean
     */
    public function createDateTime($spec = null, array $options = []);

    /**
     * createFromFormat
     *
     * @param string $spec    The date and time specification.
     * @param string $format  The date and time format.
     * @param array  $options The date and time options.
     *
     * @return \DateTime|boolean
     */
    public function createFromFormat($spec, $format, array $options = []);

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
    public function createDateTimeZone($spec, array $options = []);
}