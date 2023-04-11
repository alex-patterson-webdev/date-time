<?php

declare(strict_types=1);

namespace ArpTest\DateTime\Exception;

use Arp\DateTime\Exception\DateTimeException;
use Arp\DateTime\Exception\DateTimeFactoryException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Arp\DateTime\Exception\DateTimeFactoryException
 */
final class DateTimeFactoryExceptionTest extends TestCase
{
    /**
     * Assert that the exception class implements \Exception
     */
    public function testImplementsException(): void
    {
        $exception = new DateTimeFactoryException();

        $this->assertInstanceOf(\Exception::class, $exception);
    }

    /**
     * Assert that the exception class implements DateTimeException
     */
    public function testImplementsDateTimeException(): void
    {
        $exception = new DateTimeFactoryException();

        $this->assertInstanceOf(DateTimeException::class, $exception);
    }
}
