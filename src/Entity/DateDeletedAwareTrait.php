<?php

declare(strict_types=1);

namespace Arp\DateTime\Entity;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Entity
 */
class DateDeletedAwareTrait
{
    /**
     * @var \DateTimeInterface|null
     */
    protected ?\DateTimeInterface $dateDeleted;

    /**
     * Check if the deleted date has been set.
     *
     * @return bool
     */
    public function hasDateDeleted(): bool
    {
        return isset($this->dateDeleted);
    }

    /**
     * Return the deleted date.
     *
     * @return \DateTimeInterface|null
     */
    public function getDateDeleted(): ?\DateTimeInterface
    {
        return $this->dateDeleted;
    }

    /**
     * Set the deleted date.
     *
     * @param \DateTimeInterface|null $dateTime
     */
    public function setDateDeleted(?\DateTimeInterface $dateTime): void
    {
        $this->dateDeleted = $dateTime;
    }
}
