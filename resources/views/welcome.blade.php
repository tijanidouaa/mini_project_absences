<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Absences - ENSAH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #0a0f2c;
            --navy-mid: #111936;
            --navy-light: #1a2550;
            --accent: #e63562;
            --accent-soft: rgba(230,53,98,0.15);
            --gold: #f5a623;
            --text: #e8eaf6;
            --text-muted: rgba(232,234,246,0.5);
            --border: rgba(255,255,255,0.07);
            --glass: rgba(255,255,255,0.04);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--navy);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* ── Background ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 80% 20%, rgba(230,53,98,0.12) 0%, transparent 60%),
                radial-gradient(ellipse 40% 40% at 10% 80%, rgba(26,37,80,0.8) 0%, transparent 60%);
            pointer-events: none;
            z-index: 0;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: var(--navy-mid);
            border-right: 1px solid var(--border);
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-logo {
            padding: 28px 24px 24px;
            border-bottom: 1px solid var(--border);
        }
        .sidebar-logo .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: -0.3px;
        }
        .sidebar-logo .brand-icon {
            width: 36px; height: 36px;
            background: var(--accent);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .sidebar-logo .brand-sub {
            font-size: 0.68rem;
            color: var(--text-muted);
            margin-top: 2px;
            font-family: 'JetBrains Mono', monospace;
            letter-spacing: 0.5px;
        }

        .sidebar-nav { flex: 1; padding: 16px 0; overflow-y: auto; }

        .nav-section {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 16px 24px 8px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 24px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            border-left: 2px solid transparent;
            transition: all 0.2s ease;
            position: relative;
        }
        .nav-link i { font-size: 1rem; width: 18px; text-align: center; }
        .nav-link:hover {
            color: var(--text);
            background: var(--glass);
            border-left-color: var(--accent);
        }
        .nav-link.active {
            color: white;
            background: var(--accent-soft);
            border-left-color: var(--accent);
        }

        .sidebar-footer {
            padding: 16px 0;
            border-top: 1px solid var(--border);
        }

        /* Logout button */
        .logout-form { margin: 0; padding: 0; }
        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 24px;
            color: var(--text-muted);
            font-size: 0.875rem;
            font-weight: 500;
            background: none;
            border: none;
            border-left: 2px solid transparent;
            width: 100%;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Sora', sans-serif;
        }
        .logout-btn:hover {
            color: var(--accent);
            background: var(--accent-soft);
            border-left-color: var(--accent);
        }
        .logout-btn i { font-size: 1rem; width: 18px; text-align: center; }

        /* ── MAIN ── */
        .main-content {
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 1;
        }

        /* ── TOPBAR ── */
        .topbar {
            background: rgba(10,15,44,0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 90;
        }
        .topbar-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text);
        }
        .topbar-title span {
            color: var(--text-muted);
            font-weight: 400;
        }

        .user-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--glass);
            border: 1px solid var(--border);
            border-radius: 50px;
            padding: 6px 14px 6px 6px;
        }
        .user-avatar {
            width: 30px; height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), #8b1a3a);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
        }
        .user-name {
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        /* ── CONTENT ── */
        .content-area { padding: 32px; flex: 1; }

        /* ── ALERTS ── */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.875rem;
        }
        .alert-success {
            background: rgba(16,185,129,0.12);
            border: 1px solid rgba(16,185,129,0.25);
            color: #6ee7b7;
        }
        .alert-danger {
            background: rgba(230,53,98,0.12);
            border: 1px solid rgba(230,53,98,0.25);
            color: #fca5a5;
        }

        /* ── CARDS ── */
        .card {
            background: var(--navy-mid);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
        }
        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border);
            padding: 18px 24px;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text);
        }
        .card-body { padding: 24px; }

        /* ── TABLES ── */
        .table {
            color: var(--text);
            font-size: 0.875rem;
        }
        .table thead th {
            background: rgba(255,255,255,0.03);
            border-bottom: 1px solid var(--border);
            color: var(--text-muted);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px 16px;
            font-weight: 500;
        }
        .table tbody td {
            border-bottom: 1px solid var(--border);
            padding: 13px 16px;
            vertical-align: middle;
        }
        .table tbody tr:hover td { background: var(--glass); }
        .table tbody tr:last-child td { border-bottom: none; }

        /* ── BUTTONS ── */
        .btn-primary {
            background: var(--accent);
            border: none;
            border-radius: 10px;
            padding: 10px 22px;
            font-size: 0.875rem;
            font-weight: 600;
            font-family: 'Sora', sans-serif;
            transition: all 0.2s;
        }
        .btn-primary:hover {
            background: #cc2d57;
            transform: translateY(-1px);
            box-shadow: 0 4px 20px rgba(230,53,98,0.35);
        }
        .btn-outline-secondary {
            border-color: var(--border);
            color: var(--text-muted);
            border-radius: 10px;
            font-family: 'Sora', sans-serif;
        }
        .btn-outline-secondary:hover {
            background: var(--glass);
            color: var(--text);
            border-color: var(--text-muted);
        }

        /* ── FORMS ── */
        .form-control, .form-select {
            background: var(--navy-light);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            padding: 10px 14px;
            font-family: 'Sora', sans-serif;
            font-size: 0.875rem;
            transition: border-color 0.2s;
        }
        .form-control:focus, .form-select:focus {
            background: var(--navy-light);
            border-color: var(--accent);
            color: var(--text);
            box-shadow: 0 0 0 3px rgba(230,53,98,0.15);
        }
        .form-control::placeholder { color: var(--text-muted); }
        .form-select option { background: var(--navy-mid); }
        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 6px;
            letter-spacing: 0.3px;
        }

        /* ── BADGES ── */
        .badge {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.65rem;
            padding: 4px 10px;
            border-radius: 6px;
        }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .content-area > * { animation: fadeUp 0.4s ease both; }
    </style>
