<?php

declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateTimeFactoryException;
use Arp\DateTime\Exception\DateTimeZoneFactoryException;

final class DateTimeFactory implements DateTimeFactoryInterface
{
    /**
     * @var class-string<\DateTimeInterface>
     */
    private string $dateTimeClassName;

    /**
     * @param class-string<\DateTimeInterface>|null $dateTimeClassName
     *
     * @throws DateTimeFactoryException
     */
    public function __construct(
        private ?DateTimeZoneFactoryInterface $dateTimeZoneFactory = null,
        ?string $dateTimeClassName = null
    ) {
        $this->dateTimeZoneFactory = $dateTimeZoneFactory ?? new DateTimeZoneFactory();

        $dateTimeClassName ??= \DateTime::class;
        if (!is_a($dateTimeClassName, \DateTimeInterface::class, true)) {
            throw new DateTimeFactoryException(
                sprintf(
                    'The \'dateTimeClassName\' parameter must be a class that implements \'%s\'',
                    \DateTimeInterface::class
                )
            );
        }

        $this->dateTimeClassName = $dateTimeClassName;
    }

    /**
     * @throws DateTimeFactoryException
     */
    public function createDateTime(?string $spec = null, string|\DateTimeZone|null $timeZone = null): \DateTimeInterface
    {
        $dateTimeZone = $this->resolveDateTimeZone($timeZone);

        try {
            /** @throws \Exception */
            return new $this->dateTimeClassName($spec ?? 'now', $dateTimeZone);
        } catch (\Exception $e) {
            throw new DateTimeFactoryException(
                sprintf('Failed to create a valid \DateTime instance using \'%s\'', $spec),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * @throws DateTimeFactoryException
     */
    public function createFromFormat(
        string $format,
        string $spec,
        string|\DateTimeZone|null $timeZone = null
    ): \DateTimeInterface {
        /** @var callable $factory */
        $factory = [$this->dateTimeClassName, 'createFromFormat'];

        $dateTime = $factory($format, $spec, $this->resolveDateTimeZone($timeZone));

        if (!$dateTime instanceof \DateTimeInterface) {
            throw new DateTimeFactoryException(
                sprintf(
                    'Failed to create a valid \DateTime instance using \'%s\' and format \'%s\'',
                    $spec,
                    $format
                )
            );
        }

        return $dateTime;
    }

    /**
     * @throws DateTimeFactoryException
     */
    private function resolveDateTimeZone(string|\DateTimeZone|null $timeZone): ?\DateTimeZone
    {
        try {
            return is_string($timeZone)
                ? $this->dateTimeZoneFactory->createDateTimeZone($timeZone)
                : $timeZone;
        } catch (DateTimeZoneFactoryException $e) {
            throw new DateTimeFactoryException('Failed to create date time zone', $e->getCode(), $e);
        }
    }
}
