<?php declare(strict_types=1);

namespace Arp\DateTime\Entity;

/**
 * DateUpdatedAwareInterface
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Entity
 */
interface DateUpdatedAwareInterface
{
    /**
     * hasDateUpdated
     *
     * Check if the updated date has been set.
     *
     * @return boolean
     */
    public function hasDateUpdated() : bool;

    /**
     * getDateUpdated
     *
     * Return the updated date.
     *
     * @return \DateTime|null
     */
    public function getDateUpdated() : ?\DateTime;

    /**
     * setDateUpdated
     *
     * Set the updated date.
     *
     * @param \DateTime|null $dateTime
     */
    public function setDateUpdated(\DateTime $dateTime = null);

}