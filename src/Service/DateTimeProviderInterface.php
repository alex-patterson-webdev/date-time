<?php

namespace Arp\DateTime\Service;

use Arp\DateTime\Exception\DateTimeProviderException;

/**
 * DateTimeProviderInterface
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Service
 */
interface DateTimeProviderInterface
{
    /**
     * getDateTime
     *
     * Return a date and time instance.
     *
     * @return \DateTime
     *
     * @throws DateTimeProviderException  If the date and time cannot be returned.
     */
    public function getDateTime() : \DateTime;

}