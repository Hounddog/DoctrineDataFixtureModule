# DoctrineDataFixture Module for Zend Framework 2

The DoctrineDataFixtureModule module intends to integrate Doctrine 2 data-fixture with Zend Framework 2 quickly
and easily. The following features are intended to work out of the box:

  - Doctrine ORM support
  - Multiple ORM entity managers
  - Multiple DBAL connections
  - Support reuse existing PDO connections in DBAL

## Requirements
[Zend Framework 2](http://www.github.com/zendframework/zf2)

## Installation

Installation of this module uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

#### Installation steps

  1. `cd my/project/directory`
  2. create a `composer.json` file with following contents (minimum stability is required since the module still has
     frequent updates):

     ```json
     {
         "minimum-stability": "dev",
         "require": {
             "hounddog/doctrine-data-fixture-module": "dev-master"
         }
     }
     ```
  3. run `php composer.phar install`
  4. open `my/project/directory/config/application.config.php` and add `DoctrineModule`, `DoctrineORMModule` and `DoctrineDataFixtureModule` to your `modules`

#### Registering Fixtures

To register drivers with Doctrine module simply add the drivers to the doctrine.driver key in your configuration.

```php
<?php
return array(
    'data-fixture' => array(
        'ModuleName_fixture' => __DIR__ . '/../src/ModuleName/Fixture',
    ),
);
```

## Usage

#### Command Line
Access the Doctrine command line as following

```sh
./vendor/bin/doctrine-module
```
