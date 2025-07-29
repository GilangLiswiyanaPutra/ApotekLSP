@extends('layouts.app')
@section('title', 'Transaksi Penjualan')

@push('styles')
<style>
    /* Enhanced styling untuk daftar produk dan keranjang */
    .product-grid { 
        max-height: 70vh; 
        overflow-y: auto; 
        padding-right: 15px; 
    }
    
    .product-card { 
        cursor: pointer; 
        border: 2px solid #404040; 
        transition: all 0.3s ease-in-out;
        border-radius: 10px;
        background: linear-gradient(145deg, #2a2a2a, #1a1a1a);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        position: relative;
        overflow: hidden;
    }
    
    /* Menambahkan overlay indicator untuk click */
    .product-card::before {
        content: '🛒 Klik untuk tambah ke keranjang';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 123, 255, 0.9);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1;
        font-size: 14px;
        text-align: center;
        padding: 10px;
        pointer-events: none; /* Allow clicks to pass through */
    }
    
    .product-card:hover::before {
        opacity: 1;
    }
    
    .product-card:hover { 
        border-color: #007bff; 
        transform: translateY(-8px);
        box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
        background: linear-gradient(145deg, #1a1a1a, #2a2a2a);
    }
    
    /* Loading state untuk card yang diklik */
    .product-card.loading {
        pointer-events: none;
        opacity: 0.7;
    }
    
    .product-card.loading::before {
        content: '⏳ Menambahkan...';
        opacity: 1;
        background: rgba(40, 167, 69, 0.9);
    }
    
    .product-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 8px 8px 0 0;
        background: #333;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #666;
        font-size: 40px;
        position: relative;
        z-index: 2; /* Ensure image is above the overlay */
        transition: all 0.3s ease;
    }
    
    .product-image:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.4);
    }
    
    .product-image img:hover {
        filter: brightness(1.1);
    }
    
    /* Image click indicator */
    .product-image::after {
        content: '🔍 Klik untuk melihat gambar';
        position: absolute;
        bottom: 5px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 500;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 4;
        pointer-events: none;
        white-space: nowrap;
    }
    
    .product-image:hover::after {
        opacity: 1;
    }
    
    .cart-items { 
        max-height: 45vh; 
        overflow-y: auto; 
    }
    
    .nav-tabs .nav-link.active {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
        color: #fff !important;
        border-radius: 8px 8px 0 0;
    }
    
    .nav-tabs .nav-link {
        border-radius: 8px 8px 0 0;
        margin-right: 5px;
        transition: all 0.2s ease;
    }
    
    .nav-tabs .nav-link:hover {
        background-color: #495057;
        color: #fff;
    }
    
    .search-box {
        border-radius: 25px;
        border: 2px solid #404040;
        background: #2a2a2a;
        color: #fff;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }
    
    .search-box:focus {
        border-color: #007bff;
        background: #1a1a1a;
        color: #fff;
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
    }
    
    .cart-card {
        border-radius: 15px;
        border: 2px solid #404040;
        background: linear-gradient(145deg, #2a2a2a, #1a1a1a);
    }
    
    .btn-primary {
        background: linear-gradient(45deg, #007bff, #0056b3);
        border: none;
        border-radius: 25px;
        padding: 12px 25px;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background: linear-gradient(45deg, #0056b3, #007bff);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
    }
    
    .stock-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(40, 167, 69, 0.9);
        color: white;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: bold;
    }
    
    .stock-low {
        background: rgba(220, 53, 69, 0.9);
    }
    
    .price-tag {
        background: linear-gradient(45deg, #28a745, #20c997);
        color: white;
        padding: 8px 15px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 14px;
    }
    
    .medicine-type-badge {
        background: rgba(108, 117, 125, 0.8);
        color: white;
        padding: 3px 8px;
        border-radius: 10px;
        font-size: 10px;
        position: absolute;
        top: 10px;
        left: 10px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="text-white mb-0">💊 Sistem Penjualan Obat</h2>
            <p class="text-muted">Pilih obat dan kelola transaksi penjualan dengan mudah</p>
        </div>
    </div>
    
    <div class="row">
        {{-- Kolom Kiri: Daftar Produk --}}
        <div class="col-lg-7 col-md-7">
            <div class="card bg-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title text-white mb-0">🔍 Pilih Obat</h4>
                        <div class="search-container" style="width: 300px;">
                            <input type="text" id="search-obat" class="form-control search-box" 
                                   placeholder="🔍 Cari nama obat..." autocomplete="off">
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
                                        <div class="card product-card position-relative" 
                                             data-id="{{ $obat->id }}" 
                                             data-kode="{{ $obat->kode_obat }}"
                                             data-nama="{{ $obat->nama }}" 
                                             data-harga="{{ $obat->harga_jual }}" 
                                             data-stok="{{ $obat->stok }}">
                                            
                                            <div class="medicine-type-badge">{{ $obat->jenis }}</div>
                                            <div class="stock-badge {{ $obat->stok <= 5 ? 'stock-low' : '' }}">
                                                {{ $obat->stok }} pcs
                                            </div>
                                            
                                            <div class="product-image" style="position: relative;">
                                                @if($obat->gambar && file_exists(public_path('storage/obat/' . $obat->gambar)))
                                                    <img src="{{ asset('storage/obat/' . $obat->gambar) }}" 
                                                         alt="{{ $obat->nama }}" class="product-image" 
                                                         style="cursor: pointer; z-index: 3;">
                                                @else
                                                    <i class="fas fa-pills" style="z-index: 3;"></i>
                                                @endif
                                            </div>
                                            
                                            <div class="card-body text-center p-3">
                                                <h6 class="card-title mb-2 text-white" style="min-height: 45px; font-size: 13px;">
                                                    {{ Str::limit($obat->nama, 35) }}
                                                </h6>
                                                <div class="mb-2">
                                                    <span class="price-tag">
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
                                            <div class="card product-card position-relative" 
                                                 data-id="{{ $obat->id }}" 
                                                 data-kode="{{ $obat->kode_obat }}"
                                                 data-nama="{{ $obat->nama }}" 
                                                 data-harga="{{ $obat->harga_jual }}" 
                                                 data-stok="{{ $obat->stok }}">
                                                
                                                <div class="stock-badge {{ $obat->stok <= 5 ? 'stock-low' : '' }}">
                                                    {{ $obat->stok }} pcs
                                                </div>
                                                
                                                <div class="product-image" style="position: relative;">
                                                    @if($obat->gambar && file_exists(public_path('storage/obat/' . $obat->gambar)))
                                                        <img src="{{ asset('storage/obat/' . $obat->gambar) }}" 
                                                             alt="{{ $obat->nama }}" class="product-image"
                                                             style="cursor: pointer; z-index: 3;">
                                                    @else
                                                        <i class="fas fa-pills" style="z-index: 3;"></i>
                                                    @endif
                                                </div>
                                                
                                                <div class="card-body text-center p-3">
                                                    <h6 class="card-title mb-2 text-white" style="min-height: 45px; font-size: 13px;">
                                                        {{ Str::limit($obat->nama, 35) }}
                                                    </h6>
                                                    <div class="mb-2">
                                                        <span class="price-tag">
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
            <div class="card cart-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title text-white mb-0">🛒 Keranjang Belanja</h4>
                        <button type="button" class="btn btn-outline-warning btn-sm" id="clear-cart">
                            🗑️ Kosongkan
                        </button>
                    </div>
                    
                    <form action="{{ route('penjualans.store') }}" method="POST" id="form-penjualan">
                        @csrf
                        <div class="cart-items mb-3">
                            <div class="table-responsive">
                                <table class="table table-dark">
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
                                <div class="col-6"><strong class="text-white">Total Item:</strong></div>
                                <div class="col-6 text-right"><span id="total-items" class="text-info">0</span></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6"><strong class="text-white">TOTAL HARGA:</strong></div>
                                <div class="col-6 text-right">
                                    <h5 id="total-harga" class="text-success mb-0">Rp 0</h5>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" id="process-transaction" disabled>
                                💳 PROSES TRANSAKSI
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            {{-- Transaksi Terakhir --}}
            <div class="card mt-4 bg-dark">
                <div class="card-body">
                    <h5 class="card-title text-white">📋 Transaksi Terakhir</h5>
                    <div class="list-group list-group-flush">
                        @forelse($recentSales as $sale)
                            <div class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-secondary">
                                <div>
                                    <a href="{{ route('penjualans.show', $sale->nota) }}" class="text-primary text-decoration-none">
                                        {{ $sale->nota }}
                                    </a>
                                    <br><small class="text-muted">{{ $sale->tanggal_nota }}</small>
                                </div>
                                <span class="badge badge-primary badge-pill">📄</span>
                            </div>
                        @empty
                            <div class="list-group-item bg-transparent border-0">
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
// Enhanced JavaScript for better cart functionality and search
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

        // Add to cart functionality with loading state
        $(document).on('click', '.product-card', function(e) {
            const $card = $(this);
            
            // Prevent double clicks during processing
            if ($card.hasClass('loading')) {
                return;
            }
            
            // Check if clicked on image - handle image click separately
            if ($(e.target).closest('.product-image').length > 0) {
                e.stopPropagation(); // Prevent cart addition when clicking on image
                handleImageClick($card, e);
                return;
            }
            
            // Add loading state
            $card.addClass('loading');
            
            const itemData = {
                id: $card.data('id'),
                kode: $card.data('kode'),
                nama: $card.data('nama'),
                harga: parseFloat($card.data('harga')),
                stok: parseInt($card.data('stok')),
            };

            // Simulate brief loading for better UX
            setTimeout(() => {
                if (itemData.stok <= 0) {
                    $card.removeClass('loading');
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
                $card.removeClass('loading');
            }, 300);
        });

        // Change quantity
        $(document).on('change', '.item-jumlah', function() {
            const itemId = $(this).data('id');
            const newJumlah = parseInt($(this).val());
            const item = cartItems.find(item => item.id === itemId);
            
            if (item && newJumlah > 0 && newJumlah <= item.stok) {
                item.jumlah = newJumlah;
            } else if (item) {
                $(this).val(item.jumlah);
                showNotification(`⚠️ Jumlah tidak valid untuk ${item.nama}`);
            }
            renderCart();
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
                                <strong class="text-white">${item.nama}</strong><br>
                                <small class="text-muted">Kode: ${item.kode}</small><br>
                                <small class="text-success">${formatRupiah(item.harga)}/pcs</small>
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm item-jumlah bg-secondary text-white text-center" 
                                       value="${item.jumlah}" min="1" max="${item.stok}" data-id="${item.id}" 
                                       style="width: 60px; margin: 0 auto;">
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

        // Handle image click for viewing
        function handleImageClick($card, e) {
            const imageUrl = $card.find('.product-image img').attr('src');
            const productName = $card.data('nama');
            
            if (imageUrl) {
                // Create image modal
                const modal = $(`
                    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content bg-dark">
                                <div class="modal-header border-secondary">
                                    <h5 class="modal-title text-white">${productName}</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center p-0">
                                    <img src="${imageUrl}" alt="${productName}" 
                                         class="img-fluid" style="max-height: 500px; object-fit: contain;">
                                </div>
                                <div class="modal-footer border-secondary">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    <button type="button" class="btn btn-primary" onclick="$(this).closest('.modal').modal('hide'); $('.product-card[data-nama=&quot;${productName}&quot;]').click();">
                                        🛒 Tambah ke Keranjang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
                
                // Remove existing modal if any
                $('#imageModal').remove();
                
                // Add modal to body and show
                $('body').append(modal);
                $('#imageModal').modal('show');
                
                // Remove modal when hidden
                $('#imageModal').on('hidden.bs.modal', function() {
                    $(this).remove();
                });
            }
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

        // Form submission validation
        $('#form-penjualan').on('submit', function(e) {
            if (cartItems.length === 0) {
                e.preventDefault();
                showNotification('❌ Keranjang masih kosong!');
                return false;
            }
            
            const totalAmount = cartItems.reduce((total, item) => total + (item.harga * item.jumlah), 0);
            const confirmed = confirm(`💳 Konfirmasi transaksi dengan total: ${formatRupiah(totalAmount)}?`);
            
            if (!confirmed) {
                e.preventDefault();
                return false;
            }
        });
    });
});
</script>
@endpush
