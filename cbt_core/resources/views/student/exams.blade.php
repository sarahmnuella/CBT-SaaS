@extends('layouts.app')

@section('title', 'Daftar Jadwal Ujian')

@section('content')
<style>
    .exams-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }
    .exam-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .exam-card:hover {
        border-color: var(--accent-color);
        transform: translateY(-4px);
    }
    .modal {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(5px);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    .modal-content {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        max-width: 400px;
        width: 100%;
        padding: 2rem;
    }
</style>

<div class="page-header" style="margin-bottom: 2rem;">
    <h1 class="page-title">Jadwal Ujian Aktif</h1>
    <p class="page-subtitle">Pilih ujian yang sedang berlangsung dan masukkan token untuk memulai.</p>
</div>

<div class="exams-grid">
    @forelse($exams as $exam)
        <div class="exam-card">
            <div>
                <span class="badge badge-premium" style="margin-bottom: 0.5rem;">{{ $exam->subject->name }}</span>
                <h3 style="color:white; font-size:1.25rem; margin-bottom: 0.5rem;">{{ $exam->name }}</h3>
                <p style="color:var(--text-secondary); font-size:0.9rem; margin-bottom: 1rem;">
                    <i class="fa-solid fa-clock"></i> Durasi: {{ $exam->duration }} Menit<br>
                    <i class="fa-solid fa-file-invoice"></i> Jumlah Soal: {{ $exam->total_questions }} PG
                </p>
                <div style="border-top: 1px solid var(--border-color); padding-top:0.75rem; margin-bottom:1.5rem; font-size:0.8rem; color:var(--text-secondary)">
                    Akses Mulai: {{ $exam->start_at->format('d M Y, H:i') }}<br>
                    Akses Selesai: {{ $exam->end_at->format('d M Y, H:i') }}
                </div>
            </div>

            <div>
                @if(in_array($exam->id, $completedExamIds))
                    <button class="btn btn-secondary" style="width: 100%; justify-content: center; cursor: not-allowed;" disabled>
                        <i class="fa-solid fa-check-double"></i> Selesai Dikerjakan
                    </button>
                @elseif(isset($ongoingExamResults[$exam->id]))
                    <a href="{{ route('student.exam.page', ['slug' => session('tenant_slug'), 'id' => $exam->id]) }}" class="btn btn-primary" style="width: 100%; justify-content: center; background:var(--gradient-accent)">
                        <i class="fa-solid fa-spinner fa-spin"></i> Lanjutkan Ujian
                    </a>
                @else
                    <button onclick="openTokenModal({{ $exam->id }}, '{{ $exam->name }}')" class="btn btn-primary" style="width: 100%; justify-content: center;">
                        Ikuti Ujian <i class="fa-solid fa-key"></i>
                    </button>
                @endif
            </div>
        </div>
    @empty
        <div class="card" style="grid-column: 1 / -1; text-align:center; padding:3rem; color:var(--text-secondary)">
            <i class="fa-solid fa-circle-info" style="font-size:2.5rem; margin-bottom:1rem; color:var(--accent-color)"></i>
            <p>Tidak ada ujian aktif terjadwal saat ini.</p>
        </div>
    @endforelse
</div>

<!-- Token Modal -->
<div id="tokenModal" class="modal">
    <div class="modal-content">
        <h3 id="modal_exam_title" style="margin-bottom:1rem; color:white; font-size:1.25rem;">Masukkan Token</h3>
        <p style="color:var(--text-secondary); font-size:0.875rem; margin-bottom:1.5rem;">Mintalah token ujian kepada guru mata pelajaran atau pengawas ujian.</p>
        <form id="tokenForm" method="POST" action="">
            @csrf
            <div class="form-group">
                <input type="text" name="token" class="form-control" placeholder="Contoh: AB12C" style="text-align:center; font-size:1.5rem; font-family:monospace; text-transform:uppercase; letter-spacing:4px;" required autocomplete="off">
            </div>
            <div style="display:flex; justify-content:flex-end; gap:0.5rem; margin-top:2rem;">
                <button type="button" onclick="closeModal()" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Mulai Ujian</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openTokenModal(id, name) {
        document.getElementById('tokenForm').action = "/s/{{ session('tenant_slug') }}/student/exam/" + id + "/start";
        document.getElementById('modal_exam_title').innerText = name;
        document.getElementById('tokenModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('tokenModal').style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    }
</script>
@endsection
