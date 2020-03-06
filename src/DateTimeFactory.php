<?php declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateTimeFactoryException;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime
 */
class DateTimeFactory implements DateTimeFactoryInterface
{
    /**
     * Create a new \DateTime instance using the provided specification.
     *
     * @param null|string $spec    The optional date and time specification.
     * @param array       $options The date and time options.
     *
     * @return \DateTime
     *
     * @throws DateTimeFactoryException If the \DateTime instance cannot be created.
     */
    public function createDateTime(string $spec = null, array $options = []) : \DateTime
    {
        $timeZone = $options['time_zone'] ?? null;

        try {
            return new \DateTime($spec, $this->resolveDateTimeZone($timeZone));
        } catch (\Throwable $e) {
            throw new DateTimeFactoryException(sprintf(
                'Failed to create a valid \DateTime instance using specification \'%s\' in \'%s\'.',
                $spec,
                static::class
            ));
        }
    }

    /**
     * Resolve a date time zone from the provided $timeZone argument.
     *
     * @param mixed $timeZone
     *
     * @return \DateTimeZone|null
     *
     * @throws DateTimeFactoryException
     */
    private function resolveDateTimeZone($timeZone) : ?\DateTimeZone
    {
        if (is_string($timeZone) && !empty($timeZone)) {
            $timeZone = $this->createDateTimeZone($timeZone);
        } elseif (empty($timeZone) || (!$timeZone instanceof \DateTimeZone)) {
            $timeZone = null;
        }

        return $timeZone;
    }

    /**
     * Create a new \DateTimeZone instance using the provided specification.
     *
     * @param string $spec    The date time zone specification.
     * @param array  $options The optional creation options.
     *
     * @return \DateTimeZone
     *
     * @throws DateTimeFactoryException If the \DateTimeZone cannot be created.
     */
    public function createDateTimeZone(string $spec, array $options = []) : \DateTimeZone
    {
        try {
            return new \DateTimeZone($spec);
        } catch (\Throwable $e) {
            throw new DateTimeFactoryException(sprintf(
                'Failed to create a valid \DateTimeZone instance using \'%s\' in \'%s\'.',
                $spec,
                static::class
            ));
        }
    }

    /**
     * Create a new \DateTime instance using the provided format.
     *
     * @param string $spec    The date and time specification.
     * @param string $format  The date and time format.
     * @param array  $options The date and time options.
     *
     * @return \DateTime
     *
     * @throws DateTimeFactoryException  If the \DateTime instance cannot be created.
     */
    public function createFromFormat(string $spec, string $format, array $options = []) : \DateTime
    {
        $timeZone = $options['time_zone'] ?? null;

        $dateTime = \DateTime::createFromFormat($format, $spec, $this->resolveDateTimeZone($timeZone));

        if (empty($dateTime) || (!$dateTime instanceof \DateTime)) {
            throw new DateTimeFactoryException(sprintf(
                'Failed to create a valid \DateTime instance using specification \'%s\' in \'%s\'.',
                $spec,
                static::class
            ));
        }

        return $dateTime;
    }
}
