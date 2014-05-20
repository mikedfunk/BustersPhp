<?php
/**
 * Helper File System class to abstract file_exists and stuff for testing
 *
 * @package BustersPhp
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\BustersPhp\Support;

/**
 * FileSystem
 *
 * @author Michael Funk <mike@mikefunk.com>
 */
class FileSystem
{

    /**
     * pass through to file_exists
     *
     * @return boolean
     */
    public function fileExists($filePath)
    {
        return file_exists($filePath);
    }

    /**
     * pass through to require
     *
     * @param  string $filePath
     * @return string the file contents
     */
    public function getFile($filePath)
    {
        // return require $filePath;
        return file_get_contents($filePath);
    }
}
