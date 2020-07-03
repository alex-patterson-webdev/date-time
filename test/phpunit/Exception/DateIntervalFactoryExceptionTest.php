<?php

declare(strict_types=1);

namespace ArpTest\DateTime\Exception;

use Arp\DateTime\Exception\DateIntervalFactoryException;
use Arp\DateTime\Exception\DateTimeException;
use PHPUnit\Framework\TestCase;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\DateTime\Exception
 */
final class DateIntervalFactoryExceptionTest extends TestCase
{
    /**
     * Assert that the exception class implements \Exception.
     *
     * @covers \Arp\DateTime\Exception\DateIntervalFactoryException
     */
    public function testImplementsException(): void
    {
        $exception = new DateIntervalFactoryException();

        $this->assertInstanceOf(\Exception::class, $exception);
    }

    /**
     * Assert that the exception class implements DateTimeException.
     *
     * @covers \Arp\DateTime\Exception\DateIntervalFactoryException
     */
    public function testImplementsDateTimeException(): void
    {
        $exception = new DateIntervalFactoryException();

        $this->assertInstanceOf(DateTimeException::class, $exception);
    }
}
