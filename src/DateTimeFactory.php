<?php

declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateTimeFactoryException;
use Arp\DateTime\Exception\DateTimeZoneFactoryException;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime
 */
final class DateTimeFactory implements DateTimeFactoryInterface
{
    /**
     * @var DateTimeZoneFactoryInterface
     */
    private DateTimeZoneFactoryInterface $dateTimeZoneFactory;

    /**
     * @var string
     */
    private string $dateTimeClassName;

    /**
     * @param DateTimeZoneFactoryInterface|null $dateTimeZoneFactory
     * @param string|null                       $dateTimeClassName
     *
     * @throws DateTimeFactoryException
     */
    public function __construct(
        DateTimeZoneFactoryInterface $dateTimeZoneFactory = null,
        string $dateTimeClassName = null
    ) {
        $this->dateTimeZoneFactory = $dateTimeZoneFactory ?? new DateTimeZoneFactory();

        $dateTimeClassName ??= \DateTime::class;
        if (!is_a($dateTimeClassName, \DateTimeInterface::class, true)) {
            throw new DateTimeFactoryException(
                sprintf(
                    'The \'dateTimeClassName\' parameter must be a class name that implements \'%s\'',
                    \DateTimeInterface::class
                )
            );
        }

        $this->dateTimeClassName = $dateTimeClassName;
    }

    /**
     * @param null|string               $spec     The date and time specification
     * @param string|\DateTimeZone|null $timeZone The date time zone; if omitted or null the PHP default will be used
     *
     * @return \DateTimeInterface
     *
     * @throws DateTimeFactoryException If the \DateTime instance cannot be created.
     */
    public function createDateTime(?string $spec = null, $timeZone = null): \DateTimeInterface
    {
        try {
            return new $this->dateTimeClassName($spec ?? 'now', $this->resolveDateTimeZone($timeZone));
        } catch (\Exception $e) {
            throw new DateTimeFactoryException(
                sprintf(
                    'Failed to create a valid \DateTime instance using \'%s\': %s',
                    $spec,
                    $e->getMessage()
                ),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * @param string                    $spec     The date and time specification
     * @param string                    $format   The date and time format
     * @param string|\DateTimeZone|null $timeZone The date time zone; if omitted or null the PHP default will be used
     *
     * @return \DateTimeInterface
     *
     * @throws DateTimeFactoryException  If the \DateTime instance cannot be created
     */
    public function createFromFormat(string $spec, string $format, $timeZone = null): \DateTimeInterface
    {
        /** @var callable $factory */
        $factory = [$this->dateTimeClassName, 'createFromFormat'];

        try {
            $dateTime = $factory($format, $spec, $this->resolveDateTimeZone($timeZone));
        } catch (\Exception $e) {
            throw new DateTimeFactoryException(
                sprintf(
                    'Failed to create a valid \DateTime instance from format \'%s\' using \'%s\': %s',
                    $format,
                    $spec,
                    $e->getMessage()
                ),
                $e->getCode(),
                $e
            );
        }

        if (false === $dateTime || !$dateTime instanceof \DateTimeInterface) {
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
     * @param mixed|string|\DateTimeZone|null $timeZone
     *
     * @return \DateTimeZone|null
     *
     * @throws DateTimeFactoryException
     */
    private function resolveDateTimeZone($timeZone): ?\DateTimeZone
    {
        if (empty($timeZone) || (!is_string($timeZone) && !$timeZone instanceof \DateTimeZone)) {
            return null;
        }

        try {
            return is_string($timeZone)
                ? $this->dateTimeZoneFactory->createDateTimeZone($timeZone)
                : $timeZone;
        } catch (DateTimeZoneFactoryException $e) {
            throw new DateTimeFactoryException(
                sprintf('Failed to create date time zone: %s', $e->getMessage()),
                $e->getCode(),
                $e
            );
        }
    }
}
