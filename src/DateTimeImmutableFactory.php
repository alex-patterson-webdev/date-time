<?php

declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateTimeFactoryException;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime
 */
final class DateTimeImmutableFactory implements DateTimeFactoryInterface
{
    /**
     * @var DateTimeFactory
     */
    private DateTimeFactory $dateTimeFactory;

    /**
     * @param string|null                       $dateTimeClassName
     * @param DateTimeZoneFactoryInterface|null $dateTimeZoneFactory
     *
     * @throws DateTimeFactoryException
     */
    public function __construct(
        ?string $dateTimeClassName = null,
        ?DateTimeZoneFactoryInterface $dateTimeZoneFactory = null
    ) {
        $dateTimeClassName ??= \DateTimeImmutable::class;
        if (!is_a($dateTimeClassName, \DateTimeImmutable::class, true)) {
            throw new DateTimeFactoryException(
                sprintf(
                    'The \'dateTimeClassName\' parameter must be a class name that implements \'%s\'',
                    \DateTimeImmutable::class
                )
            );
        }

        $dateTimeZoneFactory ??= new DateTimeZoneFactory();
        $this->dateTimeFactory = new DateTimeFactory($dateTimeZoneFactory, $dateTimeClassName);
    }

    /**
     * @param string|null               $spec
     * @param null|string|\DateTimeZone $timeZone
     *
     * @return \DateTimeImmutable&\DateTimeInterface
     *
     * @throws DateTimeFactoryException
     */
    public function createDateTime(?string $spec = null, $timeZone = null): \DateTimeInterface
    {
        /** @phpstan-ignore-next-line */
        return $this->dateTimeFactory->createDateTime($spec, $timeZone);
    }

    /**
     * @param string                    $spec
     * @param string                    $format
     * @param null|string|\DateTimeZone $timeZone
     *
     * @return \DateTimeImmutable&\DateTimeInterface
     *
     * @throws DateTimeFactoryException
     */
    public function createFromFormat(string $spec, string $format, $timeZone = null): \DateTimeInterface
    {
        /** @phpstan-ignore-next-line */
        return $this->dateTimeFactory->createDateTime($spec, $timeZone);
    }
}
