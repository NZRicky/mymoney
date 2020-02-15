<?php

namespace App\Tests\Controller;


class ApiControllerTest extends ApiTestCase
{
    public function testNew()
    {
        $response = $this->client->request('POST', '/api/transaction/new', [
            'body' => json_encode([
                'aa' => 'dd'
            ])
        ]);


        $responseStatus = $response->getStatusCode();
        $this->assertEquals(200, $responseStatus);

    }

}