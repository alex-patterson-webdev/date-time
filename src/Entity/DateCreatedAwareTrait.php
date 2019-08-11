<?php declare(strict_types=1);

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
     * Check if the created date has been defined.
     *
     * @return boolean
     */
    public function hasDateCreated() : bool
    {
        return isset($this->dateCreated);
    }

    /**
     * getDateCreated
     *
     * Return the created date.
     *
     * @return \DateTime|null
     */
    public function getDateCreated() :?\DateTime
    {
        return $this->dateCreated;
    }

    /**
     * setDateCreated
     *
     * Set the created date.
     *
     * @param \DateTime|null $dateCreated
     */
    public function setDateCreated(\DateTime $dateCreated = null)
    {
        $this->dateCreated = $dateCreated;
    }
}