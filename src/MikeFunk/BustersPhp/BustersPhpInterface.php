<?php
/**
 * BustersPhp Interface
 *
 * @package BustersPhp
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\BustersPhp;

/**
 * BustersPhpInterface
 *
 * @author Michael Funk <mike@mikefunk.com>
 */
interface BustersPhpInterface
{

    /**
     * return css link tag
     *
     * @return string
     */
    public function css();

    /**
     * return js script tag
     *
     * @return string
     */
    public function js();

    /**
     * return css and js
     *
     * @return string
     */
    public function assets();
}
