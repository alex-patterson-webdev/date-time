<?php

namespace Arp\DateTime\Entity;

/**
 * DateCreatedAwareInterface
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Entity
 */
interface DateCreatedAwareInterface
{
    /**
     * hasDateCreated
     *
     * @return boolean
     */
    public function hasDateCreated();

    /**
     * getDateCreated
     *
     * @return \DateTime|null
     */
    public function getDateCreated();

    /**
     * setDateCreated
     *
     * @param \DateTime|null $dateCreated
     */
    public function setDateCreated(\DateTime $dateCreated = null);

}