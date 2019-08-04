<?php

namespace Arp\DateTime\Entity;

/**
 * DateCreatedAwareTrait
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Entity
 */
trait DateCreatedAwareTrait
{
    /**
     * $dateCreated
     *
     * @var \DateTime|null
     */
    protected $dateCreated;

    /**
     * hasDateCreated
     *
     * @return boolean
     */
    public function hasDateCreated()
    {
        return isset($this->dateCreated);
    }

    /**
     * getDateCreated
     *
     * @return \DateTime|null
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * setDateCreated
     *
     * @param \DateTime|null $dateCreated
     */
    public function setDateCreated(\DateTime $dateCreated = null)
    {
        $this->dateCreated = $dateCreated;
    }
}