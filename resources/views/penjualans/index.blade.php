@extends('layouts.app')
@section('title', 'Transaksi Penjualan')

@push('styles')
<style>
    /* Simple Bootstrap-based styling */
    .product-grid { 
        max-height: 70vh; 
        overflow-y: auto; 
    }
    
    .product-card { 
        cursor: pointer; 
        transition: all 0.3s ease;
        border-radius: 8px;
    }
    
    .product-card:hover { 
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    
    .product-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 8px 8px 0 0;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 40px;
    }
    
    .cart-items { 
        max-height: 45vh; 
        overflow-y: auto; 
    }
    
    .search-box {
        border-radius: 20px;
    }
    
    .stock-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 11px;
    }
    
    .stock-low {
        background-color: #dc3545 !important;
    }
    
    .medicine-type-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        font-size: 10px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    {{-- Display Success/Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0">💊 Sistem Penjualan Obat</h2>
            <p class="text-muted">Pilih obat dan kelola transaksi penjualan dengan mudah</p>
        </div>
    </div>
    
    <div class="row">
        {{-- Kolom Kiri: Daftar Produk --}}
        <div class="col-lg-7 col-md-7">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">🔍 Pilih Obat</h4>
                        <div class="d-flex align-items-center">
                            <a href="{{ route('penjualans.riwayat') }}" class="btn btn-outline-info btn-sm me-3">
                                <i class="fas fa-history"></i> Riwayat Penjualan
                            </a>
                            <div class="search-container" style="width: 300px;">
                                <input type="text" id="search-obat" class="form-control search-box" 
                                       placeholder="🔍 Cari nama obat..." autocomplete="off">
                            </div>
                        </div>
                    </div>
                    
                    {{-- Navigasi Tab untuk Jenis Obat --}}
                    <ul class="nav nav-tabs mb-3" id="jenisObatTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#semua" role="tab">
                                📋 Semua
                            </a>
                        </li>
                        @foreach($jenisObat as $jenis)
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#{{ Str::slug($jenis->jenis) }}" role="tab">
                                    💊 {{ $jenis->jenis }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    
                    {{-- Konten Produk --}}
                    <div class="tab-content product-grid">
                        <div class="tab-pane fade show active" id="semua" role="tabpanel">
                            <div class="row" id="all-products">
                                @forelse($obatsByJenis->flatten() as $obat)
                                    <div class="col-lg-4 col-md-6 col-sm-6 mb-4 product-item" 
                                         data-name="{{ strtolower($obat->nama) }}" 
                                         data-type="{{ strtolower($obat->jenis) }}">
                                        <div class="card product-card position-relative border" 
                                             data-id="{{ $obat->id }}" 
                                             data-kode="{{ $obat->kode_obat }}"
                                             data-nama="{{ $obat->nama }}" 
                                             data-harga="{{ $obat->harga_jual }}" 
                                             data-stok="{{ $obat->stok }}">
                                            
                                            <div class="badge badge-secondary medicine-type-badge">{{ $obat->jenis }}</div>
                                            <div class="badge badge-success stock-badge {{ $obat->stok <= 5 ? 'stock-low' : '' }}">
                                                {{ $obat->stok }} pcs
                                            </div>
                                            
                                            <div class="product-image">
                                                @if($obat->gambar && file_exists(public_path('storage/' . $obat->gambar)))
                                                    <img src="{{ asset('storage/' . $obat->gambar) }}" 
                                                         alt="{{ $obat->nama }}" class="product-image">
                                                @else
                                                    <i class="fas fa-pills"></i>
                                                @endif
                                            </div>
                                            
                                            <div class="card-body text-center p-3">
                                                <h6 class="card-title mb-2" style="min-height: 45px; font-size: 13px;">
                                                    {{ Str::limit($obat->nama, 35) }}
                                                </h6>
                                                <div class="mb-2">
                                                    <span class="badge badge-success">
                                                        Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                                <small class="text-muted">Kode: {{ $obat->kode_obat }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="text-center text-muted py-5">
                                            <i class="fas fa-box-open fa-3x mb-3"></i>
                                            <p>Tidak ada obat yang tersedia</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        
                        @foreach($obatsByJenis as $jenis => $obats)
                            <div class="tab-pane fade" id="{{ Str::slug($jenis) }}" role="tabpanel">
                                <div class="row">
                                    @foreach($obats as $obat)
                                        <div class="col-lg-4 col-md-6 col-sm-6 mb-4 product-item" 
                                             data-name="{{ strtolower($obat->nama) }}">
                                            <div class="card product-card position-relative border" 
                                                 data-id="{{ $obat->id }}" 
                                                 data-kode="{{ $obat->kode_obat }}"
                                                 data-nama="{{ $obat->nama }}" 
                                                 data-harga="{{ $obat->harga_jual }}" 
                                                 data-stok="{{ $obat->stok }}">
                                                
                                                <div class="badge badge-success stock-badge {{ $obat->stok <= 5 ? 'stock-low' : '' }}">
                                                    {{ $obat->stok }} pcs
                                                </div>
                                                
                                                <div class="product-image">
                                                    @if($obat->gambar && file_exists(public_path('storage/' . $obat->gambar)))
                                                        <img src="{{ asset('storage/' . $obat->gambar) }}" 
                                                             alt="{{ $obat->nama }}" class="product-image">
                                                    @else
                                                        <i class="fas fa-pills"></i>
                                                    @endif
                                                </div>
                                                
                                                <div class="card-body text-center p-3">
                                                    <h6 class="card-title mb-2" style="min-height: 45px; font-size: 13px;">
                                                        {{ Str::limit($obat->nama, 35) }}
                                                    </h6>
                                                    <div class="mb-2">
                                                        <span class="badge badge-success">
                                                            Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}
                                                        </span>
                                                    </div>
                                                    <small class="text-muted">Kode: {{ $obat->kode_obat }}</small>
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
        <div class="col-lg-5 col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">🛒 Keranjang Belanja</h4>
                        <button type="button" class="btn btn-outline-warning btn-sm" id="clear-cart">
                            🗑️ Kosongkan
                        </button>
                    </div>
                    
                    <form action="{{ route('penjualans.store') }}" method="POST" id="form-penjualan">
                        @csrf
                        <div class="cart-items mb-3">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-right">Subtotal</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="keranjang">
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">
                                                <i class="fas fa-shopping-cart fa-2x mb-2"></i><br>
                                                Keranjang kosong.<br>
                                                <small>Klik pada produk untuk menambahkan ke keranjang</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="border-top pt-3">
                            <div class="row mb-2">
                                <div class="col-6"><strong>Total Item:</strong></div>
                                <div class="col-6 text-right"><span id="total-items" class="text-primary">0</span></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6"><strong>TOTAL HARGA:</strong></div>
                                <div class="col-6 text-right">
                                    <h5 id="total-harga" class="text-success mb-0">Rp 0</h5>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block btn-lg" id="process-transaction" disabled>
                                💳 PROSES TRANSAKSI
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            {{-- Transaksi Terakhir --}}
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">📋 Transaksi Terakhir</h5>
                    <div class="list-group list-group-flush">
                        @forelse($recentSales as $sale)
                            <div class="list-group-item mb-2 border rounded">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <a href="{{ route('penjualans.show', $sale->nota) }}" class="text-primary text-decoration-none fw-bold">
                                            {{ $sale->nota }}
                                        </a>
                                        <br><small class="text-muted">{{ \Carbon\Carbon::parse($sale->tanggal_nota)->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <div class="text-right">
                                        <span class="badge badge-primary">
                                            {{ $sale->details->count() }} Item{{ $sale->details->count() > 1 ? 's' : '' }}
                                        </span>
                                    </div>
                                </div>
                                
                                @if($sale->details && $sale->details->count() > 0)
                                    <div class="mt-2">
                                        <small class="text-muted">Obat yang dibeli:</small>
                                        <div class="mt-1">
                                            @foreach($sale->details->take(3) as $index => $detail)
                                                @if($detail->obat)
                                                    <span class="badge badge-info me-1 mb-1">
                                                        <i class="fas fa-pills"></i> {{ $detail->obat->nama }} ({{ $detail->jumlah }}x)
                                                    </span>
                                                @endif
                                            @endforeach
                                            @if($sale->details->count() > 3)
                                                <small class="text-muted">...dan {{ $sale->details->count() - 3 }} obat lainnya</small>
                                            @endif
                                        </div>
                                        
                                        @if($sale->details->where('obat', '!=', null)->count() > 0)
                                            @php
                                                $totalAmount = $sale->details->sum(function($detail) {
                                                    return $detail->obat ? $detail->obat->harga_jual * $detail->jumlah : 0;
                                                });
                                            @endphp
                                            <div class="mt-2">
                                                <small class="text-success fw-bold">
                                                    <i class="fas fa-money-bill-wave"></i> Total: Rp {{ number_format($totalAmount, 0, ',', '.') }}
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <small class="text-warning">
                                        <i class="fas fa-exclamation-triangle"></i> Detail transaksi tidak ditemukan
                                    </small>
                                @endif
                            </div>
                        @empty
                            <div class="list-group-item border-0">
                                <div class="text-center text-muted">
                                    <i class="fas fa-receipt fa-2x mb-2"></i><br>
                                    Belum ada transaksi
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('vendors/js/vendor.bundle.base.js')}}"></script>
<script>
// Simplified JavaScript for basic cart functionality
window.addEventListener('load', function () {
    $(document).ready(function() {
        let cartItems = [];

        // Search functionality
        $('#search-obat').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            $('.product-item').each(function() {
                const productName = $(this).data('name');
                if (productName.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Add to cart functionality
        $(document).on('click', '.product-card', function(e) {
            const $card = $(this);
            
            const itemData = {
                id: $card.data('id'),
                kode: $card.data('kode'),
                nama: $card.data('nama'),
                harga: parseFloat($card.data('harga')),
                stok: parseInt($card.data('stok')),
            };

            if (itemData.stok <= 0) {
                showNotification('❌ Stok obat tidak tersedia!', 'danger');
                return;
            }

            const existingItem = cartItems.find(item => item.id === itemData.id);
            
            if (existingItem) {
                if (existingItem.jumlah < itemData.stok) {
                    existingItem.jumlah++;
                    showNotification(`✅ ${itemData.nama} ditambahkan ke keranjang (${existingItem.jumlah} pcs)`, 'success');
                } else {
                    showNotification(`⚠️ Stok ${itemData.nama} tidak mencukupi! (Max: ${itemData.stok} pcs)`, 'warning');
                }
            } else {
                itemData.jumlah = 1;
                cartItems.push(itemData);
                showNotification(`✅ ${itemData.nama} ditambahkan ke keranjang`, 'success');
            }
            
            renderCart();
        });

        // Change quantity with plus/minus buttons
        $(document).on('click', '.increase-qty', function() {
            const itemId = $(this).data('id');
            const item = cartItems.find(item => item.id === itemId);
            
            if (item && item.jumlah < item.stok) {
                item.jumlah++;
                renderCart();
            } else if (item) {
                showNotification(`⚠️ Stok ${item.nama} tidak mencukupi`);
            }
        });

        $(document).on('click', '.decrease-qty', function() {
            const itemId = $(this).data('id');
            const item = cartItems.find(item => item.id === itemId);
            
            if (item && item.jumlah > 1) {
                item.jumlah--;
                renderCart();
            } else if (item && item.jumlah === 1) {
                showNotification(`⚠️ Jumlah minimal adalah 1. Gunakan tombol hapus untuk menghapus item.`);
            }
        });

        // Remove item
        $(document).on('click', '.hapus-item', function() {
            const itemId = $(this).data('id');
            const item = cartItems.find(item => item.id === itemId);
            cartItems = cartItems.filter(item => item.id !== itemId);
            if (item) {
                showNotification(`🗑️ ${item.nama} dihapus dari keranjang`);
            }
            renderCart();
        });

        // Clear cart
        $('#clear-cart').click(function() {
            if (cartItems.length > 0) {
                if (confirm('🗑️ Yakin ingin mengosongkan keranjang?')) {
                    cartItems = [];
                    renderCart();
                    showNotification('🗑️ Keranjang dikosongkan');
                }
            }
        });

        // Render cart
        function renderCart() {
            const keranjangBody = $('#keranjang');
            const form = $('#form-penjualan');
            const processBtn = $('#process-transaction');
            
            keranjangBody.empty();
            
            let grandTotal = 0;
            let totalItems = 0;

            // Remove old hidden inputs
            form.find('input[name^="items"]').remove();

            if (cartItems.length === 0) {
                keranjangBody.html(`
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            <i class="fas fa-shopping-cart fa-2x mb-2"></i><br>
                            Keranjang kosong.<br>
                            <small>Klik pada produk untuk menambahkan ke keranjang</small>
                        </td>
                    </tr>
                `);
                processBtn.prop('disabled', true);
            } else {
                cartItems.forEach((item, index) => {
                    const subtotal = item.harga * item.jumlah;
                    grandTotal += subtotal;
                    totalItems += item.jumlah;
                    
                    const row = `
                        <tr>
                            <td>
                                <strong>${item.nama}</strong><br>
                                <small class="text-muted">Kode: ${item.kode}</small><br>
                                <small class="text-success">${formatRupiah(item.harga)}/pcs</small>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <button type="button" class="btn btn-outline-secondary btn-sm me-1 decrease-qty" data-id="${item.id}" style="width: 25px; height: 25px; padding: 0;">-</button>
                                    <span class="font-weight-bold mx-2" id="qty-${item.id}">${item.jumlah}</span>
                                    <button type="button" class="btn btn-outline-secondary btn-sm ms-1 increase-qty" data-id="${item.id}" style="width: 25px; height: 25px; padding: 0;">+</button>
                                </div>
                                <small class="text-muted">max: ${item.stok}</small>
                            </td>
                            <td class="text-right">
                                <strong class="text-success">${formatRupiah(subtotal)}</strong>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm hapus-item" data-id="${item.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    keranjangBody.append(row);
                    
                    // Add hidden inputs for form submission
                    form.append(`<input type="hidden" name="items[${index}][kode_obat]" value="${item.kode}">`);
                    form.append(`<input type="hidden" name="items[${index}][jumlah]" value="${item.jumlah}">`);
                });
                processBtn.prop('disabled', false);
            }
            
            $('#total-harga').text(formatRupiah(grandTotal));
            $('#total-items').text(totalItems + ' item');
        }

        // Format currency
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', { 
                style: 'currency', 
                currency: 'IDR', 
                minimumFractionDigits: 0 
            }).format(angka);
        }

        // Show notification with type
        function showNotification(message, type = 'info') {
            // Mapping type to Bootstrap alert classes
            const alertClass = {
                'success': 'alert-success',
                'danger': 'alert-danger', 
                'warning': 'alert-warning',
                'info': 'alert-info'
            };
            
            const notification = $(`
                <div class="alert ${alertClass[type]} alert-dismissible fade show position-fixed" 
                     style="top: 20px; right: 20px; z-index: 9999; max-width: 350px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                    <strong>${message}</strong>
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            `);
            
            $('body').append(notification);
            
            // Auto dismiss notification
            setTimeout(() => {
                notification.alert('close');
            }, type === 'success' ? 2000 : 4000);
        }

        // Form submission with simple confirmation
        $('#form-penjualan').on('submit', function(e) {
            if (cartItems.length === 0) {
                e.preventDefault();
                showNotification('❌ Keranjang masih kosong!', 'danger');
                return false;
            }
            
            const totalAmount = cartItems.reduce((total, item) => total + (item.harga * item.jumlah), 0);
            
            const confirmed = confirm(`Yakin ingin memproses transaksi dengan total Rp ${formatRupiah(totalAmount)}?`);
            
            if (!confirmed) {
                e.preventDefault();
                return false;
            }
        });
    });
});
</script>
@endpush
