<?php

namespace Tests\Service;

use App\Models\ScanTerminal;
use App\Models\Company;
use Tests\TestCase;
use App\Service\ScanTerminalService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ScanTerminalServiceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetScanTerminalListTest()
    {
        $terminal = ScanTerminal::factory()->create()->toArray();
        $company = Company::find($terminal['company_id']);

        $csvService = new ScanTerminalService();
        $res = $csvService->getScanTerminalList();
        $this->assertSame($company->company_name, $res['data'][0]->company->company_name);
        $this->assertSame($terminal['mac_address'], $res['data'][0]->mac_address);
        $this->assertSame(1, $res['result']);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetScanTerminalListByCompanyTest()
    {
        $terminals = ScanTerminal::factory(10)->create()->toArray();
        $company = Company::find($terminals[0]['company_id']);

        $csvService = new ScanTerminalService();
        $requestParam = [
            'company_id' => $terminals[0]['company_id']
        ];
        $res = $csvService->getScanTerminalList($requestParam);
        $this->assertSame($company->company_name, $res['data'][0]->company->company_name);
        $this->assertSame($terminals[0]['mac_address'], $res['data'][0]->mac_address);
        $this->assertSame(1, $res['result']);

        Schema::drop('scan_terminal');
        $res = $csvService->getScanTerminalList($requestParam);
        $this->assertSame(99, $res['result']);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function tesUpdateCsvField()
    {
        $csv_field = CsvField::factory()->create([
            'field_name' => "aaaa",
            'field_disp_name' => "ddddd",
            'is_required' => 0
        ])->toArray();

        $data = [
            'field_name' => "bbbb",
            'field_disp_name' => "ccccc",
            'is_required' => 0
        ];

        $csvService = new CsvService();
        $res = $csvService->updateCsvField($csv_field['id'], $data);
        $this->assertEquals($res['data']['field_name'], 'bbbb');
        $this->assertEquals($res['result'], '1');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function tesUpdateCsvFieldError()
    {
        $csv_field = CsvField::factory()->create([
            'field_name' => "aaaa",
            'field_disp_name' => "ddddd",
            'is_required' => 0
        ])->toArray();

        // 存在しない項目でエラーを起こす
        $data = [
            'field_na' => null,
            'field_disp_name' => null,
            'is_required' => 0
        ];
        $csvService = new CsvService();
        $res = $csvService->updateCsvField('1', $data);
        $this->assertEquals($res['result'], '99');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function tesDeleteCsvField()
    {
        $csv_field_ids = CsvField::factory(2)->create()->pluck('id')->toArray();

        $csvService = new CsvService();
        $res = $csvService->deleteCsvField($csv_field_ids);
        $this->assertEquals($res['result'], '1');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function tesRegistCsvField()
    {
        $data = [];

        $updateData = [
            'field_name' => 'code2',
            'field_disp_name' => '元品番',
            'is_required' => 0
        ];

        $data[] = $updateData;

        $updateData = [
            'field_name' => 'code',
            'field_disp_name' => '品番',
            'is_required' => 1
        ];

        $data[] = $updateData;

        $csvService = new CsvService();
        $res = $csvService->registCsvField(10, $data);
        $this->assertEquals($res['result'], '1');
    }
}
