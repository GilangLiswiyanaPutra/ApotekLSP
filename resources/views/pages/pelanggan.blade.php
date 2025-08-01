@extends('layouts.app')
@section('title', 'Data Pelanggan')

@push('styles')
<style>
    /* Menambahkan pointer pada baris tabel agar terlihat bisa di-hover */
    .table-hover tbody tr:hover {
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Pelanggan</h4>
                    <p class="card-description">Daftar pelanggan yang terdaftar.</p>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-primary btn-fw" data-toggle="modal" data-target="#dataModal">
                                <i class="mdi mdi-plus"></i> Tambah Pelanggan
                            </button>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <select class="form-control" id="filterKota">
                                            <option value="">Semua Kota</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" id="searchInput" class="form-control" placeholder="Cari nama pelanggan...">
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
                                    <th>Nama Pelanggan</th>
                                    <th>Alamat</th>
                                    <th>Kota</th>
                                    <th>Telepon</th>
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

{{-- Modal Tambah Pelanggan --}}
<div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">Tambah Data Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addDataForm">
                    <div class="form-group">
                        <label for="nama">Nama Pelanggan</label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Contoh: Budi Santoso" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" name="alamat" id="alamat" rows="3" placeholder="Contoh: Jl. Pahlawan No. 25" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="kota">Kota</label>
                        <input type="text" class="form-control" name="kota" id="kota" placeholder="Contoh: Surabaya" required>
                    </div>
                    <div class="form-group">
                        <label for="telepon">Telepon</label>
                        <input type="tel" class="form-control" name="telepon" id="telepon" placeholder="Contoh: 081298765432" required>
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
        // [UBAH] Sesuaikan URL API ke rute pelanggan
        const API_URL = "{{ route('pelanggan.data') }}";
        const STORE_URL = "{{ route('pelanggan.store') }}";
        const FILTER_API_URL = "{{ route('pelanggan.filters') }}";

        function fetchData(page = 1) {
            $.ajax({
                url: API_URL,
                type: 'GET',
                data: {
                    page: page,
                    search: $('#searchInput').val(),
                    kota: $('#filterKota').val()
                },
                success: function(response) {
                    renderTable(response.data);
                    renderPagination(response);
                    updateDataInfo(response);
                },
                error: function(err) {
                    $('#dataTableBody').html('<tr><td colspan="6" class="text-center text-danger">Gagal memuat data.</td></tr>');
                }
            });
        }

        function populateFilters() {
            $.get(FILTER_API_URL, function(response) {
                const kotaSelect = $('#filterKota');
                if (response.kota) {
                    response.kota.forEach(kota => {
                       kotaSelect.append(`<option value="${kota}">${kota}</option>`);
                    });
                }
            });
        }

        // [UBAH] renderTable untuk menampilkan data pelanggan
        function renderTable(data) {
            const tableBody = $('#dataTableBody');
            tableBody.empty();
            if (data.length === 0) {
                tableBody.append('<tr><td colspan="6" class="text-center">Data pelanggan tidak ditemukan.</td></tr>');
                return;
            }
            data.forEach(item => {
                const rowHtml = `
                    <tr>
                        <td><span class="badge badge-dark">${item.kode}</span></td>
                        <td>${item.nama}</td>
                        <td>${item.alamat}</td>
                        <td>${item.kota}</td>
                        <td>${item.telepon}</td>
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
        $('#searchInput, #filterKota').on('keyup change', function() {
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

        // Inisialisasi
        populateFilters();
        fetchData();
    });
</script>
@endpush