<?php declare(strict_types=1);

namespace Arp\DateTime\Factory\Service;

use Arp\DateTime\Service\CurrentDateTimeProvider;
use Arp\DateTime\Service\DateTimeFactory;
use Arp\DateTime\Service\DateTimeProviderInterface;
use Arp\Factory\Exception\FactoryException;
use Arp\Factory\FactoryInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Factory\Service
 */
class CurrentDateTimeProviderFactory implements FactoryInterface
{
    /**
     * Create a new DateTimeProviderInterface instance from the provided $config.
     *
     * @param array $config
     *
     * @return DateTimeProviderInterface
     *
     * @throws FactoryException If the date time provider cannot be created.
     */
    public function create(array $config = []) : DateTimeProviderInterface
    {
        $factory = $config['factory'] ?? DateTimeFactory::class;

        if (!is_a($factory, DateTimeFactory::class, true)) {
            throw new FactoryException(sprintf(
                'The factory argument must be a class that implements \'%s\'; \'%s\' provided in \'%s\'',
                DateTimeFactory::class,
                is_string($factory) ? $factory : gettype($factory),
                static::class
            ));
        }

        return new CurrentDateTimeProvider(new $factory);
    }
}
