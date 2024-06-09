<?php

namespace App\Http\Controllers\Can;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Can;

class AuthController extends Controller
{
    
    

    public function register()
    {
        return view('auth.register');

    }
    public function login()
    {
        return view('auth.login');

    }


}
