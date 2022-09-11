<?php

namespace Tests\Unit;

use App\Constant\ConfigConst;
use PHPUnit\Framework\TestCase;
use BenSampo\Enum\Rules\EnumValue;

class ConfigConstTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertSame(1, ConfigConst::SERVICE_SUCCESS);

        $success = ConfigConst::SERVICE_SUCCESS();
        $this->assertSame(1, $success->value);
    }
}
