<?php

declare(strict_types=1);

namespace Arp\DateTime\Entity;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Entity
 */
trait DateUpdatedAwareTrait
{
    /**
     * @var \DateTimeInterface|null
     */
    protected ?\DateTimeInterface $dateUpdated;

    /**
     * Check if the updated date has been set.
     *
     * @return bool
     */
    public function hasDateUpdated(): bool
    {
        return isset($this->dateUpdated);
    }

    /**
     * Return the updated date.
     *
     * @return \DateTimeInterface|null
     */
    public function getDateUpdated(): ?\DateTime
    {
        return $this->dateUpdated;
    }

    /**
     * Set the updated date.
     *
     * @param \DateTimeInterface|null $dateTime
     */
    public function setDateUpdated(?\DateTimeInterface $dateTime): void
    {
        $this->dateUpdated = $dateTime;
    }
}
