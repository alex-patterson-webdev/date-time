<?php

declare(strict_types=1);

namespace Arp\DateTime\Entity;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Entity
 */
trait DateCreatedAwareTrait
{
    /**
     * @var \DateTimeInterface|null
     */
    protected ?\DateTimeInterface $dateCreated;

    /**
     * Check if the created date has been defined.
     *
     * @return bool
     */
    public function hasDateCreated(): bool
    {
        return isset($this->dateCreated);
    }

    /**
     * Return the created date.
     *
     * @return \DateTimeInterface|null
     */
    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    /**
     * Set the created date.
     *
     * @param \DateTimeInterface|null $dateCreated
     */
    public function setDateCreated(?\DateTimeInterface $dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }
}
