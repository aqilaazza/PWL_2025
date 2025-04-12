<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; 

class PenjualanController extends Controller
{
    // Halaman index daftar penjualan
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Penjualan',
            'list' => ['Home', 'Penjualan']
        ];

        $page = (object) [
            'title' => 'Penjualan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'penjualan';

        return view('penjualan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Mengambil daftar penjualan untuk DataTables
    public function list(Request $request)
    {
        $penjualans = PenjualanModel::with('user') 
            ->select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal')
            ->get();

        // Return data untuk DataTables
        return DataTables::of($penjualans)
            ->addIndexColumn()
            // Menambahkan kolom 'username' yang diambil dari relasi user
            ->addColumn('username', function ($penjualan) {
                return $penjualan->user->nama ?? 'N/A';  // Menampilkan username jika ada
            })
            ->addColumn('aksi', function ($penjualan) { 
                $btn = '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    //Show AJAX
    public function show_ajax(string $id)
    {
        $penjualan = PenjualanModel::select('penjualan_id', 'penjualan_kode', 'pembeli', 'penjualan_tanggal', 'user_id')
            ->with('user')
            ->find($id);

        return view('penjualan.show_ajax', ['penjualan' => $penjualan]);
    }

    // Create AJAX
    public function create_ajax()
    {
        $user = \App\Models\UserModel::all();
        return view('penjualan.create_ajax', compact('user'));
    }

    //Store AJAX
    public function store_ajax(Request $request)
    {
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_kode'    => 'required|string|min:3|unique:t_penjualan,penjualan_kode',
                'pembeli'           => 'required|min:3',
                'penjualan_tanggal' => 'required|date',
                'user_id'           => 'required|integer'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
            
            PenjualanModel::create($request->all());
            
            return response()->json([
                'status' => true,
                'message' => 'Data penjualan berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    //Edit AJAX
    public function edit_ajax(string $id)
    {
        $penjualan = PenjualanModel::find($id);
        $user = UserModel::select('user_id', 'nama')->get();
        
        return view('penjualan.edit_ajax', ['penjualan' => $penjualan, 'user' => $user]);
    }

    //Update AJAX
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_kode'    => 'required|string|min:3|unique:t_penjualan,penjualan_kode,'. $id . ',penjualan_id',
                'user_id'           => 'required|integer',
                'pembeli'           => 'required|min:3',
                'penjualan_tanggal' => 'required|date'
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }
    
            $check = PenjualanModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status'  => true,
                    'message' => 'Data penjualan berhasil diubah'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data penjualan tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    //Confirm AJAX
    public function confirm_ajax(string $id)
    {
        $penjualan = PenjualanModel::find($id);
        return view('penjualan.confirm_ajax', ['penjualan' => $penjualan]);
    }

    //Delete AJAX
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $penjualan = PenjualanModel::find($id);
            if ($penjualan) {
                $penjualan->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data penjualan berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data penjualantidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
}
