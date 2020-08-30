<?php

declare(strict_types=1);

namespace Arp\DateTime\Factory;

use Arp\DateTime\DateTimeFactory;
use Arp\Factory\Exception\FactoryException;
use Arp\Factory\FactoryInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Factory
 */
final class DateTimeImmutableFactoryFactory implements FactoryInterface
{
    /**
     * @param array $config
     *
     * @return DateTimeFactory
     *
     * @throws FactoryException
     */
    public function create(array $config = []): DateTimeFactory
    {
        $config = array_replace_recursive(
            $config,
            ['date_time_class_name' => \DateTimeImmutable::class]
        );

        return (new DateTimeFactoryFactory())->create($config);
    }
}
