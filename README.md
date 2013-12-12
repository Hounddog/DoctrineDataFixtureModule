# DoctrineDataFixture Module for Zend Framework 2

[![Build Status](https://travis-ci.org/Hounddog/DoctrineDataFixtureModule.png)](https://travis-ci.org/Hounddog/DoctrineDataFixtureModule)
[![Coverage Status](https://coveralls.io/repos/Hounddog/DoctrineDataFixtureModule/badge.png?branch=master)](https://coveralls.io/r/Hounddog/DoctrineDataFixtureModule)

## Introduction

The DoctrineDataFixtureModule module intends to integrate Doctrine 2 data-fixture with Zend Framework 2 quickly
and easily. The following features are intended to work out of the box:

  - Doctrine ORM support
  - Multiple ORM entity managers
  - Multiple DBAL connections
  - Support reuse existing PDO connections in DBAL

## Requirements

This module is designed to work with a typical [ZF2 MVC application](https://github.com/zendframework/ZendSkeletonApplication).

## Installation

Installation of this module uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

```sh
$ php composer.phar require hounddog/doctrine-data-fixture-module:0.0.*
```

Then open `config/application.config.php` and add `DoctrineModule`, `DoctrineORMModule` and 
`DoctrineDataFixtureModule` to your `modules`

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
