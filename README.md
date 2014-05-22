[![Build Status](https://travis-ci.org/mikedfunk/BustersPhp.png?branch=master)](https://travis-ci.org/mikedfunk/BustersPhp)
# BustersPhp

A simple class to generate js/css tags with cache names from busters.json. If you use [gulp-buster](https://www.npmjs.org/package/gulp-buster) to create a busters.json, it will look something like this:

```javascript
{
    "path/to/app.min.css": "f77f5bee5ef6a19bf63fe66aa0971576",
    "path/to/app.min.js": "03cbc5dc0b5b117264ae74515cd3fb76"
}
```

Then you can put ```<?=$bustersPhp->assets()?>``` in your view and it will display like this:

```html
<link href="//mysite.com/path/to/app.min.f77f5bee5ef6a19bf63fe66aa0971576.css" rel="stylesheet">
<script src="//mysite.com/path/to/app.min.03cbc5dc0b5b117264ae74515cd3fb76.js"></script>
```

## Installation

[Get composer](http://getcomposer.org), then put this in your `composer.json` in the "require" block:

```json
"mikefunk/bustersphp": "1.1.*"
```

then run `composer update`.

## Usage

* use [gulp-buster](https://www.npmjs.org/package/gulp-buster) to generate combined css/js cache files with the hash as the file name
* add BustersPhp to your PHP application via composer: `composer require MikeFunk/BustersPhp:dev-develop`
* instantiate in your php with your config passed in:

```php
    <?php
    use MikeFunk\BustersPhp\BustersPhp;

    // optional config array - if you want to set a custom config
    $config = array(
        'rootPath'        => '//'.$_SERVER['HTTP_HOST'],
        'cssTemplate'     => '<link href="{{ROOT_PATH}}/{{FILE_PATH}}/{{FILE_NAME}}.{{HASH}}.css" rel="stylesheet">',
        'jsTemplate'      => '<script src="{{ROOT_PATH}}/{{FILE_PATH}}/{{FILE_NAME}}.{{HASH}}.js"></script>',
        'bustersJsonPath' => $_SERVER['DOCUMENT_ROOT'].'/assets/cache/busters.json',
    );
    $bustersPhp = new BustersPhp($config);
```
* echo css/js in your view:

```php
    <!-- css link tagss -->
    <?=$bustersPhp->css()?>

    <!-- js script tags -->
    <?=$bustersPhp->js()?>

    <!-- js tags and css tags -->
    <?=$bustersPhp->assets()?>
```

For more information check out [gulp-buster](https://www.npmjs.org/package/gulp-buster)
