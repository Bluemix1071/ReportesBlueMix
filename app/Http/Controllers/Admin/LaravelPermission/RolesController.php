<?php

namespace App\Http\Controllers\Admin\LaravelPermission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{
    public function index(){

        return view('/admin/LaravelPermission/MantenedorDeRoles');
    }
}
