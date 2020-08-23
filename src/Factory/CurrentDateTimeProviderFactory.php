<?php

declare(strict_types=1);

namespace Arp\DateTime\Factory;

use Arp\DateTime\CurrentDateTimeProvider;
use Arp\DateTime\DateTimeFactoryInterface;
use Arp\Factory\Exception\FactoryException;
use Arp\Factory\FactoryInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Factory
 */
class CurrentDateTimeProviderFactory implements FactoryInterface
{
    /**
     * @var FactoryInterface
     */
    private FactoryInterface $dateTimeFactoryFactory;

    /**
     * @param FactoryInterface|null $dateTimeFactoryFactory
     */
    public function __construct(FactoryInterface $dateTimeFactoryFactory = null)
    {
        $this->dateTimeFactoryFactory = $dateTimeFactoryFactory ?? new DateTimeFactoryFactory();
    }

    /**
     * @param array $config
     *
     * @return CurrentDateTimeProvider
     *
     * @throws FactoryException If the date time provider cannot be created.
     */
    public function create(array $config = []): CurrentDateTimeProvider
    {
        /** @var DateTimeFactoryInterface|array $dateTimeFactory */
        $dateTimeFactory = $config['date_time_factory'] ?? [];
        if (is_array($dateTimeFactory)) {
            $dateTimeFactory = $this->dateTimeFactoryFactory->create($dateTimeFactory);
        }

        return new CurrentDateTimeProvider($dateTimeFactory);
    }
}
