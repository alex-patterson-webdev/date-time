<?php

namespace Arp\DateTime\Service;

/**
 * CurrentDateTimeProvider
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
     * @return \DateTime
     */
    public function getDateTime()
    {
        return $this->factory->createDateTime();
    }

}