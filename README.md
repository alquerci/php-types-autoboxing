PHP types autoboxing
====================

An implementation of the experimental PHP extension [SPL Types](http://www.php.net/manual/book.spl-types.php).


Requirements
------------

PHP 5.3.3 or above (at least 5.3.4 recommended to avoid potential bugs)


Installation
------------

Using Composer, just add the following configuration to your `composer.json`:

``` json
{
    "require": {
        "instinct/types-autoboxing": "v1.0.0-BETA1"
    }
}
```

If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

``` sh
curl -sS https://getcomposer.org/installer | php
```

Now tell composer to download it by running the command:

``` bash
php composer.phar update instinct/types-autoboxing
```


Examples
--------

``` php
Bool::create($var); // Defined a new boolean type
$var = true;       // Assign it a new value
if ($var instanceof Bool) {
    // $var is always a Bool object
}
```


Contributing
------------

Fork the project, create a feature branch, and send us a pull request.

To ensure a consistent code base, you should make sure the code follows
the [Coding Standards](http://symfony.com/doc/master/contributing/code/standards.html)
which we borrowed from Symfony.

If you would like to help take a look at the [list of issues](https://github.com/alquerci/php-types-autoboxing/issues).


Contributors
------------

See the list of [contributors](https://github.com/alquerci/php-types-autoboxing/contributors) who participated in this project.


License
-------

This library is licensed under the MIT License - see the [LICENSE](https://github.com/alquerci/php-types-autoboxing/blob/master/LICENSE) file for details


Running Tests
-------------

You can run the unit tests with the following command:

``` sh
php composer.phar install --dev
phpunit
```
