@extends('layouts.app')
@section('title', 'Riwayat Penjualan')

@push('styles')
<style>
    .stats-card {
        background: linear-gradient(145deg, #2a2a2a, #1a1a1a);
        border: 2px solid #404040;
        border-radius: 15px;
        transition: all 0.3s ease;
    }
    
    .stats-card:hover {
        border-color: #007bff;
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
    }
    
    .stats-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
    }
    
    .transaction-card {
        background: linear-gradient(145deg, #2a2a2a, #1a1a1a);
        border: 2px solid #404040;
        border-radius: 12px;
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }
    
    .transaction-card:hover {
        border-color: #28a745;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);
    }
    
    .medicine-item {
        background: rgba(0, 123, 255, 0.1);
        border: 1px solid rgba(0, 123, 255, 0.3);
        border-radius: 8px;
        padding: 8px 12px;
        margin: 5px;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .medicine-item:hover {
        background: rgba(0, 123, 255, 0.2);
        transform: translateX(5px);
    }
    
    .medicine-image img:hover {
        transform: scale(1.1);
        transition: all 0.3s ease;
    }
    
    .filter-section {
        background: linear-gradient(145deg, #2a2a2a, #1a1a1a);
        border: 2px solid #404040;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 30px;
    }
    
    .search-box {
        border-radius: 25px;
        border: 2px solid #404040;
        background: #3a3a3a;
        color: #fff;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }
    
    .search-box:focus {
        border-color: #007bff;
        background: #2a2a2a;
        color: #fff;
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
    }
    
    .top-medicine-item {
        background: linear-gradient(45deg, #28a745, #20c997);
        border-radius: 10px;
        padding: 10px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }
    
    .top-medicine-item:hover {
        transform: translateX(10px);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }
    
    .pagination .page-link {
        background-color: #2a2a2a;
        border-color: #404040;
        color: #fff;
    }
    
    .pagination .page-link:hover {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
    }
    
    /* Enhanced search and filter styling */
    .search-box:focus {
        border-color: #007bff !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
    }
    
    .input-group-text {
        background: #404040 !important;
        border-color: #404040 !important;
    }
    
    .filter-section .btn-outline-primary:hover,
    .filter-section .btn-outline-success:hover,
    .filter-section .btn-outline-info:hover,
    .filter-section .btn-outline-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    }
    
    #results-counter {
        animation: fadeIn 0.3s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .clear-search {
        transition: all 0.2s ease;
    }
    
    .clear-search:hover {
        color: #007bff !important;
        transform: scale(1.1);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    {{-- Header Section --}}
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="text-white mb-0">📊 Riwayat Penjualan</h2>
            <p class="text-muted">Laporan lengkap penjualan obat dan statistik toko</p>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <div class="stats-icon text-primary">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <h3 class="text-white">{{ number_format($totalTransaksi) }}</h3>
                    <p class="text-muted mb-0">Total Transaksi</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <div class="stats-icon text-success">
                        <i class="fas fa-pills"></i>
                    </div>
                    <h3 class="text-white">{{ number_format($totalObatTerjual) }}</h3>
                    <p class="text-muted mb-0">Obat Terjual</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <div class="stats-icon text-info">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <h3 class="text-white">{{ \Carbon\Carbon::today()->format('d/m/Y') }}</h3>
                    <p class="text-muted mb-0">Hari Ini</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <div class="stats-icon text-warning">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="text-white">{{ $riwayatPenjualan->count() }}</h3>
                    <p class="text-muted mb-0">Transaksi Periode Ini</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Main Content: Transaction History --}}
        <div class="col-lg-8">
            {{-- Filter Section --}}
            <div class="filter-section card bg-dark border-secondary mb-4">
                <div class="card-body">
                    <h5 class="text-white mb-3">
                        <i class="fas fa-search text-primary"></i> Filter & Pencarian
                    </h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-white-50 mb-1">
                                <i class="fas fa-search"></i> Cari Transaksi
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-secondary border-secondary">
                                        <i class="fas fa-search text-white-50"></i>
                                    </span>
                                </div>
                                <input type="text" id="search-transaction" class="form-control search-box" 
                                       placeholder="Cari nomor nota, nama obat, atau kasir..."
                                       style="background: #2a2a2a; border-color: #404040; color: white;">
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> 
                                Tips: Gunakan spasi untuk mencari beberapa kata sekaligus
                            </small>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-white-50 mb-1">
                                <i class="fas fa-calendar"></i> Bulan
                            </label>
                            <select id="filter-month" class="form-control search-box"
                                    style="background: #2a2a2a; border-color: #404040; color: white;">
                                <option value="">Semua Bulan</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ date('n') == $i ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->locale('id')->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-white-50 mb-1">
                                <i class="fas fa-calendar-alt"></i> Tahun
                            </label>
                            <select id="filter-year" class="form-control search-box"
                                    style="background: #2a2a2a; border-color: #404040; color: white;">
                                <option value="">Semua Tahun</option>
                                @for($year = date('Y'); $year >= date('Y') - 5; $year--)
                                    <option value="{{ $year }}" {{ date('Y') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    
                    {{-- Quick Filter Buttons --}}
                    <div class="row mt-3">
                        <div class="col-12">
                            <label class="text-white-50 mb-2">
                                <i class="fas fa-bolt"></i> Filter Cepat
                            </label>
                            <div class="btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="quickFilter('today')">
                                    <i class="fas fa-calendar-day"></i> Hari Ini
                                </button>
                                <button type="button" class="btn btn-outline-success btn-sm" onclick="quickFilter('week')">
                                    <i class="fas fa-calendar-week"></i> Minggu Ini
                                </button>
                                <button type="button" class="btn btn-outline-info btn-sm" onclick="quickFilter('month')">
                                    <i class="fas fa-calendar"></i> Bulan Ini
                                </button>
                                <button type="button" class="btn btn-outline-warning btn-sm" onclick="clearAllFilters()">
                                    <i class="fas fa-times"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Search Tips --}}
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="fas fa-keyboard"></i> 
                            <strong>Shortcut:</strong> Ctrl+F untuk fokus pencarian, Escape untuk hapus pencarian
                        </small>
                    </div>
                </div>
            </div>

            {{-- Transaction List --}}
            <div id="transaction-list">
                @forelse($riwayatPenjualan as $penjualan)
                    <div class="transaction-card" data-nota="{{ $penjualan->nota }}" 
                         data-date="{{ $penjualan->tanggal_nota }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-2" style="display: none;" id="bulk-checkbox-{{ $penjualan->nota }}">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input transaction-checkbox" 
                                               id="checkbox-{{ $penjualan->nota }}" value="{{ $penjualan->nota }}"
                                               onchange="updateBulkDeleteButton()">
                                        <label class="custom-control-label text-white" for="checkbox-{{ $penjualan->nota }}">
                                            <strong>Pilih untuk dihapus</strong>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="text-primary mb-1">
                                                <i class="fas fa-receipt"></i> {{ $penjualan->nota }}
                                            </h5>
                                            <p class="text-muted mb-1">
                                                <i class="fas fa-calendar"></i> 
                                                {{ \Carbon\Carbon::parse($penjualan->tanggal_nota)->format('d F Y, H:i') }}
                                            </p>
                                            @if($penjualan->user)
                                                <p class="text-muted mb-0">
                                                    <i class="fas fa-user"></i> 
                                                    Kasir: <span class="cashier-name">{{ $penjualan->user->name ?? 'System' }}</span>
                                                </p>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <span class="badge badge-success badge-lg">
                                                {{ $penjualan->details->count() }} Item{{ $penjualan->details->count() > 1 ? 's' : '' }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Medicine Details --}}
                                    <div class="mb-3">
                                        <h6 class="text-white mb-2">💊 Obat yang Dibeli:</h6>
                                        <div class="medicine-list" style="display: flex; flex-direction: column; gap: 10px;">
                                            @foreach($penjualan->details as $detail)
                                                @if($detail->obat)
                                                    <div class="medicine-item d-flex align-items-center">
                                                        <div class="medicine-image me-3" style="width: 50px; height: 50px; min-width: 50px;">
                                                            @if($detail->obat->gambar && file_exists(public_path('storage/' . $detail->obat->gambar)))
                                                                <img src="{{ asset('storage/' . $detail->obat->gambar) }}" 
                                                                     alt="{{ $detail->obat->nama }}" 
                                                                     class="img-fluid rounded"
                                                                     style="width: 50px; height: 50px; object-fit: cover; cursor: pointer;"
                                                                     onclick="showMedicineImage('{{ asset('storage/' . $detail->obat->gambar) }}', '{{ $detail->obat->nama }}')">
                                                            @else
                                                                <div class="d-flex align-items-center justify-content-center bg-secondary rounded" 
                                                                     style="width: 50px; height: 50px;">
                                                                    <i class="fas fa-pills text-white"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <strong class="medicine-name">{{ $detail->obat->nama }}</strong>
                                                            <br>
                                                            <small class="text-muted medicine-details">
                                                                <span class="medicine-code">Kode: {{ $detail->kode_obat }}</span> | 
                                                                <span class="medicine-quantity">Qty: {{ $detail->jumlah }} pcs</span> | 
                                                                <span class="medicine-price">@{{ number_format($detail->obat->harga_jual, 0, ',', '.') }}</span>
                                                            </small>
                                                            <br>
                                                            <small class="text-success medicine-subtotal">
                                                                Subtotal: Rp {{ number_format($detail->obat->harga_jual * $detail->jumlah, 0, ',', '.') }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="medicine-item border-warning d-flex align-items-center">
                                                        <div class="medicine-image me-3" style="width: 50px; height: 50px; min-width: 50px;">
                                                            <div class="d-flex align-items-center justify-content-center bg-warning rounded" 
                                                                 style="width: 50px; height: 50px;">
                                                                <i class="fas fa-exclamation-triangle text-dark"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <strong class="text-warning">Obat Tidak Ditemukan</strong>
                                                            <br>
                                                            <small class="text-muted">
                                                                Kode: {{ $detail->kode_obat }} | Qty: {{ $detail->jumlah }} pcs
                                                            </small>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Total Amount --}}
                                    @php
                                        $totalAmount = $penjualan->details->sum(function($detail) {
                                            return $detail->obat ? $detail->obat->harga_jual * $detail->jumlah : 0;
                                        });
                                    @endphp
                                    <div class="border-top pt-3">
                                        <div class="row">
                                            <div class="col-6">
                                                <strong class="text-white">TOTAL TRANSAKSI:</strong>
                                            </div>
                                            <div class="col-6 text-right">
                                                <h5 class="text-success mb-0">
                                                    Rp {{ number_format($totalAmount, 0, ',', '.') }}
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-shopping-cart text-primary" style="font-size: 3rem;"></i>
                                    </div>
                                    <a href="{{ route('penjualans.show', $penjualan->nota) }}" 
                                       class="btn btn-outline-primary btn-sm mb-2 btn-block">
                                        <i class="fas fa-eye"></i> Lihat Detail
                                    </a>
                                    <button class="btn btn-outline-info btn-sm mb-2 btn-block" 
                                            onclick="printTransaction('{{ $penjualan->nota }}')">
                                        <i class="fas fa-print"></i> Print Struk
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm btn-block" 
                                            onclick="confirmDeleteTransaction('{{ $penjualan->nota }}')"
                                            title="Hapus transaksi ini (stok obat akan dikembalikan)">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="transaction-card text-center">
                        <div class="card-body py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">Belum Ada Transaksi</h4>
                            <p class="text-muted">Transaksi penjualan akan muncul di sini setelah ada penjualan obat.</p>
                            <a href="{{ route('penjualans.index') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Mulai Transaksi
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($riwayatPenjualan->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $riwayatPenjualan->links() }}
                </div>
            @endif
        </div>

        {{-- Sidebar: Top Medicines --}}
        <div class="col-lg-4">
            <div class="card stats-card">
                <div class="card-body">
                    <h5 class="card-title text-white mb-4">
                        <i class="fas fa-trophy text-warning"></i> Obat Terlaris
                    </h5>
                    
                    @forelse($obatTerlaris as $index => $obat)
                        <div class="top-medicine-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-light badge-pill me-2">
                                            #{{ $index + 1 }}
                                        </span>
                                        <div>
                                            <strong class="text-white">
                                                {{ $obat->obat ? $obat->obat->nama : 'Obat Tidak Ditemukan' }}
                                            </strong>
                                            <br>
                                            <small class="text-light">
                                                Kode: {{ $obat->kode_obat }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="badge badge-warning badge-pill">
                                        {{ $obat->total_terjual }} pcs
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-chart-bar fa-2x mb-2"></i>
                            <p>Belum ada data penjualan</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="card stats-card mt-4">
                <div class="card-body">
                    <h5 class="card-title text-white mb-4">
                        <i class="fas fa-bolt text-warning"></i> Aksi Cepat
                    </h5>
                    
                    <div class="alert alert-info mb-3" style="background: rgba(0,123,255,0.1); border: 1px solid rgba(0,123,255,0.3);">
                        <small class="text-info">
                            <i class="fas fa-info-circle"></i> 
                            <strong>Info:</strong> Saat menghapus transaksi, stok obat akan otomatis dikembalikan.
                        </small>
                    </div>
                    
                    <a href="{{ route('penjualans.index') }}" class="btn btn-primary btn-block mb-3">
                        <i class="fas fa-plus"></i> Transaksi Baru
                    </a>
                    
                    <button class="btn btn-outline-success btn-block mb-3" onclick="exportData()">
                        <i class="fas fa-download"></i> Export Data
                    </button>
                    
                    <button class="btn btn-outline-info btn-block mb-3" onclick="refreshData()">
                        <i class="fas fa-sync"></i> Refresh Data
                    </button>
                    
                    <button class="btn btn-outline-danger btn-block" onclick="toggleBulkDelete()" id="bulk-delete-toggle"
                            title="Aktifkan mode hapus multiple untuk menghapus beberapa transaksi sekaligus">
                        <i class="fas fa-tasks"></i> Hapus Multiple
                    </button>
                    
                    <div id="bulk-delete-controls" class="mt-3" style="display: none;">
                        <button class="btn btn-danger btn-block mb-2" onclick="confirmBulkDelete()" id="bulk-delete-btn" disabled>
                            <i class="fas fa-trash"></i> Hapus Terpilih (<span id="selected-count">0</span>)
                        </button>
                        <button class="btn btn-outline-secondary btn-block" onclick="cancelBulkDelete()">
                            <i class="fas fa-times"></i> Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let allTransactions = $('.transaction-card');
    let filteredCount = 0;
    
    // Search functionality with debounce
    let searchTimeout;
    $('#search-transaction').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            filterTransactions();
        }, 300);
    });

    // Filter functionality
    $('#filter-month, #filter-year').on('change', function() {
        filterTransactions();
    });

    function filterTransactions() {
        const searchTerm = $('#search-transaction').val().toLowerCase().trim();
        const selectedMonth = $('#filter-month').val();
        const selectedYear = $('#filter-year').val();
        
        filteredCount = 0;

        allTransactions.each(function() {
            const $card = $(this);
            const nota = $card.data('nota') ? $card.data('nota').toString().toLowerCase() : '';
            const cardDate = $card.data('date');
            
            // Parse date correctly
            let cardMonth = '';
            let cardYear = '';
            if (cardDate) {
                const dateObj = new Date(cardDate);
                cardMonth = (dateObj.getMonth() + 1).toString();
                cardYear = dateObj.getFullYear().toString();
            }
            
                         // Get specific searchable content
             const medicineNames = $card.find('.medicine-name').map(function() { return $(this).text(); }).get().join(' ').toLowerCase();
             const medicineCodes = $card.find('.medicine-code').map(function() { return $(this).text(); }).get().join(' ').toLowerCase();
             const cashierName = $card.find('.cashier-name').text().toLowerCase();
             const cardText = $card.text().toLowerCase();
             
             // Combine all searchable text
             const allText = [nota, medicineNames, medicineCodes, cashierName, cardText].join(' ').replace(/\s+/g, ' ');
            
            let showCard = true;

            // Search filter - search in nota, medicine names, and all card content
            if (searchTerm) {
                const searchWords = searchTerm.split(' ').filter(word => word.length > 0);
                const matchesSearch = searchWords.every(word => 
                    allText.includes(word) || 
                    nota.includes(word) ||
                    medicineNames.includes(word)
                );
                
                if (!matchesSearch) {
                    showCard = false;
                }
            }

            // Month filter
            if (selectedMonth && cardMonth && cardMonth !== selectedMonth) {
                showCard = false;
            }

            // Year filter  
            if (selectedYear && cardYear && cardYear !== selectedYear) {
                showCard = false;
            }

            // Show/hide card with animation
            if (showCard) {
                $card.fadeIn(200);
                filteredCount++;
            } else {
                $card.fadeOut(200);
            }
        });
        
        // Update results counter
        updateResultsCounter();
    }
    
    function updateResultsCounter() {
        // Remove existing counter
        $('#results-counter').remove();
        
        // Add results counter
        const totalTransactions = allTransactions.length;
        const counterHtml = `
            <div id="results-counter" class="alert alert-info mb-3" style="background: rgba(0,123,255,0.1); border: 1px solid rgba(0,123,255,0.3); color: #17a2b8;">
                <i class="fas fa-info-circle"></i> 
                Menampilkan <strong>${filteredCount}</strong> dari <strong>${totalTransactions}</strong> transaksi
                ${filteredCount === 0 ? '<br><small>Coba ubah kata kunci atau filter pencarian</small>' : ''}
            </div>
        `;
        
        $('#transaction-list').prepend(counterHtml);
        
        // Show/hide no results message
        if (filteredCount === 0 && (
            $('#search-transaction').val().trim() || 
            $('#filter-month').val() || 
            $('#filter-year').val()
        )) {
            showNoResultsMessage();
        } else {
            $('#no-results-message').remove();
        }
    }
    
    function showNoResultsMessage() {
        $('#no-results-message').remove();
        
        const noResultsHtml = `
            <div id="no-results-message" class="text-center py-5">
                <div class="card bg-dark border-secondary">
                    <div class="card-body">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h5 class="text-white">Tidak ada transaksi yang ditemukan</h5>
                        <p class="text-muted">Coba gunakan kata kunci yang berbeda atau ubah filter pencarian</p>
                        <button class="btn btn-outline-primary" onclick="clearAllFilters()">
                            <i class="fas fa-times"></i> Hapus Semua Filter
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        $('#transaction-list').append(noResultsHtml);
    }
    
         // Add clear filters functionality
     window.clearAllFilters = function() {
         $('#search-transaction').val('');
         $('#filter-month').val('');
         $('#filter-year').val('');
         filterTransactions();
         showNotification('🔄 Filter berhasil dihapus', 'success');
     };
     
     // Add quick filter functionality
     window.quickFilter = function(period) {
         const today = new Date();
         let startDate, endDate;
         
         // Clear existing filters first
         $('#search-transaction').val('');
         $('#filter-month').val('');
         $('#filter-year').val('');
         
         switch(period) {
             case 'today':
                 $('#filter-month').val(today.getMonth() + 1);
                 $('#filter-year').val(today.getFullYear());
                 showNotification('📅 Menampilkan transaksi hari ini', 'info');
                 break;
                 
             case 'week':
                 // For week, we'll just use current month as approximation
                 $('#filter-month').val(today.getMonth() + 1);
                 $('#filter-year').val(today.getFullYear());
                 showNotification('📅 Menampilkan transaksi minggu ini', 'info');
                 break;
                 
             case 'month':
                 $('#filter-month').val(today.getMonth() + 1);
                 $('#filter-year').val(today.getFullYear());
                 showNotification('📅 Menampilkan transaksi bulan ini', 'info');
                 break;
         }
         
         filterTransactions();
     };
    
    // Add clear search button
    const searchContainer = $('#search-transaction').parent();
    if (!searchContainer.find('.clear-search').length) {
        searchContainer.css('position', 'relative');
        searchContainer.append(`
            <button type="button" class="btn btn-link clear-search" 
                    style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); z-index: 10; color: #666; padding: 0; border: none; background: none;">
                <i class="fas fa-times"></i>
            </button>
        `);
        
        $('.clear-search').on('click', function() {
            $('#search-transaction').val('');
            filterTransactions();
        });
        
                 // Show/hide clear button
         $('#search-transaction').on('input', function() {
             $('.clear-search').toggle($(this).val().length > 0);
         });
         
         // Initial clear button state
         $('.clear-search').toggle($('#search-transaction').val().length > 0);
    }
    
    // Initialize counter
    updateResultsCounter();
    
    // Add keyboard shortcuts
    $(document).on('keydown', function(e) {
        // Ctrl/Cmd + F to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            $('#search-transaction').focus();
        }
        
        // Escape to clear search
        if (e.key === 'Escape' && $('#search-transaction').is(':focus')) {
            $('#search-transaction').val('');
            filterTransactions();
        }
    });
});

// Print transaction function
function printTransaction(nota) {
    window.open(`{{ route('penjualans.show', '') }}/${nota}?print=1`, '_blank');
}

// Export data function
function exportData() {
    alert('📊 Fitur export akan segera tersedia!');
}

// Refresh data function
function refreshData() {
    location.reload();
}

// Show medicine image in modal
function showMedicineImage(imageUrl, medicineName) {
    // Create image modal
    const modal = $(`
        <div class="modal fade" id="medicineImageModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content bg-dark">
                    <div class="modal-header border-secondary">
                        <h5 class="modal-title text-white">
                            <i class="fas fa-pills"></i> ${medicineName}
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center p-0">
                        <img src="${imageUrl}" alt="${medicineName}" 
                             class="img-fluid" style="max-height: 500px; object-fit: contain; width: 100%;">
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `);
    
    // Remove existing modal if any
    $('#medicineImageModal').remove();
    
    // Add modal to body and show
    $('body').append(modal);
    $('#medicineImageModal').modal('show');
    
    // Remove modal when hidden
    $('#medicineImageModal').on('hidden.bs.modal', function() {
        $(this).remove();
    });
}

// Show notification
function showNotification(message, type = 'info') {
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
    
    setTimeout(() => {
        notification.alert('close');
    }, 3000);
}

// Delete transaction functions
function confirmDeleteTransaction(nota) {
    Swal.fire({
        title: '⚠️ Konfirmasi Hapus',
        html: `Apakah Anda yakin ingin menghapus transaksi <strong>${nota}</strong>?<br><br>
               <small class="text-muted">Stok obat akan dikembalikan setelah penghapusan.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus!',
        cancelButtonText: '<i class="fas fa-times"></i> Batal',
        background: '#2a2a2a',
        color: '#fff',
        customClass: {
            popup: 'border border-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            deleteTransaction(nota);
        }
    });
}

