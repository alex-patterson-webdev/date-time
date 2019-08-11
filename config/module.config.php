<?php

namespace Arp\DateTime;

use Arp\DateTime\Service\DateTimeFactory;
use Arp\DateTime\Service\CurrentDateTimeProvider;
use Arp\DateTime\View\Helper\DateTime as DateTimeViewHelper;
use Arp\DateTime\Factory\Service\CurrentDateTimeProviderFactory;
use Zend\Hydrator\Strategy\DateTimeFormatterStrategy;
use Zend\ServiceManager\Factory\InvokableFactory;

return [

    'service_manager' => [
        'factories' => [
            DateTimeFactory::class           => InvokableFactory::class,
            CurrentDateTimeProvider::class   => CurrentDateTimeProviderFactory::class,
            DateTimeFormatterStrategy::class => InvokableFactory::class,
        ],
    ],

    'view_helpers' => [
        'aliases' => [
            'dateTime' => DateTimeViewHelper::class,
        ],
        'factories' => [
            DateTimeViewHelper::class => InvokableFactory::class,
        ],
    ],
];