<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory; // Menggunakan trait HasFactory untuk memfasilitasi pembuatan instance model melalui factory

    protected $fillable = [ // Mendefinisikan atribut yang dapat diisi secara massal
        'name', // Nama item
        'description', // Deskripsi item
    ];
}
