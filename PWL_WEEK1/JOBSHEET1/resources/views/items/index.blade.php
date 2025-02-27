<!DOCTYPE html>
<html>
<head>
    <title>Item List</title>
</head>
<body>
    <h1>Items</h1>
    {{-- Menampilkan pesan sukses jika ada --}}
    @if(session('success')) {{--Pemeriksaan kondisi dengan @if untuk melihat apakah terdapat pesan sukses dalam sesi.--}}
        <p>{{ session('success') }}</p> {{--Jika ada, pesan tersebut ditampilkan--}}
    @endif
    {{-- Tautan untuk menambahkan item baru --}}
    <a href="{{ route('items.create') }}">Add Item</a> {{--Tag <a> membuat tautan yang mengarahkan pengguna ke halaman pembuatan item baru melalui rute items.create.--}}
    <ul>
        {{-- Loop melalui setiap item dan tampilkan --}}
        @foreach ($items as $item) {{--Direktif @foreach mengiterasi setiap item dalam koleksi $items.--}}
            <li>
                {{-- Menampilkan nama item --}}
                {{ $item->name }} - 
                {{-- Tautan untuk mengedit item --}}
                <a href="{{ route('items.edit', $item) }}">Edit</a>
                {{-- Formulir untuk menghapus item --}}
                <form action="{{ route('items.destroy', $item) }}" method="POST" style="display:inline;">
                    @csrf {{--untuk menambahkan token CSRF sebagai perlindungan.--}}
                    @method('DELETE') {{--untuk mengindikasikan metode HTTP DELETE.--}}
                    <button type="submit">Delete</button> {{--Tombol submit berlabel "Delete"--}}
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
