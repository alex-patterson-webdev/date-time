<?php

declare(strict_types=1);

namespace Arp\DateTime\Entity;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Entity
 */
interface DateUpdatedAwareInterface
{
    /**
     * Check if the updated date has been set.
     *
     * @return bool
     */
    public function hasDateUpdated(): bool;

    /**
     * Return the updated date.
     *
     * @return \DateTimeInterface|null
     */
    public function getDateUpdated(): ?\DateTimeInterface;

    /**
     * Set the updated date.
     *
     * @param \DateTimeInterface|null $dateTime
     */
    public function setDateUpdated(?\DateTimeInterface $dateTime): void;
}
