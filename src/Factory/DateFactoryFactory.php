<?php

declare(strict_types=1);

namespace Arp\DateTime\Factory;

use Arp\DateTime\DateFactory;
use Arp\DateTime\DateIntervalFactoryInterface;
use Arp\DateTime\DateTimeFactoryInterface;
use Arp\Factory\Exception\FactoryException;
use Arp\Factory\FactoryInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Factory
 */
final class DateFactoryFactory implements FactoryInterface
{
    /**
     * @var FactoryInterface
     */
    private FactoryInterface $dateTimeFactoryFactory;

    /**
     * @var FactoryInterface
     */
    private FactoryInterface $dateIntervalFactoryFactory;

    /**
     * @param FactoryInterface|null $dateTimeFactoryFactory
     * @param FactoryInterface|null $dateIntervalFactoryFactory
     */
    public function __construct(
        FactoryInterface $dateTimeFactoryFactory = null,
        FactoryInterface $dateIntervalFactoryFactory = null
    ) {
        $this->dateTimeFactoryFactory = $dateTimeFactoryFactory ?? new DateTimeFactoryFactory();
        $this->dateIntervalFactoryFactory = $dateIntervalFactoryFactory ?? new DateIntervalFactoryFactory();
    }

    /**
     * @param array $config
     *
     * @return DateFactory
     *
     * @throws FactoryException
     */
    public function create(array $config = []): DateFactory
    {
        /** @var DateTimeFactoryInterface|array $dateTimeFactory */
        $dateTimeFactory = $config['date_time_factory'] ?? [];
        if (is_array($dateTimeFactory)) {
            $dateTimeFactory = $this->dateTimeFactoryFactory->create($dateTimeFactory);
        }

        /** @var DateIntervalFactoryInterface|array $dateIntervalFactory */
        $dateIntervalFactory = $config['date_interval_factory'] ?? [];
        if (is_array($dateIntervalFactory)) {
            $dateIntervalFactory = $this->dateIntervalFactoryFactory->create($dateIntervalFactory);
        }

        return new DateFactory($dateTimeFactory, $dateIntervalFactory);
    }
}
