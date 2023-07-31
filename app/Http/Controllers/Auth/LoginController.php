<?php

namespace App\Http\Controllers\Auth;
//use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;


class LoginController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

  //  use AuthenticatesUsers;

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  protected $redirectTo = '/';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest')->except('logout');
    //$this->middleware('guest',['only'=> 'showLoginForm']);
    // $this->middleware('guest');
  }

  public function showLoginForm()
  {
    return view('auth.login');
  }

  public function showLoginFormAdmin()
  {
    return view('auth.loginAdmin');
  }

  public function showLoginFormAnalista()
  {
    return view('auth.loginAnalista');
  }

  public function login()
  {
    $credentials = $this->validate(request(), [
      'email' => 'email|required|string',
      'password' => 'required|string'
    ]);
    //return $credentials;
    $email = $credentials['email'];

    // return $correo[0]['email'];
    if (Auth::attempt($credentials)) {
      $correo = User::where("email", "=", $email)->get()->toArray();
      if ($correo[0]['autorizado'] == 1) {
        if ($correo[0]['role_id'] == 1) {
          return redirect()->route('dashboard');
        } elseif ($correo[0]['role_id'] == 2) {
          return redirect()->route('dashboardAnalista');
        } elseif ($correo[0]['role_id'] == 3) {
          return redirect()->route('dashboardCtrlEscolar');
        }
      } {
        Auth::logout();
        return redirect('/aviso');
      }
    } {
      return back()
        ->withErrors(['email' => trans('auth.failed')])
        ->withInput(request(['email']));
    }
  }

  public function loginAdmin()
  {
    $credentials = $this->validate(request(), [
      'email' => 'email|required|string',
      'password' => 'required|string'
    ]);
    //return $credentials;
    $email = $credentials['email'];

    // return $correo[0]['email'];
    if (Auth::attempt($credentials)) {
      $correo = User::where("email", "=", $email)->get()->toArray();
      if ($correo[0]['autorizado'] == 1) {
        if ($correo[0]['role_id'] == 1) {
          return redirect()->route('dashboard');
        } elseif ($correo[0]['role_id'] == 2) {
          return redirect()->route('dashboardAnalista');
        } elseif ($correo[0]['role_id'] == 3) {
          return redirect()->route('dashboardCtrlEscolar');
        }
      } {
        Auth::logout();
        return redirect('/aviso');
      }
    } {
      return back()
        ->withErrors(['email' => trans('auth.failed')])
        ->withInput(request(['email']));
    }
  }

  public function loginAnalista()
  {
    $credentials = $this->validate(request(), [
      'email' => 'email|required|string',
      'password' => 'required|string'
    ]);
    //return $credentials;
    $email = $credentials['email'];

    // return $correo[0]['email'];
    if (Auth::attempt($credentials)) {
      $correo = User::where("email", "=", $email)->get()->toArray();
      if ($correo[0]['autorizado'] == 1) {
        if ($correo[0]['role_id'] == 1) {
          return redirect()->route('dashboard');
        } elseif ($correo[0]['role_id'] == 2) {
          return redirect()->route('dashboardAnalista');
        } elseif ($correo[0]['role_id'] == 3) {
          return redirect()->route('dashboardCtrlEscolar');
        }
      } {
        Auth::logout();
        return redirect('/aviso');
      }
    } {
      return back()
        ->withErrors(['email' => trans('auth.failed')])
        ->withInput(request(['email']));
    }
  }



  public function logout()
  {
    Auth::logout();

    return redirect('/');
  }


  protected function redirectTo()
  {
    return redirect('/');
  }
}
