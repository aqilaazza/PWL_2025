@empty($penjualan)
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal">
                <span>×</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">Data tidak ditemukan.</div>
        </div>
    </div>
</div>
@else
<div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 350px;">
    <div class="modal-content">
        <div class="modal-body px-3 py-2">

            {{-- Cover Header --}}
            <div class="text-center mb-2">
                <img src="{{ asset('polinema-bw.png') }}" style="height: 60px; max-width: 100px;">
                <div style="font-size: 9pt; font-weight: bold; margin-top: 4px;">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</div>
                <div style="font-size: 10pt; font-weight: bold;">POLITEKNIK NEGERI MALANG</div>
                <div style="font-size: 8pt;">Jl. Soekarno-Hatta No. 9 Malang 65141</div>
                <div style="font-size: 8pt;">Telp. (0341) 404424, Fax. (0341) 404420</div>
                <div style="font-size: 8pt;">www.polinema.ac.id</div>
            </div>

            {{-- Garis Pembatas --}}
            <hr style="border-top: 1px dashed #000; margin-top: 5px; margin-bottom: 10px;">

            <div class="receipt" style="font-family: 'Courier New', Courier, monospace; font-size: 13px;">
                <p><strong>Kode Penjualan:</strong> {{ $penjualan->penjualan_kode }}</p>
                <p><strong>Petugas:</strong> {{ $penjualan->user->nama ?? '-' }}</p>
                <p><strong>Pembeli:</strong> {{ $penjualan->pembeli }}</p>
                <p><strong>Tanggal:</strong> {{ $penjualan->penjualan_tanggal }}</p>
                <hr>
                <table width="100%">
                    @php $total = 0; @endphp
                    @foreach ($penjualan->details as $detail)
                        @php
                            $nama = $detail->barang->barang_nama ?? '-';
                            $jumlah = $detail->jumlah;
                            $harga = $detail->harga;
                            $subtotal = $jumlah * $harga;
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td colspan="2"><strong>{{ $nama }}</strong></td>
                        </tr>
                        <tr>
                            <td>{{ $jumlah }} x Rp {{ number_format($harga, 0, ',', '.') }}</td>
                            <td style="text-align: right;">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </table>
                <hr>
                <p style="text-align: right;"><strong>Total: Rp {{ number_format($total, 0, ',', '.') }}</strong></p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-success" onclick="window.print()">Cetak Struk</button>
        </div>
    </div>
</div>
@endempty

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .modal-content, .modal-content * {
            visibility: visible;
        }
        .modal-content {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .modal-footer {
            display: none;
        }
        h5, h3 {
            text-align: center;
        }
        .receipt {
            font-family: "Courier New", Courier, monospace;
            font-size: 14px;
            line-height: 1.5;
            width: 260px;
            margin: 0 auto;
            padding: 10px;
        }
        .receipt hr {
            border: 1px solid #000;
        }
        .receipt p {
            margin: 0;
            padding: 3px 0;
        }
        .receipt table {
            width: 100%;
        }
        .receipt table td {
            padding: 2px 0;
        }
    }
</style>
