<?php


namespace App\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\HttpClient\HttpClient;

/**
 * Base class for all API request test
 * @package App\Tests\Controller
 */
class ApiTestCase extends TestCase
{
    private static $staticClient;
    protected static $siteUrl;
    protected $client;
    protected $token;

    public static function setUpBeforeClass()
    {
        self::$staticClient = HttpClient::create([
            'base_uri' => 'http://web',
            'headers' => [
                'Content-Type' => 'application/json'
            ],
        ]);
    }

    /**
     * Get jwt token for each request
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    protected function setUp()
    {
        $this->client = self::$staticClient;

        // get jwt token before test
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