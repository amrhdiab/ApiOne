<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //Home Page - Front
    public function index(){
        return view('pages.index');
    }

    public function readme(){
        return view('pages.readme');
    }
}
