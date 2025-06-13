<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function index()
    {
        // Creating Permissions
        // Permission::create(['name' => 'edit articles']);
        // Permission::create(['name' => 'delete articles']);
        
        // Creating Roles and Assigning Permissions
        $roles = ['ADMIN', 'PARTNER', 'CUSTOMER'];
        foreach($roles as $role){
            Role::create(['name' => $role]);
        }
        // $role->givePermissionTo('edit articles');
        
        // $admin = Role::create(['name' => 'admin']);
        // $admin->givePermissionTo(['edit articles', 'delete articles']);
    }
}
