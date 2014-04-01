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
use Mockery;

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
        // mock getFile to return test json
        $fileSystem = Mockery::mock('MikeFunk\BustersPhp\Support\FileSystem');
        $json = '{"myfile.css": "4kfgkl2"}';
        $fileSystem
            ->shouldReceive('fileExists')
            ->andReturn(true)
            ->shouldReceive('getFile')
            ->andReturn($json);

        // set config and instantiate
        $config = array(
            'cssBasePath' => 'mypath',
            'cssTemplate' => '{{CSS_BASE_PATH}}/{{HASH}}.testcss'
        );
        $bustersPhp = new BustersPhp($config, $fileSystem);

        // ensure output is like template
        $this->assertEquals('mypath/4kfgkl2.testcss', $bustersPhp->css());
    }

    /**
     * fail with no busters.json
     *
     * @expectedException Exception
     * @return void
     */
    public function testCssFailNoBustersJsonFile()
    {
        // mock fileExists to return false
        $fileSystem = Mockery::mock('MikeFunk\BustersPhp\Support\FileSystem');
        $fileSystem->shouldReceive('fileExists')->andReturn(false);

        // instantiate, run css(), ensure exception thrown
        $bustersPhp = new BustersPhp(array(), $fileSystem);
        $throwExceptionHere = $bustersPhp->css();
    }

    /**
     * empty no css in busters.json
     *
     * @return void
     */
    public function testCssEmptyNoCssInBustersJson()
    {
        // mock getFile to return test json
        $fileSystem = Mockery::mock('MikeFunk\BustersPhp\Support\FileSystem');
        $json = '{"myfile.js": "4kfgkl2"}';
        $fileSystem
            ->shouldReceive('fileExists')
            ->andReturn(true)
            ->shouldReceive('getFile')
            ->andReturn($json);

        // instantiate
        $bustersPhp = new BustersPhp(array(), $fileSystem);

        // ensure result is empty
        $result = $bustersPhp->css();
        $this->assertEquals('', $result);
    }

    /**
     * test js method
     *
     * @return void
     */
    public function testJsSuccess()
    {
        // mock getFile to return test json
        $fileSystem = Mockery::mock('MikeFunk\BustersPhp\Support\FileSystem');
        $json = '{"myfile.js": "4kfgkl2"}';
        $fileSystem
            ->shouldReceive('fileExists')
            ->andReturn(true)
            ->shouldReceive('getFile')
            ->andReturn($json);

        // set config and instantiate
        $config = array(
            'jsBasePath'  => 'mypath',
            'jsTemplate'  => '{{JS_BASE_PATH}}/{{HASH}}.js',
        );
        $bustersPhp = new BustersPhp($config, $fileSystem);

        // ensure output is like template
        $this->assertEquals('mypath/4kfgkl2.js', $bustersPhp->js());
    }

    /**
     * empty no js in busters.json
     *
     * @return void
     */
    public function testJsEmptyNoJsInBustersJson()
    {
        // mock getFile to return test json
        $fileSystem = Mockery::mock('MikeFunk\BustersPhp\Support\FileSystem');
        $json = '{"myfile.css": "4kfgkl2"}';
        $fileSystem
            ->shouldReceive('fileExists')
            ->andReturn(true)
            ->shouldReceive('getFile')
            ->andReturn($json);

        // instantiate
        $bustersPhp = new BustersPhp(array(), $fileSystem);

        // ensure result is empty
        $result = $bustersPhp->js();
        $this->assertEquals('', $result);
    }

    /**
     * test assets method
     *
     * @return void
     */
    public function testAssets()
    {
        // mock getFile to return test json
        $fileSystem = Mockery::mock('MikeFunk\BustersPhp\Support\FileSystem');
        $json = '{"myfile.js": "4kfgkl2", "myfile.css": "5kfgkl2"}';
        $fileSystem
            ->shouldReceive('fileExists')
            ->andReturn(true)
            ->shouldReceive('getFile')
            ->andReturn($json);

        // set template
        // call, ensure output is as expected
        $config = array(
            'jsBasePath' => 'jspath',
            'cssBasePath' => 'csspath',
            'jsTemplate'  => '{{JS_BASE_PATH}}/{{HASH}}.js',
            'cssTemplate' => '{{CSS_BASE_PATH}}/{{HASH}}.css',
        );
        $bustersPhp = new BustersPhp($config, $fileSystem);

        // ensure output is like template
        $expected = 'csspath/5kfgkl2.css'."\n".'jspath/4kfgkl2.js';
        $this->assertEquals($expected, $bustersPhp->assets());
    }
}
