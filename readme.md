# Laravel Gelf driver

laravel-gelf  graylog2/gelf-php implementation for laravel framework 5.7+

### Installation

composer install

```sh
$ composer require chameleon/laravel-gelf
```
### Config

`config/logging.php`
```php
 'graylog' => [
     'driver'     => 'laravel-gelf',
     'level'      => 'debug',
     'facility'   => 'laravel',
    //'formatter' => \Monolog\Formatter\GelfMessageFormatter::class,
     'connection' => [
         'type' => 'udp', // or tcp
         'host' => '127.0.0.1'
         'port' => 12201
     ],
     //additional fields
     'additional' => [
         'from_php' => true
     ]
 ],
```