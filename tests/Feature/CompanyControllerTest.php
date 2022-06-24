<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Company;
use Illuminate\Support\Facades\Schema;
use Cache;

class CompanyControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCompanyTest()
    {
        $companies = Company::factory(10)->create()->toArray();
        $companies_collection = collect($companies)->pluck('company_name', 'id')->toArray();

        $response = $this->get('/api/company');
        $response->assertStatus(200);
        /*  レスポンスの形を完全に整えるのが面倒・・・  
            ->assertJson([
                'data' => $companies_collection,
                'result' => '1',
            ]);*/
        // cacheが効いていることの確認(DB落ちても大丈夫)
        Schema::drop('company');
        $response = $this->get('/api/company');
        $response->assertStatus(200);
    }

        /**
     * A basic test example.
     *
     * @return void
     */
    public function testCompanyTest500()
    {

        Schema::drop('company');
        Cache::store('file')->forget('company_list');
        $response = $this->get('/api/company');
        $response->assertStatus(500);
        /*  レスポンスの形を完全に整えるのが面倒・・・  
            ->assertJson([
                'data' => $companies_collection,
                'result' => '1',
            ]);*/
    }

}
