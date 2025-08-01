@extends('layouts.app')
@section('title', 'Data Obat')

@push('styles')
<style>
    /* Menambahkan pointer pada baris tabel agar terlihat bisa di-hover */
    .table-hover tbody tr:hover {
        cursor: pointer;
    }
    
    /* Style untuk baris yang bisa diklik */
    .clickable-row {
        cursor: pointer;
        transition: background-color 0.2s ease;
    }
    
    .clickable-row:hover {
        background-color: #f8f9fa !important;
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Obat</h4>
                    <p class="card-description">Daftar obat yang tersedia.</p>
                    
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-primary btn-fw" data-toggle="modal" data-target="#dataModal">
                                <i class="mdi mdi-plus"></i> Tambah Obat
                            </button>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="form-control" id="filterJenis">
                                            <option value="">Semua Jenis</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="form-control" id="filterSupplier">
                                            <option value="">Semua Supplier</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" id="searchInput" class="form-control" placeholder="Cari nama obat...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Obat</th>
                                    <th>Jenis</th>
                                    <th>Supplier</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="dataTableBody"></tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <div id="dataInfo">Menampilkan 0 dari 0 data</div>
                        <nav>
                            <ul class="pagination" id="pagination"></ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Obat --}}
<div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">Tambah Data Obat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addDataForm">
                    <div class="form-group">
                        <label for="nama">Nama Obat</label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Contoh: Paracetamol 500mg" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis">Jenis Obat</label>
                        <select class="form-control" name="jenis" id="jenis" required>
                            <option value="">Pilih Jenis</option>
                            <option value="Tablet">Tablet</option>
                            <option value="Kapsul">Kapsul</option>
                            <option value="Sirup">Sirup</option>
                            <option value="Salep">Salep</option>
                            <option value="Injeksi">Injeksi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="supplier">Supplier</label>
                        <select class="form-control" name="supplier_id" id="supplier" required>
                            <option value="">Pilih Supplier</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="harga_beli">Harga Beli</label>
                        <input type="number" class="form-control" name="harga_beli" id="harga_beli" placeholder="Contoh: 5000" required>
                    </div>
                    <div class="form-group">
                        <label for="harga_jual">Harga Jual</label>
                        <input type="number" class="form-control" name="harga_jual" id="harga_jual" placeholder="Contoh: 7000" required>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" class="form-control" name="stok" id="stok" placeholder="Contoh: 100" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // [UBAH] Sesuaikan URL API ke rute obat
        const API_URL = "{{ route('obat.data') }}";
        const STORE_URL = "{{ route('obat.store') }}";
        const FILTER_API_URL = "{{ route('obat.filters') }}";

        function fetchData(page = 1) {
            $.ajax({
                url: API_URL,
                type: 'GET',
                data: {
                    page: page,
                    search: $('#searchInput').val(),
                    jenis: $('#filterJenis').val(),
                    supplier: $('#filterSupplier').val()
                },
                success: function(response) {
                    renderTable(response.data);
                    renderPagination(response);
                    updateDataInfo(response);
                },
                error: function(err) {
                    $('#dataTableBody').html('<tr><td colspan="8" class="text-center text-danger">Gagal memuat data.</td></tr>');
                }
            });
        }

        function populateFilters() {
            $.get(FILTER_API_URL, function(response) {
                // Populate jenis filter
                const jenisSelect = $('#filterJenis');
                if (response.jenis) {
                    response.jenis.forEach(jenis => {
                       jenisSelect.append(`<option value="${jenis}">${jenis}</option>`);
                    });
                }
                
                // Populate supplier filter and modal
                const supplierSelect = $('#filterSupplier');
                const supplierModal = $('#supplier');
                if (response.suppliers) {
                    response.suppliers.forEach(supplier => {
                       supplierSelect.append(`<option value="${supplier.id}">${supplier.nama}</option>`);
                       supplierModal.append(`<option value="${supplier.id}">${supplier.nama}</option>`);
                    });
                }
            });
        }

        // [UBAH] renderTable untuk menampilkan data obat
        function renderTable(data) {
            const tableBody = $('#dataTableBody');
            tableBody.empty();
            if (data.length === 0) {
                tableBody.append('<tr><td colspan="8" class="text-center">Data obat tidak ditemukan.</td></tr>');
                return;
            }
            data.forEach(item => {
                const rowHtml = `
                    <tr class="clickable-row" data-id="${item.id}">
                        <td><span class="badge badge-dark">${item.kode_obat}</span></td>
                        <td>${item.nama}</td>
                        <td><span class="badge badge-info">${item.jenis}</span></td>
                        <td>${item.supplier ? item.supplier.nama : '-'}</td>
                        <td>Rp ${new Intl.NumberFormat('id-ID').format(item.harga_beli)}</td>
                        <td>Rp ${new Intl.NumberFormat('id-ID').format(item.harga_jual)}</td>
                        <td>
                            <span class="badge ${item.stok <= 5 ? 'badge-danger' : 'badge-success'}">
                                ${item.stok} pcs
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning"><i class="mdi mdi-pencil"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></button>
                        </td>
                    </tr>
                `;
                tableBody.append(rowHtml);
            });
        }

        function renderPagination(paginator) {
            const pagination = $('#pagination');
            pagination.empty();
            if (!paginator.links || paginator.links.length <= 3) return;
            paginator.links.forEach(link => {
                let label = link.label.replace('&laquo; Previous', 'Previous').replace('Next &raquo;', 'Next');
                pagination.append(`
                    <li class="page-item ${link.active ? 'active' : ''} ${link.url === null ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${link.url ? new URL(link.url).searchParams.get('page') : ''}">${label}</a>
                    </li>
                `);
            });
        }

        function updateDataInfo(paginator) {
            $('#dataInfo').text(`Menampilkan ${paginator.from || 0} - ${paginator.to || 0} dari ${paginator.total} data`);
        }

        // Event Listeners
        $('#searchInput, #filterJenis, #filterSupplier').on('keyup change', function() {
            fetchData(1);
        });

        $('#pagination').on('click', 'a', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            if (page) fetchData(page);
        });

        $('#addDataForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: STORE_URL,
                type: 'POST',
                data: $(this).serialize(),
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    if(response.success) {
                        $('#dataModal').modal('hide');
                        $('#addDataForm')[0].reset();
                        fetchData(1);
                    }
                },
                error: function(err) {
                    alert('Gagal menyimpan data!');
                }
            });
        });

        // Click event for table rows
        $(document).on('click', '.clickable-row', function() {
            const obatId = $(this).data('id');
            // Implementasi detail obat jika diperlukan
            console.log('Obat ID:', obatId);
        });

        // Inisialisasi
        populateFilters();
        fetchData();
    });
</script>
@endpush