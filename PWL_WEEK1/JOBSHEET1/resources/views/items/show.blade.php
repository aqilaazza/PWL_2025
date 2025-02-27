<!DOCTYPE html>
<html>
<head>
    <title>Item List</title>
</head>
<body>
    <h1>Items</h1>
    
    <!-- Menampilkan pesan sukses jika ada -->
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif
    
    <!-- Tautan untuk menambahkan item baru -->
    <a href="{{ route('items.create') }}">Add Item</a>
    
    <!-- Daftar item -->
    <ul>
        <!-- Loop melalui setiap item dan tampilkan -->
        @foreach ($items as $item)
            <li>
                <!-- Menampilkan nama item -->
                {{ $item->name }} - 
                
                <!-- Tautan untuk mengedit item -->
                <a href="{{ route('items.edit', $item) }}">Edit</a>
                
                <!-- Formulir untuk menghapus item -->
                <form action="{{ route('items.destroy', $item) }}" method="POST" style="display:inline;">
                    <!-- Token CSRF untuk keamanan -->
                    @csrf
                    <!-- Metode DELETE untuk penghapusan -->
                    @method('DELETE')
                    <!-- Tombol untuk menghapus item -->
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
