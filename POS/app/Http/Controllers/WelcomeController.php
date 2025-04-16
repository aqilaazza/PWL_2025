<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\UserModel;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\PenjualanModel;
use App\Models\LevelModel;
use App\Models\SuplierModel;


class WelcomeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list'  => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboard';

        // Grafik Harian
        $dataHarian = DB::table('t_penjualan')
            ->select(DB::raw('DATE(penjualan_tanggal) as tanggal'), DB::raw('COUNT(*) as total'))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'ASC')
            ->get();

        $labelsHarian = $dataHarian->pluck('tanggal');
        $totalsHarian = $dataHarian->pluck('total');

        // Grafik Bulanan
        $dataBulanan = DB::table('t_penjualan')
            ->select(DB::raw("DATE_FORMAT(penjualan_tanggal, '%Y-%m') as bulan"), DB::raw('COUNT(*) as total'))
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->get();

        $labelsBulanan = $dataBulanan->pluck('bulan');
        $totalsBulanan = $dataBulanan->pluck('total');

        // Statistik Jumlah
        $jumlahUser      = DB::table('m_user')->count();
        $jumlahBarang    = DB::table('m_barang')->count();
        $jumlahKategori  = DB::table('m_kategori')->count();
        $jumlahTransaksi = DB::table('t_penjualan')->count();
        $jumlahLevel     = DB::table('m_level')->count();
        $jumlahSuplier   = DB::table('m_supplier')->count();


        //Grafik Barang Terjual
        $barangTerjual = DB::table('t_penjualan_detail')
        ->join('m_barang', 't_penjualan_detail.barang_id', '=', 'm_barang.barang_id')
        ->select('m_barang.barang_nama', DB::raw('SUM(t_penjualan_detail.jumlah) as total_terjual'))
        ->groupBy('m_barang.barang_nama')
        ->orderByDesc('total_terjual')
        ->limit(10)
        ->get();
    
    
        // Total Barang Terjual
        $totalBarangTerjual = $barangTerjual->sum('total_terjual');
        
        // Menghitung persentase dan menyiapkan data untuk pie chart
        $labelsBarang = $barangTerjual->pluck('barang_nama');
        $jumlahTerjual = $barangTerjual->pluck('total_terjual');
        $persentase = $barangTerjual->map(function($item) use ($totalBarangTerjual) {
            return ($item->total_terjual / $totalBarangTerjual) * 100;
        });


        // Tampilkan stok yang hampir habis 
        $stokHampirHabis = DB::table('m_barang')
        ->join('t_stok', 'm_barang.barang_id', '=', 't_stok.barang_id')  // Sesuaikan dengan kolom yang berelasi
        ->select('m_barang.barang_nama', 't_stok.stok_jumlah')
        ->where('t_stok.stok_jumlah', '<=', 5)
        ->orderBy('t_stok.stok_jumlah', 'asc')
        ->get();
    

        //Tampilkan Omset
        $omzet = DB::table('t_penjualan_detail')
        ->join('m_barang', 't_penjualan_detail.barang_id', '=', 'm_barang.barang_id')  // Menyesuaikan dengan kolom yang berelasi
        ->select(DB::raw('SUM(m_barang.harga_jual * t_penjualan_detail.jumlah) as total_omzet'))
        ->value('total_omzet');

        // Kirim semua data ke view
        return view('welcome', [
            'breadcrumb'      => $breadcrumb,
            'activeMenu'      => $activeMenu,
            'labelsHarian'    => $labelsHarian,
            'totalsHarian'    => $totalsHarian,
            'labelsBulanan'   => $labelsBulanan,
            'totalsBulanan'   => $totalsBulanan,
            'jumlahUser'      => $jumlahUser,
            'jumlahBarang'    => $jumlahBarang,
            'jumlahKategori'  => $jumlahKategori,
            'jumlahTransaksi' => $jumlahTransaksi,
            'jumlahLevel'     => $jumlahLevel,
            'jumlahSuplier'   => $jumlahSuplier,
            'labelsBarang'    => $labelsBarang,  
            'jumlahTerjual'   => $jumlahTerjual,
            'persentase'      => $persentase,
            'stokHampirHabis' => $stokHampirHabis,
            'omzet'           => $omzet,

        ]);
    }
}
