@extends('layouts.template')

@section('content')
<div class="card shadow-lg border-0">
    <div class="card-header bg-gradient-primary text-white d-flex align-items-center">
        <i class="fas fa-user-circle fa-2x mr-3"></i>
        <h3 class="card-title mb-0">Profil Pengguna</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Kolom kiri: Foto profil dan form upload -->
            <div class="col-md-4 text-center border-right">
                <!-- Foto profil -->
                <img 
                    src="{{ $user->profile_picture ? asset('storage/'.$user->profile_picture) : asset('img/default-profile.png') }}" 
                    class="rounded-circle shadow mb-3 border border-primary"
                    alt="User Image" 
                    id="preview-image"
                    style="width: 180px; height: 180px; object-fit: cover; transition: 0.3s ease-in-out;">

                <!-- Form upload foto -->
                <form action="{{ route('user.updatePhoto') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group text-left">
                        <label for="profile_picture" class="font-weight-bold text-secondary">Ganti Foto Profil</label>
                        <input 
                            type="file" 
                            class="form-control-file border p-2 rounded shadow-sm" 
                            id="profile_picture" 
                            name="profile_picture" 
                            accept="image/*">
                        @error('profile_picture')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-outline-primary btn-sm mt-2">
                        <i class="fas fa-upload mr-1"></i> Upload Foto
                    </button>
                </form>
            </div>

            <!-- Kolom kanan: Data user -->
            <div class="col-md-8">
                <h4 class="mb-4 text-primary"><i class="fas fa-id-badge mr-2"></i>Data Akun</h4>
                <table class="table table-borderless table-sm">
                    <tr>
                        <td class="text-muted" style="width: 30%;"><strong>Username</strong></td>
                        <td>: {{ $user->username }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted"><strong>Nama</strong></td>
                        <td>: {{ $user->nama }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted"><strong>Level</strong></td>
                        <td>: {{ $user->level->level_nama ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function () {
            $('#profile_picture').on('change', function () {
                // Tampilkan nama file
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName);

                // Preview gambar
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#preview-image').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
@endpush
