<?php


namespace App\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\HttpClient\HttpClient;

class ApiTestCase extends TestCase
{
    private static $staticClient;
    protected static $siteUrl;
    protected $client;
    protected $token;

    public static function setUpBeforeClass()
    {
        self::$siteUrl = 'http://mymoney.local';
        self::$staticClient = HttpClient::create([
            'base_uri' => 'http://web',
            'headers' => [
                'Content-Type' => 'application/json'
            ],
        ]);
    }

    protected function setUp()
    {
        $this->client = self::$staticClient;

        $response = $this->client->request('POST', '/api/auth/login', [

            'body' => json_encode([
                'username' => 'admin',
                'password' => 'admin'
            ])
        ]);

        $responseData = json_decode($response->getContent(), true);

        if ($response->getStatusCode() === 200
            && isset($responseData['token'])
            && $responseData['token']) {
            return $this->token = $responseData['token'];
        }


    }


}