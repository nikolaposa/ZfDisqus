# ZfDisqus

ZfDisqus is a [Zend Framework 2](http://framework.zend.com) module which facilitates integration of
[Disqus](https://disqus.com/websites) widgets.

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

### Provide your Disqus *shortname* through configuration:

```php
<?php
return array(
    'disqus' => array(
        'shortname' => 'your_disqus_shortname'
    ),
    // ...
);
```

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

This module provides a `Disqus` view helper (`ZfDisqus\View\Helper\Disqus`) which is a main entry point for invoking concrete Disqus widgets.
Two widgets are currently supported:
* **Thread** (`ZfDisqus\View\Helper\Disqus\Thread`) - renders the Disqus comments thread
* **CommentsCount** (`ZfDisqus\View\Helper\Disqus\CommentsCount`) - renders link along with number of comments for some page ([more info](https://help.disqus.com/customer/portal/articles/565624-tightening-your-disqus-integration))

IMPORTANT: By default, this module uses `InlineScript` container for the purpose of loading necessary JS code, thus you must invoke that helper in your layout:
```php
echo $this->inlineScript();
```

### Examples

```php
echo $this->disqus()->thread(array('title' => 'My article', 'identifier' => 'article1'));

echo $this->disqus()->commentsCount(
    array('shortname' => 'custom_shortname'), //JS config options if any
    array(
        //Options for the Url helper which is internally used for rendering actual URL
        'url' => array(
            'name' => 'article/view',
            'params' => array('id' => 1),
            'options' => array('query' => array('p' => 3)),
            'reuseMatchedParams' => true
        ),
        //options specific to the comments count widget itself
        'identifier' => 'article1',
        'label' => 'Comments'
    )
);
```