</head>
<body>

<!-- ═══════════════ SIDEBAR ═══════════════ -->
<div class="sidebar">
    <div class="sidebar-logo">
        <div class="brand">
            <div class="brand-icon"><i class="bi bi-mortarboard-fill"></i></div>
            <div>
                <div>ENSAH</div>
                <div class="brand-sub">Gestion des Absences</div>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        @if(session('role') === 'enseignant')
            <div class="nav-section">Enseignant</div>
            <a href="{{ route('enseignant.saisie') }}" class="nav-link {{ request()->routeIs('enseignant.saisie') ? 'active' : '' }}">
                <i class="bi bi-pencil-square"></i> Saisir des absences
            </a>
            <a href="{{ route('enseignant.fiche') }}" class="nav-link {{ request()->routeIs('enseignant.fiche') ? 'active' : '' }}">
                <i class="bi bi-person-lines-fill"></i> Fiche étudiant
            </a>
            <a href="{{ route('enseignant.annulation') }}" class="nav-link {{ request()->routeIs('enseignant.annulation') ? 'active' : '' }}">
                <i class="bi bi-x-circle"></i> Annuler une absence
            </a>
            <a href="{{ route('enseignant.demandes') }}" class="nav-link {{ request()->routeIs('enseignant.demandes') ? 'active' : '' }}">
                <i class="bi bi-envelope"></i> Demandes de permission
            </a>

        @elseif(session('role') === 'etudiant')
            <div class="nav-section">Étudiant</div>
            <a href="{{ route('etudiant.fiche') }}" class="nav-link {{ request()->routeIs('etudiant.fiche') ? 'active' : '' }}">
                <i class="bi bi-calendar3"></i> Mes absences
            </a>
            <a href="{{ route('etudiant.justification') }}" class="nav-link {{ request()->routeIs('etudiant.justification') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-check"></i> Justifications
            </a>
            <a href="{{ route('etudiant.reclamation') }}" class="nav-link {{ request()->routeIs('etudiant.reclamation') ? 'active' : '' }}">
                <i class="bi bi-chat-left-text"></i> Réclamations
            </a>
            <a href="{{ route('etudiant.demande') }}" class="nav-link {{ request()->routeIs('etudiant.demande') ? 'active' : '' }}">
                <i class="bi bi-send"></i> Demande de permission
            </a>
            <a href="{{ route('etudiant.profil') }}" class="nav-link {{ request()->routeIs('etudiant.profil') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> Mon profil
            </a>

        @elseif(session('role') === 'administrateur')
            <div class="nav-section">Administration</div>
            <a href="{{ route('admin.absences') }}" class="nav-link {{ request()->routeIs('admin.absences') ? 'active' : '' }}">
                <i class="bi bi-table"></i> Toutes les absences
            </a>
            <a href="{{ route('admin.justifications') }}" class="nav-link {{ request()->routeIs('admin.justifications') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-check"></i> Justifications
            </a>
            <a href="{{ route('admin.reclamations') }}" class="nav-link {{ request()->routeIs('admin.reclamations') ? 'active' : '' }}">
                <i class="bi bi-chat-left-dots"></i> Réclamations
            </a>
            <a href="{{ route('admin.saisie.manuelle') }}" class="nav-link {{ request()->routeIs('admin.saisie.manuelle') ? 'active' : '' }}">
                <i class="bi bi-keyboard"></i> Saisie manuelle
            </a>
        @endif
    </nav>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-left"></i> Déconnexion
            </button>
        </form>
    </div>
</div>

<!-- ═══════════════ MAIN ═══════════════ -->
<div class="main-content">

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="topbar-title">
            @yield('page_title', 'Tableau de bord')
        </div>
        <div class="user-badge">
            <div class="user-avatar">
                {{ strtoupper(substr(session('role', 'U'), 0, 1)) }}
            </div>
            <span class="user-name">{{ session('role', 'Utilisateur') }}</span>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="content-area">

        @if(session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        @yield('contenu')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>