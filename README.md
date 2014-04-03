[![Build Status](https://travis-ci.org/mikedfunk/BustersPhp.png?branch=master)](https://travis-ci.org/mikedfunk/BustersPhp)
# BustersPhp

A simple class to generate js/css tags with cache names from busters.json. This is related to [gulp-buster](https://www.npmjs.org/package/gulp-buster).

## Usage

* use [gulp-buster](https://www.npmjs.org/package/gulp-buster) to generate combined css/js cache files with the hash as the file name
* add BustersPhp to your PHP application via composer: `composer require MikeFunk/BustersPhp:dev-develop`
* instantiate in your php with your config passed in:

```php
    use MikeFunk\BustersPhp\BustersPhp;

    // optional config array - if you want to set a custom config
    $config = array(
        'rootPath'        => $_SERVER['DOCUMENT_ROOT'],
        'cssTemplate'     => '<link href="{{ROOT_PATH}}/{{FILE_PATH}}/{{FILE_NAME}}.{{HASH}}.css" rel="stylesheet">',
        'jsTemplate'      => '<script src="{{ROOT_PATH}}/{{FILE_PATH}}/{{FILE_NAME}}.{{HASH}}.js"></script>',
        'bustersJsonPath' => $_SERVER['DOCUMENT_ROOT'].'/assets/cache/busters.json',
    );
    $bustersPhp = new BustersPhp($config);
```
* echo css/js in your view:

```php
    <!-- css link tag -->
    <?=$bustersPhp->css()?>

    <!-- js script tag -->
    <?=$bustersPhp->js()?>

    <!-- js tag and css tag -->
    <?=$bustersPhp->assets()?>
```

For more information check out [gulp-buster](https://www.npmjs.org/package/gulp-buster)
