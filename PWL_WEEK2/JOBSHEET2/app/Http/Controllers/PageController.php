<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(){
        return ('Selamat Datang');
    }

    public function about(){
        return ('Aqila Nur Azza (2341760022)');
    }

    public function articles($id = null){
        return 'Halaman Artikel dengan Id ' . $id;
    }
}
