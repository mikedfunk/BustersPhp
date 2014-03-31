<?php
/**
 * Laravel Service Provider for BustersPhp
 *
 * @package BustersPhp
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\BustersPhp;

use Illuminate\Support\ServiceProvider;

/**
 * BustersPhpServiceProvider
 *
 * @author Michael Funk <mike@mikefunk.com>
 */
class BustersPhpServiceProvider extends ServiceProvider
{

    /**
     * Bind the interface to the implementation
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'MikeFunk\BustersPhp\BustersPhpInterface',
            'MikeFunk\BustersPhp\BustersPhp'
        );
    }
}
