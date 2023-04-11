<?php

declare(strict_types=1);

namespace ArpTest\DateTime\Exception;

use Arp\DateTime\Exception\DateFactoryException;
use Arp\DateTime\Exception\DateTimeException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Arp\DateTime\Exception\DateFactoryException
 */
final class DateFactoryExceptionTest extends TestCase
{
    /**
     * Assert that the exception class implements \Exception
     */
    public function testImplementsException(): void
    {
        $exception = new DateFactoryException();

        $this->assertInstanceOf(\Exception::class, $exception);
    }

    /**
     * Assert that the exception class implements DateTimeException
     */
    public function testImplementsDateTimeException(): void
    {
        $exception = new DateFactoryException();

        $this->assertInstanceOf(DateTimeException::class, $exception);
    }
}
