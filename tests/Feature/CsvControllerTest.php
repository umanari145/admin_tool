<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CsvField;
use App\Models\User;
use Tests\TestKit;
use Log;

class CsvControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $users = User::factory()->create()->toArray();
        $test_kit = new TestKit();
        $access_token = $test_kit->getToken();
        $this->headers = $test_kit->getHeadersIncToken($access_token);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCsvTest()
    {
        $response = $this->getJson('/api/csv_category/10');
        $response->assertStatus(401);

        $response = $this->getJson('/api/csv_category/10', $this->headers);
        //Log::debug((array)$response['data']);
        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRegistCsvFieldTest()
    {
        $data = [];

        $updateData = [
            'field_name' => 'code',
            'field_disp_name' => '品番',
            'is_required' => 1
        ];

        $data[] = $updateData;

        $updateData = [
            'field_name' => 'code2',
            'field_disp_name' => '元品番',
            'is_required' => 0
        ];

        $data[] = $updateData;

        $response = $this->postJson('/api/csv_category/10', $data);
        $response->assertStatus(401);

        $response = $this->postJson('/api/csv_category/10', $data, $this->headers);
        Log::debug((array)$response['data']);
        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRegistCsvFieldError400()
    {
        $data = [];

        $updateData = [
        ];

        $response = $this->postJson('/api/csv_category/10', $data);
        $response->assertStatus(401);

        $response = $this->postJson('/api/csv_category/10', $data, $this->headers);
        $response->assertStatus(400);

        $data[] = $updateData;

        $updateData = [
            'field_name' => 'testtest',
            'field_disp_name' => 'aaaaa',
            'is_required' => 'aaaaa'
        ];
        $response = $this->postJson('/api/csv_category/10', $data, $this->headers);
        $response->assertStatus(400);
    }

    /**
     * CSVフィールドの更新
     *
     * @return void
     */
    public function testCsvField()
    {
        $csv_field = CsvField::factory()->create([
            'field_name' => "aaaa",
            'field_disp_name' => "ddddd",
            'is_required' => 0
        ])->toArray();

        $updateData = [
            'field_name' => 'testtest',
            'field_disp_name' => 'aaaaa',
            'is_required' => 1
        ];
        $data = [
            'updateData' => $updateData
        ];

        $response = $this->putJson('/api/csv_field/' . $csv_field['id'], $data);
        $response->assertStatus(401);

        $response = $this->putJson(
            '/api/csv_field/' . $csv_field['id'],
            $data,
            $this->headers
        );

        $response->assertStatus(200);

        $updateData = [
            'field_name' => null,
            'field_disp_name' => null,
            'is_required' => 0
        ];

        $data = [
            'updateData' => $updateData
        ];

        $response = $this->putJson(
            '/api/csv_field/' . $csv_field['id'],
            $data,
            $this->headers
        );
        $response->assertStatus(200);
    }

    /**
     * CSVフィールドの更新(validation error)
     *
     * @return void
     */
    public function testCsvFieldError400()
    {

        $csv_field = CsvField::factory()->create([
            'field_name' => "aaaa",
            'field_disp_name' => "ddddd",
            'is_required' => 0
        ])->toArray();

        $updateData = [
            'field_name' => null,
            'is_required' => 0
        ];

        $data = [
            'updateData' => $updateData
        ];

        $response = $this->putJson(
            '/api/csv_field/' . $csv_field['id'],
            $data
        );

        $response->assertStatus(401);

        $response = $this->putJson(
            '/api/csv_field/' . $csv_field['id'],
            $data,
            $this->headers
        );

        $response->assertStatus(400);
    }

    /**
     * CSVフィールドの削除(validation error)
     *
     * @return void
     */
    public function testDeleteField400()
    {
        $data = [
            'delete_ids' => '1'
        ];

        $response = $this->deleteJson('/api/csv_field', $data);
        $response->assertStatus(401);

        $response = $this->deleteJson('/api/csv_field', $data, $this->headers);
        $response->assertStatus(400);

        $data = [
            'delete_ids' => ['aaaa', 'bbbb']
        ];

        $response = $this->deleteJson('/api/csv_field', $data, $this->headers);
        $response->assertStatus(400);
    }

    /**
     * CSVフィールドの削除
     *
     * @return void
     */
    public function testDeleteField()
    {
        $csv_field_ids = CsvField::factory(2)->create([
            'field_name' => "aaaa",
            'field_disp_name' => "ddddd",
            'is_required' => 0
        ])->pluck('id')->toArray();

        $data = [
            'delete_ids' => $csv_field_ids
        ];

        $response = $this->deleteJson('/api/csv_field', $data);
        $response->assertStatus(401);

        $response = $this->deleteJson('/api/csv_field', $data, $this->headers);
        $response->assertStatus(200);
    }
}
