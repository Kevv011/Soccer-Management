<?php

namespace App\Enums;

enum ReportType: string
{
    case Federation = 'federation';
    case Team = 'team';

    public function label(): string
    {
        return match ($this) {
            self::Federation => 'Federation',
            self::Team => 'Team',
        };
    }
}
