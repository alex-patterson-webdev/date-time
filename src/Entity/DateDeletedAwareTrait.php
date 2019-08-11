<?php declare(strict_types=1);

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
     * Check if the deleted date has been set.
     *
     * @return boolean
     */
    public function hasDateDeleted() : bool
    {
        return isset($this->dateDeleted);
    }

    /**
     * getDateDeleted
     *
     * Return the deleted date.
     *
     * @return \DateTime|null
     */
    public function getDateDeleted() : ?\DateTime
    {
        return $this->dateDeleted;
    }

    /**
     * setDateDeleted
     *
     * Set the deleted date.
     *
     * @param \DateTime|null $dateTime
     */
    public function setDateDeleted(\DateTime $dateTime = null)
    {
        $this->dateDeleted = $dateTime;
    }
}