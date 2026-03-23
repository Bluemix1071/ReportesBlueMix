<?php

namespace App\Http\Controllers\Admin\LaravelPermission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Modelos\Roles;
use App\Modelos\Permisos;
use App\User;
use App\Modelos\RolesYPermisos;
use App\Modelos\ModelHasRoles;
use DB;

class RolesController extends Controller
{
    public function index(){

        return view('/admin/LaravelPermission/MantenedorDeRoles');
    }


    public function ShowRoles(){

        $roles= Roles::all();

        $data= array(
            'code'=>200,
            'status'=>'success',
            'data' => $roles
        );

        return response()->json($data,$data['code']);
    }

    public function AddRol(Request $request){
      $RolEntrante= $request->input("rol");

      $roles=Roles::where('name',$RolEntrante)->first();

      //dd($roles,$RolEntrante);
      if ($roles == null &&  $RolEntrante !='' && $RolEntrante!=null) {


            $role = Role::create(['name' =>$RolEntrante]);

            $data= [
                'code'=>200,
                'status'=>'success',
                'data' => 'Rol guardado con exito!!'

            ];

      }else{

          $data= [
            'code'=>404,
            'status'=>'error',
            'data' => 'ya existe un Rol registro con ese nombre'

          ];
      }



       return response()->json($data,$data['code']);

    }


    public function ShowPermisos(Request $request,$id){


        $permisos = DB::table('roles')
        ->join('role_has_permissions', 'roles.id', '=', 'role_has_permissions.role_id')
        ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
        ->where('roles.id',$id)
        ->select('permissions.name as name','permissions.id as id')
        ->get();
      //dd($permisos);
        $data=[];
      for ($i=0; $i < sizeof($permisos) ; $i++) {
          $data[]=$permisos[$i]->id;
      }



        $permisosFaltantes = DB::table('permissions')
        ->select('name','id')
        ->whereNotIn('id',$data )
        ->get();

        //dd($permisos,$data,$permisosFaltantes);
      $Json=[
          "permisos"=>$permisos,
          "permisosFaltantes" => $permisosFaltantes
      ];


      return response()->json($Json);
    }

    public function AddPermisoRol(Request $request){
        $arrayPermisos = $request->input('check') ?? [];
        $rol = $request->input('rol');

        try {
            $role = Role::findById($rol);
            if (!empty($arrayPermisos)) {
                $permissions = Permission::whereIn('id', $arrayPermisos)->pluck('name')->toArray();
            } else {
                $permissions = [];
            }
            $role->syncPermissions($permissions);

            $data = [
                'code' => 200,
                'status' => 'success',
                'data' => 'Permisos asignados correctamente'
            ];
        } catch (\Exception $e) {
            $data = [
                'code' => 500,
                'status' => 'error',
                'data' => 'Error al asignar permisos'
            ];
        }

        return response()->json($data, $data['code'] == 200 ? 200 : 500);
    }


    public function ShowUsers(Request $request){

          $users=User::All();


          if ($users->isEmpty()) {

              $data= [
                'code'=>400,
                'status'=>'Error',
                'data' => 'Usuarios no Encontrados'
              ];

          } elseif($users->isNotEmpty()) {

              $data= [
                'code'=>200,
                'status'=>'success',
                'data' => $users
              ];

          }



        return response()->json($data , $data['code'] );

    }



    public function ShowRolesUser (Request $request , $id){

      $Roles = DB::table('users')
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->where('users.id',$id)
        ->select('roles.id as id','roles.name as name')
        ->get();

        $data=[];

        for ($i=0; $i < sizeof($Roles) ; $i++) {
            $data[]=$Roles[$i]->id;
        }

        $RolesFaltantes = DB::table('roles')
        ->select('id','name')
        ->whereNotIn('id',$data )
        ->get();


        $Json=[
          "Roles"=>$Roles,
          "RolesFaltantes" => $RolesFaltantes
      ];


      return response()->json($Json);

    }


    public function AddRolUser(Request $request){
        $arrayRoles = $request->input('Roles') ?? [];
        $userId = $request->input('UserId');

        try {
            $user = User::findOrFail($userId);
            if (!empty($arrayRoles)) {
                $roles = Role::whereIn('id', $arrayRoles)->pluck('name')->toArray();
            } else {
                $roles = [];
            }
            $user->syncRoles($roles);

            $data = [
                'code' => 200,
                'status' => 'success',
                'data' => 'Roles asignados correctamente'
            ];
        } catch (\Exception $e) {
            $data = [
                'code' => 500,
                'status' => 'error',
                'data' => 'Error al asignar roles'
            ];
        }

        return response()->json($data, $data['code'] == 200 ? 200 : 500);
    }






    }




















          /*
                                $RolePermiso = ModelHasRoles::create(['role_id' => $arrayRoles[$i],
                                                                        'model_id' => $userId,
                                                                        'model_type'=>'App\User'
                                                                        ]);*/
