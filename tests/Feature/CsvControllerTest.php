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
        $updateData = [
            'id' => '1',
            'field_name' => 'testtest',
            'field_disp_name' => 'aaaaa',
            'is_required' => 1
        ];
        $data = [
            'updateData' => $updateData
        ];
        $response = $this->put('/api/csv_field/1', $data);
        $response->assertStatus(200);

        $updateData = [
            'id' => '1',
            'field_name' => null,
            'field_disp_name' => null,
            'is_required' => 0
        ];

        $data = [
            'updateData' => $updateData
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
        $updateData = [
            'id' => '1',
            'field_name' => null,
            'is_required' => 0
        ];
        
        $data = [
            'updateData' => $updateData
        ];
        $response = $this->put('/api/csv_field/1', $data);
        $response->assertStatus(400);
    }
}
