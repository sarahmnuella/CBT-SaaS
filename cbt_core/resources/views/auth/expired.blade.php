@extends('layouts.app')

@section('title', 'Masa Aktif Berakhir — CBT SaaS')

@section('content')
<style>
    .expired-container {
        max-width: 580px;
        margin: 4rem auto;
        text-align: center;
    }
    .expired-card {
        background: #ffffff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 3rem 2rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }
    .expired-icon {
        font-size: 4.5rem;
        color: var(--warning);
        margin-bottom: 1.5rem;
        animation: pulse-slow 2.5s infinite ease-in-out;
    }
    @keyframes pulse-slow {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.08); }
    }
    .expired-title {
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 1rem;
        color: var(--text);
        letter-spacing: -0.02em;
    }
    .expired-text {
        color: var(--text-2);
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 2.5rem;
    }
    .expired-actions {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
</style>

<div class="expired-container">
    <div class="expired-card">
        <div class="expired-icon">
            <i class="fa-solid fa-hourglass-end"></i>
        </div>
        <h2 class="expired-title">Masa Aktif Langganan Berakhir</h2>
        <p class="expired-text">
            Masa aktif portal CBT SaaS untuk sekolah <strong>{{ $tenant->nama_sekolah }}</strong> telah berakhir. Silakan hubungi pemilik platform (Super Admin) untuk memperpanjang paket langganan Anda.
        </p>

        <div class="expired-actions">
            <a href="https://wa.me/628123456789" target="_blank" class="btn btn-primary" style="font-size: 0.9rem; padding: 0.65rem 1.5rem;">
                <i class="fa-brands fa-whatsapp"></i> Hubungi WhatsApp Admin
            </a>
            
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-secondary" style="font-size: 0.9rem; padding: 0.65rem 1.5rem;">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar Akun
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
