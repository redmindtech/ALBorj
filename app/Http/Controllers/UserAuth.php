<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class UserAuth extends Controller
{

    public function index(Request $request)
    {

return view('login');

    }

    function checklogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:30',
            'password' => 'required|min:5'
        ]);

        $data = $request->input();

        $user = User::where('email', $request->input('email'))
            ->where('password', $request->input('password'))
            ->first(); // Use "first()" instead of "get()" to retrieve a single user

        if ($user) {
            $request->session()->put('user', $user->name);
            return redirect("dashboard");
        } else {
            return back()->with('error', 'Invalid Login Details');
        }
    }


    public function successlogin()
    {
        return view('successlogin');
    }


    // public function logout(Request $request)
    // {
    //     $request->session()->forget('user');

    //     $response = redirect('/');

    //     $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
    //     $response->headers->set('Pragma', 'no-cache');
    //     $response->headers->set('Expires', '0');

    //     return $response;
    // }

public function logout(Request $request)
{
    $request->session()->forget('user');
    $request->session()->flush();
    $request->session()->regenerate();

    return redirect('/');
}
}
?>