@extends('layouts.app')
@section('title', 'Transaksi Penjualan')

@push('styles')
<style>
    /* Styling untuk daftar produk dan keranjang */
    .product-grid { max-height: 65vh; overflow-y: auto; padding-right: 15px; }
    .product-card { 
        cursor: pointer; 
        border: 1px solid #444; 
        transition: all 0.2s ease-in-out;
    }
    .product-card:hover { 
        border-color: #007bff; 
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.1);
    }
    .cart-items { max-height: 40vh; overflow-y: auto; }
    .nav-tabs .nav-link.active {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
        color: #fff !important;
    }
</style>
@endpush

@section('content')
<div class="row">
    {{-- Kolom Kiri: Daftar Produk --}}
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pilih Obat</h4>
                {{-- Navigasi Tab untuk Jenis Obat --}}
                <ul class="nav nav-tabs" id="jenisObatTabs" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#semua" role="tab">Semua</a></li>
                    @foreach($jenisObat as $jenis)
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#{{ Str::slug($jenis->jenis) }}" role="tab">{{ $jenis->jenis }}</a></li>
                    @endforeach
                </ul>
                {{-- Konten Produk --}}
                <div class="tab-content product-grid mt-3">
                    <div class="tab-pane fade show active" id="semua" role="tabpanel">
                        <div class="row">
                            @forelse($obatsByJenis->flatten() as $obat)
                                {{-- Kode Kartu Produk Dimasukkan Langsung --}}
                                <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                                    <div class="card product-card bg-dark" 
                                         data-id="{{ $obat->id }}" 
                                         data-nama="{{ $obat->nama }}" 
                                         data-harga="{{ $obat->harga_jual }}" 
                                         data-stok="{{ $obat->stok }}">
                                        <div class="card-body text-center p-3">
                                            <h6 class="card-title mb-1" style="min-height: 40px;">{{ Str::limit($obat->nama, 30) }}</h6>
                                            <p class="text-muted small mb-2">Stok: {{ $obat->stok }}</p>
                                            <p class="font-weight-bold text-success mb-0">Rp {{ number_format($obat->harga_jual) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted col-12">Tidak ada obat yang tersedia.</p>
                            @endforelse
                        </div>
                    </div>
                    @foreach($obatsByJenis as $jenis => $obats)
                        <div class="tab-pane fade" id="{{ Str::slug($jenis) }}" role="tabpanel">
                            <div class="row">
                                @foreach($obats as $obat)
                                    {{-- Kode Kartu Produk Dimasukkan Langsung --}}
                                    <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                                        <div class="card product-card bg-dark" 
                                             data-id="{{ $obat->id }}" 
                                             data-nama="{{ $obat->nama }}" 
                                             data-harga="{{ $obat->harga_jual }}" 
                                             data-stok="{{ $obat->stok }}">
                                            <div class="card-body text-center p-3">
                                                <h6 class="card-title mb-1" style="min-height: 40px;">{{ Str::limit($obat->nama, 30) }}</h6>
                                                <p class="text-muted small mb-2">Stok: {{ $obat->stok }}</p>
                                                <p class="font-weight-bold text-success mb-0">Rp {{ number_format($obat->harga_jual) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Keranjang & Transaksi --}}
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Keranjang</h4>
                <form action="{{ route('penjualans.store') }}" method="POST" id="form-penjualan">
                    @csrf
                    <div class="table-responsive cart-items">
                        <table class="table">
                            <tbody id="keranjang">
                                <!-- Item keranjang akan diisi oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between font-weight-bold">
                        <h5>TOTAL</h5>
                        <h5 id="total-harga">Rp 0</h5>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mt-3">PROSES TRANSAKSI</button>
                </form>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Transaksi Terakhir</h5>
                <ul class="list-group list-group-flush">
                    @forelse($recentSales as $sale)
                        <li class="list-group-item d-flex justify-content-between bg-transparent">
                            <a href="{{ route('penjualan.show', $sale->nota) }}">{{ $sale->nota }}</a>
                            <span class="text-muted">{{ $sale->tgl_nota->format('d/m/y') }}</span>
                        </li>
                    @empty
                        <li class="list-group-item bg-transparent">Belum ada transaksi.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// [FIX] Menunggu semua aset (termasuk jQuery) dimuat sebelum menjalankan skrip
window.addEventListener('load', function () {
    // Kode jQuery Anda sekarang aman untuk dijalankan di sini
    $(document).ready(function() {
        let cartItems = [];

        $(document).on('click', '.product-card', function() {
            const itemData = {
                id: $(this).data('id'),
                nama: $(this).data('nama'),
                harga: parseFloat($(this).data('harga')),
                stok: parseInt($(this).data('stok')),
            };

            const existingItem = cartItems.find(item => item.id === itemData.id);
            if (existingItem) {
                if (existingItem.jumlah < itemData.stok) existingItem.jumlah++;
            } else {
                itemData.jumlah = 1;
                cartItems.push(itemData);
            }
            renderCart();
        });

        $(document).on('change', '.item-jumlah', function() {
            const itemId = $(this).data('id');
            const newJumlah = parseInt($(this).val());
            const item = cartItems.find(item => item.id === itemId);
            if (item && newJumlah > 0 && newJumlah <= item.stok) {
                item.jumlah = newJumlah;
            } else if (item) {
                $(this).val(item.jumlah); // Kembalikan ke nilai valid jika input salah
            }
            renderCart();
        });

        $(document).on('click', '.hapus-item', function() {
            const itemId = $(this).data('id');
            cartItems = cartItems.filter(item => item.id !== itemId);
            renderCart();
        });

        function renderCart() {
            const keranjangBody = $('#keranjang');
            const form = $('#form-penjualan');
            keranjangBody.empty();
            let grandTotal = 0;

            // Hapus input hidden lama sebelum render ulang
            form.find('input[name^="items"]').remove();

            if (cartItems.length === 0) {
                keranjangBody.html('<tr><td class="text-center text-muted py-4">Keranjang kosong.</td></tr>');
            } else {
                cartItems.forEach((item, index) => {
                    const subtotal = item.harga * item.jumlah;
                    grandTotal += subtotal;
                    const row = `
                        <tr>
                            <td>
                                ${item.nama} <br>
                                <small class="text-muted">${formatRupiah(item.harga)}</small>
                            </td>
                            <td class="text-right">
                                <input type="number" class="form-control form-control-sm item-jumlah bg-dark" value="${item.jumlah}" min="1" max="${item.stok}" data-id="${item.id}" style="width: 70px;">
                            </td>
                            <td class="text-right">${formatRupiah(subtotal)}</td>
                            <td><button type="button" class="btn btn-outline-danger btn-sm hapus-item" data-id="${item.id}">&times;</button></td>
                        </tr>
                    `;
                    keranjangBody.append(row);
                    
                    // Tambahkan input hidden untuk form submission
                    form.append(`<input type="hidden" name="items[${index}][obat_id]" value="${item.id}">`);
                    form.append(`<input type="hidden" name="items[${index}][jumlah]" value="${item.jumlah}">`);
                });
            }
            $('#total-harga').text(formatRupiah(grandTotal));
        }

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
        }
    });
});
</script>
@endpush
