<?php

namespace App\Http\Controllers;

use App\Http\Middleware\EsAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class DashboardController extends Controller
{

	protected $redirectTo = '/';

    public function _construct(){
        $this->middleware('auth');
        $this->middleware('EsAdmin');
    }

    public function index(){
    	return view('dashboard');
    }

}
