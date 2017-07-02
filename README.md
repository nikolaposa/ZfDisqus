# ZfDisqus

[![Build Status][ico-build]][link-build]
[![Code Quality][ico-code-quality]][link-code-quality]
[![Code Coverage][ico-code-coverage]][link-code-coverage]
[![Latest Version][ico-version]][link-packagist]

ZF module which facilitates integration of [Disqus](https://disqus.com/websites) widgets.

## Installation

The preferred method of installation is via [Composer](http://getcomposer.org/). Run the following command to install the latest version of a package and add it to your project's `composer.json`:

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

This module provides a `Disqus` view helper (`ZfDisqus\View\Helper\Disqus`) which is essentially a wrapper around the [DisqusHelper][link-disqus-helper]. Refer to the DisqusHelper project documenation for more information about available widget methods.

### Examples

Typical example would be in some application which uses layouts. Widgets should be rendered in specific templates, while Disqus assets will be rendered somewhere in the layout, most commonly within the head or tail sections:

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

## Credits

- [Nikola Poša][link-author]
- [All Contributors][link-contributors]

## License

Released under MIT License - see the [License File](LICENSE) for details.

[ico-version]: https://img.shields.io/packagist/v/nikolaposa/zf-disqus.svg
[ico-build]: https://travis-ci.org/nikolaposa/ZfDisqus.svg?branch=master
[ico-code-coverage]: https://img.shields.io/scrutinizer/coverage/g/nikolaposa/ZfDisqus.svg?b=master
[ico-code-quality]: https://img.shields.io/scrutinizer/g/nikolaposa/ZfDisqus.svg?b=master

[link-packagist]: https://packagist.org/packages/nikolaposa/zf-disqus
[link-build]: https://travis-ci.org/nikolaposa/ZfDisqus
[link-code-coverage]: https://scrutinizer-ci.com/g/nikolaposa/ZfDisqus/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/nikolaposa/ZfDisqus
[link-disqus-helper]: https://github.com/nikolaposa/disqus-helper
[link-author]: https://github.com/nikolaposa
[link-contributors]: ../../contributors
