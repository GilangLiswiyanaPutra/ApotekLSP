@extends('layouts.app')
@section('title', 'Data Pelanggan')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Pelanggan</h4>
                <p class="card-description">Daftar pelanggan yang terdaftar.</p>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="{{ route('pelanggans.create') }}" class="btn btn-primary btn-fw"><i class="mdi mdi-plus"></i> Tambah Pelanggan</a>
                    <form method="GET" action="{{ route('pelanggans.index') }}" class="d-flex">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama..." value="{{ request('search') }}">
                            <select name="kota" class="form-control">
                                <option value="">Semua Kota</option>
                                @foreach($all_kota ?? [] as $kota)
                                    <option value="{{ $kota }}" {{ request('kota') == $kota ? 'selected' : '' }}>{{ $kota }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary"><i class="mdi mdi-magnify"></i></button>
                            <!-- <a href="{{ route('pelanggans.index') }}" class="btn btn-dark"><i class="mdi mdi-reload"></i></a> -->
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Kota</th>
                                <th>Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pelanggans as $pelanggan)
                                <tr>
                                    <td><span>{{ $pelanggan->id }}</span></td>
                                    <td>{{ $pelanggan->user->name }}</td>
                                    <td>{{ $pelanggan->user->email }}</td>
                                    <td>{{ $pelanggan->kota }}</td>
                                    <td>{{ $pelanggan->telepon }}</td>
                                    <td>
                                        <a href="{{ route('pelanggans.edit', $pelanggan->id) }}" class="btn btn-sm btn-warning"><i class="mdi mdi-pencil"></i></a>
                                        <form action="{{ route('pelanggans.destroy', $pelanggan->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-btn" 
                                                    data-nama="{{ $pelanggan->user->name }}"
                                                    data-message="Yakin hapus pelanggan '{{ $pelanggan->user->name }}'? Data akan dihapus permanen.">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center">Data tidak ditemukan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $pelanggans->links() }}</div>
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