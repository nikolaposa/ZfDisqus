# ZfDisqus

ZfDisqus is a [Zend Framework 2](http://framework.zend.com) module which facilitates integration of
Disqus services (https://disqus.com/websites).

## Installation

You can install this module either by cloning this project into your `./vendor/` directory,
or using composer, which is more recommended:

Add this project into your composer.json:

```json
"require": {
    "nikolaposa/zf-disqus": "dev-master"
}
```

Tell composer to download ZfDisqus by running update command:

```bash
$ php composer.phar update
```

For more information about composer itself, please refer to [getcomposer.org](http://getcomposer.org/).

### Enable the module in your `application.config.php`:

```php
<?php
return array(
    'modules' => array(
        // ...
        'ZfDisqus',
    ),
    // ...
);
```

## Usage



