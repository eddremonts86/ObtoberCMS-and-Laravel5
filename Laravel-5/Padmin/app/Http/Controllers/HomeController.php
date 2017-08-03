<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace lvadmin\Http\Controllers;

use lvadmin\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use lvadmin\Http\Models\User;

/**
 * Class HomeController
 * @package lvadmin\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {

        return view('home' ,['User' => User::all()]);
    }
}