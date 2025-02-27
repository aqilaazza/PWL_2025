<!DOCTYPE html>
<html>
<head>
    <title>Add Item</title>
</head>
<body>
    <h1>Add Item</h1>
    
    <!-- Formulir untuk menambahkan item baru -->
    <form action="{{ route('items.store') }}" method="POST">
        <!-- Token CSRF untuk melindungi dari serangan CSRF -->
        @csrf
        
        <!-- Label dan input untuk nama item -->
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <br>
        <!--Label dan input teks untuk field "name", dengan atribut required untuk memastikan field ini tidak kosong.-->
        
        <!-- Label dan textarea untuk deskripsi item -->
        <label for="description">Description:</label>
        <textarea name="description" required></textarea>
        <br>
        <!--Label dan input teks untuk field "discription", dengan atribut required untuk memastikan field ini tidak kosong.-->
        
        <!-- Tombol untuk mengirim formulir -->
        <button type="submit">Add Item</button>
    </form>
    
    <!-- Tautan untuk kembali ke daftar item -->
    <a href="{{ route('items.index') }}">Back to List</a>
</body>
</html>
