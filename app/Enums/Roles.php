<?php

namespace App\Enums;

use App\Concerns\EnumToArray;

enum Roles: int
{
    use EnumToArray;

    case SYSADMIN = 1;
    case TEAM_ADMIN = 2;
    case TEAM_MEMBER = 3;

    public static function translate(): array
    {
        return [
            self::SYSADMIN->value => 'System Admin',
            self::TEAM_ADMIN->value => 'Team Admin',
            self::TEAM_MEMBER->value => 'Team Member',
        ];
    }
}
