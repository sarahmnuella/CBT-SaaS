@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('content')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .stat-icon {
        font-size: 2.25rem;
        color: var(--accent-color);
    }
    .stat-value {
        font-size: 1.75rem;
        font-weight: bold;
    }
    .stat-label {
        color: var(--text-secondary);
        font-size: 0.875rem;
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
        max-width: 500px;
        width: 100%;
        padding: 2rem;
        position: relative;
    }
</style>

<div class="page-header" style="margin-bottom: 2rem;">
    <h1 class="page-title">SaaS Owner Dashboard</h1>
    <p class="page-subtitle">Pusat kontrol manajemen sekolah, lisensi, dan kapasitas multi-tenant</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="color: #6366f1;"><i class="fa-solid fa-school"></i></div>
        <div>
            <div class="stat-value">{{ $stats['total_tenants'] }}</div>
            <div class="stat-label">Total Sekolah</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="color: var(--success-color);"><i class="fa-solid fa-circle-check"></i></div>
        <div>
            <div class="stat-value">{{ $stats['active_tenants'] }}</div>
            <div class="stat-label">Sekolah Aktif</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="color: var(--warning-color);"><i class="fa-solid fa-hourglass-half"></i></div>
        <div>
            <div class="stat-value">{{ $stats['trial_tenants'] }}</div>
            <div class="stat-label">Sekolah Trial</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="color: #a78bfa;"><i class="fa-solid fa-gem"></i></div>
        <div>
            <div class="stat-value">{{ $stats['premium_tenants'] }}</div>
            <div class="stat-label">Sekolah Premium</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-title">
        <i class="fa-solid fa-list-check"></i> Daftar Tenant / Sekolah Terdaftar
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Nama Sekolah</th>
                    <th>Slug URL</th>
                    <th>Email / Admin</th>
                    <th>Paket</th>
                    <th>Status</th>
                    <th>Kedaluwarsa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tenants as $tenant)
                    <tr>
                        <td>
                            <strong>{{ $tenant->nama_sekolah }}</strong>
                            <div style="font-size:0.8rem; color:var(--text-secondary)">{{ $tenant->phone ?? '-' }}</div>
                        </td>
                        <td><a href="{{ route('school.login', ['slug' => $tenant->slug]) }}" target="_blank" style="color: var(--accent-color)">{{ $tenant->slug }}</a></td>
                        <td>{{ $tenant->email }}</td>
                        <td>
                            @if($tenant->status == 'premium')
                                <span class="badge badge-premium">Premium</span>
                            @elseif($tenant->status == 'trial')
                                <span class="badge badge-trial">Trial</span>
                            @else
                                <span class="badge badge-free">Free</span>
                            @endif
                        </td>
                        <td>
                            @if($tenant->is_active)
                                <span class="badge badge-active">Aktif</span>
                            @else
                                <span class="badge badge-suspended">Ditangguhkan</span>
                            @endif
                        </td>
                        <td>
                            @if($tenant->status == 'trial')
                                <div style="font-size:0.9rem;">Trial Berakhir:</div>
                                <div style="font-size:0.85rem; color:var(--text-secondary)">{{ $tenant->trial_ends_at ? $tenant->trial_ends_at->format('d M Y') : '-' }}</div>
                            @else
                                <div style="font-size:0.9rem;">Expiry:</div>
                                <div style="font-size:0.85rem; color:var(--text-secondary)">{{ $tenant->expired_at ? $tenant->expired_at->format('d M Y') : 'Unlimited' }}</div>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex; gap:0.5rem;">
                                <button onclick="openStatusModal({{ $tenant->id }}, '{{ $tenant->status }}', {{ $tenant->is_active ? 'true' : 'false' }})" class="btn btn-secondary" style="padding:0.4rem 0.8rem; font-size:0.8rem;">
                                    <i class="fa-solid fa-edit"></i> Status
                                </button>
                                <button onclick="openExtendModal({{ $tenant->id }})" class="btn btn-secondary" style="padding:0.4rem 0.8rem; font-size:0.8rem;">
                                    <i class="fa-solid fa-clock"></i> Perpanjang
                                </button>
                                <form action="{{ route('superadmin.tenant.delete', $tenant->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus instansi ini beserta seluruh datanya?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" style="padding:0.4rem 0.8rem; font-size:0.8rem;">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; color:var(--text-secondary)">Belum ada sekolah terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:1.5rem;">
        {{ $tenants->links() }}
    </div>
</div>

<!-- Edit Status Modal -->
<div id="statusModal" class="modal">
    <div class="modal-content">
        <h3 style="margin-bottom:1.5rem;"><i class="fa-solid fa-sliders"></i> Update Status Tenant</h3>
        <form id="statusForm" method="POST" action="">
            @csrf
            <div class="form-group">
                <label class="form-label">Paket Layanan</label>
                <select name="status" id="modal_status" class="form-control">
                    <option value="trial">Trial 14 Hari</option>
                    <option value="free">Free Selamanya</option>
                    <option value="premium">Premium</option>
                </select>
            </div>
            <div class="form-group">
                <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer;">
                    <input type="checkbox" name="is_active" id="modal_is_active" style="accent-color: var(--accent-color)"> Aktifkan Akses Sekolah
                </label>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:0.5rem; margin-top:2rem;">
                <button type="button" onclick="closeModal('statusModal')" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Extend Subscription Modal -->
<div id="extendModal" class="modal">
    <div class="modal-content">
        <h3 style="margin-bottom:1.5rem;"><i class="fa-solid fa-calendar-plus"></i> Perpanjang Langganan</h3>
        <form id="extendForm" method="POST" action="">
            @csrf
            <div class="form-group">
                <label class="form-label">Tambah Durasi Aktif</label>
                <select name="months" class="form-control">
                    <option value="1">1 Bulan</option>
                    <option value="3">3 Bulan</option>
                    <option value="6">6 Bulan</option>
                    <option value="12">12 Bulan (1 Tahun)</option>
                </select>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:0.5rem; margin-top:2rem;">
                <button type="button" onclick="closeModal('extendModal')" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Perpanjang Ujian</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openStatusModal(id, currentStatus, isActive) {
        document.getElementById('statusForm').action = "/superadmin/tenant/" + id + "/status";
        document.getElementById('modal_status').value = currentStatus;
        document.getElementById('modal_is_active').checked = isActive;
        document.getElementById('statusModal').style.display = 'flex';
    }

    function openExtendModal(id) {
        document.getElementById('extendForm').action = "/superadmin/tenant/" + id + "/extend";
        document.getElementById('extendModal').style.display = 'flex';
    }

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    // Close when clicking outside modal content
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    }
</script>
@endsection
