<?php

declare(strict_types=1);

namespace ArpTest\DateTime\Exception;

use Arp\DateTime\Exception\DateTimeException;
use PHPUnit\Framework\TestCase;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\DateTime\Exception
 */
final class DateTimeExceptionTest extends TestCase
{
    /**
     * Assert that the exception class implements \Exception.
     *
     * @covers \Arp\DateTime\Exception\DateTimeException
     */
    public function testImplementsException(): void
    {
        $exception = new DateTimeException();

        $this->assertInstanceOf(\Exception::class, $exception);
    }
}
