<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Console Resepsionis - Warung Banjar</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Forum&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Visual Map Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/table-map.css') }}?v=4">

    <style>
        /* ══════════════════════════════════════
           PREMIUM DESIGN SYSTEM (VANILLA CSS)
           ══════════════════════════════════════ */
        :root {
            --gold: #e4c590;
            --gold-hover: #caa66d;
            --dark-bg: #0b0a09;
            --card-bg: rgba(22, 21, 19, 0.7);
            --border-color: rgba(228, 197, 144, 0.12);
            --text-main: #f5f5f4;
            --text-muted: #a1a09e;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            
            --success: #34d399;
            --pending: #fbbf24;
            --danger: #f87171;
            --completed: #38bdf8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--dark-bg);
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(228, 197, 144, 0.03) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(228, 197, 144, 0.02) 0%, transparent 40%);
            color: var(--text-main);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* ── Header ── */
        header {
            background: rgba(11, 10, 9, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-b: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-group {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .brand-title {
            font-family: 'Forum', serif;
            font-size: 24px;
            letter-spacing: 2px;
            color: #fff;
            text-shadow: 0 2px 10px rgba(255,255,255,0.05);
        }

        .brand-divider {
            width: 1px;
            height: 18px;
            background: rgba(228, 197, 144, 0.25);
        }

        .brand-subtitle {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--gold);
            font-weight: 700;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .nav-btn {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            transition: var(--transition);
            cursor: pointer;
        }

        .nav-btn--admin {
            border: 1px solid var(--border-color);
            color: var(--text-main);
            background: rgba(255,255,255,0.02);
        }

        .nav-btn--admin:hover {
            border-color: var(--gold);
            background: rgba(228, 197, 144, 0.05);
        }

        .nav-btn--logout {
            background: rgba(248, 113, 113, 0.15);
            color: #f87171;
            border: 1px solid rgba(248, 113, 113, 0.2);
        }

        .nav-btn--logout:hover {
            background: rgba(248, 113, 113, 0.3);
            color: #fff;
        }

        /* ── Main Layout ── */
        main {
            max-width: 1280px;
            width: 100%;
            margin: 0 auto;
            padding: 40px 24px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 32px;
        }

        /* ── Page Header ── */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            padding-bottom: 24px;
        }

        .page-title h1 {
            font-family: 'Forum', serif;
            font-size: 32px;
            letter-spacing: 1px;
            margin-bottom: 6px;
            color: #fff;
        }

        .page-title p {
            color: var(--text-muted);
            font-size: 14px;
        }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--gold);
            color: #0b0a09;
            font-family: 'DM Sans', sans-serif;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 14px 28px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(228, 197, 144, 0.25);
            transition: var(--transition);
        }

        .btn-add:hover {
            background: var(--gold-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(228, 197, 144, 0.35);
        }

        .btn-add i {
            font-size: 16px;
        }

        /* ── Glassmorphism Filter Board ── */
        .filter-board {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
        }

        .filter-form {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 20px;
            align-items: flex-end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--gold);
            font-weight: 700;
        }

        .input-control {
            background: rgba(0, 0, 0, 0.35);
            border: 1px solid rgba(228, 197, 144, 0.15);
            border-radius: 8px;
            height: 46px;
            padding: 0 16px;
            color: #fff;
            font-family: inherit;
            font-size: 14px;
            outline: none;
            transition: var(--transition);
            width: 100%;
        }

        .input-control:focus {
            border-color: var(--gold);
            background: rgba(0,0,0,0.5);
            box-shadow: 0 0 0 1px rgba(228, 197, 144, 0.2);
        }

        .input-search-wrapper {
            position: relative;
        }

        .input-search-wrapper .clear-btn {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            cursor: pointer;
            background: none;
            border: none;
            font-size: 14px;
        }

        .input-search-wrapper .clear-btn:hover {
            color: #fff;
        }

        .filter-actions {
            display: flex;
            gap: 12px;
        }

        .btn-filter-submit {
            background: var(--text-main);
            color: var(--dark-bg);
            font-weight: 700;
            font-size: 14px;
            border: none;
            border-radius: 8px;
            height: 46px;
            padding: 0 24px;
            cursor: pointer;
            flex: 1;
            transition: var(--transition);
        }

        .btn-filter-submit:hover {
            background: #fff;
            transform: translateY(-1px);
        }

        .btn-filter-reset {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: var(--text-main);
            font-weight: 500;
            font-size: 14px;
            border-radius: 8px;
            height: 46px;
            padding: 0 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-filter-reset:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255,255,255,0.15);
        }

        /* Tabs Saringan Status */
        .filter-tabs {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .tab-item {
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            padding: 6px 16px;
            border-radius: 20px;
            background: rgba(255,255,255,0.03);
            color: var(--text-muted);
            border: 1px solid rgba(255,255,255,0.04);
            transition: var(--transition);
        }

        .tab-item:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }

        .tab-item--active {
            background: var(--gold) !important;
            color: #0b0a09 !important;
            font-weight: 700;
            border-color: var(--gold) !important;
            box-shadow: 0 4px 12px rgba(228, 197, 144, 0.18);
        }

        /* ── Table Container Board ── */
        .board-container {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
        }

        .board-title {
            padding: 20px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            background: rgba(255, 255, 255, 0.01);
        }

        .board-title h3 {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.5px;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
        }

        th {
            background: rgba(255,255,255,0.01);
            color: var(--gold);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 16px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        td {
            padding: 18px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            vertical-align: middle;
        }

        tr:hover td {
            background: rgba(255, 255, 255, 0.015);
        }

        /* Table Components */
        .guest-name {
            font-weight: 700;
            color: #fff;
            font-size: 15px;
            margin-bottom: 3px;
        }

        .guest-meta {
            font-size: 12px;
            color: var(--text-muted);
        }

        .arrival-time {
            font-weight: 700;
            color: #fff;
            font-size: 15px;
            margin-bottom: 3px;
        }

        .table-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.06);
            color: #fff;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 12px;
        }

        .table-badge span {
            color: var(--text-muted);
            font-weight: 400;
        }

        .status-pill {
            display: inline-flex;
            border-radius: 30px;
            padding: 4px 14px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .status-pill--pending {
            background: rgba(251, 191, 36, 0.12);
            color: var(--pending);
            border: 1px solid rgba(251, 191, 36, 0.2);
        }

        .status-pill--confirmed {
            background: rgba(52, 211, 153, 0.12);
            color: var(--success);
            border: 1px solid rgba(52, 211, 153, 0.2);
        }

        .status-pill--completed {
            background: rgba(56, 189, 248, 0.12);
            color: var(--completed);
            border: 1px solid rgba(56, 189, 248, 0.2);
        }

        .status-pill--cancelled {
            background: rgba(248, 113, 113, 0.12);
            color: var(--danger);
            border: 1px solid rgba(248, 113, 113, 0.2);
        }

        /* Action Buttons */
        .actions-group {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
        }

        .act-btn {
            font-family: inherit;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 8px 14px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: var(--transition);
        }

        .act-btn--confirm {
            background: var(--success);
            color: #0b0a09;
        }

        .act-btn--confirm:hover {
            background: #6ee7b7;
            box-shadow: 0 0 10px rgba(52, 211, 153, 0.3);
        }

        .act-btn--checkin {
            background: var(--gold);
            color: #0b0a09;
        }

        .act-btn--checkin:hover {
            background: var(--gold-hover);
            box-shadow: 0 0 10px rgba(228, 197, 144, 0.3);
        }

        .act-btn--cancel {
            background: rgba(248, 113, 113, 0.08);
            border: 1px solid rgba(248, 113, 113, 0.15);
            color: var(--danger);
        }

        .act-btn--cancel:hover {
            background: rgba(248, 113, 113, 0.2);
            border-color: rgba(248, 113, 113, 0.3);
        }

        .status-text {
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-text--completed {
            color: var(--success);
        }

        .status-text--cancelled {
            color: var(--text-muted);
        }

        /* ── Empty State ── */
        .empty-state {
            padding: 60px 24px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 16px;
        }

        .empty-icon {
            font-size: 40px;
            color: rgba(255,255,255,0.15);
        }

        .empty-state h4 {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
        }

        .empty-state p {
            color: var(--text-muted);
            font-size: 14px;
            max-width: 360px;
        }

        /* ── Modal Pop-up ── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.85);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-card {
            background: #12110f;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            width: 100%;
            max-width: 1080px;
            height: 90vh;
            max-height: 800px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.8);
            transform: scale(0.95);
            transition: transform 0.3s ease;
            overflow: hidden;
        }

        .modal-overlay.active .modal-card {
            transform: scale(1);
        }

        .modal-head {
            padding: 20px 28px;
            border-bottom: 1px solid rgba(228, 197, 144, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255, 255, 255, 0.01);
        }

        .modal-head h3 {
            font-family: 'Forum', serif;
            font-size: 22px;
            letter-spacing: 1.5px;
            color: var(--gold);
        }

        .modal-close-btn {
            background: none;
            border: none;
            font-size: 20px;
            color: var(--text-muted);
            cursor: pointer;
            transition: var(--transition);
        }

        .modal-close-btn:hover {
            color: #fff;
        }

        .modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 28px;
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 28px;
        }

        .modal-col-title {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--gold);
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(228, 197, 144, 0.1);
        }

        .modal-form-fields {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .form-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* Visual map panel inside modal */
        .modal-map-panel {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .modal-floor-map-container {
            flex: 1;
            background: #090807;
            border: 1px solid rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            position: relative;
            overflow: auto;
            min-height: 380px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Scale floor plan slightly inside modal */
        .modal-floor-map-container .table-map__floor {
            transform: scale(0.85);
            transform-origin: center;
            margin: auto;
            background: #11100e !important;
            border-color: rgba(228, 197, 144, 0.12) !important;
        }

        /* Modal Footer */
        .modal-foot {
            padding: 20px 28px;
            border-top: 1px solid rgba(228, 197, 144, 0.1);
            background: rgba(255, 255, 255, 0.01);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .selection-status {
            font-size: 14px;
            font-weight: 700;
            color: var(--gold);
        }

        .modal-actions {
            display: flex;
            gap: 12px;
        }

        .btn-modal-cancel {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: var(--text-main);
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-modal-cancel:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .btn-modal-submit {
            background: var(--gold);
            color: #0b0a09;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px 28px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(228, 197, 144, 0.2);
            transition: var(--transition);
        }

        .btn-modal-submit:hover {
            background: var(--gold-hover);
            transform: translateY(-1px);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .modal-body {
                grid-template-columns: 1fr;
                overflow-y: auto;
            }
            .modal-card {
                height: 95vh;
            }
        }

        @media (max-width: 768px) {
            .filter-form {
                grid-template-columns: 1fr;
            }
            .page-header {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <header>
        <div class="header-container">
            <div class="brand-group">
                <span class="brand-title">Warung Banjar</span>
                <span class="brand-divider"></span>
                <span class="brand-subtitle">Console Resepsionis</span>
            </div>
            
            <div class="nav-actions">
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.index') }}" class="nav-btn nav-btn--admin">Panel Admin</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-btn nav-btn--logout">Keluar</button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Workspace -->
    <main>
        
        <!-- Alerts -->
        @if (session()->has('danger') || session()->has('success') || session()->has('warning'))
            <div style="padding: 16px 24px; border-radius: 10px; font-weight: 700; border: 1px solid; margin-bottom: 8px;
                {{ session()->has('success') ? 'border-color: rgba(52, 211, 153, 0.2); background: rgba(52, 211, 153, 0.08); color: var(--success);' : '' }}
                {{ session()->has('warning') ? 'border-color: rgba(251, 191, 36, 0.2); background: rgba(251, 191, 36, 0.08); color: var(--pending);' : '' }}
                {{ session()->has('danger') ? 'border-color: rgba(248, 113, 113, 0.2); background: rgba(248, 113, 113, 0.08); color: var(--danger);' : '' }}">
                <i class="fa-solid {{ session()->has('success') ? 'fa-circle-check' : 'fa-circle-exclamation' }}" style="margin-right: 8px;"></i>
                {{ session('success') ?? session('warning') ?? session('danger') }}
            </div>
        @endif

        <!-- Action Header -->
        <div class="page-header">
            <div class="page-title">
                <h1>Daftar Kedatangan Tamu</h1>
                <p>Kelola konfirmasi, pembatalan, dan check-in kedatangan tamu secara langsung.</p>
            </div>
            <div>
                <button type="button" onclick="openBookingModal()" class="btn-add">
                    <i class="fa-solid fa-plus"></i> Reservasi Baru (Walk-in)
                </button>
            </div>
        </div>

        <!-- Filter & Search Board -->
        <div class="filter-board">
            <form method="GET" action="{{ route('receptionist.index') }}" class="filter-form">
                <!-- Search Input -->
                <div class="form-group">
                    <label for="search" class="form-label">Cari Tamu</label>
                    <div class="input-search-wrapper">
                        <input type="text" name="search" id="search" value="{{ $search }}" placeholder="Nama, email, atau telepon..." class="input-control">
                        @if($search)
                            <a href="{{ route('receptionist.index', ['date' => $date]) }}" class="clear-btn">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Date Filter -->
                <div class="form-group">
                    <label for="date" class="form-label">Tanggal Operasional</label>
                    <input type="date" name="date" id="date" value="{{ $date }}" class="input-control">
                </div>

                <!-- Action Buttons -->
                <div class="filter-actions">
                    <button type="submit" class="btn-filter-submit">Filter</button>
                    <a href="{{ route('receptionist.index') }}" class="btn-filter-reset">Reset</a>
                </div>
            </form>

            <!-- Quick Filter Tabs -->
            <div class="filter-tabs">
                <a href="{{ route('receptionist.index', ['date' => $date, 'search' => $search]) }}" class="tab-item {{ !$status ? 'tab-item--active' : '' }}">
                    Semua Status
                </a>
                @foreach(App\Enums\ReservationStatus::cases() as $s)
                    <a href="{{ route('receptionist.index', ['status' => $s->value, 'date' => $date, 'search' => $search]) }}" class="tab-item {{ $status === $s->value ? 'tab-item--active' : '' }}">
                        {{ $s->label() }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Bookings Board Table -->
        <div class="board-container">
            <div class="board-title">
                <h3>Daftar Tamu 
                    @if($date && !$search)
                        ({{ Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }})
                    @endif
                </h3>
            </div>

            @if($reservations->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon"><i class="fa-solid fa-users-slash"></i></div>
                    <h4>Tidak Ada Data Reservasi</h4>
                    <p class="mt-1 text-sm text-white/50">Tidak ditemukan jadwal pemesanan meja yang sesuai untuk pencarian atau filter Anda.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Tamu & Kontak</th>
                                <th>Jam Datang</th>
                                <th style="text-align: center;">Jumlah Tamu</th>
                                <th style="text-align: center;">Pilihan Meja</th>
                                <th style="text-align: center;">Status</th>
                                <th style="text-align: right;">Aksi Kedatangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                                <tr>
                                    <!-- Guest -->
                                    <td>
                                        <div class="guest-name">{{ $reservation->name }}</div>
                                        <div class="guest-meta"><i class="fa-solid fa-phone" style="font-size: 10px; margin-right: 4px;"></i> {{ $reservation->phone }}</div>
                                        <div class="guest-meta"><i class="fa-solid fa-envelope" style="font-size: 10px; margin-right: 4px;"></i> {{ $reservation->email }}</div>
                                    </td>
                                    <!-- Date & Time -->
                                    <td>
                                        <div class="arrival-time">{{ $reservation->date->format('H:i') }} WITA</div>
                                        <div class="guest-meta"><i class="fa-regular fa-calendar" style="font-size: 10px; margin-right: 4px;"></i> {{ $reservation->date->isoFormat('D MMM Y') }}</div>
                                    </td>
                                    <!-- Guests Count -->
                                    <td style="text-align: center; font-weight: 700; color: var(--gold);">
                                        {{ $reservation->guests }} Orang
                                    </td>
                                    <!-- Table Info -->
                                    <td style="text-align: center;">
                                        @if($reservation->table)
                                            <span class="table-badge">
                                                Meja {{ preg_replace('/\D+/', '', $reservation->table->name) ?: $reservation->table->name }} 
                                                <span>({{ $reservation->table->capacity }} C)</span>
                                            </span>
                                        @else
                                            <span style="font-size: 12px; color: var(--text-muted)">Belum disetel</span>
                                        @endif
                                    </td>
                                    <!-- Status -->
                                    <td style="text-align: center;">
                                        <span class="status-pill 
                                            {{ $reservation->status === App\Enums\ReservationStatus::Pending ? 'status-pill--pending' : '' }}
                                            {{ $reservation->status === App\Enums\ReservationStatus::Confirmed ? 'status-pill--confirmed' : '' }}
                                            {{ $reservation->status === App\Enums\ReservationStatus::Completed ? 'status-pill--completed' : '' }}
                                            {{ $reservation->status === App\Enums\ReservationStatus::Cancelled ? 'status-pill--cancelled' : '' }}
                                        ">
                                            {{ $reservation->status->label() }}
                                        </span>
                                    </td>
                                    <!-- Actions -->
                                    <td style="text-align: right;">
                                        <div class="actions-group">
                                            @if($reservation->status === App\Enums\ReservationStatus::Pending)
                                                <!-- Confirm -->
                                                <form method="POST" action="{{ route('receptionist.confirm', $reservation) }}">
                                                    @csrf
                                                    <button type="submit" class="act-btn act-btn--confirm">
                                                        Konfirmasi
                                                    </button>
                                                </form>
                                            @endif

                                            @if($reservation->status === App\Enums\ReservationStatus::Confirmed)
                                                <!-- Check-In -->
                                                <form method="POST" action="{{ route('receptionist.check-in', $reservation) }}">
                                                    @csrf
                                                    <button type="submit" class="act-btn act-btn--checkin">
                                                        Tamu Hadir
                                                    </button>
                                                </form>
                                            @endif

                                            @if($reservation->status === App\Enums\ReservationStatus::Completed)
                                                <span class="status-text status-text--completed">
                                                    <i class="fa-solid fa-circle-check"></i> Telah Hadir
                                                </span>
                                            @endif

                                            @if($reservation->status === App\Enums\ReservationStatus::Cancelled)
                                                <span class="status-text status-text--cancelled">
                                                    Dibatalkan
                                                </span>
                                            @endif

                                            @if($reservation->status !== App\Enums\ReservationStatus::Cancelled && $reservation->status !== App\Enums\ReservationStatus::Completed)
                                                <!-- Cancel -->
                                                <form method="POST" action="{{ route('receptionist.cancel', $reservation) }}" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')">
                                                    @csrf
                                                    <button type="submit" class="act-btn act-btn--cancel">
                                                        Batal
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </main>

    <!-- Walk-in Booking Pop-up Modal -->
    <div id="bookingModal" class="modal-overlay">
        <div class="modal-card">
            <!-- Header -->
            <div class="modal-head">
                <h3>Reservasi Walk-in Baru</h3>
                <button type="button" onclick="closeBookingModal()" class="modal-close-btn">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            
            <!-- Body -->
            <form id="walkinForm" method="POST" action="{{ route('receptionist.store-walkin') }}" class="modal-body">
                @csrf
                
                <!-- Left: Form Fields -->
                <div>
                    <h4 class="modal-col-title">Data Tamu</h4>
                    
                    <div class="modal-form-fields">
                        <div class="form-group">
                            <label for="name_walkin" class="form-label">Nama Tamu</label>
                            <input type="text" id="name_walkin" name="name" required class="input-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="phone_walkin" class="form-label">Nomor Telepon</label>
                            <input type="tel" id="phone_walkin" name="phone" required class="input-control">
                        </div>

                        <div class="form-group">
                            <label for="email_walkin" class="form-label">Email <span style="font-size: 10px; color: var(--text-muted)">(Opsional)</span></label>
                            <input type="email" id="email_walkin" name="email" class="input-control" placeholder="tamu@email.com">
                        </div>

                        <div class="form-row-2">
                            <div class="form-group">
                                <label for="guests_walkin" class="form-label">Jumlah Tamu</label>
                                <input type="number" id="guests_walkin" name="guests" min="1" max="20" required value="2" class="input-control">
                            </div>

                            <div class="form-group">
                                <label for="date_only" class="form-label">Tanggal</label>
                                <input type="date" id="date_only" required value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" class="input-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="time_only" class="form-label">Waktu Kedatangan</label>
                            <select id="time_only" required class="input-control">
                                @php
                                    $start = Carbon\Carbon::createFromTimeString('08:00');
                                    $end = Carbon\Carbon::createFromTimeString('21:00');
                                @endphp
                                @while($start->lte($end))
                                    @php $timeStr = $start->format('H:i'); @endphp
                                    <option value="{{ $timeStr }}" @selected($timeStr === '12:00')>{{ $timeStr }} WITA</option>
                                    @php $start->addMinutes(30); @endphp
                                @endwhile
                            </select>
                        </div>
                    </div>

                    <!-- Hidden fields -->
                    <input type="hidden" id="date_combined" name="date">
                    <input type="hidden" id="selected_table_id" name="table_id" required>
                </div>

                <!-- Right: Visual Table Selector -->
                <div class="modal-map-panel">
                    <h4 class="modal-col-title">Peta Denah Meja</h4>
                    
                    <div class="modal-floor-map-container">
                        <div class="table-map__floor">
                            <div class="table-map__grid"></div>
                            
                            @foreach($tables as $table)
                                @php
                                    $shape = $table->layout_shape === 'horizontal' ? 'horizontal' : 'vertical';
                                @endphp
                                <label class="table-choice table-choice--{{ $shape }} table-capacity--{{ $table->capacity }}" 
                                       data-id="{{ $table->id }}" 
                                       data-capacity="{{ $table->capacity }}" 
                                       style="left: {{ $table->layout_x }}%; top: {{ $table->layout_y }}%; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center;">
                                    <input type="radio" name="modal_table_radio" value="{{ $table->id }}" style="position: absolute; opacity: 0; pointer-events: none;">
                                    <span style="display: flex; align-items: center; justify-content: center; width: 100%; flex: 1 1 auto; text-align: center; font-size: 14px; font-style: italic; font-weight: 700; line-height: 1; margin: 0; box-sizing: border-box;">{{ preg_replace('/\D+/', '', $table->name) ?: $table->name }}</span>
                                    <em style="display: flex; align-items: center; justify-content: center; width: 100%; font-size: 8px; font-style: normal; margin: 0; padding-bottom: 2px; box-sizing: border-box;">{{ $table->capacity }} C</em>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>

            <!-- Footer -->
            <div class="modal-foot">
                <span id="selectionSummary" class="selection-status">Pilih meja pada denah...</span>
                <div class="modal-actions">
                    <button type="button" onclick="closeBookingModal()" class="btn-modal-cancel">Batal</button>
                    <button type="button" onclick="submitWalkin()" class="btn-modal-submit">Simpan Reservasi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for Interactive Booking Modal -->
    <script>
        const openBookingModal = () => {
            document.getElementById('bookingModal').classList.add('active');
            updateDateTimeCombined();
            fetchAvailability();
        };

        const closeBookingModal = () => {
            document.getElementById('bookingModal').classList.remove('active');
        };

        const updateDateTimeCombined = () => {
            const dateVal = document.getElementById('date_only').value;
            const timeVal = document.getElementById('time_only').value;
            if (dateVal && timeVal) {
                document.getElementById('date_combined').value = `${dateVal} ${timeVal}`;
            }
        };

        const fetchAvailability = () => {
            updateDateTimeCombined();
            const dateCombined = document.getElementById('date_combined').value;
            const guests = parseInt(document.getElementById('guests_walkin').value) || 1;

            if (!dateCombined) return;

            // Reset current selection
            document.getElementById('selected_table_id').value = '';
            document.getElementById('selectionSummary').innerText = 'Pilih meja pada denah...';

            fetch(`/receptionist/check-availability?date=${encodeURIComponent(dateCombined)}&guests=${guests}`)
                .then(response => response.json())
                .then(data => {
                    const reservedIds = data.reserved_table_ids || [];
                    const tableLabels = document.querySelectorAll('#bookingModal .table-choice');

                    tableLabels.forEach(label => {
                        const tableId = parseInt(label.getAttribute('data-id'));
                        const capacity = parseInt(label.getAttribute('data-capacity'));
                        const isReserved = reservedIds.includes(tableId);
                        const isTooSmall = capacity < guests;

                        // Reset styles
                        label.style.background = '';
                        label.style.boxShadow = '';
                        label.style.color = '#fff';
                        
                        const radio = label.querySelector('input');
                        radio.checked = false;

                        if (isReserved || isTooSmall) {
                            label.classList.add('table-choice--disabled');
                            label.style.opacity = '0.2';
                            label.style.cursor = 'not-allowed';
                            label.style.pointerEvents = 'none';
                        } else {
                            label.classList.remove('table-choice--disabled');
                            label.style.opacity = '1';
                            label.style.cursor = 'pointer';
                            label.style.pointerEvents = 'auto';
                        }
                    });
                })
                .catch(err => console.error('Error checking table availability:', err));
        };

        document.getElementById('date_only').addEventListener('change', fetchAvailability);
        document.getElementById('time_only').addEventListener('change', fetchAvailability);
        document.getElementById('guests_walkin').addEventListener('input', fetchAvailability);

        // Click Handler for Tables
        document.querySelectorAll('#bookingModal .table-choice').forEach(label => {
            label.addEventListener('click', () => {
                if (label.classList.contains('table-choice--disabled')) return;

                // Unselect others
                document.querySelectorAll('#bookingModal .table-choice').forEach(l => {
                    if (!l.classList.contains('table-choice--disabled')) {
                        l.style.background = '';
                        l.style.boxShadow = '';
                        l.style.color = '#fff';
                        l.querySelector('input').checked = false;
                    }
                });

                // Select current
                label.style.background = 'linear-gradient(180deg, #e4c590, #caa66d)';
                label.style.color = '#0b0a09';
                label.style.boxShadow = '0 8px 20px rgba(228, 197, 144, 0.35)';
                
                const radio = label.querySelector('input');
                radio.checked = true;
                
                const tableId = label.getAttribute('data-id');
                document.getElementById('selected_table_id').value = tableId;

                const tableName = label.querySelector('span').innerText;
                document.getElementById('selectionSummary').innerText = `Terpilih: Meja ${tableName} (${label.getAttribute('data-capacity')} Kursi)`;
            });
        });

        const submitWalkin = () => {
            const tableId = document.getElementById('selected_table_id').value;
            if (!tableId) {
                alert('Pilih salah satu meja pada denah terlebih dahulu!');
                return;
            }
            document.getElementById('walkinForm').submit();
        };
    </script>
</body>
</html>
