<?php

declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateTimeFactoryException;

interface DateTimeFactoryInterface
{
    /**
     * @throws DateTimeFactoryException
     */
    public function createDateTime(
        ?string $spec = null,
        string|\DateTimeZone|null $timeZone = null
    ): \DateTimeInterface;

    /**
     * @throws DateTimeFactoryException
     */
    public function createFromFormat(
        string $format,
        string $spec,
        string|\DateTimeZone|null $timeZone = null
    ): \DateTimeInterface;
}
