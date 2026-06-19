@extends('layouts.app')

@section('title', 'Kelola Kelas')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <h1 class="page-title">Kelola Kelas</h1>
    <p class="page-subtitle">Daftar rombongan belajar sekolah</p>
</div>

<div style="display:grid; grid-template-columns: 1fr 2fr; gap:2rem; align-items: flex-start;">
    <!-- Add Kelas Card -->
    <div class="card">
        <h3 class="card-title"><i class="fa-solid fa-plus-circle"></i> Tambah Kelas</h3>
        <form action="{{ route('admin.classes', ['slug' => session('tenant_slug')]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Kelas</label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: XII RPL 1" required>
            </div>
            <div class="form-group">
                <label class="form-label">Pilih Jurusan</label>
                <select name="major_id" class="form-control">
                    <option value="">-- Tanpa Jurusan --</option>
                    @foreach($majors as $major)
                        <option value="{{ $major->id }}">{{ $major->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">
                Tambah Kelas
            </button>
        </form>
    </div>

    <!-- Kelas List Table -->
    <div class="card">
        <h3 class="card-title"><i class="fa-solid fa-list"></i> Daftar Kelas</h3>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kelas</th>
                        <th>Jurusan</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $index => $class)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $class->name }}</strong></td>
                            <td>{{ $class->major ? $class->major->name : '-' }}</td>
                            <td>
                                <form action="{{ route('admin.class.delete', ['slug' => session('tenant_slug'), 'id' => $class->id]) }}" method="POST" onsubmit="return confirm('Hapus kelas ini? Siswa di kelas ini akan kehilangan relasi kelas.');">
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
                            <td colspan="4" style="text-align:center; color:var(--text-secondary)">Belum ada data kelas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
