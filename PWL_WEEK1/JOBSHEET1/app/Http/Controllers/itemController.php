<?php

namespace App\Http\Controllers;

use App\Models\Item; //Item digunakan untuk berinteraksi dengan database.
use Illuminate\Http\Request; //Request digunakan untuk menangani input dari pengguna

class ItemController extends Controller //Class itemController akan menangani CRUD model item dengan mewarisi fitur controler dari Laravel
{
    /**
     * Display a listing of the resource.
     */
    public function index() //Menampilkan semua item
    {
        $items = Item::all(); //Mengambil semua data items dari database dengan Item::all().
        return view('items.index', compact('items')); //Mengembalikan tampilan items.index dengan data items.
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() //Menampilkan form tambah item.
    { 
        return view('items.create'); //Mengembalikan tampilan items.create yang berisi form untuk menambah item baru.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)  //Menyimpan item baru.
    {
        $request->validate([ //name dan description wajib diisi.
            'name' => 'required',
            'description' => 'required'
        ]);

        //Item::create($request->all());
        //return redirect()->route('items.index');

        // Hanya masukkan atribut yang diizinkan
        Item::create($request->only(['name', 'description'])); //Menggunakan only(['name', 'description']) agar hanya field yang diizinkan yang masuk.
        return redirect()->route('items.index')->with('success', 'Item added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item) //Menampilkan detail item
    {
        return view('items.show', compact('item')); //Mengambil data item berdasarkan id dan menampilkannya di items.show.
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item) //Menampilkan form edit item.
    {
        return view('items.edit', compact('item')); //Mengambil data item dan mengembalikan tampilan items.edit.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Item $item) //Memperbarui item.
    {
        $request->validate([ //name dan description harus diisi.
            'name' => 'required',
            'description' => 'required',
        ]);
    
        //$item->update($request->all());
        //return redirect()->route('items.index');
        // Hanya masukkan atribut yang diizinkan
        $item->update($request->only(['name', 'description'])); //Menggunakan only(['name', 'description']) agar hanya field yang diperbolehkan yang diperbarui.
        return redirect()->route('items.index')->with('success', 'Item updated successfully.'); //Redirect ke halaman daftar item dengan pesan sukses
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item) //Menghapus item.
    {
        //return redirect()->route('items.index);
        $item->delete(); //Menghapus item berdasarkan id dengan $item->delete().
        return redirect()->route('items.index')->with('success', 'Item deleted successfully.'); //Redirect ke halaman daftar item dengan pesan sukses.
    }
}

//note