<?php

namespace Database\Seeders;

use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Clear existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('users')->truncate(); // ← Added this line
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // ============================================
        // 1. CREATE PERMISSIONS
        // ============================================
        $permissions = [
            ['name' => 'view_dashboard', 'guard_name' => 'web'],
            ['name' => 'view_products', 'guard_name' => 'web'],
            ['name' => 'create_products', 'guard_name' => 'web'],
            ['name' => 'edit_products', 'guard_name' => 'web'],
            ['name' => 'delete_products', 'guard_name' => 'web'],
            ['name' => 'import_products', 'guard_name' => 'web'],
            ['name' => 'export_products', 'guard_name' => 'web'],
            ['name' => 'view_categories', 'guard_name' => 'web'],
            ['name' => 'create_categories', 'guard_name' => 'web'],
            ['name' => 'edit_categories', 'guard_name' => 'web'],
            ['name' => 'delete_categories', 'guard_name' => 'web'],
            ['name' => 'view_brands', 'guard_name' => 'web'],
            ['name' => 'create_brands', 'guard_name' => 'web'],
            ['name' => 'edit_brands', 'guard_name' => 'web'],
            ['name' => 'delete_brands', 'guard_name' => 'web'],
            ['name' => 'view_orders', 'guard_name' => 'web'],
            ['name' => 'edit_orders', 'guard_name' => 'web'],
            ['name' => 'cancel_orders', 'guard_name' => 'web'],
            ['name' => 'process_refunds', 'guard_name' => 'web'],
            ['name' => 'view_users', 'guard_name' => 'web'],
            ['name' => 'create_users', 'guard_name' => 'web'],
            ['name' => 'edit_users', 'guard_name' => 'web'],
            ['name' => 'delete_users', 'guard_name' => 'web'],
            ['name' => 'block_users', 'guard_name' => 'web'],
            ['name' => 'manage_roles', 'guard_name' => 'web'],
            ['name' => 'manage_permissions', 'guard_name' => 'web'],
            ['name' => 'view_coupons', 'guard_name' => 'web'],
            ['name' => 'create_coupons', 'guard_name' => 'web'],
            ['name' => 'edit_coupons', 'guard_name' => 'web'],
            ['name' => 'delete_coupons', 'guard_name' => 'web'],
            ['name' => 'view_reports', 'guard_name' => 'web'],
            ['name' => 'export_reports', 'guard_name' => 'web'],
            ['name' => 'manage_settings', 'guard_name' => 'web'],
            ['name' => 'manage_reviews', 'guard_name' => 'web'],
            ['name' => 'manage_support', 'guard_name' => 'web'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // ============================================
        // 2. CREATE ROLES
        // ============================================
        $roles = [
            [
                'name' => 'super_admin',
                'guard_name' => 'web',
                'permissions' => Permission::pluck('name')->toArray()
            ],
            [
                'name' => 'admin',
                'guard_name' => 'web',
                'permissions' => [
                    'view_dashboard',
                    'view_products', 'create_products', 'edit_products', 'delete_products',
                    'view_categories', 'create_categories', 'edit_categories', 'delete_categories',
                    'view_brands', 'create_brands', 'edit_brands', 'delete_brands',
                    'view_orders', 'edit_orders',
                    'view_users', 'edit_users',
                    'view_coupons', 'create_coupons', 'edit_coupons', 'delete_coupons',
                    'view_reports',
                    'manage_reviews',
                    'manage_support',
                ]
            ],
            [
                'name' => 'manager',
                'guard_name' => 'web',
                'permissions' => [
                    'view_dashboard',
                    'view_products', 'create_products', 'edit_products',
                    'view_categories', 'create_categories', 'edit_categories',
                    'view_brands', 'create_brands', 'edit_brands',
                    'view_orders', 'edit_orders',
                    'view_users',
                    'view_reports',
                ]
            ],
            [
                'name' => 'customer',
                'guard_name' => 'web',
                'permissions' => []
            ],
        ];

        foreach ($roles as $roleData) {
            $permissionsList = $roleData['permissions'];
            unset($roleData['permissions']);

            $role = Role::create($roleData);
            $role->syncPermissions($permissionsList);
        }

        // ============================================
        // 3. CREATE DEFAULT ADMIN USER
        // ============================================
        $adminRole = Role::where('name', 'super_admin')->first();

        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@pakzone.com',
            'phone' => '03001234567',
            'password' => bcrypt('admin123'),
            'status' => 'active',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
        ]);

        // Assign role to admin
        $admin->assignRole($adminRole);

        $this->command->info('✅ Roles, Permissions, and Admin created successfully!');
        $this->command->info('');
        $this->command->info('Admin Email: admin@pakzone.com');
        $this->command->info('Admin Password: admin123');
        $this->command->info('');
    }
}
