<?php

declare(strict_types=1);

namespace Arp\DateTime\Service;

use Arp\DateTime\Exception\DateTimeProviderException;

/**
 * CurrentDateTimeProvider
 *
 * Service to provide the current date and time.
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Service
 */
final class CurrentDateTimeProvider implements DateTimeProviderInterface
{
    /**
     * $factory
     *
     * @var DateTimeFactoryInterface
     */
    protected $factory;

    /**
     * __construct
     *
     * @param DateTimeFactoryInterface $factory
     */
    public function __construct(DateTimeFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * getDateTime
     *
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
        }
        catch(\Exception $e) {

            throw new DateTimeProviderException(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

}