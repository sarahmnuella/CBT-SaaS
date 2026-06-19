<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CBT SaaS')</title>
    <meta name="description" content="Platform ujian online multi-tenant terpercaya untuk sekolah dan instansi pendidikan Indonesia.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #ecf0f5; /* Light grey content background */
            --bg-2:      #222d32; /* Dark sidebar background */
            --bg-3:      #ffffff; /* White card background */
            --bg-4:      #f4f4f4; /* Light grey accents */
            --border:    #d2d6de; /* Border color */
            --border-2:  #b5bbc8;
            --text:      #333333; /* Dark text */
            --text-2:    #444444; /* Dark secondary text */
            --text-3:    #888888; /* Muted text */
            --accent:    #605ca8; /* Purple skin header */
            --accent-2:  #504c90; 
            --accent-glow: rgba(96,92,168,0.25);
            --success:   #00a65a; /* Green card */
            --danger:    #dd4b39; /* Red card */
            --warning:   #f39c12; /* Orange card */
            --info:      #00c0ef; /* Blue card */
            --radius:    4px;
            --radius-lg: 6px;
            --sidebar-w: 230px;
            --nav-h:     50px;
            --shadow:    0 1px 1px rgba(0,0,0,0.1);
            --shadow-lg: 0 2px 5px rgba(0,0,0,0.15);

            /* Backward compatibility for old templates */
            --bg-card: var(--bg-3);
            --border-color: var(--border);
            --text-secondary: var(--text-2);
            --accent-color: var(--accent);
            --success-color: var(--success);
            --danger-color: var(--danger);
            --bg-secondary: var(--bg-2);
            --warning-color: var(--warning);
        }

        html { font-size: 16px; scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ─── Scrollbar ─── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: #b5bbc8; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #888888; }

        /* ─── TOP NAVBAR ─── */
        .topbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: var(--nav-h);
            background: var(--accent);
            border-bottom: 1px solid var(--accent-2);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.25rem;
            z-index: 200;
            gap: 1rem;
            color: #ffffff;
        }

        .topbar-left { display: flex; align-items: center; gap: 0.75rem; }

        .brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1rem;
            color: #ffffff;
            letter-spacing: -0.01em;
        }
        .brand-icon {
            width: 28px; height: 28px;
            background: rgba(255,255,255,0.2);
            border-radius: 4px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem; color: #ffffff;
            flex-shrink: 0;
        }

        .topbar-divider {
            width: 1px; height: 20px;
            background: rgba(255,255,255,0.25);
        }

        .tenant-pill {
            display: flex; align-items: center; gap: 0.4rem;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            padding: 0.2rem 0.65rem 0.2rem 0.4rem;
            font-size: 0.75rem;
            color: #ffffff;
            font-weight: 500;
        }
        .tenant-pill .dot {
            width: 6px; height: 6px;
            background: #22c55e;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .topbar-right { display: flex; align-items: center; gap: 0.5rem; }

        .user-chip {
            display: flex; align-items: center; gap: 0.5rem;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            padding: 0.25rem 0.75rem 0.25rem 0.4rem;
            font-size: 0.8125rem;
            color: #ffffff;
        }
        .user-avatar {
            width: 22px; height: 22px;
            background: #ffffff;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.6rem; font-weight: 700; color: var(--accent);
            flex-shrink: 0;
        }

        .btn-logout-top {
            display: flex; align-items: center; gap: 0.4rem;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            color: #ffffff;
            padding: 0.3rem 0.75rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s;
            font-family: inherit;
        }
        .btn-logout-top:hover {
            border-color: #ffffff;
            color: #ffffff;
            background: rgba(255,255,255,0.25);
        }

        .nav-links-top { display: flex; align-items: center; gap: 0.25rem; }
        .nav-link-top {
            padding: 0.35rem 0.75rem;
            border-radius: 4px;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.15s;
        }
        .nav-link-top:hover { background: rgba(255,255,255,0.1); color: #ffffff; }
        .btn-primary-top {
            background: rgba(255,255,255,0.2);
            color: white !important;
            font-weight: 600;
            border: 1px solid rgba(255,255,255,0.3);
        }
        .btn-primary-top:hover {
            background: rgba(255,255,255,0.3);
        }

        /* ─── APP BODY STRUCTURE ─── */
        .app-body {
            display: flex;
            padding-top: var(--nav-h);
            min-height: 100vh;
        }

        /* ─── SIDEBAR ─── */
        .sidebar {
            position: fixed;
            top: var(--nav-h); left: 0;
            bottom: 0;
            width: var(--sidebar-w);
            background: var(--bg-2);
            border-right: 1px solid rgba(0,0,0,0.15);
            overflow-y: auto;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 0;
            z-index: 100;
        }

        .sidebar-section-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #4b646f;
            background: #1a2226;
            padding: 0.65rem 1rem;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.75rem 1rem;
            color: #b8c7ce;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.12s;
            position: relative;
            border-left: 3px solid transparent;
        }
        .sidebar-item i {
            width: 16px;
            text-align: center;
            font-size: 0.8125rem;
            opacity: 0.7;
            flex-shrink: 0;
            color: #b8c7ce;
        }
        .sidebar-item:hover {
            background: #1e282c;
            color: #ffffff;
        }
        .sidebar-item:hover i { opacity: 1; color: #ffffff; }

        .sidebar-item.active {
            background: #1e282c;
            color: #ffffff;
            font-weight: 600;
            border-left-color: var(--accent);
        }
        .sidebar-item.active i {
            color: #ffffff;
            opacity: 1;
        }
        .sidebar-item.active::before {
            display: none;
        }

        /* ─── MAIN CONTENT ─── */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-w);
            min-height: calc(100vh - var(--nav-h));
            display: flex;
            flex-direction: column;
        }

        .main-content.no-sidebar {
            margin-left: 0;
        }

        /* ─── PAGE INNER ─── */
        .page-inner {
            flex: 1;
            padding: 2rem 2.5rem;
            max-width: 1180px;
            width: 100%;
        }

        /* ─── ALERT / FLASH ─── */
        .flash-area { padding: 1.25rem 2.5rem 0; }

        .alert {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.75rem 1rem;
            border-radius: var(--radius);
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.75rem;
        }
        .alert-success {
            background: rgba(22,163,74,0.1);
            border: 1px solid rgba(22,163,74,0.25);
            color: #86efac;
        }
        .alert-danger {
            background: rgba(220,38,38,0.08);
            border: 1px solid rgba(220,38,38,0.2);
            color: #fca5a5;
        }

        /* ─── CARDS ─── */
        .card {
            background: var(--bg-3);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            margin-bottom: 1.25rem;
            transition: border-color 0.15s;
        }
        .card:hover { border-color: var(--border-2); }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }
        .card-title {
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .card-title i { color: var(--text-3); font-size: 0.875rem; }

        /* ─── PAGE HEADER ─── */
        .page-header {
            margin-bottom: 1.75rem;
        }
        .page-title {
            font-size: 1.375rem;
            font-weight: 700;
            color: var(--text);
            letter-spacing: -0.02em;
        }
        .page-subtitle {
            font-size: 0.875rem;
            color: var(--text-3);
            margin-top: 0.25rem;
        }

        /* ─── STAT CARDS ─── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .stat-card {
            background: var(--bg-3);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 1.25rem;
            transition: border-color 0.15s;
        }
        .stat-card:hover { border-color: var(--border-2); }
        .stat-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--text-3);
            margin-bottom: 0.5rem;
        }
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.03em;
            color: var(--text);
            line-height: 1;
        }
        .stat-meta {
            font-size: 0.75rem;
            color: var(--text-3);
            margin-top: 0.375rem;
        }

        /* ─── BUTTONS ─── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.45rem 0.875rem;
            border-radius: var(--radius);
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border: 1px solid transparent;
            transition: all 0.15s;
            font-family: inherit;
            white-space: nowrap;
        }
        .btn:active { transform: scale(0.98); }

        .btn-primary {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
        }
        .btn-primary:hover {
            background: var(--accent-2);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        .btn-secondary {
            background: var(--bg-3);
            color: var(--text-2);
            border-color: var(--border);
        }
        .btn-secondary:hover {
            background: var(--bg-4);
            color: var(--text);
            border-color: var(--border-2);
        }

        .btn-danger {
            background: rgba(220,38,38,0.1);
            color: #f87171;
            border-color: rgba(220,38,38,0.2);
        }
        .btn-danger:hover {
            background: var(--danger);
            color: white;
            border-color: var(--danger);
        }

        .btn-ghost {
            background: transparent;
            color: var(--text-3);
            border-color: transparent;
        }
        .btn-ghost:hover { background: var(--bg-3); color: var(--text); }

        .btn-sm { padding: 0.3rem 0.625rem; font-size: 0.8125rem; }
        .btn-lg { padding: 0.625rem 1.25rem; font-size: 0.9375rem; }
        .btn-block { width: 100%; justify-content: center; }

        /* ─── FORMS ─── */
        .form-group { margin-bottom: 1rem; }
        .form-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--text-2);
            margin-bottom: 0.375rem;
        }
        .form-control {
            width: 100%;
            background: var(--bg);
            border: 1px solid var(--border);
            color: var(--text);
            padding: 0.5625rem 0.75rem;
            border-radius: var(--radius);
            font-size: 0.875rem;
            font-family: inherit;
            transition: all 0.15s;
            appearance: none;
        }
        .form-control::placeholder { color: var(--text-3); }
        .form-control:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px var(--accent-glow);
        }
        .form-control:hover:not(:focus) { border-color: var(--border-2); }

        select.form-control { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2371717a' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 0.75rem center; padding-right: 2rem; }
        select.form-control option { background: var(--bg-3); }

        .form-hint { font-size: 0.75rem; color: var(--text-3); margin-top: 0.3rem; }
        .form-error { font-size: 0.75rem; color: #f87171; margin-top: 0.3rem; }

        .input-group { display: flex; }
        .input-prefix {
            display: flex; align-items: center;
            background: var(--bg-3);
            border: 1px solid var(--border);
            border-right: none;
            padding: 0 0.75rem;
            border-radius: var(--radius) 0 0 var(--radius);
            font-size: 0.8125rem;
            color: var(--text-3);
            font-family: 'DM Mono', monospace;
            white-space: nowrap;
        }
        .input-group .form-control { border-radius: 0 var(--radius) var(--radius) 0; }
        .input-group .form-control:focus { z-index: 1; }

        /* ─── TABLES ─── */
        .table-wrap { overflow-x: auto; }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }
        thead th {
            background: var(--bg-2);
            padding: 0.625rem 0.875rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-3);
            border-bottom: 1px solid var(--border);
            text-align: left;
            white-space: nowrap;
        }
        tbody td {
            padding: 0.75rem 0.875rem;
            border-bottom: 1px solid var(--border);
            color: var(--text-2);
            vertical-align: middle;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: var(--bg-4); color: var(--text); }

        /* ─── BADGES ─── */
        .badge {
            display: inline-flex; align-items: center; gap: 0.25rem;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.6875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border: 1px solid;
        }
        .badge-premium { background: rgba(124,58,237,0.1); color: #a78bfa; border-color: rgba(124,58,237,0.2); }
        .badge-trial   { background: rgba(217,119,6,0.1); color: #fbbf24; border-color: rgba(217,119,6,0.2); }
        .badge-active  { background: rgba(22,163,74,0.1); color: #86efac; border-color: rgba(22,163,74,0.2); }
        .badge-suspended { background: rgba(220,38,38,0.1); color: #fca5a5; border-color: rgba(220,38,38,0.2); }
        .badge-free    { background: rgba(161,161,170,0.1); color: #a1a1aa; border-color: rgba(161,161,170,0.2); }
        .badge-info    { background: rgba(8,145,178,0.1); color: #67e8f9; border-color: rgba(8,145,178,0.2); }
        .badge-done    { background: rgba(22,163,74,0.1); color: #86efac; border-color: rgba(22,163,74,0.2); }
        .badge-ongoing { background: rgba(37,99,235,0.1); color: #93c5fd; border-color: rgba(37,99,235,0.2); }

        /* ─── DIVIDER ─── */
        .divider { border: none; border-top: 1px solid var(--border); margin: 1.5rem 0; }

        /* ─── EMPTY STATE ─── */
        .empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
            color: var(--text-3);
        }
        .empty-state i { font-size: 2rem; margin-bottom: 0.75rem; display: block; opacity: 0.4; }
        .empty-state p { font-size: 0.875rem; }

        /* ─── Responsive ─── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; }
            .page-inner { padding: 1.25rem; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
        }
    </style>

    @yield('head')
</head>
<body>

<header class="topbar">
    <div class="topbar-left">
        <a href="{{ url('/') }}" class="brand">
            <div class="brand-icon"><i class="fa-solid fa-graduation-cap"></i></div>
            CBT SaaS
        </a>
        @auth
            @if(session('tenant_name'))
                <div class="topbar-divider"></div>
                <div class="tenant-pill">
                    <span class="dot"></span>
                    {{ session('tenant_name') }}
                </div>
            @endif
        @endauth
    </div>

    <div class="topbar-right">
        @auth
            <div class="user-chip">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                {{ auth()->user()->name }}
            </div>
            <form action="{{ route('logout') }}" method="POST" style="display:inline">
                @csrf
                <button type="submit" class="btn-logout-top">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
                </button>
            </form>
        @else
            <nav class="nav-links-top">
                <a href="{{ route('login') }}" class="nav-link-top">Masuk</a>
                <a href="{{ route('register.school') }}" class="nav-link-top btn-primary-top">Daftar Sekolah</a>
            </nav>
        @endauth
    </div>
</header>

<div class="app-body">
    @auth
        <aside class="sidebar">
            @if(auth()->user()->isSuperAdmin())
                <span class="sidebar-section-title">Platform</span>
                <a href="{{ route('superadmin.dashboard') }}"
                   class="sidebar-item {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i> Dashboard
                </a>
                <a href="{{ route('superadmin.tenants') }}"
                   class="sidebar-item {{ request()->routeIs('superadmin.tenants') ? 'active' : '' }}">
                    <i class="fa-solid fa-building-columns"></i> Kelola Sekolah
                </a>

            @elseif(auth()->user()->isAdmin())
                <span class="sidebar-section-title">Manajemen</span>
                <a href="{{ route('admin.dashboard', ['slug' => session('tenant_slug')]) }}"
                   class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line"></i> Dashboard
                </a>
                <a href="{{ route('admin.majors', ['slug' => session('tenant_slug')]) }}"
                   class="sidebar-item {{ request()->routeIs('admin.majors') ? 'active' : '' }}">
                    <i class="fa-solid fa-layer-group"></i> Jurusan
                </a>
                <a href="{{ route('admin.classes', ['slug' => session('tenant_slug')]) }}"
                   class="sidebar-item {{ request()->routeIs('admin.classes') ? 'active' : '' }}">
                    <i class="fa-solid fa-door-open"></i> Kelas
                </a>
                <a href="{{ route('admin.subjects', ['slug' => session('tenant_slug')]) }}"
                   class="sidebar-item {{ request()->routeIs('admin.subjects') ? 'active' : '' }}">
                    <i class="fa-solid fa-book-bookmark"></i> Mata Pelajaran
                </a>
                <span class="sidebar-section-title">Pengguna</span>
                <a href="{{ route('admin.teachers', ['slug' => session('tenant_slug')]) }}"
                   class="sidebar-item {{ request()->routeIs('admin.teachers') ? 'active' : '' }}">
                    <i class="fa-solid fa-chalkboard-user"></i> Guru
                </a>
                <a href="{{ route('admin.students', ['slug' => session('tenant_slug')]) }}"
                   class="sidebar-item {{ request()->routeIs('admin.students') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-graduate"></i> Siswa
                </a>

            @elseif(auth()->user()->isTeacher())
                <span class="sidebar-section-title">CBT</span>
                <a href="{{ route('teacher.dashboard', ['slug' => session('tenant_slug')]) }}"
                   class="sidebar-item {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i> Beranda
                </a>
                <a href="{{ route('teacher.questions', ['slug' => session('tenant_slug')]) }}"
                   class="sidebar-item {{ request()->routeIs('teacher.questions') ? 'active' : '' }}">
                    <i class="fa-solid fa-database"></i> Bank Soal
                </a>
                <a href="{{ route('teacher.exams', ['slug' => session('tenant_slug')]) }}"
                   class="sidebar-item {{ request()->routeIs('teacher.exams') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-days"></i> Jadwal Ujian
                </a>
                <a href="{{ route('teacher.results', ['slug' => session('tenant_slug')]) }}"
                   class="sidebar-item {{ request()->routeIs('teacher.results') ? 'active' : '' }}">
                    <i class="fa-solid fa-square-poll-vertical"></i> Rekap Nilai
                </a>

            @elseif(auth()->user()->isStudent())
                <span class="sidebar-section-title">Ujian</span>
                <a href="{{ route('student.dashboard', ['slug' => session('tenant_slug')]) }}"
                   class="sidebar-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i> Beranda
                </a>
                <a href="{{ route('student.exams', ['slug' => session('tenant_slug')]) }}"
                   class="sidebar-item {{ request()->routeIs('student.exams') ? 'active' : '' }}">
                    <i class="fa-solid fa-pen-to-square"></i> Daftar Ujian
                </a>
            @endif
        </aside>
    @endauth

    <main class="main-content @guest no-sidebar @endguest">
        @if(session('success') || $errors->any())
            <div class="flash-area">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <div>@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
                    </div>
                @endif
            </div>
        @endif

        <div class="page-inner" style="@guest max-width: 100%; padding-top: 0; @else padding-top: 2rem; @endguest">
            @yield('content')
        </div>
    </main>
</div>

@yield('scripts')
</body>
</html>
