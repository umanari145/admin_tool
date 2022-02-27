<?php

namespace Tests\Feature;

use Tests\TestCase;
use Log;

class CsvControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCsvTest()
    {
        $response = $this->get('/api/csv/10');
        //Log::debug((array)$response['data']);
        $response->assertStatus(200);
    }

    /**
     * error
     *
     * @return void
     */
    public function testCsvError404Test()
    {
        $response = $this->get('/api/csv/');
        $response->assertStatus(404);
    }

    /**
     * error
     *
     * @return void
     */
    public function testCsvError400Test()
    {
        $response = $this->get('/api/csv/hogehoge');
        //dd((array)$response['data']);
        //Log::debug((array)$response['data']);
        $response->assertStatus(400);
    }
}
