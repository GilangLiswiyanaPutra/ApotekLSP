@extends('layouts.app')
@section('title', 'Data Supplier')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Supplier</h4>
                <p class="card-description">Daftar supplier yang terdaftar.</p>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-fw"><i class="mdi mdi-plus"></i> Tambah Supplier</a>
                    </div>
                    <div>
                        <form method="GET" action="{{ route('suppliers.index') }}" class="d-flex">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama..." value="{{ request('search') }}">
                                <select name="kota" class="form-control">
                                    <option value="">Semua Kota</option>
                                    @foreach($all_kota ?? [] as $kota)
                                        <option value="{{ $kota }}" {{ request('kota') == $kota ? 'selected' : '' }}>{{ $kota }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary"><i class="mdi mdi-magnify"></i></button>
                                <!-- <a href="{{ route('suppliers.index') }}" class="btn btn-dark"><i class="mdi mdi-reload"></i></a> -->
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Supplier</th>
                                <th>Kota</th>
                                <th>Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($suppliers as $supplier)
                                <tr>
                                    <td><span class="badge badge-dark">{{ $supplier->kode_supplier }}</span></td>
                                    <td>{{ $supplier->nama }}</td>
                                    <td>{{ $supplier->kota }}</td>
                                    <td>{{ $supplier->telepon }}</td>
                                    <td>
                                        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-warning"><i class="mdi mdi-pencil"></i></a>
                                        <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-btn" 
                                                    data-nama="{{ $supplier->nama }}"
                                                    data-message="Yakin hapus supplier '{{ $supplier->nama }}'? Data akan dihapus permanen.">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center">Data tidak ditemukan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $suppliers->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle delete buttons with modal
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                const message = this.getAttribute('data-message');
                showDeleteModal(form, message);
            });
        });
    });
</script>
@endpush