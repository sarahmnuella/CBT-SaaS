@extends('layouts.app')

@section('title', 'Kelola Data Siswa')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <h1 class="page-title">Kelola Data Siswa</h1>
    <p class="page-subtitle">Daftar siswa peserta ujian sekolah</p>
</div>

<div style="display:grid; grid-template-columns: 1fr 2fr; gap:2rem; align-items: flex-start;">
    <!-- Add Siswa Card -->
    <div class="card">
        <h3 class="card-title"><i class="fa-solid fa-user-plus"></i> Tambah Siswa</h3>
        <form action="{{ route('admin.students', ['slug' => session('tenant_slug')]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: Andi Wijaya" required>
            </div>
            <div class="form-group">
                <label class="form-label">NISN / Nomor Induk</label>
                <input type="text" name="nisn" class="form-control" placeholder="Contoh: 005423...">
            </div>
            <div class="form-group">
                <label class="form-label">Email Siswa</label>
                <input type="email" name="email" class="form-control" placeholder="Contoh: andi@siswa.com" required>
            </div>
            <div class="form-group">
                <label class="form-label">Pilih Kelas</label>
                <select name="class_id" class="form-control" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Jenis Kelamin</label>
                <select name="gender" class="form-control" required>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Password Akun Siswa</label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">
                Simpan & Daftarkan Siswa
            </button>
        </form>
    </div>

    <!-- Siswa List Table -->
    <div class="card">
        <h3 class="card-title"><i class="fa-solid fa-users"></i> Daftar Siswa</h3>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>NISN</th>
                        <th>Nama Lengkap</th>
                        <th>Kelas</th>
                        <th>Email Login</th>
                        <th>Gender</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td><span style="font-family:monospace">{{ $student->nisn ?? '-' }}</span></td>
                            <td><strong>{{ $student->name }}</strong></td>
                            <td><span class="badge badge-free">{{ $student->class ? $student->class->name : '-' }}</span></td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td>
                                <form action="{{ route('admin.student.delete', ['slug' => session('tenant_slug'), 'id' => $student->id]) }}" method="POST" onsubmit="return confirm('Menghapus siswa ini akan menghapus semua riwayat ujian yang bersangkutan. Lanjutkan?');">
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
                            <td colspan="6" style="text-align:center; color:var(--text-secondary)">Belum ada data siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
