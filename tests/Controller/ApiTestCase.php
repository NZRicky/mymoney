<?php


namespace App\Tests\Controller;

use Symfony\Component\HttpClient\HttpClient;

class ApiTestCase extends \PHPUnit_Framework_TestCase
{
    private static $staticClient;
    protected static $siteUrl;
    protected $client;

    public static function setUpBeforeClass()
    {
        self::$siteUrl = getenv('SITE_URL');
        self::$staticClient = HttpClient::create();
    }



}