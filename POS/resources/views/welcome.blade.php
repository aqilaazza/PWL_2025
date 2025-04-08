@extends('layouts.template')

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Hai, Selamat Datang di POS! 👋</h3>
        <div class="card-tools">x</div>
    </div>
    <div class="card-body">
        Welcome back, {{ Auth::user()->username }}!  
        Semangat kerja hari ini ya 💪  
        Yuk, mulai aktivitasmu di halaman utama ini, {{ Auth::user()->nama }}.
    </div>
</div>

@endsection
