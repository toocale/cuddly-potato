<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add assets.view permission
        $exists = DB::table('permissions')->where('name', 'assets.view')->exists();
        if (!$exists) {
            $permissionId = DB::table('permissions')->insertGetId([
                'name' => 'assets.view',
                'description' => 'View asset configuration (plants, lines, machines)',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Grant to Admin group (id=1) and Plant Manager group (id=2) by default
            $adminGroup = DB::table('groups')->where('name', 'Admin')->first();
            $plantManagerGroup = DB::table('groups')->where('name', 'Plant Manager')->first();

            $assignments = [];
            if ($adminGroup) {
                $assignments[] = ['group_id' => $adminGroup->id, 'permission_id' => $permissionId];
            }
            if ($plantManagerGroup) {
                $assignments[] = ['group_id' => $plantManagerGroup->id, 'permission_id' => $permissionId];
            }

            if (!empty($assignments)) {
                DB::table('group_permission')->insert($assignments);
            }
        }
    }

    public function down(): void
    {
        $permission = DB::table('permissions')->where('name', 'assets.view')->first();
        if ($permission) {
            DB::table('group_permission')->where('permission_id', $permission->id)->delete();
            DB::table('permissions')->where('id', $permission->id)->delete();
        }
    }
};
