<?php

namespace Tests\Service;

use Tests\TestCase;
use App\Service\CsvService;


class CsvServiceTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function tesGetCsvListTest()
    {
        $csvService = new CsvService();
        $res = $csvService->getCsvFieldList(10);
        //デバッグ
        // dd($res);
        $this->assertEquals($res['data'][0]['field_name'], 'attribute1_code');
        $this->assertEquals($res['result'], '1');
    }

        /**
     * A basic test example.
     *
     * @return void
     */
    public function testUpdateCsvField()
    {
        $data = [
            'id' => '1',
            'field_name' => "aaaa",
            'field_disp_name' => "ddddd",
            'is_required' => 0
        ];
        $csvService = new CsvService();
        $res = $csvService->updateCsvField('1', $data);
        $this->assertEquals($res['data']['field_name'], 'aaaa');
        $this->assertEquals($res['result'], '1');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUpdateCsvFieldError()
    {
        // 存在しない項目でエラーを起こす
        $data = [
            'id' => '1',
            'field_na' => null,
            'field_disp_name' => null,
            'is_required' => 0
        ];
        $csvService = new CsvService();
        $res = $csvService->updateCsvField('1', $data);
        $this->assertEquals($res['result'], '99');
    }

}