<?php

namespace Arp\DateTime\Entity;

/**
 * DateDeletedAwareTrait
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Entity
 */
class DateDeletedAwareTrait
{
    /**
     * $dateDeleted
     *
     * @var \DateTime|null
     */
    protected $dateDeleted;

    /**
     * hasDateDeleted
     *
     * @return boolean
     */
    public function hasDateDeleted()
    {
        return isset($this->dateDeleted);
    }

    /**
     * getDateDeleted
     *
     * @return \DateTime|null
     */
    public function getDateDeleted()
    {
        return $this->dateDeleted;
    }

    /**
     * setDateDeleted
     *
     * @param \DateTime|null $dateDeleted
     */
    public function setDateDeleted(\DateTime $dateDeleted = null)
    {
        $this->dateDeleted = $dateDeleted;
    }
}