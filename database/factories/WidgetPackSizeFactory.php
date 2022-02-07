<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WidgetPackSizeFactory extends Factory
{
    private static $size = [250, 500, 1000, 2000, 5000];
    private static $key = 0;

    public function definition()
    {
        return [
            'size' => self::$size[self::$key++],
        ];
    }

}
