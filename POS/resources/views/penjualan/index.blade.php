@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/penjualan/import') }}')" class="btn btn-info">Import Penjualan</button>
                <a href="{{ url('/penjualan/export_excel') }}" class="btn btn-primary"><i class="fa fa-file- excel"></i> Export Penjualan (Xlsx)</a>
                <button onclick="modalAction('{{ url('/penjualan/create_ajax') }}')" class="btn btn-success">Tambah Data</button>
                <a href="{{ url('/penjualan/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file- pdf"></i> Export Penjualan (Pdf)</a>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-sm table-striped table-hover" id="table-penjualan" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Petugas</th>
                        <th>Kode Penjualan</th>
                        <th>Pembeli</th>
                        <th>Tanggal Penjualan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }

        var tablePenjualan;
        $(document).ready(function () {
            tablePenjualan = $('#table-penjualan').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('penjualan/list') }}",
                    dataType: "json",
                    type: "POST",
                    dataType: "json",
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        className: "text-center",
                        width: "5%",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "user.nama",
                        className: "",
                        width: "20%",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "penjualan_kode",
                        className: "",
                        width: "20%",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "pembeli",
                        className: "",
                        width: "20%",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "penjualan_tanggal",
                        className: "",
                        width: "20%",
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: "aksi",
                        className: "text-center",
                        width: "15%",
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#table-penjualan_filter input').unbind().bind().on('keyup', function (e) {
                if (e.keyCode === 13) {
                    tablePenjualan.search(this.value).draw();
                }
            });
        });
    </script>
@endpush