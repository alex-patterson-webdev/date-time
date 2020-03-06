<?php declare(strict_types=1);

namespace Arp\DateTime\Entity;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Entity
 */
trait DateUpdatedAwareTrait
{
    /**
     * @var \DateTime|null
     */
    protected $dateUpdated;

    /**
     * Check if the updated date has been set.
     *
     * @return boolean
     */
    public function hasDateUpdated() : bool
    {
        return isset($this->dateUpdated);
    }

    /**
     * Return the updated date.
     *
     * @return \DateTime|null
     */
    public function getDateUpdated() : ?\DateTime
    {
        return $this->dateUpdated;
    }

    /**
     * Set the updated date.
     *
     * @param \DateTime|null $dateTime
     */
    public function setDateUpdated(?\DateTime $dateTime) : void
    {
        $this->dateUpdated = $dateTime;
    }
}
