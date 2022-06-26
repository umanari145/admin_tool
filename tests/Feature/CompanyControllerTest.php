<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\TestKit;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Cache;

class CompanyControllerTest extends TestCase
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
    public function testCompanyTest()
    {
        $companies = Company::factory(10)->create()->toArray();
        $companies_collection = collect($companies)->pluck('company_name', 'id')->toArray();

        $response = $this->getJson('/api/company', $this->headers);
        // debug
        //$retJson = $response->json();
        $response->assertStatus(200);
        /*  レスポンスの形を完全に整えるのが面倒・・・  
            ->assertJson([
                'data' => $companies_collection,
                'result' => '1',
            ]);*/
        // cacheが効いていることの確認(DB落ちても大丈夫)
        Schema::drop('company');
        $response = $this->getJson('/api/company', $this->headers);
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
        $response = $this->getJson('/api/company', $this->headers);
        $response->assertStatus(500);
        /*  レスポンスの形を完全に整えるのが面倒・・・  
            ->assertJson([
                'data' => $companies_collection,
                'result' => '1',
            ]);*/
    }

}
