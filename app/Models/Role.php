<?php

namespace App\Models;

use \Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    const ADMIN = 'ADMIN';
    const SUPERADMIN = 'SUPER ADMIN';
    const AGENT = 'RETAILER';
    const SUPERAGENT = 'WHOLESALER';
}
