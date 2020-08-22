<?php

declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateIntervalFactoryException;
use Arp\DateTime\Exception\DateTimeFactoryException;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime
 */
final class DateTimeFactory implements DateFactoryInterface
{
    /**
     * @var DateIntervalFactoryInterface
     */
    private DateIntervalFactoryInterface $dateIntervalFactory;

    /**
     * @param DateIntervalFactoryInterface|null $dateIntervalFactory
     */
    public function __construct(DateIntervalFactoryInterface $dateIntervalFactory = null)
    {
        $this->dateIntervalFactory = $dateIntervalFactory ?? new DateIntervalFactory();
    }

    /**
     * @param null|string               $spec     The date and time specification.
     * @param string|\DateTimeZone|null $timeZone The date time zone. If omitted or null the PHP default will be used.
     *
     * @return \DateTimeInterface
     *
     * @throws DateTimeFactoryException If the \DateTime instance cannot be created.
     */
    public function createDateTime(string $spec = null, $timeZone = null): \DateTimeInterface
    {
        try {
            return new \DateTime($spec ?? 'now', $this->resolveDateTimeZone($timeZone));
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
     * Create a new \DateTime instance using the provided format.
     *
     * @param string                    $spec     The date and time specification.
     * @param string                    $format   The date and time format.
     * @param string|\DateTimeZone|null $timeZone The date time zone. If omitted or null the PHP default will be used.
     *
     * @return \DateTimeInterface
     *
     * @throws DateTimeFactoryException  If the \DateTime instance cannot be created.
     */
    public function createFromFormat(string $spec, string $format, $timeZone = null): \DateTimeInterface
    {
        $dateTime = \DateTime::createFromFormat($format, $spec, $this->resolveDateTimeZone($timeZone));

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
     * Create a new \DateTimeZone instance using the provided specification.
     *
     * @param string $spec The date time zone specification.
     *
     * @return \DateTimeZone
     *
     * @throws DateTimeFactoryException If the \DateTimeZone cannot be created.
     */
    public function createDateTimeZone(string $spec): \DateTimeZone
    {
        try {
            return new \DateTimeZone($spec);
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
     * @param string $spec
     *
     * @return \DateInterval
     *
     * @throws DateTimeFactoryException
     */
    public function createDateInterval(string $spec): \DateInterval
    {
        try {
            return $this->dateIntervalFactory->createDateInterval($spec);
        } catch (DateIntervalFactoryException $e) {
            throw new DateTimeFactoryException(
                sprintf('Failed to create date interval \'%s\': %s', $spec, $e->getMessage()),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Perform a diff of two dates and return the \DateInterval
     *
     * @param \DateTimeInterface $origin    The origin date
     * @param \DateTimeInterface $target    The date to compare to
     * @param bool               $absolute  If the interval is negative, should it be forced to be a positive value?
     *
     * @return \DateInterval
     *
     * @throws DateTimeFactoryException If the date diff cannot be performed
     */
    public function diff(\DateTimeInterface $origin, \DateTimeInterface $target, bool $absolute = false): \DateInterval
    {
        try {
            return $this->dateIntervalFactory->diff($origin, $target, $absolute);
        } catch (DateIntervalFactoryException $e) {
            throw new DateTimeFactoryException(
                sprintf('Failed to perform date diff: %s', $e->getMessage()),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Resolve a date time zone from the provided $timeZone argument.
     *
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
                    is_object($timeZone) ? get_class($timeZone) : gettype($timeZone),
                    __FUNCTION__
                )
            );
        }

        return $timeZone;
    }
}
