<?php

namespace App\Tests\Controller;


class ApiControllerTest extends ApiTestCase
{
    /**
     * Test if create new transaction successfully
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function testNewTransaction()
    {
        $response = $this->client->request('POST', '/api/transaction/new', [
            'auth_bearer' => $this->token,
            'body' => json_encode([
                'amount' => 100,
            ])
        ]);

        $responseStatus = $response->getStatusCode();
        $this->assertEquals(201, $responseStatus);
    }



}