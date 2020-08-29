<?php

declare(strict_types=1);

namespace Arp\DateTime\Factory;

use Arp\DateTime\DateTimeFactory;
use Arp\DateTime\Exception\DateTimeFactoryException;
use Arp\Factory\Exception\FactoryException;
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
     *
     * @throws FactoryException If the factory cannot be created
     */
    public function create(array $config = []): DateTimeFactory
    {
        $dateTimeClassName = $config['date_class_name'] ?? null;
        $dateTimeZoneClassName = $config['time_zone_class_name'] ?? null;

        try {
            return new DateTimeFactory($dateTimeClassName, $dateTimeZoneClassName);
        } catch (DateTimeFactoryException $e) {
            throw new FactoryException(
                sprintf('Failed to create DateTimeFactory: %s', $e->getMessage()),
                $e->getCode(),
                $e
            );
        }
    }
}
