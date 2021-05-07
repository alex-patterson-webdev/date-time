![build](https://github.com/alex-patterson-webdev/date-time/actions/workflows/workflow.yml/badge.svg)
[![codecov](https://codecov.io/gh/alex-patterson-webdev/date-time/branch/master/graph/badge.svg)](https://codecov.io/gh/alex-patterson-webdev/date-time)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-patterson-webdev/date-time/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-patterson-webdev/date-time/?branch=master)

# Arp\DateTime

## About

The library provides a number of factory interfaces which abstracts the creation of native PHP DateTime classes, 
`\DateTime`, `\DateTimeImmutible`, `\DateInterval` and `\DateTimeZone`.

## Installation

Installation via [composer](https://getcomposer.org).

    require alex-patterson-webdev/date-time ^0.5

## Theory

By abstracting the creation of Date Time objects behind a simple collection of interfaces, we can allow developers to treat date time creation as a service.
The `Arp\DateTime\DateTimeFactory` can be used as a replacement for any code that would normally require `new \DateTime()`.

Consider an example `UserService::updateLastLoginDate()` method; designed to update a user's last login date with the current date and time.

    class UserService
    {
        public function updateLastLoginDate($user)
        {
            $user->setLastLoginDate(new \DateTime());
        }
    }

This approach, while simple, would be difficult to assert a value for the 'current time' in a unit test. Alternatively, we could update this
example to include the `DateTimeFactory`, which would abstract the creation of the `\DateTime` object. 

    class UserService
    {
        private DateTimeFactoryInterface $dateTimeFactory;

        public function __construct(DateTimeFactoryInterface $dateTimeFactory)
        {
            $this->dateTimeFactory = $dateTimeFactory;
        }

        public function updateLastLoginDate($user)
        {
            $user->setLastLoginDate($this->dateTimeFactory->createDateTime());
        }
    }

The approach has a number of notable benefits

- The `DateTimeFactoryInterface` provides an abstraction for all `\DateTime` object creation.
- Unit testing and asserting date time values becomes very easy as we can now mock the return value of `$this->dateTimeFactory->createDateTime()`.
- Rather than returning a boolean `false` when unable to create date objects, the factory classes will instead throw a `DateTimeException`.

## DateTimeFactoryInterface

The `DateTimeFactoryInterface` exposes two public methods, `createDateTime()` and `createFromFormat()`. The method signatures are
similar to the PHP `\DateTime` methods. 

    interface DateTimeFactoryInterface
    {
        /**
         * @throws DateTimeFactoryException
         */
        public function createDateTime(?string $spec = null, $timeZone = null): \DateTimeInterface;

        /**
         * @throws DateTimeFactoryException
         */
        public function createFromFormat(string $format, string $spec, $timeZone = null): \DateTimeInterface;
    }

The `createDateTime()` method can replace uses of [\DateTime::__construct](https://www.php.net/manual/en/datetime.construct.php).
The `createFromFormat()` method can replace uses of [\DateTime::createFromFormat()](https://www.php.net/manual/en/datetime.createfromformat.php).

There are however a number of differences to consider.

- The methods of the interface are defined as non-static and require a factory instance to invoke them.
- A `DateTimeFactoryException` will be thrown if the `\DateTime` instance cannot be created.
- The `$spec` parameter of `createDateTime()` accepts `null`. Passing `null` is equivalent to using the current date and time, i.e. `now`.
- The `$timeZone` can be either a `string` or `\DateTimeZone` instance. If a [supported `DateTimeZone` string](https://www.php.net/manual/en/timezones.php) 
  is provided, the `\DateTimeZone` instance will be created internally; otherwise a `DateTimeFactoryException` will be thrown.
  
### Implementations

The package provides two default implementations of the `DateTimeFactoryInterface`.

- `DateTimeFactory` can be used to create `\DateTime` instances.
- `DateTimeImmutableFactory` can be used to create `\DateTimeImmutible` instances

Because both classes implement the `DateTimeFactoryInterface`, they can be used in the same way.

    $dateTimeFactory = new \Arp\DateTime\DateTimeFactory();
    $dateTimeImmutableFactory = new \Arp\DateTime\DateTimeImmutableFactory();

    try {
        /** @var \DateTime $dateTime **/
        $dateTime = $dateTimeFactory->createDateTime();

        /** @var \DateTimeImmutable $dateTimeImmutable **/
        $dateTimeImmutable = $dateTimeImmutableFactory->createDateTime();
    } catch (\DateTimeFactoryException $e) {
        // if the date creation fails
    }

### DateTimeZoneFactory

`\DateTimeZone` instances can be created using any class that implements `Arp\DateTime\DateTimeZoneFactoryInterface`.

    /*
     * @throws DateTimeZoneFactoryException
     */
    public function createDateTimeZone(string $spec): \DateTimeZone;

The default implementation of the interface is `Arp\DateTime\DateTimeZoneFactory`.

    $dateTimeZoneFactory = new \Arp\DateTime\DateTimeZoneFactory();

    try { 
        /** @var \DateTimeZone $dateTimeZone **/
        $dateTimeZone = $dateTimeZoneFactory->createDateTimeZone('UTC');
    } catch (\DateTimeZoneFactoryException $e) {
        // The \DateTimeZone() could not be created
    }

## Unit tests

Unit tests can be executed using PHPUnit from the application root directory.

    php vendor/bin/phpunit
