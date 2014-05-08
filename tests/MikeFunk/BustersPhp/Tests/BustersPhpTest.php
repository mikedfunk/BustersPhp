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
        $json = '{"path/to/myfile.css": "4kfgkl2"}';
        $fileSystem
            ->shouldReceive('fileExists')
            ->andReturn(true)
            ->shouldReceive('getFile')
            ->andReturn($json);

        // set config and instantiate
        $config = array(
            'cssTemplate' => '{{ROOT_PATH}}/{{FILE_PATH}}/{{FILE_NAME}}.{{HASH}}.testcss'
        );
        $bustersPhp = new BustersPhp($config, $fileSystem);

        // ensure output is like template
        $this->assertEquals('//mysite.com/path/to/myfile.4kfgkl2.testcss', $bustersPhp->css());
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
        $json = '{"path/to/myfile.js": "4kfgkl2"}';
        $fileSystem
            ->shouldReceive('fileExists')
            ->andReturn(true)
            ->shouldReceive('getFile')
            ->andReturn($json);

        // set config and instantiate
        $config = array(
            'jsTemplate'  => '{{ROOT_PATH}}/{{FILE_PATH}}/{{FILE_NAME}}.{{HASH}}.testjs',
        );
        $bustersPhp = new BustersPhp($config, $fileSystem);

        // ensure output is like template
        $this->assertEquals('//mysite.com/path/to/myfile.4kfgkl2.testjs', $bustersPhp->js());
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
        $json = '{"path/to/my/js/my_js_file.js": "4kfgkl2", "path/to/my/css/my_css_file.css": "5kfgkl2"}';
        $fileSystem
            ->shouldReceive('fileExists')
            ->andReturn(true)
            ->shouldReceive('getFile')
            ->andReturn($json);

        // set template
        // call, ensure output is as expected
        $config = array(
            'jsTemplate'  => '{{ROOT_PATH}}/{{FILE_PATH}}/{{FILE_NAME}}.{{HASH}}.testjs',
            'cssTemplate'  => '{{ROOT_PATH}}/{{FILE_PATH}}/{{FILE_NAME}}.{{HASH}}.testcss',
        );
        $bustersPhp = new BustersPhp($config, $fileSystem);

        // ensure output is like template
        $expected = '//mysite.com/path/to/my/css/my_css_file.5kfgkl2.testcss'
            ."\n"
            .'//mysite.com/path/to/my/js/my_js_file.4kfgkl2.testjs';
        $this->assertEquals($expected, $bustersPhp->assets());
    }
}
