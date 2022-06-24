<?php

namespace Tests\Service;

use App\Models\Company;
use Tests\TestCase;
use App\Service\CompanyService;
use Illuminate\Support\Facades\Schema;
use Cache;

class CompanyServiceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetCompnayTest()
    {
        $companies = Company::factory(10)->create()->toArray();
        $companies_collection = collect($companies)->pluck('company_name', 'id')->toArray();

        $companyService = new CompanyService();
        $res = $companyService->getCompanyList();
        //デバッグ
        $this->assertEquals($res['result'], '1');
        $this->assertEquals($res['data'], $companies_collection);

        // cacheが効いていることの確認(DB落ちても大丈夫)
        Schema::drop('company');
        $res = $companyService->getCompanyList();
        $this->assertEquals($res['result'], '1');
        $this->assertEquals($res['data'], $companies_collection);

    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetCompnayTest500()
    {
        $companies = Company::factory(10)->create()->toArray();
        Schema::drop('company');
        Cache::store('file')->forget('company_list');
        $companyService = new CompanyService();
        $res = $companyService->getCompanyList();
        //デバッグ
        $this->assertEquals($res['result'], '99');
    }
}
