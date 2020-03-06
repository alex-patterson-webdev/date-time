<?php declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateTimeProviderException;

/**
 * Service to provide the current date and time.
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime
 */
final class CurrentDateTimeProvider implements DateTimeProviderInterface
{
    /**
     * @var DateTimeFactoryInterface
     */
    private $factory;

    /**
     * @param DateTimeFactoryInterface $factory
     */
    public function __construct(DateTimeFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Return a date and time instance.
     *
     * @return \DateTime
     *
     * @throws DateTimeProviderException  If the date and time cannot be returned.
     */
    public function getDateTime() : \DateTime
    {
        try {
            return $this->factory->createDateTime();
        } catch (\Throwable $e) {
            throw new DateTimeProviderException(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
