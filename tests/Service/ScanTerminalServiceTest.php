<?php

namespace Tests\Service;

use App\Models\ScanTerminal;
use App\Models\Company;
use Tests\TestCase;
use App\Service\ScanTerminalService;
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
    public function testRegistScanTerminalError()
    {
        $company = Company::factory()->create()->toArray();

        $registData = [
            'company_i' => $company['id'],
            'mac_address' => 'aa-bb-cc-dd-ee-ff-gg',
            'name' => 'サンプルhandy'
        ];

        $csvService = new ScanTerminalService();
        $res = $csvService->registScanTerminal($registData);
        $this->assertEquals($res['result'], '99');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUpdateScanTerminal()
    {
        $terminal = ScanTerminal::factory()->create()->toArray();

        $registData = [
            'mac_address' => 'aa-bb-cc-dd-ee-ff-hh',
            'name' => 'サンプルhandy'
        ];

        $csvService = new ScanTerminalService();
        $res = $csvService->updateScanTerminal($terminal['id'], $registData);
        $this->assertEquals($res['result'], '1');
        $this->assertEquals($terminal['id'], $res['data']->id);
        $this->assertEquals('aa-bb-cc-dd-ee-ff-hh', $res['data']->mac_address);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUpdateTerminalError()
    {
        $terminal = ScanTerminal::factory()->create()->toArray();

        $registData = [
            'mac_address' => 'aa-bb-cc-dd-ee-ff-hh',
            'name' => 'サンプルhandy'
        ];

        $scanTerminalService = new ScanTerminalService();
        $res = $scanTerminalService->updateScanTerminal('100', $registData);
        $this->assertEquals($res['errorMessage'], '存在しないハンディです。[id = 100]');
        $this->assertEquals($res['result'], '99');

        Schema::drop('scan_terminal');
        $res = $scanTerminalService->updateScanTerminal($terminal['id'], $registData);
        $this->assertEquals($res['result'], '99');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDeleteScanTerminal()
    {
        $scan_terminal_ids = ScanTerminal::factory(2)->create()->pluck('id')->toArray();

        $scanTerminalService = new ScanTerminalService();
        $res = $scanTerminalService->deleteScanTerminal($scan_terminal_ids);
        $this->assertEquals($res['result'], '1');
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDeleteScanTerminalError()
    {
        $scan_terminal_ids = ScanTerminal::factory(2)->create()->pluck('id')->toArray();
        $scanTerminalService = new ScanTerminalService();
        $res = $scanTerminalService->deleteScanTerminal(['111', '222']);
        $this->assertEquals($res['errorMessage'], 'ハンディが存在しません。');
        $this->assertEquals($res['result'], '99');

        $res = $scanTerminalService->deleteScanTerminal([$scan_terminal_ids[0], '999']);
        $this->assertEquals($res['errorMessage'], '削除が失敗しました。IDの件数と削除の件数が一致しません。');
        $this->assertEquals($res['result'], '99');
    }
}
