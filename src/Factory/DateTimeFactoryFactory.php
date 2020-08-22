<?php

declare(strict_types=1);

namespace Arp\DateTime\Factory;

use Arp\DateTime\DateIntervalFactory;
use Arp\DateTime\DateTimeFactory;
use Arp\Factory\FactoryInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Factory
 */
final class DateTimeFactoryFactory implements FactoryInterface
{
    /**
     * @param array $config
     *
     * @return DateTimeFactory
     */
    public function create(array $config = []): DateTimeFactory
    {
        $intervalFactory = $config['interval_factory'] ?? new DateIntervalFactory();

        return new DateTimeFactory($intervalFactory);
    }
}
