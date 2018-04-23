<?php

namespace App\Helpers;

use Auth;

class RoleHelper
{
    const ROLE_ADMIN = 1;
    const ROLE_MODERATOR = 2;
    const ROLE_AUDIT_FIRM = 3;

    public static function isRoleAdmin()
    {
        return Auth::user()->role_id === self::ROLE_ADMIN;
    }

    public static function isRoleModerator()
    {
        return Auth::user()->role_id === self::ROLE_MODERATOR;
    }


    public static function isRoleAudit()
    {
        return Auth::user()->role_id === self::ROLE_AUDIT_FIRM;
    }
}
