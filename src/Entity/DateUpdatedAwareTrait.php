<?php declare(strict_types=1);

namespace Arp\DateTime\Entity;

/**
 * DateUpdatedAwareTrait
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Entity
 */
trait DateUpdatedAwareTrait
{
    /**
     * $dateUpdated
     *
     * @var \DateTime|null
     */
    protected $dateUpdated;

    /**
     * hasDateUpdated
     *
     * Check if the updated date has been set.
     *
     * @return boolean
     */
    public function hasDateUpdated() : bool
    {
        return isset($this->dateUpdated);
    }

    /**
     * getDateUpdated
     *
     * Return the updated date.
     *
     * @return \DateTime|null
     */
    public function getDateUpdated() : ?\DateTime
    {
        return $this->dateUpdated;
    }

    /**
     * setDateUpdated
     *
     * Set the updated date.
     *
     * @param \DateTime|null $dateTime
     */
    public function setDateUpdated(\DateTime $dateTime = null)
    {
        $this->dateUpdated = $dateTime;
    }
}