<?php declare(strict_types=1);

namespace Arp\DateTime\Entity;

/**
 * DateCreatedAwareInterface
 *
 * Interface for a class that manages a created DateTime instance.
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Entity
 */
interface DateCreatedAwareInterface
{
    /**
     * hasDateCreated
     *
     * Check if the created date has been defined.
     *
     * @return boolean
     */
    public function hasDateCreated() : bool;

    /**
     * getDateCreated
     *
     * Return the created date.
     *
     * @return \DateTime|null
     */
    public function getDateCreated() :?\DateTime;

    /**
     * setDateCreated
     *
     * Set the created date.
     *
     * @param \DateTime|null $dateCreated
     */
    public function setDateCreated(\DateTime $dateCreated = null);

}