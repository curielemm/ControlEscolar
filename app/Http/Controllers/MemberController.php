<?php

namespace AppHttpControllers;

use IlluminateHttpRequest;

  

class MemberController extends Controller

{

    /**

     * Create a Laravel 5.7 new controller instance.

     *

     * @return void

     */

    public function memberCreateRequest()

    {

        return view('memberCreateRequest');

    }

   

    /**

     * Create a Laravel 5.7 new controller instance.

     *

     * @return void

     */

    public function memberCreateRequestPost(Request $request)

    {

        $input = $request->all();

        return response()->json(['success'=>'onlinecode Simple Member Create Ajax Request.']);

    }

}
