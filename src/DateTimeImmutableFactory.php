<?php

declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateTimeFactoryException;

class DateTimeImmutableFactory implements DateTimeFactoryInterface
{
    private DateTimeFactory $dateTimeFactory;

    /**
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
     * @throws DateTimeFactoryException
     */
    public function createDateTime(
        ?string $spec = null,
        string|\DateTimeZone|null $timeZone = null
    ): \DateTimeImmutable {
        /**
         * @phpstan-ignore-next-line
         * @noinspection PhpIncompatibleReturnTypeInspection
         */
        return $this->dateTimeFactory->createDateTime($spec, $timeZone);
    }

    /**
     * @throws DateTimeFactoryException
     */
    public function createFromFormat(
        string $format,
        string $spec,
        string|\DateTimeZone|null $timeZone = null
    ): \DateTimeImmutable {
        /**
         * @phpstan-ignore-next-line
         * @noinspection PhpIncompatibleReturnTypeInspection
         */
        return $this->dateTimeFactory->createFromFormat($format, $spec, $timeZone);
    }
}
