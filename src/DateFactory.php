<?php

declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateFactoryException;
use Arp\DateTime\Exception\DateIntervalFactoryException;
use Arp\DateTime\Exception\DateTimeFactoryException;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime
 */
final class DateFactory implements DateFactoryInterface
{
    /**
     * @var DateTimeFactoryInterface
     */
    private DateTimeFactoryInterface $dateTimeFactory;

    /**
     * @var DateIntervalFactoryInterface
     */
    private DateIntervalFactoryInterface $dateIntervalFactory;

    /**
     * @param DateTimeFactoryInterface          $dateTimeFactory
     * @param DateIntervalFactoryInterface|null $dateIntervalFactory
     */
    public function __construct(
        DateTimeFactoryInterface $dateTimeFactory,
        DateIntervalFactoryInterface $dateIntervalFactory = null
    ) {
        $this->dateTimeFactory = $dateTimeFactory ?? new DateTimeFactory();
        $this->dateIntervalFactory = $dateIntervalFactory ?? new DateIntervalFactory();
    }

    /**
     * @param string|null $spec
     * @param null        $timeZone
     *
     * @return \DateTimeInterface
     *
     * @throws DateFactoryException
     */
    public function createDateTime(string $spec = null, $timeZone = null): \DateTimeInterface
    {
        try {
            return $this->dateTimeFactory->createDateTime($spec, $timeZone);
        } catch (DateTimeFactoryException $e) {
            throw new DateFactoryException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param string $spec
     * @param string $format
     * @param null   $timeZone
     *
     * @return \DateTimeInterface
     *
     * @throws DateFactoryException
     */
    public function createFromFormat(string $spec, string $format, $timeZone = null): \DateTimeInterface
    {
        try {
            return $this->dateTimeFactory->createFromFormat($spec, $format, $timeZone);
        } catch (DateTimeFactoryException $e) {
            throw new DateFactoryException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param string $spec
     *
     * @return \DateTimeZone
     *
     * @throws DateFactoryException
     */
    public function createDateTimeZone(string $spec): \DateTimeZone
    {
        try {
            return $this->dateTimeFactory->createDateTimeZone($spec);
        } catch (DateTimeFactoryException $e) {
            throw new DateFactoryException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param string $spec
     *
     * @return \DateInterval
     *
     * @throws DateFactoryException
     */
    public function createDateInterval(string $spec): \DateInterval
    {
        try {
            return $this->dateIntervalFactory->createDateInterval($spec);
        } catch (DateIntervalFactoryException $e) {
            throw new DateFactoryException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Perform a diff of two dates and return the \DateInterval
     *
     * @param \DateTimeInterface $origin   The origin date
     * @param \DateTimeInterface $target   The date to compare to
     * @param bool               $absolute If the interval is negative, should it be forced to be a positive value?
     *
     * @return \DateInterval
     *
     * @throws DateFactoryException If the date diff cannot be performed
     */
    public function diff(\DateTimeInterface $origin, \DateTimeInterface $target, bool $absolute = false): \DateInterval
    {
        try {
            return $this->dateIntervalFactory->diff($origin, $target, $absolute);
        } catch (DateIntervalFactoryException $e) {
            throw new DateFactoryException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
