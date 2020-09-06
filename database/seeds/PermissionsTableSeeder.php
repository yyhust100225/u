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
                'name' => '查阅角色列表',
                'controller' => 'RoleController',
                'action' => 'list',
                'level' => 2,
                'remark' => '查阅角色列表'
            ], [
                'name' => '新增角色列表',
                'controller' => 'RoleController',
                'action' => 'create',
                'level' => 2,
                'remark' => '新增角色列表'
            ], [
                'name' => '编辑角色列表',
                'controller' => 'RoleController',
                'action' => 'edit',
                'level' => 2,
                'remark' => '编辑角色列表'
            ], [
                'name' => '删除角色列表',
                'controller' => 'RoleController',
                'action' => 'delete',
                'level' => 2,
                'remark' => '删除角色列表'
            ],
            [
                'name' => '查阅权限列表',
                'controller' => 'PermissionController',
                'action' => 'list',
                'level' => 2,
                'remark' => '查阅权限列表'
            ], [
                'name' => '新增权限列表',
                'controller' => 'PermissionController',
                'action' => 'create',
                'level' => 2,
                'remark' => '新增权限列表'
            ], [
                'name' => '编辑权限列表',
                'controller' => 'PermissionController',
                'action' => 'edit',
                'level' => 2,
                'remark' => '编辑权限列表'
            ], [
                'name' => '删除权限列表',
                'controller' => 'PermissionController',
                'action' => 'delete',
                'level' => 2,
                'remark' => '删除权限列表'
            ]
        ]);
    }
}
