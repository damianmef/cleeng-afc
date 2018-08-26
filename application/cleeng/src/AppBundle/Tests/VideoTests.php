<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 22.08.18
 * Time: 23:50
 */
/* vendor/bin/phpunit --bootstrap vendor/autoload.php src/AppBundle/Tests/VideoTests.php */
namespace AppBundle\Tests;

use AppBundle\Model\ProcessResponseObject;
use AppBundle\Model\Video\VideoProcess;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class VideoTests extends KernelTestCase
{
    /**
     * @var VideoProcess $videoProcess
     */
    protected $videoProcess;

    /**
     * @var ProcessResponseObject $result
     */
    protected $result;

    /**
     * @var Client $http
     */
    protected $http;

    protected function setUp()
    {
        self::bootKernel();

        $this->videoProcess = static::$kernel->getContainer()
            ->get(VideoProcess::class);

        $this->http = new Client(['base_uri' => 'http://cleeng.local/']);
    }

    public function runSetUp()
    {
        $this->setUp();
    }


    public function testGetVideos()
    {
        $this->result = $this->videoProcess->getItems();
        $this->assertEquals(true, $this->result->getStatus());
        $this->assertNotEmpty($this->result->getData());
    }

    public function testAddVideo()
    {
        $response = $this->http->request('POST', 'api/video', [
            'form_params' => [
                'video-title' => 'Test one',
                'video-url' => 'Test url',
                'video-subscription' => 7,
                'test' => true
            ]
        ]);
        $result = json_decode($response->getBody()->read(80), true);
        $this->assertEquals(true, $result['status']);
        $this->assertEquals('Item was added succesfull', $result['msg']);
    }


    public function testEditVideo()
    {
        $response = $this->http->request('PUT', 'api/video/999', [
            'form_params' => [
                'video-title' => 'Test one',
                'video-url' => 'Test url',
                'video-subscription' => 6,
                'id' => 9999,
                'test' => true
            ]
        ]);
        $result = json_decode($response->getBody()->read(180), true);
        $this->assertEquals(true, $result['status']);
        $this->assertEquals('Item was updated succesfull', $result['msg']);
    }
}
