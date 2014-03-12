<?php
/**
 * Test BustersPhp methods
 *
 * @package BustersPhp
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\BustersPhp\Tests;

use Exception;
use MikeFunk\BustersPhp\BustersPhp;

/**
 * BustersPhpTest
 *
 * @author Michael Funk <mike@mikefunk.com>
 */
class BustersPhpTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The BustersPhp class
     *
     * @var BustersPhp
     */
    protected $bustersPhp;

    /**
     * construct
     *
     * @return void
     */
    public function setUp()
    {
        $this->bustersPhp = new BustersPhp;
    }

    /**
     * test css method
     *
     * @return void
     */
    public function testCssSuccess()
    {
        // call css
        $config = array(
            'cssBasePath' => 'mypath',
            'cssTemplate' => '{{CSS_BASE_PATH}}{{HASH}} test',
            'bustersJson' => '{"myfile.css": "4kfgkl2"}',
        );
        $bustersPhp = new BustersPhp($config);

        // ensure output is like template
        $this->assertEquals($bustersPhp->css(), 'mypath4kfgkl2 test');
    }

    /**
     * fail with no busters.json
     *
     * @expectedException Exception
     * @return void
     */
    public function testCssFailNoBustersJson()
    {
        $bustersPhp = new BustersPhp(array());
        $noWay = $bustersPhp->css();
    }

    /**
     * fail with no css in busters.json
     *
     * @expectedException Exception
     * @return void
     */
    public function testCssFailNoCssInBustersJson()
    {
        $bustersPhp = new BustersPhp(array('bustersJson' => '{}'));
        $noWay = $bustersPhp->css();
    }

    /**
     * test js method
     *
     * @return void
     */
    public function testJsSuccess()
    {
        // call js
        $config = array(
            'jsBasePath'  => 'mypath',
            'jsTemplate'  => '{{HASH}} test',
            'bustersJson' => '{"myfile.js": "4kfgkl2"}',
        );
        $bustersPhp = new BustersPhp($config);

        // ensure output is like template
        $this->assertEquals($bustersPhp->js(), '4kfgkl2 test');
    }

    /**
     * fail with no busters.json
     *
     * @expectedException Exception
     * @return void
     */
    public function testJsFailNoBustersJson()
    {
        $bustersPhp = new BustersPhp(array());
        $noWay      = $bustersPhp->js();
    }

    /**
     * fail with no js in busters.json
     *
     * @expectedException Exception
     * @return void
     */
    public function testJsFailNojsInBustersJson()
    {
        $bustersPhp = new BustersPhp(array('bustersJson' => '{}'));
        $noWay = $bustersPhp->js();
    }

    /**
     * test assets method
     *
     * @return void
     */
    public function testAssets()
    {
        // set template
        // call, ensure output is as expected
        $json = '{"myfile.js": "4kfgkl2", "myfile.css": "5kfgkl2"}';
        $config = array(
            'jsTemplate'  => '{{HASH}} test',
            'cssTemplate' => '{{HASH}} test2',
            'bustersJson' => $json,
        );
        $bustersPhp = new BustersPhp($config);

        // ensure output is like template
        $expected = '4kfgkl2 test'."\n".'5kfgkl2 test2';
        $this->assertEquals($expected, $bustersPhp->assets());
    }
}
