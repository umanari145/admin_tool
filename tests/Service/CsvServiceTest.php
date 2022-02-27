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


}