function deleteTransaction(nota) {
    // Show loading
    Swal.fire({
        title: 'Menghapus Transaksi...',
        text: 'Mohon tunggu, sedang memproses penghapusan.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        },
        background: '#2a2a2a',
        color: '#fff'
    });

    $.ajax({
        url: `{{ route('penjualans.index') }}/${nota}`,
        type: 'DELETE',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    title: '✅ Berhasil!',
                    text: response.message,
                    icon: 'success',
                    background: '#2a2a2a',
                    color: '#fff',
                    confirmButtonColor: '#28a745'
                }).then(() => {
                    // Remove the transaction card from view
                    $(`.transaction-card[data-nota="${nota}"]`).fadeOut(300, function() {
                        $(this).remove();
                        updateResultsCounter();
                    });
                });
            } else {
                Swal.fire({
                    title: '❌ Gagal!',
                    text: response.message,
                    icon: 'error',
                    background: '#2a2a2a',
                    color: '#fff',
                    confirmButtonColor: '#dc3545'
                });
            }
        },
        error: function(xhr) {
            let errorMessage = 'Terjadi kesalahan saat menghapus transaksi.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            
            Swal.fire({
                title: '❌ Error!',
                text: errorMessage,
                icon: 'error',
                background: '#2a2a2a',
                color: '#fff',
                confirmButtonColor: '#dc3545'
            });
        }
    });
}

