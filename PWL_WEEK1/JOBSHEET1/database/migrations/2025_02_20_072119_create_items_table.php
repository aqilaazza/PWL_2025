<?php

use Illuminate\Database\Migrations\Migration; //Kelas dasar untuk membuat migration.
use Illuminate\Database\Schema\Blueprint; //Digunakan untuk mendefinisikan struktur tabel.
use Illuminate\Support\Facades\Schema; //Untuk mengelola skema database.

return new class extends Migration //membuat kelas anonymous yang akan diwariskan dari class migration
{
    /**
     * Run the migrations.
     */
    public function up(): void //Methode up Digunakan untuk menjalankan migration, yaitu membuat tabel.
    {
        Schema::create('items', function (Blueprint $table) { //Menggunakan Schema::create() untuk membuat tabel baru.Menggunakan Blueprint $table untuk mendefinisikan kolom tabel.
            $table->id(); //id() otomatis menjadi primary key dengan tipe bigInteger (Auto Increment).
            $table->string('name'); //string('name') berarti tipe data VARCHAR (default 255 karakter).
            $table->text('description'); //menambah kolom text('description') digunakan untuk menyimpan teks panjang.
            $table->timestamps(); //timestamps() otomatis menambahkan dua kolom:created_at → Waktu saat data dibuat.updated_at → Waktu saat data terakhir diperbarui.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items'); //Digunakan untuk menghapus tabel.
    }
};
