<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validate;
use Illuminate\Routing\Redirector;
use App\Models\User;
use Illuminate\Support\Facades\Session;



class UserAuth extends Controller
{
    function index()
    {
        return view("login");
    }
    function checklogin(Request $request)
    {
     $request->validate( [
      'email'   => 'required|email|max:15',
      'password'  => 'required|min:5'
     ]);
     $data=$request->input();
     $request->session()->put('user',$data['email']);
     $user = User::where('email',$request->input('email'))->
                    where('password',$request->input('password'))->get();

    if(strlen($user)>3)
       {
         return redirect("employeemaster");
       }
       else{

        return back()->with ('error','Invalid Login Details');
       }

     }


      function successlogin()
    {
     return view('successlogin');
    }

    function logout()
    {
      if(Session::has('user'))
      Session::pull('user');
     return redirect('/');
    }

}
?>
