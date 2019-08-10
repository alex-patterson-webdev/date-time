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
     * @return boolean
     */
    public function hasDateDeleted();

    /**
     * getDateDeleted
     *
     * @return \DateTime|null
     */
    public function getDateDeleted();

    /**
     * setDateDeleted
     *
     * @param \DateTime|null $dateTime
     */
    public function setDateDeleted(\DateTime $dateTime = null);
}