<?php

declare(strict_types=1);

namespace Arp\DateTime\Factory;

use Arp\DateTime\DateIntervalFactory;
use Arp\Factory\FactoryInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Factory
 */
final class DateIntervalFactoryFactory implements FactoryInterface
{
    /**
     * @param array $config
     *
     * @return DateIntervalFactory
     */
    public function create(array $config = []): DateIntervalFactory
    {
        return new DateIntervalFactory();
    }
}
