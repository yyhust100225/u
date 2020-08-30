<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'controller' => 'RoleController',
                'action' => 'list',
                'level' => 2,
                'remark' => '查阅角色列表权限'
            ], [
                'controller' => 'RoleController',
                'action' => 'create',
                'level' => 2,
                'remark' => '新增角色列表权限'
            ], [
                'controller' => 'RoleController',
                'action' => 'edit',
                'level' => 2,
                'remark' => '新增角色列表权限'
            ], [
                'controller' => 'RoleController',
                'action' => 'delete',
                'level' => 2,
                'remark' => '删除角色列表权限'
            ]
        ]);
    }
}
