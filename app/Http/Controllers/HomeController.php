<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    function index() {
        $data['name'] = 'Ahmad Ripai';
        $data ['gender'] = 'Male';

        return view('test', $data);
    }
}
