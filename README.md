# BustersPhp

A simple class to generate js/css tags with cache names from busters.json. This is related to [gulp-buster](https://www.npmjs.org/package/gulp-buster).

## Usage

* use [gulp-buster](https://www.npmjs.org/package/gulp-buster) to generate combined css/js cache files with the hash as the file name
* add BustersPhp to your PHP application via composer: `composer require MikeFunk/BustersPhp`
* instantiate in your php with your config passed in:

```php
    use MikeFunk\BustersPhp\BustersPhp;

    $config = array(
        // bustersJson is required! Everything else has defaults that can be
        // overridden.
        'bustersJson' => '{"whatever.css" => "3g3kf1", "myscript.js" => "hgok230"}',
        'cssBasePath' => '/path/to/css/cache',
        'jsBasePath'  => '/path/to/js/cache',
        'cssTemplate' => '<link href="{{CSS_BASE_PATH}}{{HASH}}.min.css">',
        'jsTemplate'  => '<script src="{{JS_BASE_PATH}}{{HASH}}.min.js"></script>',
    );
    $bustersPhp = new BustersPhp($config);
```
* echo css/js in your view:

```php
    <!-- css link tag -->
    <?=$bustersJson->css()?>

    <!-- js script tag -->
    <?=$bustersJson->js()?>

    <!-- js tag and css tag -->
    <?=$bustersJson->assets()?>
```

For more information check out [gulp-buster](https://www.npmjs.org/package/gulp-buster)
