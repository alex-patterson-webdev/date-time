# About

Date and Time components for ARP.

# Installation

Installation via [composer](https://getcomposer.org).

    require alex-patterson-webdev/date-time ^1
        
# DateTimeFactory

The `Arp\DateTime\Serivce\DateTimeFactory` acts as a wrapper for the creation of PHP `DateTime` and `DateTimeZone` instances in
client code.

    use Arp\DateTime\Service\DateTimeFactory

    $factory = new DateTimeFactory();