// Bulk delete functions
function toggleBulkDelete() {
    const isActive = $('#bulk-delete-controls').is(':visible');
    
    if (isActive) {
        cancelBulkDelete();
    } else {
        // Show checkboxes
        $('[id^="bulk-checkbox-"]').fadeIn(200);
        $('#bulk-delete-controls').fadeIn(200);
        $('#bulk-delete-toggle').html('<i class="fas fa-times"></i> Batal Mode Hapus');
        
        showNotification('📋 Mode hapus multiple diaktifkan. Pilih transaksi yang ingin dihapus.', 'info');
    }
}

function cancelBulkDelete() {
    // Hide checkboxes
    $('[id^="bulk-checkbox-"]').fadeOut(200);
    $('#bulk-delete-controls').fadeOut(200);
    $('#bulk-delete-toggle').html('<i class="fas fa-tasks"></i> Hapus Multiple');
    
    // Uncheck all checkboxes
    $('.transaction-checkbox').prop('checked', false);
    updateBulkDeleteButton();
}

function updateBulkDeleteButton() {
    const checkedCount = $('.transaction-checkbox:checked').length;
    $('#selected-count').text(checkedCount);
    $('#bulk-delete-btn').prop('disabled', checkedCount === 0);
}

function confirmBulkDelete() {
    const selectedTransactions = $('.transaction-checkbox:checked').map(function() {
        return $(this).val();
    }).get();
    
    if (selectedTransactions.length === 0) {
        showNotification('❗ Pilih minimal satu transaksi untuk dihapus.', 'warning');
        return;
    }
    
    Swal.fire({
        title: '⚠️ Konfirmasi Hapus Multiple',
        html: `Apakah Anda yakin ingin menghapus <strong>${selectedTransactions.length}</strong> transaksi yang dipilih?<br><br>
               <small class="text-muted">Stok obat akan dikembalikan untuk semua transaksi yang dihapus.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus Semua!',
        cancelButtonText: '<i class="fas fa-times"></i> Batal',
        background: '#2a2a2a',
        color: '#fff',
        customClass: {
            popup: 'border border-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            bulkDeleteTransactions(selectedTransactions);
        }
    });
}

function bulkDeleteTransactions(notaList) {
    // Show loading
    Swal.fire({
        title: 'Menghapus Transaksi...',
        text: `Mohon tunggu, sedang menghapus ${notaList.length} transaksi.`,
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        },
        background: '#2a2a2a',
        color: '#fff'
    });

    $.ajax({
        url: '{{ route("penjualans.bulkDestroy") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            nota_list: notaList
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    title: '✅ Berhasil!',
                    text: response.message,
                    icon: 'success',
                    background: '#2a2a2a',
                    color: '#fff',
                    confirmButtonColor: '#28a745'
                }).then(() => {
                    // Remove selected transaction cards from view
                    notaList.forEach(nota => {
                        $(`.transaction-card[data-nota="${nota}"]`).fadeOut(300, function() {
                            $(this).remove();
                        });
                    });
                    
                    setTimeout(() => {
                        updateResultsCounter();
                        cancelBulkDelete();
                    }, 400);
                });
            } else {
                Swal.fire({
                    title: '❌ Gagal!',
                    text: response.message,
                    icon: 'error',
                    background: '#2a2a2a',
                    color: '#fff',
                    confirmButtonColor: '#dc3545'
                });
            }
        },
        error: function(xhr) {
            let errorMessage = 'Terjadi kesalahan saat menghapus transaksi.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            
            Swal.fire({
                title: '❌ Error!',
                text: errorMessage,
                icon: 'error',
                background: '#2a2a2a',
                color: '#fff',
                confirmButtonColor: '#dc3545'
            });
        }
    });
}
</script>
@endpush