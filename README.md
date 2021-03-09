# IED-ddd-cqrs-level-2-PHP7.4

[![<ORG_NAME>](https://circleci.com/gh/NFLorD/IED-ddd-cqrs-level-2-PHP7.4.svg?style=shield)](https://circleci.com/gh/NFLorD/IED-ddd-cqrs-level-2-PHP7.4)

https://github.com/inextensodigital/developers/blob/master/Backend/ddd-and-cqs-level-2.md

I used :
 - [doctrine/orm](https://github.com/doctrine/orm)
 - [symfony/console](https://github.com/symfony/console)
 - [php-di/php-di](https://github.com/php-di/php-di)
 
 - [SQLite](https://www.sqlite.org/)
 - [CircleCI](https://circleci.com/)


### Installation
 - composer install
 - vendor/bin/doctrine orm:schema-tool:create


### Notes
 - I'm unsure whether I should have written the verification for the existence of fleets/vehicles in Domain\Model or Domain\Specification instead of App\Query. I am also considering moving App\Handler to Domain\Handler as I feel the way Models interact pertains to the Domain rather than the App itself.
 - I was also unsure what the command ./fleet localize-vehicle is supposed to do: park a vehicle (set its location), or find and return its location ? As such, I went for the first interpretation.
