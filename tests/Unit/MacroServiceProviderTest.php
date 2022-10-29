<?php

namespace Tests\Unit;

use Tests\TestCase;

class MacroServiceProviderTest extends TestCase
{
    public function test_transpose()
    {

        // 縦横変換→転置
        $input_data = [
            [1, 2, 3],
            [4, 5, 6],
            [7, 8, 9]
        ];

        $before = collect($input_data);
        $after = $before->transpose();
        $expected = [
            [1, 4, 7],
            [2, 5, 8],
            [3, 6, 9],
        ];
        $this->assertSame($expected, $after->toArray());
    }


    public function test_transpose_head_with_key()
    {

        // 縦横変換→転置
        $input_data = [
            'name' => ['umehara', 'kurahashi', 'ogou'],
            'character' => ['ryu', 'guile', 'sagat']
        ];

        $before = collect($input_data);
        $after = $before->transposeWithHeadKey();
        $expected = [
            [
                'name' => 'umehara',
                'character' => 'ryu'
            ],
            [
                'name' => 'kurahashi',
                'character' => 'guile'
            ],
            [
                'name' => 'ogou',
                'character' => 'sagat'
            ],
        ];
        $this->assertSame($expected, $after->toArray());
    }
}
