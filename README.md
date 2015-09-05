# ZfDisqus

[![Build Status](https://travis-ci.org/nikolaposa/ZfDisqus.svg?branch=master)](https://travis-ci.org/nikolaposa/ZfDisqus)

ZfDisqus is a [Zend Framework 2](http://framework.zend.com) integration of a [DisqusHelper][disqus-helper],
library which facilitates integration of [Disqus](https://disqus.com/websites) widgets.

## Installation

Install the library using [composer](http://getcomposer.org/). Add the following to your `composer.json`:

```json
{
    "require": {
        "nikolaposa/zf-disqus": "2.*"
    }
}
```

Tell composer to download ZfDisqus by running `install` command:

```bash
$ php composer.phar install
```

### Provide your Disqus *shortname* through configuration:

```php
<?php
return array(
    'disqus' => array(
        'shortname' => 'your_disqus_shortname'
        //any other Disqus config can be provided here
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

This module provides a `Disqus` view helper (`ZfDisqus\View\Helper\Disqus`) which is essentially a wrapper around the [DisqusHelper][disqus-helper].
Refer to the DisqusHelper project documenation for more information about available widget methods.

### Examples

Typical example would be in some application which uses layouts. Widgets should be rendered in specific templates,
while Disqus assets will be rendered somewhere in the layout, most commonly within the head or tail sections:

**Layout**
```html
<!-- layout.phtml -->
<html>
    <head>
        <title>Blog</title>
    </head>

    <body>
        <?php echo $this->content; ?>

        <!-- Disqus init invokation -->
        <?php echo $this->disqus()->init(); ?>
    </body>
</html>
```

**Template**
```html
<!-- post.phtml -->
<article>
    <h1><?php echo $this->escapeHtml($this->post->title); ?></h1>

    <?php echo $this->post->body; ?>
</article>

<div>
    <h2>Comments:</h2>
    <!-- Thread widget -->
    <?php echo $this->disqus()->thread(array('title' => $this->post->title, 'identifier' => 'article_' . $this->post->id)); ?>
</div>
```

[disqus-helper]: https://github.com/nikolaposa/disqus-helper