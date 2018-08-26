<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 25.08.18
 * Time: 23:03
 */
/* vendor/bin/phpunit --bootstrap vendor/autoload.php src/AppBundle/Tests/SubscriptionTests.php */
namespace AppBundle\Tests;

use AppBundle\Model\ProcessResponseObject;
use AppBundle\Model\Subscription\SubscriptionProcess;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SubscriptionTests extends KernelTestCase
{
    /**
     * @var SubscriptionProcess $subscriptionProcess
     */
    protected $subscriptionProcess;

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

        $this->subscriptionProcess = static::$kernel->getContainer()
            ->get(SubscriptionProcess::class);

        $this->http = new Client(['base_uri' => 'http://cleeng.local/']);
    }

    public function runSetUp()
    {
        $this->setUp();
    }

    public function testGetSubscriptions()
    {
        $this->result = $this->subscriptionProcess->getItems();
        $this->assertEquals(true, $this->result->getStatus());
        $this->assertNotEmpty($this->result->getData());
    }

    public function testAddSubscription()
    {
        $response = $this->http->request('POST', 'api/subscription', [
            'form_params' => [
                'subscription-title' => 'Test title',
                'subscription-name' => 'Test subscription',
                'subscription-parent' => 999,
                'test' => true
            ]
        ]);
        $result = json_decode($response->getBody()->read(80), true);
        $this->assertEquals(true, $result['status']);
        $this->assertEquals('Item was added succesfull', $result['msg']);
    }


    public function testSubscriptionEdit()
    {
        $response = $this->http->request('PUT', 'api/subscription/999', [
            'form_params' => [
                'subscription-title' => 'Test title',
                'subscription-name' => 'Test subscription',
                'subscription-parent' => 999,
                'id' => 9999,
                'test' => true
            ]
        ]);
        $result = json_decode($response->getBody()->read(180), true);
        $this->assertEquals(true, $result['status']);
        $this->assertEquals('Item was updated succesfull', $result['msg']);
    }
}