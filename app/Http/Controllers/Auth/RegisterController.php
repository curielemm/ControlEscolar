<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Mail\Registro;
use App\Models\ModeloInstitucion;
use App\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/aviso';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'clave_usuario' => ['string', 'unique:usuarios','alpha_num', 'min:6'],
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'apaterno' => ['required', 'string', 'min:3', 'max:255'],
            'amaterno' => ['nullable','string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
             'institucion'=>['required'],
            'puesto'=>['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        Mail::to($data['email'])->send(new Registro(0));
        return User::create([
            'clave_usuario' => $data['clave_usuario'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'nombre_usuario' => $data['name'],
            'apellido_paterno' => $data['apaterno'],
            'apellido_materno' => $data['amaterno'],
            'institucion' => $data['institucion'],
            'puesto' => $data['puesto'],
            'autorizado' => '0',
            'role_id' => $data['puesto'],
        ]);
    }

    public function showRegisterForm()
    {
        $instituciones = ModeloInstitucion::all()->where('clave_cct', '!=', 'CGEMSySCyT');
        $roles = Role::all()->where('id','3');
        return view('auth.register', compact('instituciones'), compact('roles'));
        //return $instituciones;
    }

    public function showRegisterFormAdmin()
    {
        $instituciones = ModeloInstitucion::all()->where('clave_cct', '=', 'CGEMSySCyT');
        $roles = Role::all()->where('id','1');;
        return view('auth.registerAdmin', compact('instituciones'), compact('roles'));
        //return $instituciones;
    }
    public function showRegisterFormAnalista()
    {
        $instituciones = ModeloInstitucion::all()->where('clave_cct', '=', 'CGEMSySCyT');
        $roles = Role::all()->where('id','2');;
        return view('auth.registerAnalista', compact('instituciones'), compact('roles'));
        //return $instituciones;
    }
}
