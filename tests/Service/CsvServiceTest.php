<?php

namespace Tests\Service;

use App\Models\CsvField;
use Tests\TestCase;
use App\Service\CsvService;

class CsvServiceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetCsvListTest()
    {
        CsvField::factory()->create()->toArray();

        $csvService = new CsvService();
        $res = $csvService->getCsvFieldList(10);
        //デバッグ
        $this->assertEquals($res['result'], '1');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUpdateCsvField()
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
    public function testUpdateCsvFieldError()
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
    public function testDeleteCsvField()
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
    public function testRegistCsvField()
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
