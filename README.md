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
             "doctrine/doctrine-data-fixture-module": "dev-master"
         }
     }
     ```
  3. run `php composer.phar install`
  4. open `my/project/directory/config/application.config.php` and add `DoctrineModule`, `DoctrineORMModule` and 'DoctrineDataFixtureModule` to your `modules`
#### Installation steps (without composer)
#### Not Completed ####
  
  1. install [DoctrineModule](http://github.com/doctrine/DoctrineModule)
  2. clone this module to `vendor/DoctrineORMModule`
  2. setup PSR-0 autoloading for namespace `DoctrineORMModule` (the directory where the classes in this namespace live 
     is `vendor/DoctrineORMModule/src/DoctrineORMModule`.
  3. The module depends on [Doctrine ORM 2.3.*](https://github.com/doctrine/orm), 
     [Doctrine DBAL 2.3.*](https://github.com/doctrine/dbal), 
     [Doctrine Migrations](https://github.com/symfony/migrations). You have to download/install those
     packages and have them autoloaded.
  4. open `my/project/directory/configs/application.config.php` and add the following key to your `modules`:

     ```php
     'DoctrineModule',
     'DoctrineORMModule',
     'DoctrineDataFixtureModule'
     ```

   5. Follow the setup instructions on https://github.com/doctrine/DoctrineORMModule
## Usage

#### Command Line
Access the Doctrine command line as following

```sh
./vendor/bin/doctrine-module
```
