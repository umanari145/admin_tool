<?php

namespace Tests\Start;

use Tests\TestCase;


class StartTest extends TestCase
{

    /**
     * A basic test example. //プロセスの最初に
     *
     * @return void
     */
    public function testSetUp()
    {
        $this->artisan('migrate');
        $this->artisan('db:seed');
    }
}
