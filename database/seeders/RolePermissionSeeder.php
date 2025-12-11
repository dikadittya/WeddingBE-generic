<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Lauthz\Facades\Enforcer;

class RolePermissionSeeder extends Seeder
{
    /**
     * Seed Casbin policies for roles.
     */
    public function run(): void
    {
        // Allow super_admin to GET data-busana
        if (!Enforcer::hasPolicy('super_admin', 'data-busana', 'GET')) {
            Enforcer::addPolicy('super_admin', 'data-busana', 'GET');
        }
    }
}
