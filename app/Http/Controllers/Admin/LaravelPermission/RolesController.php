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

      $arrayPermisos=$request->input('check');
      $rol=$request->input('rol');

      $Eliminar=DB::table('role_has_permissions')
     // ->whereIn('permission_id',$arrayPermisos )
      ->where('role_id','=',$rol )
      ->select('permission_id')
      ->get();

      //dd($Eliminar[0]->permission_id,$arrayPermisos);

      if (sizeof($arrayPermisos) > sizeof($Eliminar)) {
       //insertando

          for ($i=0; $i < sizeof($arrayPermisos) ; $i++) {

                          $consulta=DB::table('role_has_permissions')
                          ->where('permission_id','=',$arrayPermisos[$i] )
                          ->where('role_id','=',$rol )
                          ->get();


                    if ($consulta->isEmpty()) {

                      $permission = Permission::findById($arrayPermisos[$i]);

                      $role= Role::findById($rol);

                     // dd($permission->name,$role);
                      $role->givePermissionTo($permission->name);

                      $data= [
                        'code'=>200,
                        'status'=>'success',
                        'data' => 'Permisos asignados correctamente'

                      ];


                    } elseif($consulta->isNotEmpty()) {

                      $data= [
                        'code'=>300,
                        'status'=>'warning',
                        'data' => 'los permisos ya estan asignados a este rol'

                      ];

                    }

            }

      }elseif(sizeof($arrayPermisos) < sizeof($Eliminar)){
        //elimimando


                /*
                $Eliminados=DB::table('role_has_permissions')
                ->whereNotIn('permission_id', $arrayPermisos )
                ->where('role_id','=',$rol )
                ->delete();



*/
                $data=[];
                for ($i=0; $i < sizeof($arrayPermisos) ; $i++) {
                    $data[]=$arrayPermisos[$i];
                }


                $consulta=DB::table('role_has_permissions')
                ->whereNotIn('permission_id',$data)
                ->where('role_id','=',$rol )
                ->get();



              //dd($data,$consulta[0]->permission_id,$Eliminar);

              for ($i=0; $i < sizeof( $consulta) ; $i++) {

                $permission = Permission::findById($consulta[$i]->permission_id);

                $role= Role::findById($rol);


                $role->revokePermissionTo($permission->name);


              }



                $data= [
                  'code'=>201,
                  'status'=>'warning',
                  'data' => 'permisos quitados'

                ];


      }elseif(sizeof($arrayPermisos) == sizeof($Eliminar)){
        //no hacer nada


              $data= [
                'code'=>200,
                'status'=>'warning',
                'data' => ''

              ];

      }

      return response()->json($data,$data['code']);

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

     // dd($request);
     $arrayRoles=$request->input('Roles');
     $userId=$request->input('UserId');

     $Eliminar=DB::table('model_has_roles')
     // ->whereIn('permission_id',$arrayPermisos )
      ->where('model_id','=',$userId )
      ->select('role_id')
      ->get();

                if (sizeof($arrayRoles) > sizeof($Eliminar)) {
                  //insertando

                    for ($i=0; $i < sizeof($arrayRoles) ; $i++) {

                                    $consulta=DB::table('model_has_roles')
                                    ->where('role_id','=',$arrayRoles[$i] )
                                    ->where('model_id','=',$userId )
                                    ->get();


                              if ($consulta->isEmpty()) {

                                  $role = Role::findById($arrayRoles[$i]);

                                  $user = User::find($userId);

                                  $user->assignRole($role->name);


                                $data= [
                                  'code'=>200,
                                  'status'=>'success',
                                  'data' => 'Roles asignados correctamente'

                                ];


                              } elseif($consulta->isNotEmpty()) {

                                $data= [
                                  'code'=>300,
                                  'status'=>'warning',
                                  'data' => 'los Roles ya estan asignados a este Usuario'

                                ];

                              }

                      }
                }elseif(sizeof($arrayRoles) < sizeof($Eliminar)){
            //elimimando

            $data=[];
            for ($i=0; $i < sizeof($arrayRoles) ; $i++) {
                $data[]=$arrayRoles[$i];
            }

            $consulta=DB::table('model_has_roles')
            ->whereNotIn('role_id',$data)
            ->where('model_id','=',$userId )
            ->get();

           // dd($consulta , $arrayRoles, $data);

            for ($i=0; $i < sizeof( $consulta) ; $i++) {

               $role = Role::findById($consulta[$i]->role_id);

              $user= User::find($userId);


              $user->removeRole($role->name);


            }



                    $data= [
                      'code'=>201,
                      'status'=>'warning',
                      'data' => 'Roles quitados'

                    ];


              }elseif(sizeof($arrayRoles) == sizeof($Eliminar)){
                  //no hacer nada


                        $data= [
                          'code'=>200,
                          'status'=>'warning',
                          'data' => ''

                        ];

                }



    return response()->json($data,$data['code']);

  }






    }




















          /*
                                $RolePermiso = ModelHasRoles::create(['role_id' => $arrayRoles[$i],
                                                                        'model_id' => $userId,
                                                                        'model_type'=>'App\User'
                                                                        ]);*/
