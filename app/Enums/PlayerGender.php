<?php

namespace App\Enums;

enum PlayerGender: string
{
    case Male = 'male';
    case Female = 'female';

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return [
            self::Male->value => 'Male',
            self::Female->value => 'Female',
        ];
    }
}
