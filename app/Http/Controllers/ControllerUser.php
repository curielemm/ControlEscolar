<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerUser extends Controller
{
    public function perfil(Request $request)
    {
        $id = auth()->user()->id;
        $datos = User::select(
            'usuarios.id',
            'usuarios.clave_usuario',
            'usuarios.email',
            'usuarios.nombre_usuario',
            'usuarios.apellido_paterno',
            'usuarios.apellido_materno',
            'institucion.nombre_institucion',
            'roles.descripcion'
        )
            ->join('institucion', 'institucion.clave_cct', '=', 'usuarios.institucion')
            ->join('roles', 'roles.id', '=', 'usuarios.role_id')->where("usuarios.id", "=", $id)->first();
        return view('perfil', compact('datos'));
    }

    public function update(Request $data, $clave_usuario)
    {
        User::where('clave_usuario', $clave_usuario)
            ->update([
                'nombre_usuario' => $data->nombre_usuario,
                'apellido_paterno' => $data->apellido_paterno,
                'apellido_materno' => $data->apellido_materno
            ]);

        if (auth()->user()->role_id == 1) {
            return redirect()->route('dashboard');
        } elseif (auth()->user()->role_id == 2) {
            return redirect()->route('dashboardAnalista');
        } elseif (auth()->user()->role_id == 3) {
            return redirect()->route('dashboardCtrlEscolar');
        }
    }

    public function updatePassword(Request $request)
    {
        // Validar los datos
        $this->validate($request, [
            'password' => 'required|confirmed|min:6|max:32',
        ]);
        // Note la regla de validación "confirmed", que solicitará que usted agregue un campo extra llamado password_confirm

        $user = Auth::user(); // Obtenga la instancia del usuario en sesión

        $password = bcrypt($request->password); // Encripte el password


        $user->password = $password; // Rellene el usuario con el nuevo password ya encriptado
        $user->save(); // Guarde el usuario

        // Por ultimo, redirigir al usuario, por ejemplo al formulario anterior, con un mensaje de que el password fue actualizado
        return redirect()->back()->with('message', 'Contraseña Actualizada');
    }


    public function regresarPanel()
    {
        if (auth()->user()->role_id == 1) {
            return redirect()->route('dashboard');
        } elseif (auth()->user()->role_id == 2) {
            return redirect()->route('dashboardAnalista');
        } elseif (auth()->user()->role_id == 3) {
            return redirect()->route('dashboardCtrlEscolar');
        }
    }

    public function regresarInstitucion()
    {
        if (auth()->user()->role_id == 1) {
            return redirect()->route('listarInstitucion');
        } elseif (auth()->user()->role_id == 2) {
            return redirect()->route('misInstituciones');
        } elseif (auth()->user()->role_id == 3) {
            return redirect()->route('/');
        }
    }

    
}
