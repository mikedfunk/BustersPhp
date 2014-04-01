<?php
/**
 * BustersPhp default config
 */
return array(

    /**
     * the template used to create the css link tag
     */
    'cssTemplate' => '<link href="{{FILE_PATH}}/{{FILE_NAME}}.{{HASH}}.css" rel="stylesheet">',

    /**
     * the template used to create the js script tag
     */
    'jsTemplate' => '<script src="{{FILE_PATH}}/{{FILE_NAME}}.{{HASH}}.js"></script>',

    /**
     * path to busters.json
     */
    'bustersJsonPath' => $_SERVER['DOCUMENT_ROOT'].'/assets/cache/busters.json',
);
