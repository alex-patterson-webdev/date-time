<?php

namespace Arp\DateTime\Service;

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
     * @return \DateTime
     */
    public function getDateTime();

}