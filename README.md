Laravel Paymill
=======

[![Build Status](https://travis-ci.org/threesquared/laravel-paymill.svg?branch=master)](https://travis-ci.org/threesquared/laravel-paymill)

Laravel Paymill is a Laravel 5 specific wrapper for the [Paymill PHP](https://github.com/paymill/paymill-php) library.

- [Install](#install)
- [Configuration](#configuration)
- [Usage](#usage)

**Please use the 1.0.0 release for Laravel 4**

## Install

Simply add the following line to your `composer.json` and run install/update:

    "threesquared/laravel-paymill": "~1.3"

## Configuration

Publish the package config files to configure your api keys:

    php artisan vendor:publish

You will also need to add the service provider and the facade alias to your `config/app.php`:

```php
'providers' => array(
  Threesquared\LaravelPaymill\LaravelPaymillServiceProvider::class
)

'aliases' => array(
  'Paymill'   => Threesquared\LaravelPaymill\Facades\Paymill::class
),
```

By default the package will use your test keys. In order to use the live Paymill keys you need to set the `PAYMILL_ENV` enviroment variable.

```
PAYMILL_ENV=live
```

### Usage

*Please see the [Paymill API](https://developers.paymill.com/API/index) for full documentation on all available entities, actions and methods.*

First start with instantiating the Paymill entity you want to work with.

```php
$transaction = Paymill::Transaction();
```

Available entities are:

* [Payment](https://developers.paymill.com/API/index#payments)
* [Transaction](https://developers.paymill.com/API/index#transactions)
* [Client](https://developers.paymill.com/API/index#clients)
* [Preauthorization](https://developers.paymill.com/API/index#preauthorizations)
* [Refund](https://developers.paymill.com/API/index#refunds)
* [Offer](https://developers.paymill.com/API/index#offers)
* [Subscription](https://developers.paymill.com/API/index#subscriptions)

Then add in any additional information the request requires with setter methods.

```php
$transaction->setAmount(4200)
    ->setCurrency('EUR')
    ->setPayment('pay_2f82a672574647cd911d')
    ->setDescription('Test Transaction');
```

Finally chose which action you want to perform.

```php
$transaction->create();
```

Available actions are:

* create()
* details()
* update()
* all()
* delete()

So an example to create a transaction would be:

```php
try {

    Paymill::Transaction()
        ->setAmount(4200)
        ->setCurrency('EUR')
        ->setPayment('pay_2f82a672574647cd911d')
        ->setDescription('Test Transaction')
        ->create();

} catch(PaymillException $e) {

    $e->getResponseCode();
    $e->getStatusCode();
    $e->getErrorMessage();

}
```

You can set the ID of an entity by passing it as an argument.

```php
Paymill::Client('client_8127a65bf3c84676c918')->details();
```

Payment create can also take the token as an argument.

```php
Paymill::Payment()->create('098f6bcd4621d373cade4e832627b4f6');
```

You can also use the `$paymill_public_key` variable across all blade views.

```html
<script type="text/javascript">
  var PAYMILL_PUBLIC_KEY = '{{ $paymill_public_key }}';
</script>
```
