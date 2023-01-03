<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(){
        return view('template.login');
    }

    public function loginProcess(Request $request){
        
        if(Auth::attempt($request->only('email', 'password'))){
            $request->session()->regenerate();
            return redirect('/');
        }

        return \redirect('login');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }

}
