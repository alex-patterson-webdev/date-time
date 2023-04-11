<?php

declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateIntervalFactoryException;
use Arp\DateTime\Exception\DateTimeFactoryException;
use Arp\DateTime\Exception\DateTimeZoneFactoryException;

final class DateFactory implements DateFactoryInterface
{
    /**
     * @throws DateTimeFactoryException
     */
    public function __construct(
        private ?DateTimeFactoryInterface $dateTimeFactory = null,
        private ?DateTimeZoneFactoryInterface $dateTimeZoneFactory = null,
        private ?DateIntervalFactoryInterface $dateIntervalFactory = null
    ) {
        $this->dateTimeZoneFactory = $dateTimeZoneFactory ?? new DateTimeZoneFactory();
        $this->dateTimeFactory = $dateTimeFactory ?? new DateTimeFactory($this->dateTimeZoneFactory);
        $this->dateIntervalFactory = $dateIntervalFactory ?? new DateIntervalFactory();
    }

    /**
     * @throws DateTimeFactoryException
     */
    public function createDateTime(
        ?string $spec = null,
        string|\DateTimeZone|null $timeZone = null
    ): \DateTimeInterface {
        return $this->dateTimeFactory->createDateTime($spec, $timeZone);
    }

    /**
     * @throws DateTimeFactoryException
     */
    public function createFromFormat(
        string $format,
        string $spec,
        string|\DateTimeZone|null $timeZone = null
    ): \DateTimeInterface {
        return $this->dateTimeFactory->createFromFormat($format, $spec, $timeZone);
    }

    /**
     * @throws DateTimeZoneFactoryException
     */
    public function createDateTimeZone(string $spec): \DateTimeZone
    {
        return $this->dateTimeZoneFactory->createDateTimeZone($spec);
    }

    /**
     * @throws DateIntervalFactoryException
     */
    public function createDateInterval(string $spec): \DateInterval
    {
        return $this->dateIntervalFactory->createDateInterval($spec);
    }
}
