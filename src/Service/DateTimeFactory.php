<?php declare(strict_types=1);

namespace Arp\DateTime\Service;

use Arp\DateTime\Exception\DateTimeFactoryException;

/**
 * DateTimeFactory
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Service
 */
class DateTimeFactory implements DateTimeFactoryInterface
{
    /**
     * createDateTime
     *
     * Create a new \DateTime instance using the provided specification.
     *
     * @param null|string  $spec     The optional date and time specification.
     * @param array        $options  The date and time options.
     *
     * @return \DateTime
     *
     * @throws DateTimeFactoryException  If the \DateTime instance cannot be created.
     */
    public function createDateTime($spec = null, array $options = []) : \DateTime
    {
        $timeZone = isset($options['time_zone']) ? $options['time_zone'] : null;

        try {
            return new \DateTime($spec, $timeZone);
        }
        catch (\Exception $e) {

            throw new DateTimeFactoryException(sprintf(
                'Failed to create a valid \DateTime instance using specification \'%s\' in \'%s\'.',
                is_string($spec) ? $spec : gettype($spec),
                static::class
            ));
        }
    }

    /**
     * createFromFormat
     *
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
    public function createFromFormat($spec, $format, array $options = []) : \DateTime
    {
        $timeZone = isset($options['time_zone']) ? $options['time_zone'] : null;

        if (! empty($timeZone) && is_string($timeZone)) {
            $timeZone = $this->createDateTimeZone($timeZone);
        }

        try {
            return \DateTime::createFromFormat($format, $spec, $timeZone);
        }
        catch (\Exception $e) {

            throw new DateTimeFactoryException(sprintf(
                'Failed to create a valid \DateTime instance using format \'%s\' in \'%s\'.',
                $spec,
                static::class
            ));
        }
    }

    /**
     * createDateTimeZone
     *
     * Create a new \DateTimeZone instance using the provided specification.
     *
     * @param string $spec     The date time zone specification.
     * @param array  $options  The optional creation options.
     *
     * @return \DateTimeZone
     *
     * @throws DateTimeFactoryException If the \DateTimeZone cannot be created.
     */
    public function createDateTimeZone($spec, array $options = []) : \DateTimeZone
    {
        try {
            return new \DateTimeZone($spec);
        }
        catch (\Exception $e) {

            throw new DateTimeFactoryException(sprintf(
                'Failed to create a valid \DateTimeZone( instance using format \'%s\' in \'%s\'.',
                $spec,
                static::class
            ));
        }
    }

}