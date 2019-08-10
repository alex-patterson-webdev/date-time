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
     * @return boolean
     */
    public function hasDateUpdated()
    {
        return isset($this->dateUpdated);
    }

    /**
     * getDateUpdated
     *
     * @return \DateTime|null
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * setDateUpdated
     *
     * @param \DateTime|null $dateUpdated
     */
    public function setDateUpdated(\DateTime $dateUpdated = null)
    {
        $this->dateUpdated = $dateUpdated;
    }
}