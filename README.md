Laravel Paymill
=======

Laravel Paymill is a Laravel specific wrapper for the [Paymill PHP](https://github.com/paymill/paymill-php) library.

- [Install](#install)
- [Configuration](#configuration)
- [Usage](#usage)

## Install

Simply add the following line to your `composer.json` and run install/update:

    "speakman/laravel-paymill": "dev-master"

## Configuration

You should keep your Paymill api keys in a dot file. For more information read [Protecting Sensitive Configuration](http://laravel.com/docs/configuration#protecting-sensitive-configuration) for detailed instructions.

```php
<?php
return array(
  'laravel-paymill' => array(
    'private_key' => '<YOUR_PRIVATE_KEY>',
    'public_key' => '<YOUR_PUBLIC_KEY>'
  )
);
```

Alternatively you can choose to publish the package config files to configure your api keys there instead:

    php artisan config:publish speakman/laravel-paymill

You will also need to add the service provider and the facade alias to your `app/config/app.php`:

```php
'providers' => array(
  'Speakman\LaravelPaymill\LaravelPaymillServiceProvider'
)

'aliases' => array(
  'Paymill' => 'Speakman\LaravelPaymill\Facades\Paymill'
),
```

### Usage

Please see the [Paymill PHP API](https://developers.paymill.com/en/reference/api-reference/index.html) for full documentation on all available entities and methods. The `create()`, `details()`, `delete()` and `all()` methods are available for all entities. Extra functions can be chained on to add extra information to create and update requests.

#### Payments

https://developers.paymill.com/en/reference/api-reference/index.html#document-payments

```php
try {

    Paymill::Payment()->create('098f6bcd4621d373cade4e832627b4f6');

} catch(PaymillException $e) {

    $e->getResponseCode();
    $e->getStatusCode();
    $e->getErrorMessage();
    
}
```

```php
Paymill::Payment('pay_3af44644dd6d25c820a8')->details();
```

```php
Paymill::Payment('pay_3af44644dd6d25c820a8')->delete();
```

```php
Paymill::Payment()->all();
```

#### Transactions

https://developers.paymill.com/en/reference/api-reference/index.html#document-transactions

```php
Paymill::Transaction()
    ->setAmount(4200)
    ->setCurrency('EUR')
    ->setPayment('pay_2f82a672574647cd911d')
    ->setDescription('Test Transaction');
    ->create();
```

```php
Paymill::Transaction('pay_2f82a672574647cd911d')
    ->setDescription('My updated transaction description');
    ->update();
```

#### Clients

https://developers.paymill.com/en/reference/api-reference/index.html#document-clients

```php
Paymill::Client()
    ->setEmail('max.mustermann@example.com')
    ->setDescription('Lovely Client')
    ->create();
```

```php
Paymill::Client('client_8127a65bf3c84676c918')
    ->setEmail('updated-client@example.com')
    ->setDescription('Updated Client');
    ->update();
```

#### Preauthorizations

https://developers.paymill.com/en/reference/api-reference/index.html#document-preauthorizations

```php
Paymill::Preauthorization()
    ->setToken('098f6bcd4621d373cade4e832627b4f6')
    ->setAmount(4200)
    ->setCurrency('EUR')
    ->setDescription('description example');
    ->create();
```

#### Refunds

https://developers.paymill.com/en/reference/api-reference/index.html#document-refunds

```php
Paymill::Refund('tran_023d3b5769321c649435')
    ->setAmount(4200)
    ->setDescription('Sample Description');
    ->create();
```

#### Offers

https://developers.paymill.com/en/reference/api-reference/index.html#document-offers

```php
Paymill::Offer()
    ->setAmount(4200)
    ->setCurrency('EUR')
    ->setInterval('1 WEEK')
    ->setName('Nerd Special');
    ->create();
```

```php
Paymill::Offer('offer_40237e20a7d5a231d99b')
    ->setName('Extended Special')
    ->setInterval('1 MONTH')
    ->setAmount(3333)
    ->setCurrency('USD')
    ->setTrialPeriodDays(33)
    ->updateSubscriptions(true);
    ->update();
```

```php
Paymill::Offer('pay_3af44644dd6d25c820a8')
    ->removeWithSubscriptions(true);
    ->delete();
```

#### Subscriptions

https://developers.paymill.com/en/reference/api-reference/index.html#document-subscriptions

```php
Paymill::Subscription()
    ->setClient('client_81c8ab98a8ac5d69f749')
    ->setAmount(3000);
    ->setPayment('pay_5e078197cde8a39e4908f8aa');
    ->setCurrency('EUR');
    ->setInterval('1 week,monday');
    ->setName('Example Subscription');
    ->setPeriodOfValidity('2 YEAR');
    ->setStartAt('1400575533');
    ->create();
```

```php
Paymill::Subscription('sub_dea86e5c65b2087202e3')
    ->setClient('client_81c8ab98a8ac5d69f749')
    ->setOffer('offer_40237e20a7d5a231d99b');
    ->setAmount(3000);
    ->setPayment('pay_95ba26ba2c613ebb0ca8');
    ->setCurrency('USD');
    ->setInterval('1 month,friday');
    ->setName('Changed Subscription');
    ->setPeriodOfValidity('14 MONTH');
    ->setTrialEnd(false);
    ->update();
```

```php
Paymill::Subscription('sub_dea86e5c65b2087202e3')
    ->setRemove(false);
    ->delete();
```

#### Views

You can use the `$paymill_public_key` variable across all blade views.

```php
<script type="text/javascript">
  var PAYMILL_PUBLIC_KEY = '{{ $paymill_public_key }}';
</script>  
```
