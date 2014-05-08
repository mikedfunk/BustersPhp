<?php
/**
 * BustersPhp default config
 */
return array(

    /**
     * this would go before the file path if you have it in your template
     */
    'rootPath' => '//' . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ''),

    /**
     * the template used to create the css link tag
     */
    'cssTemplate' => '<link href="{{ROOT_PATH}}/{{FILE_PATH}}/{{FILE_NAME}}.{{HASH}}.css" rel="stylesheet">',

    /**
     * the template used to create the js script tag
     */
    'jsTemplate' => '<script src="{{ROOT_PATH}}/{{FILE_PATH}}/{{FILE_NAME}}.{{HASH}}.js"></script>',

    /**
     * path to busters.json
     */
    'bustersJsonPath' => $_SERVER['DOCUMENT_ROOT'] . '/assets/cache/busters.json',
);
