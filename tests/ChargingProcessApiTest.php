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
        $response = $this->call('POST', 'api/rate');

        $this->assertEquals(200, $response->status());        

    }

}
