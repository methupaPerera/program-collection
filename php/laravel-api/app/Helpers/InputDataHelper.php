<?php

// I created this because the prepareForValidation() method is not working...

namespace App\Helpers;

use Illuminate\Support\Str;

class InputDataHelper
{
    public static function updateWithSnakeCase(array $data, array $fillable = []): array
    {
        $transformed = [];

        if (empty($fillable)) {
            $fillable = array_keys($data);
        }

        foreach ($data as $key => $value) {
            $snakeKey = Str::snake($key);

            if (in_array($snakeKey, $fillable)) {
                $transformed[$snakeKey] = $value;
            } else {
                $transformed[$key] = $value;
            }
        }

        return $transformed;
    }
}
