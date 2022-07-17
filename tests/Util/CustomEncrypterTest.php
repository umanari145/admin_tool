<?php

namespace Tests\Service;

use Tests\TestCase;
use App\CustomUtil\CustomEncrypter;

class CustomEncrypterTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCustomeEncryptTest()
    {
        $customer_encrypter = app()->make(CustomEncrypter::class);
        $encrypted = $customer_encrypter->encrypt('hello world');
        $original = $customer_encrypter->decrypt($encrypted);
        $this->assertSame('hello world', $original);
    }
}
