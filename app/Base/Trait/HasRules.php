<?php

namespace App\Base\Trait;

trait HasRules
{

    public static function rules(array $append = []): array
    {
        return array_merge(self::$rules, $append);
    }

}
