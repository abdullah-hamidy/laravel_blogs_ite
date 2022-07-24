<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function index(Request $request){
        return view('auth.login');
    }

    public function login(Request $request, User $user){
        dd($request->all());
    }
}
