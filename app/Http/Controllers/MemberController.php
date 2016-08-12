<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Member;

class MemberController extends Controller
{
    function login()
    {	
    	$errors = 0;
    	return view('auth.login');
    }

    function register()
    {	
    	$errors = 0;
    	return view('auth.register');
    }

    function reset()
    {	
    	$errors = 0;
    	return view('auth.reset');
    }
}
