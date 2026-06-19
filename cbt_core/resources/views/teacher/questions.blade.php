@extends('layouts.app')

@section('title', 'Bank Soal')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <h1 class="page-title">Kelola Bank Soal</h1>
    <p class="page-subtitle">Buat dan kelola butir soal ujian pilihan ganda serta esai</p>
</div>

<div style="display:grid; grid-template-columns: 1fr 2fr; gap:2rem; align-items: flex-start;">
    <!-- Add Soal Card -->
    <div class="card">
        <h3 class="card-title"><i class="fa-solid fa-plus-circle"></i> Tambah Soal</h3>
        <form action="{{ route('teacher.questions', ['slug' => session('tenant_slug')]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Mata Pelajaran</label>
                <select name="subject_id" class="form-control" required>
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach($subjects as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Tipe Soal</label>
                <select name="type" id="soal_type" class="form-control" onchange="toggleOptions(this.value)">
                    <option value="multiple_choice">Pilihan Ganda (PG)</option>
                    <option value="essay">Esai / Jawaban Terbuka</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Butir Soal (Teks)</label>
                <textarea name="question" class="form-control" rows="4" placeholder="Ketik pertanyaan soal di sini..." required></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Gambar Soal (Opsional)</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div id="pg-options-area">
                <div class="form-group">
                    <label class="form-label">Pilihan A</label>
                    <input type="text" name="option_a" class="form-control" placeholder="Pilihan Jawaban A">
                </div>
                <div class="form-group">
                    <label class="form-label">Pilihan B</label>
                    <input type="text" name="option_b" class="form-control" placeholder="Pilihan Jawaban B">
                </div>
                <div class="form-group">
                    <label class="form-label">Pilihan C</label>
                    <input type="text" name="option_c" class="form-control" placeholder="Pilihan Jawaban C">
                </div>
                <div class="form-group">
                    <label class="form-label">Pilihan D</label>
                    <input type="text" name="option_d" class="form-control" placeholder="Pilihan Jawaban D">
                </div>
                <div class="form-group">
                    <label class="form-label">Pilihan E</label>
                    <input type="text" name="option_e" class="form-control" placeholder="Pilihan Jawaban E">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Kunci Jawaban Benar</label>
                    <select name="answer" class="form-control">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Bobot Nilai Soal</label>
                <input type="number" name="weight" class="form-control" value="1" min="1" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">
                Simpan ke Bank Soal
            </button>
        </form>
    </div>

    <!-- Soal List Table -->
    <div class="card">
        <h3 class="card-title"><i class="fa-solid fa-folder-open"></i> Daftar Bank Soal Buatan Anda</h3>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Mapel</th>
                        <th>Tipe</th>
                        <th>Pertanyaan / Gambar</th>
                        <th>Jawaban</th>
                        <th style="width: 80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($questions as $q)
                        <tr>
                            <td><span class="badge badge-free">{{ $q->subject->name }}</span></td>
                            <td>
                                @if($q->type == 'multiple_choice')
                                    <span class="badge badge-premium">PG</span>
                                @else
                                    <span class="badge badge-trial">Esai</span>
                                @endif
                            </td>
                            <td>
                                <div style="max-height:100px; overflow-y:auto; line-height:1.4;">
                                    {!! nl2br(e($q->question)) !!}
                                </div>
                                @if($q->image)
                                    <div style="margin-top:0.5rem;">
                                        <a href="{{ asset('storage/' . $q->image) }}" target="_blank" style="color:var(--accent-color); font-size:0.8rem;">
                                            <i class="fa-solid fa-image"></i> Lihat Gambar
                                        </a>
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($q->type == 'multiple_choice')
                                    <span class="badge badge-active">{{ $q->answer }}</span>
                                @else
                                    <span style="color:var(--text-secondary)">-</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('teacher.question.delete', ['slug' => session('tenant_slug'), 'id' => $q->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal ini dari Bank Soal?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" style="padding:0.4rem 0.8rem; font-size:0.8rem;">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; color:var(--text-secondary)">Belum ada data soal di Bank Soal.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function toggleOptions(val) {
        let pgArea = document.getElementById('pg-options-area');
        if (val === 'essay') {
            pgArea.style.display = 'none';
        } else {
            pgArea.style.display = 'block';
        }
    }
</script>
@endsection
