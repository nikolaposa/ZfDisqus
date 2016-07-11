# ZfDisqus

[![Build Status](https://travis-ci.org/nikolaposa/ZfDisqus.svg?branch=master)](https://travis-ci.org/nikolaposa/ZfDisqus)

ZfDisqus is a [Zend Framework 2](http://framework.zend.com) integration of a [DisqusHelper][disqus-helper],
library which facilitates integration of [Disqus](https://disqus.com/websites) widgets.

## Installation

The preferred method of installation is via [Composer](http://getcomposer.org/). Run the following
command to install the latest version of a package and add it to your project's `composer.json`:

```bash
composer require nikolaposa/zf-disqus
```

### Provide your Disqus *shortname* through configuration:

```php
<?php
return [
    'disqus' => [
        'shortname' => 'your_disqus_shortname'
        //any other Disqus config can be provided here
    ],
    // ...
];
```

### Enable the module in your `application.config.php`:

```php
<?php
return [
    'modules' => [
        // ...
        'ZfDisqus',
    ],
    // ...
];
```

## Usage

This module provides a `Disqus` view helper (`ZfDisqus\View\Helper\Disqus`) which is essentially a wrapper around the [DisqusHelper][disqus-helper].
Refer to the DisqusHelper project documenation for more information about available widget methods.

### Examples

Typical example would be in some application which uses layouts. Widgets should be rendered in specific templates,
while Disqus assets will be rendered somewhere in the layout, most commonly within the head or tail sections:

**Template**
```html
<!-- post.phtml -->

<?php
    //Page-specific Disqus configuration
    $this->disqus()->configure([
        'identifier' => 'article_' . $this->post->id
        'title' => $this->post->title,
    ]);
?>

<article>
    <h1><?php echo $this->escapeHtml($this->post->title); ?></h1>

    <?php echo $this->post->body; ?>
</article>

<div>
    <h2>Comments:</h2>
    <!-- Thread widget HTML -->
    <?php echo $this->disqus()->thread(); ?>
</div>
```

**Layout**
```html
<!-- layout.phtml -->
<html>
    <head>
        <title>Blog</title>
    </head>

    <body>
        <?php echo $this->content; ?>

        <!-- Render Disqus JS code -->
        <?php echo $this->disqus(); ?>
    </body>
</html>
```

## Author

**Nikola Poša**

* https://twitter.com/nikolaposa
* https://github.com/nikolaposa

## Copyright and license

Copyright 2016 Nikola Poša. Released under MIT License - see the `LICENSE` file for details.

[disqus-helper]: https://github.com/nikolaposa/disqus-helper