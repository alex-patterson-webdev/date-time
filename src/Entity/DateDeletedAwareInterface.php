<?php declare(strict_types=1);

namespace Arp\DateTime\Entity;

/**
 * DateDeletedAwareInterface
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Entity
 */
interface DateDeletedAwareInterface
{
    /**
     * hasDateDeleted
     *
     * Check if the deleted date has been set.
     *
     * @return boolean
     */
    public function hasDateDeleted() : bool ;

    /**
     * getDateDeleted
     *
     * Return the deleted date.
     *
     * @return \DateTime|null
     */
    public function getDateDeleted() : ?\DateTime ;

    /**
     * setDateDeleted
     *
     * Set the deleted date.
     *
     * @param \DateTime|null $dateTime
     */
    public function setDateDeleted(\DateTime $dateTime = null);

}