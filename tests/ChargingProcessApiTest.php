<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ChargingProcessApiTest extends TestCase
{
    /**
     * Test Rate Endpoint exist.
     *
     * @return void
     */
    public function testRateRouteEndpointExist(): void
    {    
        $response = $this->call('POST', 'api/rate');

        $this->assertEquals(200, $response->status());        
    }

    /**
     * Test Calculate Method
     *
     * @return void
     */
    public function testCalculateMethodReturnsComputedRate(): void
    {    
        $this->json('POST', '/api/rate', 
            [
                'cdr' => [
                    "meterStart" => 1204307, 
                    "timestampStart" => "2021-04-05T10:04:00Z",
                    "meterStop" => 1215230,
                    "timestampStop" => "2021-04-03T11:27:00Z"                 
                ]
            ])
             ->seeJson( 
                [
                    "overall" => "7.04",
                    "components" => [
                        "energy" => "3.277",
                        "time" => "2.767",
                        "transaction" => "1"
                    ]

                ]
        );

    }

}
