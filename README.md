[![Build Status](https://travis-ci.com/alex-patterson-webdev/date-time.svg?branch=master)](https://travis-ci.com/alex-patterson-webdev/date-time)
[![codecov](https://codecov.io/gh/alex-patterson-webdev/date-time/branch/master/graph/badge.svg)](https://codecov.io/gh/alex-patterson-webdev/date-time)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-patterson-webdev/date-time/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-patterson-webdev/date-time/?branch=master)

# About

The `Arp\DateTime` module provides date and time abstractions for the built in PHP classes `DateTime`, `DateTimeImmutable` and `DateInterval`.

# Installation

Installation via [composer](https://getcomposer.org).

    require alex-patterson-webdev/date-time ^2
   
## DateTimeFactory

The `Arp\DateTime\DateTimeFactory` can be used as a replacement for any calls that would normally require `new \DateTime()`.

## DateIntervalFactory

The `Arp\DateTime\DateIntervalFactory` can be used as a replacement for any calls that would normally require `new \DateInterval()`.

## Unit Tests

Unit test using PHP Unit.

    php vendor/bin/phpunit
