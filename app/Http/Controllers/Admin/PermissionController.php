<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function createpermissions(){
        Permission::firstOrCreate(['name' => 'MATKA_GAME']);
        Permission::firstOrCreate(['name' => 'SATTA_GAME']);
        Permission::firstOrCreate(['name' => 'COLOR_GAME']);
    }
}
