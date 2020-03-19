[![Build Status](https://travis-ci.com/alex-patterson-webdev/date-time.svg?branch=master)](https://travis-ci.com/alex-patterson-webdev/date-time)
[![codecov](https://codecov.io/gh/alex-patterson-webdev/date-time/branch/master/graph/badge.svg)](https://codecov.io/gh/alex-patterson-webdev/date-time)

# About

The `Arp\DateTime` module is a general purpose date and time helper library. It provides components and interfaces that 
are useful for the creation and manipulation of Date and Time objects in PHP.

# Installation

Installation via [composer](https://getcomposer.org).

    require alex-patterson-webdev/date-time ^1
   
## Components

The module provides the following components

- `DateTimeFactory` Provides an abstraction of the creation of `DateTime` objects.
- `DateIntervalFactory` Provides an abstract for the creation of `DateInterval` objects.
- `CurrentDateTimeProvider` service that exposes one `getDateTime() : \DateTime` method that will always return the current date and time.

## Unit Tests

Unit test using PHP Unit 8.

    php vendor/bin/phpunit