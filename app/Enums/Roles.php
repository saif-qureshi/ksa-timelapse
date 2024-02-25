<?php

namespace App\Enums;

enum Roles: string
{
    case ADMIN = 'admin';
    case PROJECT_ADMIN = 'project_admin';
    case DEVELOPER = 'developer';
    case CUSTOMER = 'customer';

    public static function toArray(): array
    {
        return array_column(Roles::cases(), 'value');
    }
}
