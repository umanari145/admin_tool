<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\ScanTerminal;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Tests\TestKit;

class ScanTerminalControllerTest extends TestCase
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
    public function testScanTerminalTest()
    {
        ScanTerminal::factory(20)->create()->toArray();
        $response = $this->getJson('api/scan_terminal', $this->headers);
        $response->assertStatus(200);

        $response = $this->getJson('api/scan_terminal?page=2', $this->headers);
        $retJson = $response->json();
        $response->assertStatus(200);
        $this->assertSame(11, $retJson['meta']['from']);

        $response = $this->getJson('api/scan_terminal?company_id=1', $this->headers);
        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testScanTerminalError()
    {
        ScanTerminal::factory()->create()->toArray();
        $response = $this->getJson('api/scan_terminal?company_id=aaa', $this->headers);
        $response->assertStatus(400);

        Schema::drop('scan_terminal');
        $response = $this->getJson('api/scan_terminal?company_id=1', $this->headers);
        $response->assertStatus(500);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRegistScanTerminalTest()
    {
        $scan_terminal = ScanTerminal::factory()->make()->toArray();
        $response = $this->postJson('/api/scan_terminal', $scan_terminal, $this->headers);
        $res_data = (array)$response['data'];
        $response->assertStatus(200);
        $this->assertSame($scan_terminal['mac_address'], $res_data['mac_address']);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRegistScanTerminalError400()
    {
        $response = $this->postJson('/api/scan_terminal', [], $this->headers);
        $error_message = (array) $response['errorMessage'];
        // ない場合errorになるので以下を定義
        $error_message['company_id'];
        $error_message['mac_address'];
        $error_message['name'];
        $response->assertStatus(400);

        $scan_terminal = ScanTerminal::factory()->make()->toArray();
        $this->validateCheck($scan_terminal, 'company_id', 'aaaa');
        $this->validateCheck($scan_terminal, 'company_id', '1111');
        $this->validateCheck($scan_terminal, 'mac_address', 'testtest');
    }

    private function validateCheck(array $scan_terminal, string $column_name, string $value)
    {
        $scan_terminal[$column_name] = $value;
        $response = $this->postJson('/api/scan_terminal', $scan_terminal, $this->headers);
        $error_message = (array) $response['errorMessage'];
        // ない場合errorになるので以下を定義
        $error_message[$column_name];
        $response->assertStatus(400);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRegistCsvFieldError500()
    {
        $scan_terminal = ScanTerminal::factory()->make()->toArray();
        Schema::drop('scan_terminal');
        $response = $this->postJson('/api/scan_terminal', $scan_terminal, $this->headers);
        // ない場合errorになるので以下を定義
        $response->assertStatus(500);
    }

    /**
     * CSVフィールドの更新
     *
     * @return void
     */
    public function testUpdateScanTerminal()
    {
        $scan_terminal = ScanTerminal::factory()->create()->toArray();
        $scan_terminal_update = ScanTerminal::factory()->make()->toArray();
        $data = [
            'updateData' => $scan_terminal_update
        ];

        $response = $this->putJson('/api/scan_terminal/' . $scan_terminal['id'], $data, $this->headers);
        $response->assertStatus(200);
    }

    /**
     * CSVフィールドの更新(validation error)
     *
     * @return void
     */
    public function testUpdateScanTerminalError400()
    {
        $response = $this->putJson('/api/scan_terminal/1', ['updateData' => []], $this->headers);
        $error_message = (array) $response['errorMessage'];
        // ない場合errorになるので以下を定義
        $error_message['scan_terminal_id'];
        $error_message['company_id'];
        $error_message['mac_address'];
        $error_message['name'];
        $response->assertStatus(400);

        $scan_terminal = ScanTerminal::factory()->create()->toArray();
        $scan_terminal['scan_terminal_id'] = $scan_terminal['id'];
        $this->validateCheck2($scan_terminal, 'scan_terminal_id', 'aaaa');
        $this->validateCheck2($scan_terminal, 'scan_terminal_id', '1111');
        $this->validateCheck2($scan_terminal, 'company_id', 'aaaa');
        $this->validateCheck2($scan_terminal, 'company_id', '1111');
        $this->validateCheck2($scan_terminal, 'mac_address', 'testtest');
    }

    private function validateCheck2(array $scan_terminal, string $column_name, string $value)
    {
        $scan_terminal[$column_name] = $value;
        $response = $this->putJson(
            '/api/scan_terminal/' . $scan_terminal['scan_terminal_id'], 
            ['updateData' => $scan_terminal],
            $this->headers
        );
        $error_message = (array) $response['errorMessage'];
        // ない場合errorになるので以下を定義
        $error_message[$column_name];
        $response->assertStatus(400);
    }

    /**
     *
     * @return void
     */
    public function testUpdateScanTerminalError500()
    {
        $scan_terminal = ScanTerminal::factory()->create()->toArray();
        $scan_terminal_update = ScanTerminal::factory()->make()->toArray();

        $data = [
            'updateData' => $scan_terminal_update
        ];
        Schema::drop('scan_terminal');
        $response = $this->putJson(
            '/api/scan_terminal/' . $scan_terminal['id'],
            $data,
            $this->headers
        );
        $response->assertStatus(500);
    }

    /**
     *
     * @return void
     */
    public function testDeleteScanTerminal()
    {
        $scan_terminal_ids = ScanTerminal::factory(2)->create()
            ->pluck('id')->toArray();

        $data = [
            'delete_ids' => $scan_terminal_ids
        ];

        $response = $this->deleteJson(
            '/api/scan_terminal',
            $data,
            $this->headers
        );
        $response->assertStatus(200);
    }

    /**
     *
     * @return void
     */
    public function testDeleteScanTerminal400()
    {
        $data = [
            'delete_ids' => 'aaaaa'
        ];

        $response = $this->deleteJson(
            '/api/scan_terminal',
            $data,
            $this->headers
        );
        $error_message = (array) $response['errorMessage'];
        // ない場合errorになるので以下を定義
        $error_message['delete_ids'];
        $response->assertStatus(400);

        $data = [
            'delete_ids' => ['aaaa', '1111']
        ];

        $response = $this->deleteJson(
            '/api/scan_terminal',
            $data,
            $this->headers
        );
        $error_message = (array) $response['errorMessage'];
        // ない場合errorになるので以下を定義
        $error_message['delete_ids.0'];
        $error_message['delete_ids.1'];
        $response->assertStatus(400);
    }

    /**
     *
     * @return void
     */
    public function testDeleteScanTerminal500()
    {
        $scan_terminal_ids = ScanTerminal::factory(2)->create()
            ->pluck('id')->toArray();

        $data = [
            'delete_ids' => $scan_terminal_ids
        ];

        Schema::drop('scan_terminal');
        $response = $this->deleteJson(
            '/api/scan_terminal',
            $data,
            $this->headers
        );
        $response->assertStatus(500);
    }
}
