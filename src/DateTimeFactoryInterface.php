<?php

declare(strict_types=1);

namespace Arp\DateTime;

use Arp\DateTime\Exception\DateTimeFactoryException;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime
 */
interface DateTimeFactoryInterface
{
    /**
     * Create a new \DateTimeInterface instance using the provided specification
     *
     * @param null|string               $spec     The date and time specification
     * @param string|\DateTimeZone|null $timeZone The date time zone. If omitted or null the PHP default will be used
     *
     * @return \DateTimeInterface
     *
     * @throws DateTimeFactoryException  If the \DateTimeInterface instance cannot be created
     */
    public function createDateTime(?string $spec = null, $timeZone = null): \DateTimeInterface;

    /**
     * Create a new \DateTimeInterface instance using the provided format
     *
     * @param string                    $format   The date and time format
     * @param string                    $spec     The date and time specification
     * @param string|\DateTimeZone|null $timeZone The date time zone. If omitted or null the PHP default will be used
     *
     * @return \DateTimeInterface
     *
     * @throws DateTimeFactoryException  If the \DateTimeInterface instance cannot be created
     */
    public function createFromFormat(string $format, string $spec, $timeZone = null): \DateTimeInterface;
}
