<?php

declare(strict_types=1);

namespace Arp\DateTime\Entity;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Entity
 */
interface DateDeletedAwareInterface
{
    /**
     * Check if the deleted date has been set.
     *
     * @return bool
     */
    public function hasDateDeleted(): bool;

    /**
     * Return the deleted date.
     *
     * @return \DateTime|null
     */
    public function getDateDeleted(): ?\DateTimeInterface;

    /**
     * Set the deleted date.
     *
     * @param \DateTimeInterface|null $dateTime
     */
    public function setDateDeleted(?\DateTimeInterface $dateTime): void;
}
