<!DOCTYPE html>
<html>
<head>
    <title>Edit Item</title>
</head>
<body>
    <h1>Edit Item</h1>
    
    <!-- Formulir untuk mengedit item -->
    <form action="{{ route('items.update', $item) }}" method="POST">
        <!-- menambahkan token CSRF untuk melindungi dari serangan CSRF. -->
        @csrf
        <!-- Metode HTTP PUT untuk pembaruan data -->
        @method('PUT')
        
        <!-- Label dan input untuk nama item -->
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ $item->name }}" required>
        <br>
        {{--Label dan input teks untuk field "name", dengan nilai awal diisi dari properti $item->name dan atribut required untuk memastikan field ini tidak kosong.--}}
        
        <!-- Label dan textarea untuk deskripsi item -->
        <label for="description">Description:</label>
        <textarea name="description" required>{{ $item->description }}</textarea>
        <br>
        {{--Label dan textarea untuk field "description", dengan konten awal diisi dari properti $item->description dan atribut required untuk validasi.--}}
        
        <!-- Tombol untuk mengirim formulir -->
        <button type="submit">Update Item</button>
    </form>
    
    <!-- Tautan untuk kembali ke daftar item -->
    <a href="{{ route('items.index') }}">Back to List</a> {{--Tautan yang mengarah ke rute items.index untuk kembali ke daftar item, dengan teks "Back to List".--}}
</body>
</html>
