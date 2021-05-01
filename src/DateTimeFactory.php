<?php

declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateTimeFactoryException;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime
 */
final class DateTimeFactory implements DateTimeFactoryInterface
{
    /**
     * @var string
     */
    private string $dateTimeClassName;

    /**
     * @var string
     */
    private string $dateTimeZoneClassName;

    /**
     * @param string|null $dateTimeClassName
     * @param string|null $dateTimeZoneClassName
     *
     * @throws DateTimeFactoryException
     */
    public function __construct(string $dateTimeClassName = null, string $dateTimeZoneClassName = null)
    {
        $dateTimeClassName ??= \DateTime::class;
        if (!is_a($dateTimeClassName, \DateTimeInterface::class, true)) {
            throw new DateTimeFactoryException(
                sprintf(
                    'The \'dateTimeClassName\' must the fully qualified class name'
                    . ' of a class that implements \'%s\'; \'%s\' provided',
                    \DateTimeInterface::class,
                    $dateTimeClassName
                )
            );
        }

        $dateTimeZoneClassName ??= \DateTimeZone::class;
        if (!is_a($dateTimeZoneClassName, \DateTimeZone::class, true)) {
            throw new DateTimeFactoryException(
                sprintf(
                    'The \'dateTimeZoneClassName\' must the fully qualified class name'
                    . ' of a class that implements \'%s\'; \'%s\' provided',
                    \DateTimeZone::class,
                    $dateTimeZoneClassName
                )
            );
        }

        $this->dateTimeClassName = $dateTimeClassName;
        $this->dateTimeZoneClassName = $dateTimeZoneClassName;
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
            return (new $this->dateTimeClassName($spec ?? 'now', $this->resolveDateTimeZone($timeZone)));
        } catch (\Throwable $e) {
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
     * @throws DateTimeFactoryException  If the \DateTime instance cannot be created.
     */
    public function createFromFormat(string $spec, string $format, $timeZone = null): \DateTimeInterface
    {
        $factory = [$this->dateTimeClassName, 'createFromFormat'];
        if (!is_callable($factory)) {
            throw new DateTimeFactoryException(
                sprintf('The method \'%s::%s\' is not callable', $this->dateTimeClassName, 'createFromFormat')
            );
        }

        $dateTime = $factory($format, $spec, $this->resolveDateTimeZone($timeZone));

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
     * @param string $spec The date time zone specification
     *
     * @return \DateTimeZone
     *
     * @throws DateTimeFactoryException If the \DateTimeZone cannot be created
     */
    public function createDateTimeZone(string $spec): \DateTimeZone
    {
        try {
            return (new $this->dateTimeZoneClassName($spec));
        } catch (\Throwable $e) {
            throw new DateTimeFactoryException(
                sprintf(
                    'Failed to create a valid \DateTimeZone instance using \'%s\': %s',
                    $spec,
                    $e->getMessage()
                ),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * @param string|null|\DateTimeZone $timeZone
     *
     * @return \DateTimeZone|null
     *
     * @throws DateTimeFactoryException
     */
    private function resolveDateTimeZone($timeZone): ?\DateTimeZone
    {
        if (null === $timeZone || empty($timeZone)) {
            return null;
        }

        if (is_string($timeZone)) {
            $timeZone = $this->createDateTimeZone($timeZone);
        }

        if (!$timeZone instanceof \DateTimeZone) {
            throw new DateTimeFactoryException(
                sprintf(
                    'The \'timeZone\' argument must be a \'string\''
                    . 'or an object of type \'%s\'; \'%s\' provided in \'%s\'',
                    \DateTimeZone::class,
                    get_class($timeZone),
                    __FUNCTION__
                )
            );
        }

        return $timeZone;
    }
}
