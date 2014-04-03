<?php
/**
 * Use busters.json to create css/js tags
 *
 * @package BustersPhp
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\BustersPhp;

use Exception;
use MikeFunk\BustersPhp\Support\FileSystem;

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
     * get config if passed in. also ghetto dependency injection for mocking
     * the file system in testing.
     *
     * @param array $config (default: array())
     * @param null|FileSystem $fileSystem optional dependency injection
     */
    public function __construct(array $config = array(), $fileSystem = null)
    {
        // combine any passed in config with default config
        $this->config = array_merge($this->getConfig(), $config);

        // inject fileSystem or instantiate it
        // @codeCoverageIgnoreStart
        if ($fileSystem) {
            $this->fileSystem = $fileSystem;
        } else {
            $this->fileSystem = new FileSystem;
        }
        // @codeCoverageIgnoreEnd
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
        if (!$this->fileSystem->fileExists($this->config['bustersJsonPath'])) {
            throw new Exception('busters json not found');
        }

        // get busters json and decode it
        $bustersJson = $this->fileSystem->getFile($this->config['bustersJsonPath']);
        $busters = json_decode($bustersJson);

        // get busters.json hash for item of this type mapped down to this type
        // only
        $bustersOfThisType = array();
        foreach ($busters as $key => $value) {
            if (strpos($key, $type) !== false) {
                $bustersOfThisType[$key] = $value;
            }
        }

        // add to array and implode to string
        $busterStrings = array();
        foreach ($bustersOfThisType as $fileName => $hash) {

            // get config
            $template     = $this->config[$type.'Template'];
            $rootPath     = $this->config['rootPath'];
            $pathInfo     = pathInfo($fileName);
            $fileBasePath = $pathInfo['dirname'];
            $fileBaseName = $pathInfo['filename'];

            // replace stuff
            $template        = str_replace('{{ROOT_PATH}}', $rootPath, $template);
            $template        = str_replace('{{HASH}}', $hash, $template);
            $template        = str_replace('{{FILE_PATH}}', $fileBasePath, $template);
            $template        = str_replace('{{FILE_NAME}}', $fileBaseName, $template);
            $busterStrings[] = $template;
        }
        return implode($busterStrings, "\n");
    }

    /**
     * return both tags
     *
     * @return string
     */
    public function assets()
    {
        return $this->asset('css')."\n".$this->asset('js');
    }
}
