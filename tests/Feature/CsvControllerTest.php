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
     * CSVフィールドの更新
     *
     * @return void
     */
    public function testCsvField()
    {
        $data = [
            'key' => 'field_name',
            'data' => 'test'
        ];
        $response = $this->put('/api/csv_field/1', $data);
        $response->assertStatus(200);

        $data = [
            'key' => 'field_name',
            'data' => null
        ];
        $response = $this->put('/api/csv_field/1', $data);
        $response->assertStatus(200);
    }

    /**
     * CSVフィールドの更新(validation error)
     *
     * @return void
     */
    public function testCsvFieldError400()
    {
        $data = [
            'key' => 'field_name'
        ];
        $response = $this->put('/api/csv_field/1', $data);
        $response->assertStatus(400);
    }

    /**
     * CSVフィールドの更新(500error)
     *
     * @return void
     */
    public function testCsvFieldError500()
    {
        $data = [
            'key' => 'field_n',
            'data' => 'aaaa'
        ];
        $response = $this->put('/api/csv_field/1', $data);
        $response->assertStatus(500);
    }
}
