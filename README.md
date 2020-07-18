# PHP Type class

[![PHP Version](https://img.shields.io/packagist/php-v/umirode/type.svg)](https://packagist.org/packages/umirode/type)
[![Stable Version](https://img.shields.io/packagist/v/umirode/type.svg?label=Latest)](https://packagist.org/packages/umirode/type)
[![Total Downloads](https://img.shields.io/packagist/dt/umirode/type.svg?label=Total+downloads)](https://packagist.org/packages/umirode/type)
[![Build Status](https://travis-ci.com/umirode/type.svg?branch=master)](https://travis-ci.com/umirode/type)

Abstract type class for php application.

## Installation

Using Composer:

```sh
composer require umirode/type
```

## Example

Define type:
```php
<?php declare(strict_types=1);

use Umirode\Type\Type;

/**
 * Class ExampleType
 * @package Umirode\Type
 *
 * @method bool isActive()
 * @method bool isAccepted()
 * @method bool isCanceledByCustomer()
 * @method static ExampleType active()
 * @method static ExampleType accepted()
 * @method static ExampleType canceledByCustomer()
 */
final class ExampleType extends Type
{
    public const TYPES = [
        'active' => 'Active',
        'accepted' => 'Accepted by admin',
        'canceled_by_customer' => 'Canceled by customer'
    ];
}
```

Use it:
```php
<?php

$exampleType = new ExampleType('canceled_by_customer');
$exampleType = ExampleType::canceledByCustomer();

echo $exampleType->getValue(); // Canceled by customer
```
