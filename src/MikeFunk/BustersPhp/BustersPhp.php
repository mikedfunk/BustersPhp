<?php
/**
 * Use busters.json to create css/js tags
 *
 * @package BustersPhp
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\BustersPhp;

use LengthException;
use MikeFunk\BustersPhp\Support\FileSystem;
use UnderflowException;
use UnexpectedValueException;

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
     * the file system instance
     *
     * @var FileSystem
     */
    protected $fileSystem;

    /**
     * get config if passed in. also ghetto dependency injection for mocking
     * the file system in testing.
     *
     * @param array           $config     (default: array())
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
     * return both css and js html tags
     *
     * @return string
     */
    public function assets()
    {
        return $this->asset('css')."\n".$this->asset('js');
    }

    /**
     * return css html link tag
     *
     * @return string
     */
    public function css()
    {
        return $this->asset('css');
    }

    /**
     * return js html script tag
     *
     * @return string
     */
    public function js()
    {
        return $this->asset('js');
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
     * abstracted single asset
     *
     * @param  string                   $type either 'css' or 'js'
     * @throws LengthException          if the busters.json file is not found
     * @throws UnderflowException       if the busters.json file contents are empty
     * @throws UnexpectedValueException if the busters.json has text but is not
     *                                       valid json
     * @return string
     */
    protected function asset($type)
    {
        $busters = $this->checkAndGetBusters();

        // get busters.json hash for item of this type mapped down to this type
        // only
        $bustersOfThisType = array();
        foreach ($busters as $key => $value) {
            if (strpos($key, $type) !== false) {
                $bustersOfThisType[$key] = $value;
            }
        }

        $busterStrings = $this->parseTags($bustersOfThisType, $type);

        return implode("\n", $busterStrings);
    }

    /**
     * Check for errors in busters.json
     *
     * @throws LengthException          if the busters.json file is not found
     * @throws UnderflowException       if the busters.json file contents are empty
     * @throws UnexpectedValueException if the busters.json has text but is not
     * @return array                    the parsed json in busters.json
     */
    protected function checkAndGetBusters()
    {
        // if no bustersJson, exception
        if ($this->fileSystem->fileExists($this->config['bustersJsonPath']) === false) {
            throw new LengthException('busters json not found.');
        }

        // get busters json and decode it
        $bustersJson = $this->fileSystem->getFile($this->config['bustersJsonPath']);
        if ($bustersJson == '') {
            throw new UnderflowException('busters json is empty.');
        }
        $busters = json_decode($bustersJson);

        // is it valid json?
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new UnexpectedValueException('bustersJson is invalid JSON.');
        }

        return $busters;
    }

    /**
     * Replace the tags in the template with the actual values
     *
     * @param  array  $bustersOfThisType
     * @param  string $type              css or js
     * @return array
     */
    protected function parseTags(array $bustersOfThisType, $type)
    {

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

        return $busterStrings;
    }
}
