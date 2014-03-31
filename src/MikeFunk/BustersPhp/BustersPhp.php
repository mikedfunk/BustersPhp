<?php
/**
 * Use busters.json to create css/js tags
 *
 * @package BustersPhp
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\BustersPhp;

use Exception;

/**
 * BustersPhp
 *
 * @author Michael Funk <mike@mikefunk.com>
 */
class BustersPhp implements BustersPhpInterface
{
    /**
     * config location
     *
     * @var CONFIG_LOCATION
     */
    const CONFIG_LOCATION = '/../../Config/Config.php';

    /**
     * config array
     *
     * @var array
     */
    protected $config;

    /**
     * get config if passed in
     *
     * @param array $config (default: array())
     */
    public function __construct(array $config = array())
    {
        $this->config = array_merge($this->getConfig(), $config);
    }

    /**
     * get config array
     *
     * @return array
     */
    protected function getConfig()
    {
        return require __DIR__.self::CONFIG_LOCATION;
    }

    /**
     * return css link tag
     *
     * @return string
     */
    public function css()
    {
        return $this->asset('css');
    }

    /**
     * return js script tag
     *
     * @return string
     */
    public function js()
    {
        return $this->asset('js');
    }

    /**
     * abstracted single asset
     *
     * @param string $type either 'css' or 'js'
     * @return string
     */
    protected function asset($type)
    {
        // if no bustersJson, exception
        if (!array_key_exists('bustersJson', $this->config)) {
            throw new Exception('busters json not found');
        }


        // get busters.json hash for item of this type
        $hash = '';
        $bustersJson = json_decode($this->config['bustersJson']);
        foreach ($bustersJson as $key => $value) {
            if (strpos($key, $type) !== false) {
                $hash = $value;
                break;
            }
        }

        // if no $type in bustersJson, throw exception
        if (!$hash) {
            throw new Exception('no entries of type '.$type.' found.');
        }

        // render
        $template    = $this->config[$type.'Template'];
        $template    = str_replace('{{HASH}}', $hash, $template);
        $basePath    = $this->config[$type.'BasePath'];
        $templateVar = '{{'.strtoupper($type).'_BASE_PATH}}';
        $return      = str_replace($templateVar, $basePath, $template);
        return $return;
    }

    /**
     * return both tags
     *
     * @return string
     */
    public function assets()
    {
        return $this->asset('js')."\n".$this->asset('css');
    }
}
