@extends('layouts.app')
@section('title', 'Data Apoteker')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Apoteker</h4>
                <p class="card-description">Daftar apoteker yang bertugas.</p>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                
                <a href="{{ route('apotekers.create') }}" class="btn btn-primary btn-fw mb-4">
                    <i class="mdi mdi-plus"></i> Tambah Apoteker
                </a>

                <form method="GET" action="{{ route('apotekers.index') }}">
                    <div class="form-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama atau email..." value="{{ request('search') }}">
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($apotekers as $key => $apoteker)
                                <tr>
                                    <td>{{ $apotekers->firstItem() + $key }}</td>
                                    <td>{{ $apoteker->name }}</td>
                                    <td>{{ $apoteker->email }}</td>
                                    <td>{{ $apoteker->telepon }}</td>
                                    <td>
                                        <a href="{{ route('apotekers.edit', $apoteker->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('apotekers.destroy', $apoteker->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-btn" 
                                                    data-nama="{{ $apoteker->name }}"
                                                    data-message="Yakin hapus apoteker '{{ $apoteker->name }}'? Data akan dihapus permanen.">
                                                Hapus
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
                <div class="mt-4">{{ $apotekers->links() }}</div>
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