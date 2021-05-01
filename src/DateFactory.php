<?php

declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateIntervalFactoryException;
use Arp\DateTime\Exception\DateTimeFactoryException;
use Arp\DateTime\Exception\DateTimeZoneFactoryException;

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
     * @var DateTimeZoneFactoryInterface
     */
    private DateTimeZoneFactoryInterface $dateTimeZoneFactory;

    /**
     * @var DateIntervalFactoryInterface
     */
    private DateIntervalFactoryInterface $dateIntervalFactory;

    /**
     * @param DateTimeFactoryInterface|null     $dateTimeFactory
     * @param DateTimeZoneFactoryInterface|null $dateTimeZoneFactory
     * @param DateIntervalFactoryInterface|null $dateIntervalFactory
     *
     * @throws DateTimeFactoryException
     */
    public function __construct(
        ?DateTimeFactoryInterface $dateTimeFactory = null,
        ?DateTimeZoneFactoryInterface $dateTimeZoneFactory = null,
        ?DateIntervalFactoryInterface $dateIntervalFactory = null
    ) {
        $this->dateTimeZoneFactory = $dateTimeZoneFactory ?? new DateTimeZoneFactory();
        $this->dateTimeFactory = $dateTimeFactory ?? new DateTimeFactory($this->dateTimeZoneFactory);
        $this->dateIntervalFactory = $dateIntervalFactory ?? new DateIntervalFactory();
    }

    /**
     * @param null|string               $spec
     * @param string|\DateTimeZone|null $timeZone
     *
     * @return \DateTimeInterface
     *
     * @throws DateTimeFactoryException
     */
    public function createDateTime(?string $spec = null, $timeZone = null): \DateTimeInterface
    {
        return $this->dateTimeFactory->createDateTime($spec, $timeZone);
    }

    /**
     * @param string                    $spec
     * @param string                    $format
     * @param string|\DateTimeZone|null $timeZone
     *
     * @return \DateTimeInterface
     *
     * @throws DateTimeFactoryException
     */
    public function createFromFormat(string $spec, string $format, $timeZone = null): \DateTimeInterface
    {
        return $this->dateTimeFactory->createFromFormat($spec, $format, $timeZone);
    }

    /**
     * @param string $spec
     *
     * @return \DateTimeZone
     *
     * @throws DateTimeZoneFactoryException
     */
    public function createDateTimeZone(string $spec): \DateTimeZone
    {
        return $this->dateTimeZoneFactory->createDateTimeZone($spec);
    }

    /**
     * @param \DateTimeZone|string|null $timeZone
     *
     * @return \DateTimeZone|null
     *
     * @throws DateTimeZoneFactoryException
     */
    public function resolveDateTimeZone($timeZone): ?\DateTimeZone
    {
        return $this->dateTimeZoneFactory->resolveDateTimeZone($timeZone);
    }

    /**
     * @param string $spec
     *
     * @return \DateInterval
     *
     * @throws DateIntervalFactoryException
     */
    public function createDateInterval(string $spec): \DateInterval
    {
        return $this->dateIntervalFactory->createDateInterval($spec);
    }

    /**
     * @param \DateTimeInterface $origin
     * @param \DateTimeInterface $target
     * @param bool               $absolute
     *
     * @return \DateInterval
     *
     * @throws DateIntervalFactoryException
     */
    public function diff(\DateTimeInterface $origin, \DateTimeInterface $target, bool $absolute = false): \DateInterval
    {
        return $this->dateIntervalFactory->diff($origin, $target, $absolute);
    }
}
