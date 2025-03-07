<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = UserModel::create([
            'username' => 'manager11',
            'nama' => 'Manager11',
            'password' => Hash::make('12345'),
            'level_id' => 2,
            //Data berhasil disimpan ke database dengan username manager11
        ]);

        $user->username = 'manager12';
        // Sekarang ada perubahan, tetapi belum disimpan ke database.

        $user->save();
        //Perubahan username sudah tersimpan di database.

        $user->wasChanged(); //true (Mengembalikan true karena ada perubahan (username))
        $user->wasChanged('username'); //true (Mengembalikan true karena username memang berubah)
        $user->wasChanged(['username', 'level_id']);//true (Mengembalikan true karena username berubah (meskipun level_id tidak berubah, tapi karena salah satunya berubah, hasilnya tetap true))
        $user->wasChanged('nama');//false (Mengembalikan false karena nama tidak berubah)
        dd($user->wasChanged(['nama', 'username']));//true (Mengembalikan true karena username berubah (meskipun nama tidak berubah, karena salah satunya berubah, hasilnya tetap true))

        
    }
}

