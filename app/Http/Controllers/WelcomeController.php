<?php


namespace App\Http\Controllers;


class WelcomeController extends Controller
{

    function index()
    {
        return view('welcome');
    }

}
