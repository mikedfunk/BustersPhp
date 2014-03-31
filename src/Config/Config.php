<?php
/**
 * BustersPhp default config
 */
return array(
    /**
     * the path to the css cache folder
     */
    'cssBasePath' => $_SERVER['DOCUMENT_ROOT'].'/assets/cache/',

    /**
     * the template used to create the css link tag
     */
    'cssTemplate' => '<link href="{{CSS_BASE_PATH}}{{FILE_NAME}}.{{HASH}}.css" rel="stylesheet">',

    /**
     * the path to the js cache folder
     */
    'jsBasePath' => $_SERVER['DOCUMENT_ROOT'].'/assets/cache/',

    /**
     * the template used to create the js script tag
     */
    'jsTemplate' => '<script src="{{JS_BASE_PATH}}{{FILE_NAME}}.{{HASH}}.js"></script>',

    /**
     * path to busters.json
     */
    'bustersJsonPath' => $_SERVER['DOCUMENT_ROOT'].'/assets/cache/busters.json',
);
