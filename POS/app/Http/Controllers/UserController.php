<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id, $name) // menerima 2 parameter
    {
        return view('user.profile', compact('id', 'name')); // mengirim variable id dan name ke dalam view
    }
}
