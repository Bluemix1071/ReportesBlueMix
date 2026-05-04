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
        $user = User::findOrFail($id);
        
        // Roles asignados
        $rolesAsignados = $user->roles()->select('roles.id', 'roles.name')->get()->map(function($r) {
            return ['id' => $r->id, 'name' => $r->name];
        });

        // Permisos directos asignados
        $permisosAsignados = $user->permissions()->select('permissions.id', 'permissions.name')->get()->map(function($p) {
            return ['id' => 'p_' . $p->id, 'name' => '[P] ' . $p->name];
        });

        $Roles = $rolesAsignados->concat($permisosAsignados)->values();

        $dataIdsRoles = $user->roles()->pluck('id')->toArray();
        $dataIdsPerms = $user->permissions()->pluck('id')->toArray();

        // Roles faltantes
        $rolesFaltantes = Role::whereNotIn('id', $dataIdsRoles)->select('id', 'name')->get()->map(function($r) {
            return ['id' => $r->id, 'name' => $r->name];
        });

        // Permisos faltantes
        $permisosFaltantes = Permission::whereNotIn('id', $dataIdsPerms)->select('id', 'name')->get()->map(function($p) {
            return ['id' => 'p_' . $p->id, 'name' => '[P] ' . $p->name];
        });

        $RolesFaltantes = $rolesFaltantes->concat($permisosFaltantes)->values();

        return response()->json([
            "Roles" => $Roles,
            "RolesFaltantes" => $RolesFaltantes
        ]);
    }


    public function AddRolUser(Request $request){
        $arrayInput = $request->input('Roles') ?? [];
        $userId = $request->input('UserId');

        try {
            $user = User::findOrFail($userId);
            
            $roleIds = [];
            $permIds = [];

            foreach ($arrayInput as $item) {
                if (is_string($item) && strpos($item, 'p_') === 0) {
                    $permIds[] = substr($item, 2);
                } else {
                    $roleIds[] = $item;
                }
            }

            // Sincronizar Roles
            if (!empty($roleIds)) {
                $roles = Role::whereIn('id', $roleIds)->pluck('name')->toArray();
            } else {
                $roles = [];
            }
            $user->syncRoles($roles);

            // Sincronizar Permisos Directos
            if (!empty($permIds)) {
                $permissions = Permission::whereIn('id', $permIds)->pluck('name')->toArray();
            } else {
                $permissions = [];
            }
            $user->syncPermissions($permissions);

            $data = [
                'code' => 200,
                'status' => 'success',
                'data' => 'Asignaciones actualizadas correctamente'
            ];
        } catch (\Exception $e) {
            $data = [
                'code' => 500,
                'status' => 'error',
                'data' => 'Error al procesar asignaciones: ' . $e->getMessage()
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
