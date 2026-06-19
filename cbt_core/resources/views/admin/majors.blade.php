@extends('layouts.app')

@section('title', 'Kelola Jurusan')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <h1 class="page-title">Kelola Jurusan</h1>
    <p class="page-subtitle">Daftar program keahlian atau jurusan sekolah</p>
</div>

<div style="display:grid; grid-template-columns: 1fr 2fr; gap:2rem; align-items: flex-start;">
    <!-- Add Jurusan Card -->
    <div class="card">
        <h3 class="card-title"><i class="fa-solid fa-plus-circle"></i> Tambah Jurusan</h3>
        <form action="{{ route('admin.majors', ['slug' => session('tenant_slug')]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Jurusan</label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: Rekayasa Perangkat Lunak" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">
                Tambah Jurusan
            </button>
        </form>
    </div>

    <!-- Jurusan List Table -->
    <div class="card">
        <h3 class="card-title"><i class="fa-solid fa-list"></i> Daftar Jurusan</h3>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Jurusan</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($majors as $index => $major)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $major->name }}</strong></td>
                            <td>
                                <form action="{{ route('admin.major.delete', ['slug' => session('tenant_slug'), 'id' => $major->id]) }}" method="POST" onsubmit="return confirm('Menghapus jurusan ini akan berpengaruh pada data kelas yang berelasi. Lanjutkan?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" style="padding:0.4rem 0.8rem; font-size:0.8rem;">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align:center; color:var(--text-secondary)">Belum ada data jurusan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
