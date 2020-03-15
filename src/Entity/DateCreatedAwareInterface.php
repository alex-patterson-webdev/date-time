<?php

declare(strict_types=1);

namespace Arp\DateTime\Entity;

/**
 * Interface for a class that manages a created DateTime instance.
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Entity
 */
interface DateCreatedAwareInterface
{
    /**
     * Check if the created date has been defined.
     *
     * @return bool
     */
    public function hasDateCreated(): bool;

    /**
     * Return the created date.
     *
     * @return \DateTime|null
     */
    public function getDateCreated(): ?\DateTime;

    /**
     * Set the created date.
     *
     * @param \DateTime|null $dateCreated
     */
    public function setDateCreated(?\DateTime $dateCreated);
}
