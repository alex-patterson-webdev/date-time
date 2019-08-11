<?php

declare(strict_types=1);

namespace Arp\DateTime\Factory\Service;

use Arp\DateTime\Service\DateTimeFactory;
use Arp\DateTime\Service\DateTimeFactoryInterface;
use Arp\DateTime\Service\CurrentDateTimeProvider;
use Arp\Stdlib\Exception\ServiceNotCreatedException;
use Arp\Stdlib\Factory\AbstractServiceFactory;
use Interop\Container\ContainerInterface;

/**
 * CurrentDateTimeProviderFactory
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\Factory\Service
 */
class CurrentDateTimeProviderFactory extends AbstractServiceFactory
{
    /**
     * create
     *
     * @param ContainerInterface $container     The dependency injection container.
     * @param string             $requestedName The name of the service requested to the container.
     * @param array              $config        The optional factory configuration options.
     * @param string|null        $className     The name of the class that is being created.
     *
     * @return CurrentDateTimeProvider
     *
     * @throws ServiceNotCreatedException  If the service cannot be created.
     */
    public function create(ContainerInterface $container, $requestedName, array $config = [], $className = null)
    {
        $factory = isset($config['factory']) ? $config['factory'] : DateTimeFactory::class;

        /** @var DateTimeFactoryInterface $factory */
        $factory = $container->get($factory);

        return new CurrentDateTimeProvider($factory);
    }

}