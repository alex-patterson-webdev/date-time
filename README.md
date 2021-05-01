![build](https://github.com/alex-patterson-webdev/date-time/actions/workflows/workflow.yml/badge.svg)
[![codecov](https://codecov.io/gh/alex-patterson-webdev/date-time/branch/master/graph/badge.svg)](https://codecov.io/gh/alex-patterson-webdev/date-time)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-patterson-webdev/date-time/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-patterson-webdev/date-time/?branch=master)

# Arp\DateTime

## About

The library provides a number of factory interfaces which abstract the creation of native PHP DateTime classes, 
`\DateTime`, `DateTimeImmutible`, `\DateInterval` and `\DateTimeZone`.

## Installation

Installation via [composer](https://getcomposer.org).

    require alex-patterson-webdev/date-time ^0.4

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

## Unit tests

Unit tests can be executed using PHPUnit from the application root directory.

    php vendor/bin/phpunit
