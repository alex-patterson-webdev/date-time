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
     * @return boolean
     */
    public function hasDateUpdated();

    /**
     * getDateUpdated
     *
     * @return \DateTime|null
     */
    public function getDateUpdated();

    /**
     * setDateUpdated
     *
     * @param \DateTime|null $dateUpdated
     */
    public function setDateUpdated(\DateTime $dateUpdated = null);

}