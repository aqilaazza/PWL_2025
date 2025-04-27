@extends('layouts.template')

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Hai, Selamat Datang di POS! 👋</h3>
        <div class="card-tools">x</div>
    </div>
    <div class="card-body">
        Welcome back, {{ Auth::user()->username }}!  
        Semangat kerja hari ini ya 💪  
        Yuk, mulai aktivitasmu di halaman utama ini, {{ Auth::user()->nama }}.
    </div>
</div>

<!-- Menambahkan row untuk jumlah menu -->
<div class="row mt-4">
    <div class="col-md-2">
        <div class="small-box bg-primary">
            <div class="inner">
                <h4>{{ $jumlahUser }}</h4>
                <p>Jumlah User</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="small-box bg-success">
            <div class="inner">
                <h4>{{ $jumlahBarang }}</h4>
                <p>Jumlah Barang</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="small-box bg-warning">
            <div class="inner">
                <h4>{{ $jumlahKategori }}</h4>
                <p>Jumlah Kategori</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="small-box bg-danger">
            <div class="inner">
                <h4>{{ $jumlahTransaksi }}</h4>
                <p>Jumlah Transaksi</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="small-box bg-info">
            <div class="inner">
                <h4>{{ $jumlahLevel }}</h4>
                <p>Jumlah Level User</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h4>{{ $jumlahSuplier }}</h4>
                <p>Jumlah Supplier</p>
            </div>
        </div>
    </div>
</div>

<!-- Menambahkan row untuk stok hampir habis -->
<div class="row mt-4">
    <div class="col-md-6">
        <h5 class="mb-3">⚠️ Stok Barang Hampir Habis</h5>
        <div class="list-group">
            @foreach ($stokHampirHabis as $barang)
                <a href="#" class="list-group-item list-group-item-action">
                    {{ $barang->barang_nama }} - Stok: {{ $barang->stok_jumlah }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Menambahkan row untuk omzet -->
    <div class="col-md-6">
        <h5 class="mb-3">💸 Total Omzet Penjualan</h5>
        <p class="h4">Rp {{ number_format($omzet, 0, ',', '.') }}</p>
    </div>
</div>

<!-- Menambahkan row untuk grafik penjualan-->
<div class="row mt-4">
    <div class="col-md-6">
        <h5>📊 Grafik Penjualan per Hari</h5>
        <canvas id="grafikHarian" height="100"></canvas>
    </div>

    <div class="col-md-6">
        <h5>📈 Grafik Penjualan per Bulan</h5>
        <canvas id="grafikBulanan" height="100"></canvas>
    </div>
</div>

<!-- Menambahkan grafik barang yang terjual -->
<div class="row mt-4">
    <div class="col-md-6 d-flex align-items-center">
        <h5>📊 Diagram TOP 10 Penjualan</h5>
        {{-- Pie Chart di sebelah kiri --}}
        <div style="width: 300px; height: 300px;">
            <canvas id="pieChart"></canvas>
        </div>
    </div>

    {{-- Label di sebelah kanan --}}
    <div class="col-md-6">
        <h5 class="mb-3">Top 10 Barang Terjual</h5>
        <ul class="list-unstyled">
            @foreach ($labelsBarang as $index => $label)
                <li class="mb-1">
                    <span style="display:inline-block;width:12px;height:12px;
                        background-color: {{ ['#007bff','#28a745','#ffc107','#dc3545','#6610f2',
                        '#20c997','#fd7e14','#6f42c1','#17a2b8','#e83e8c'][$index] ?? '#ccc' }};
                        margin-right:8px;border-radius:2px;"></span>
                    {{ $label }} - {{ number_format($persentase[$index], 2) }}%
                </li>
            @endforeach
        </ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grafik Penjualan Harian
    const ctxHarian = document.getElementById('grafikHarian').getContext('2d');
    const chartHarian = new Chart(ctxHarian, {
        type: 'line',
        data: {
            labels: @json($labelsHarian),
            datasets: [{
                label: 'Penjualan Harian',
                data: @json($totalsHarian),
                borderColor: 'rgba(75, 192, 192, 1)',
                fill: false,
                tension: 0.4
            }]
        }
    });

    // Grafik Penjualan Bulanan
    const ctxBulanan = document.getElementById('grafikBulanan').getContext('2d');
    const chartBulanan = new Chart(ctxBulanan, {
        type: 'bar',
        data: {
            labels: @json($labelsBulanan),
            datasets: [{
                label: 'Penjualan Bulanan',
                data: @json($totalsBulanan),
                backgroundColor: 'rgba(153, 102, 255, 0.5)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Grafik Barang Terjual (Pie Chart)
    const ctx = document.getElementById('pieChart').getContext('2d');
    const pieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($labelsBarang) !!},
            datasets: [{
                data: {!! json_encode($jumlahTerjual) !!},
                backgroundColor: [
                    '#007bff', '#28a745', '#ffc107', '#dc3545', '#6610f2',
                    '#20c997', '#fd7e14', '#6f42c1', '#17a2b8', '#e83e8c'
                ]
            }]
        },
        options: {
            responsive: false,
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>

@endsection
