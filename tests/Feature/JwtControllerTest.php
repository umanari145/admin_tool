<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Company;
use App\Models\User;
use Tests\TestKit;

class JwtControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->test_kit = new TestKit();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testJwtLogin()
    {
        $this->markTestSkipped('認証系が完全に片付くまで一旦スキップ');
        $users = User::factory()->create()->toArray();
        Company::factory(10)->create();

        $response = $this->getJson('/api/company', $this->test_kit->getHeaders());
        // debug
        $response->assertStatus(401);
        //$retJson = $response->json();

        // token正常系
        $access_token = $this->test_kit->getToken();
        $response = $this->getJson('/api/company', $this->test_kit->getHeadersIncToken($access_token));
        $response->assertStatus(200);

        // 間違ったtoken
        $invalid_token = $access_token . "aaaa";
        $response = $this->getJson('/api/company', $this->test_kit->getHeadersIncToken($invalid_token));
        $response->assertStatus(401);

        $response = $this->postJson('/api/logout', [], $this->test_kit->getHeadersIncToken($access_token));
        $response->assertStatus(200);
        $retJson = $response->json();
        $this->assertSame($retJson, ["message" => "Successfully logged out"]);

        // logoutした後でtokenが使えなくなっていることを確認
        $response = $this->getJson('/api/company', $this->test_kit->getHeadersIncToken($access_token));
        $response->assertStatus(401);
    }
}
