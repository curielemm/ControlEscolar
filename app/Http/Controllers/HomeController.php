<?php

namespace App\Http\Controllers;

use App\Models\ModeloActualizarPlan;
use App\Models\ModeloGrupo;
use App\Models\ModeloInstitucion;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //    $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome');
    }

    public function acceso()
    {
        return view('noAutorizado');
    }

    public function pruebaLayout()
    {
        return view('pruebaLayout');
    }

    public function aviso()
    {
        return view('aviso');
    }

    public function tabla()
    {
        return view('tablajs');
    }

    public function sesion()
    {
        return view('sesion');
    }
    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function ajaxRequest()

    {

        return view('ajaxRequest');
    }



    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function ajaxRequestPost(Request $request)
    {
        $data = json_decode($request);
        /*  $curp = $request->curp;
        $acta_nacimiento = $request->acta_nacimiento;
        for ($count = 0; $count < 1; $count++) {
            $data = array(
                'acta_nacimiento' => $acta_nacimiento[$count],
                'curp' => $curp[$count],

            );
            $insert_data2[] = $data;
        }
*/

        return $request; //response()->json(['success'=>$request]);

    }

    public function data(Request $request)
    {
        $clave_cct =   $request->clave_cct;
        $nombre_institucion = ModeloInstitucion::select('nombre_institucion')
            ->where('clave_cct', '=', $clave_cct)->take(1)->first();
        return response()->json($nombre_institucion);
    }

    function documentoValido($clave_cct, $rvoe, $vigencia, $clave_grupo)
    {
        $clave_cct = decrypt($clave_cct);
        $rvoe = decrypt($rvoe);
        $vigencia = decrypt($vigencia);
        $clave_grupo = decrypt($clave_grupo);
        $institucion = ModeloInstitucion::where('clave_cct', '=', $clave_cct)->take(1)->first();
        $plan = ModeloActualizarPlan::where('rvoe', '=', $rvoe)->where('vigencia', '=', $vigencia)->take(1)->first();
        $grupo = ModeloGrupo::where('clave_grupo', '=', $clave_grupo)->take(1)->first();
        return view('acuseRegistrado', compact('institucion', 'plan', 'grupo'));
    }
}
