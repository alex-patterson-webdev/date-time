<?php

declare(strict_types=1);

namespace Arp\DateTime;

interface DateFactoryInterface extends
    DateTimeFactoryInterface,
    DateTimeZoneFactoryInterface,
    DateIntervalFactoryInterface
{
}
