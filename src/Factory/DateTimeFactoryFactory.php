<?php

declare(strict_types=1);

namespace Arp\DateTime\Factory;

use Arp\DateTime\DateTimeFactory;
use Arp\Factory\FactoryInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Factory
 */
final class DateTimeFactoryFactory implements FactoryInterface
{
    /**
     * Create a new DateTimeFactory instance
     *
     * @param array $config
     *
     * @return DateTimeFactory
     */
    public function create(array $config = []): DateTimeFactory
    {
        return new DateTimeFactory();
    }
}
