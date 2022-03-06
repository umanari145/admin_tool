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
    public function testGetCsvListTest()
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
            'key' => 'field_name',
            'data' => 'test'
        ];
        $csvService = new CsvService();
        $res = $csvService->updateCsvField('1', $data);
        $this->assertEquals($res['data']['field_name'], 'test');
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
            'key' => 'field_na',
            'data' => 'test'
        ];
        $csvService = new CsvService();
        $res = $csvService->updateCsvField('1', $data);
        $this->assertEquals($res['result'], '99');
    }

}
