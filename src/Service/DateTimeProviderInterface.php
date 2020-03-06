<?php declare(strict_types=1);

namespace Arp\DateTime\Service;

use Arp\DateTime\Exception\DateTimeProviderException;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Service
 */
interface DateTimeProviderInterface
{
    /**
     * Return a date and time instance.
     *
     * @return \DateTime
     *
     * @throws DateTimeProviderException  If the date and time cannot be returned.
     */
    public function getDateTime() : \DateTime;
}