<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'clave_usuario', 'nombre_usuario', 'apellido_paterno', 'apellido_materno', 'email', 'password', 'institucion', 'puesto', 'autorizado', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //$primaryKey = ''; // add your user table primary key here
    // Auth::loginUsingId(Auth::user()->userTablePrimaryKey);

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function esAdmin()
    {
        $hola = true;
        if ($this->role['nombre_rol'] == 'administrador') {
            return true;
        }
        return false;
    }

    public function esAnalista()
    {
        $hola = true;
        if ($this->role['nombre_rol'] == 'analista') {
            return true;
        }
        return false;
    }

    public function esControlEsc()
    {
        $hola = true;
        if ($this->role['nombre_rol'] == 'control') {
            return true;
        }
        return false;
    }
    //Scopes
    public function scopeName($query, $nombre)
    {
        if ($nombre)
            $query->where('usuarios.nombre_usuario', 'LIKE', "%$nombre%");
    }

    public function scopeClave($query, $clave_user)
    {
        if ($clave_user)
            $query->where('usuarios.clave_usuario', 'LIKE', "%$clave_user%");
    }
}
