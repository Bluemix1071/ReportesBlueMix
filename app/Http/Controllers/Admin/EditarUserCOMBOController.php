<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use DB;
use DateTime;

class EditarUserCOMBOController extends Controller
{
    //
    public function index()
    {  
        $editar=DB::table('accesos')->select('uscodi', 'usnomb', 'username', 'ustipo', 'fecha_ingreso', 'fecha_termino', 'fecha_nacimiento', 'estado', 'uscl01')->get();

        return view('admin.ListarUserCOMBO',compact('editar'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'pass' => 'required|min:6|max:10'
        ]);
    }

    public function create(Request $request)
    {
        //$val = $this->validator($request->all())->validate();
        /* $ultimo=DB::table('accesos')
        ->orderBy('uscodi', 'desc')
        ->first('uscodi'); */
        //dd($ultimo->uscodi + 1 );
        $dt = new DateTime();
        $dt->format('Y-m-d');
        //dd($dt);
        
        $data = $request->only(['name', 'username', 'estado', 'fecha_nacimiento', 'pass']);

        try{

            $nuevo = ['usnomb' => strtoupper($data['name']),
                    'username' => strtoupper($data['username']),
                    'ustipo' => '9',
                    'fecha_ingreso' => $dt,
                    'fecha_termino' => '3000-01-01',
                    'fecha_nacimiento' => $data['fecha_nacimiento'],
                    'estado' => $data['estado'],
                    'uscl01' => $data['pass']
            ];

            DB::table('accesos')->insert($nuevo);
    
            return redirect()->route('ListarUserCombo')->with('success','Se ha Agregado el usuario correctamente');

        }catch(Throwable $e){

            return redirect()->route('ListarUserCombo')->with('error','Ha ocurrido un ERROR al ingresar el Usuario')->withInput();

        }

        
        //return view('admin.AgregarUserCOMBO',compact('nuevo'));
    }

    public function update(Request $request){

        //$data = $request->only(['id', 'name', 'username', 'tipo', 'estado', 'fecha_nacimiento', 'pass']);

        $usuario = DB::table('accesos')->where('uscodi', $request->get('id'))->first();

        try{
            if($usuario != null){
                DB::table('accesos')->where('uscodi', $request->get('id'))->update([
                    'usnomb' => strtoupper($request->get('name')),
                    'username' => strtoupper($request->get('username')),
                    'estado' => $request->get('estado'),
                    'fecha_nacimiento' => $request->get('fecha_nacimiento'),
                    'uscl01' => $request->get('pass')
                    ]);
    
                    //return back();
                    return redirect()->route('ListarUserCombo')->with('success','Se ha editado el usuario correctamente');
            }else{
                //redirect()->route('ListarUserCombo')->with('success','Se ha editado el usuario');
                return redirect()->route('ListarUserCombo')->with('error','Ha ocurrido un ERROR al editar el usuario')->withInput();
            };
        }catch(Throwable $e){
            return redirect()->route('ListarUserCombo')->with('error','Ha ocurrido un ERROR al editar el Usuario')->withInput();
        }

    }
}
