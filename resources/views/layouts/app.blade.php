<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title', 'Dashboard') — ENSAH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #0f172a;
            --sidebar-hover: rgba(255,255,255,0.06);
            --accent: #e94560;
            --accent2: #6366f1;
            --topbar-bg: #ffffff;
            --content-bg: #f1f5f9;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #94a3b8;
            --border: #e2e8f0;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { background: var(--content-bg); font-family: 'Segoe UI', sans-serif; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            overflow-y: auto;
        }
        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .sidebar-brand .brand-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--accent), #c73652);
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
            margin-bottom: 10px;
        }
        .sidebar-brand h5 {
            color: white;
            font-size: 1rem;
            font-weight: 700;
            margin: 0;
        }
        .sidebar-brand p {
            color: var(--text-muted);
            font-size: 0.72rem;
            margin: 2px 0 0;
        }
        .sidebar-section {
            padding: 20px 20px 6px;
            color: rgba(255,255,255,0.25);
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 0.875rem;
            border-left: 3px solid transparent;
            transition: all 0.2s;
            position: relative;
        }
        .sidebar-link i { font-size: 1rem; min-width: 20px; }
        .sidebar-link:hover {
            color: white;
            background: var(--sidebar-hover);
        }
        .sidebar-link.active {
            color: white;
            background: rgba(233,69,96,0.12);
            border-left: 3px solid var(--accent);
        }
        .sidebar-link .badge-count {
            margin-left: auto;
            background: var(--accent);
            color: white;
            font-size: 0.65rem;
            padding: 2px 7px;
            border-radius: 20px;
        }
        .sidebar-bottom {
            margin-top: auto;
            padding: 15px 0;
            border-top: 1px solid rgba(255,255,255,0.06);
        }

        /* ===== MAIN ===== */
        .main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            background: var(--topbar-bg);
            padding: 0 30px;
            height: 65px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 999;
        }
        .topbar-left { display: flex; align-items: center; gap: 15px; }
        .topbar-left h5 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
        }
        .topbar-right { display: flex; align-items: center; gap: 15px; }
        .topbar-icon-btn {
            width: 38px; height: 38px;
            border-radius: 10px;
            background: var(--content-bg);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 1rem;
            text-decoration: none;
            position: relative;
            transition: all 0.2s;
        }
        .topbar-icon-btn:hover { background: var(--border); color: var(--text-main); }
        .topbar-icon-btn .notif-dot {
            position: absolute;
            top: 6px; right: 6px;
            width: 8px; height: 8px;
            background: var(--accent);
            border-radius: 50%;
            border: 2px solid white;
        }
        .user-avatar {
            width: 34px; height: 34px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--accent), #c73652);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.85rem;
        }
        .user-info-text .name {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-main);
            line-height: 1.2;
        }
        .user-info-text .role {
            font-size: 0.72rem;
            color: var(--text-muted);
        }

        /* ===== CONTENT ===== */
        .content-wrapper { padding: 28px 30px; flex: 1; }

        /* ===== STATS CARDS ===== */
        .stat-card {
            background: var(--card-bg);
            border-radius: 14px;
            padding: 22px;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 18px;
            transition: all 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }
        .stat-icon {
            width: 52px; height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }
        .stat-icon.red    { background: rgba(233,69,96,0.12);  color: var(--accent); }
        .stat-icon.blue   { background: rgba(99,102,241,0.12); color: var(--accent2); }
        .stat-icon.green  { background: rgba(16,185,129,0.12); color: #10b981; }
        .stat-icon.orange { background: rgba(245,158,11,0.12); color: #f59e0b; }
        .stat-number {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1;
        }
        .stat-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 3px;
        }

        /* ===== APP CARDS ===== */
        .app-card {
            background: var(--card-bg);
            border-radius: 14px;
            border: 1px solid var(--border);
            overflow: hidden;
        }
        .app-card-header {
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .app-card-header h6 {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .app-card-body { padding: 22px; }

        /* ===== TABLE ===== */
        .app-table { width: 100%; border-collapse: collapse; }
        .app-table thead th {
            padding: 12px 16px;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            font-weight: 600;
            background: #f8fafc;
            border-bottom: 1px solid var(--border);
        }
        .app-table tbody td {
            padding: 14px 16px;
            font-size: 0.875rem;
            color: var(--text-main);
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        .app-table tbody tr:hover { background: #f8fafc; }
        .app-table tbody tr:last-child td { border-bottom: none; }

        /* ===== BADGES ===== */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .status-badge::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: currentColor;
        }
        .status-badge.justified  { background: #d1fae5; color: #065f46; }
        .status-badge.pending    { background: #fee2e2; color: #991b1b; }
        .status-badge.cancelled  { background: #f1f5f9; color: #64748b; }
        .status-badge.waiting    { background: #fef3c7; color: #92400e; }

        /* ===== BUTTONS ===== */
        .btn-app {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 18px;
            border-radius: 9px;
            font-size: 0.85rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-app:hover { transform: translateY(-1px); }
        .btn-app.primary { background: var(--accent); color: white; }
        .btn-app.primary:hover { background: #c73652; color: white; }
        .btn-app.secondary { background: var(--content-bg); color: var(--text-main); border: 1px solid var(--border); }
        .btn-app.success { background: #d1fae5; color: #065f46; }
        .btn-app.warning { background: #fef3c7; color: #92400e; }
        .btn-app.danger  { background: #fee2e2; color: #991b1b; }

        /* ===== FORM ===== */
        .form-group { margin-bottom: 20px; }
        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 7px;
            display: block;
        }
        .form-control, .form-select {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: 9px;
            font-size: 0.875rem;
            outline: none;
            transition: all 0.2s;
            background: white;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(233,69,96,0.08);
        }

        /* ===== ALERTS ===== */
        .app-alert {
            padding: 14px 18px;
            border-radius: 10px;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .app-alert.success { background: #d1fae5; color: #065f46; }
        .app-alert.error   { background: #fee2e2; color: #991b1b; }

        /* ===== PAGE HEADER ===== */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
        }
        .page-header h4 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
        }
        .page-header p {
            font-size: 0.83rem;
            color: var(--text-muted);
            margin: 3px 0 0;
        }

        /* ===== STUDENT CARD ===== */
        .student-card {
            background: white;
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .student-card:hover { border-color: #cbd5e1; }
        .student-card.absent {
            border-color: var(--accent);
            background: rgba(233,69,96,0.04);
        }
        .student-card img {
            width: 64px; height: 64px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 8px;
        }
        .student-card .name {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-main);
        }
        .student-card .absent-mark {
            display: none;
            font-size: 0.72rem;
            color: var(--accent);
            font-weight: 600;
        }
        .student-card.absent .absent-mark { display: block; }

        /* ===== DROPDOWN ===== */
        .dropdown-menu {
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 6px;
        }
        .dropdown-item {
            border-radius: 8px;
            font-size: 0.875rem;
            padding: 9px 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .dropdown-item:hover { background: #f8fafc; }
    </style>
</head>
<body>

<!-- ===== SIDEBAR ===== -->
<div class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="bi bi-mortarboard-fill"></i></div>
        <h5>ENSAH Absences</h5>
        <p>Système de gestion des absences</p>
    </div>

    @if(session('role') === 'administrateur')
        <div class="sidebar-section">Administration</div>
        <a href="{{ route('admin.absences') }}"
           class="sidebar-link {{ request()->routeIs('admin.absences*') ? 'active' : '' }}">
            <i class="bi bi-table"></i> Toutes les absences
        </a>
        <a href="{{ route('admin.justifications') }}"
           class="sidebar-link {{ request()->routeIs('admin.justifications*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-check"></i> Justifications
        </a>
        <a href="{{ route('admin.reclamations') }}"
           class="sidebar-link {{ request()->routeIs('admin.reclamations*') ? 'active' : '' }}">
            <i class="bi bi-chat-left-dots"></i> Réclamations
        </a>
        <a href="{{ route('admin.saisie.manuelle') }}"
           class="sidebar-link {{ request()->routeIs('admin.saisie*') ? 'active' : '' }}">
            <i class="bi bi-keyboard"></i> Saisie manuelle
        </a>

    @elseif(session('role') === 'enseignant')
        <div class="sidebar-section">Enseignant</div>
        <a href="{{ route('enseignant.saisie') }}"
           class="sidebar-link {{ request()->routeIs('enseignant.saisie*') ? 'active' : '' }}">
            <i class="bi bi-pencil-square"></i> Saisir des absences
        </a>
        <a href="{{ route('enseignant.fiche') }}"
           class="sidebar-link {{ request()->routeIs('enseignant.fiche*') ? 'active' : '' }}">
            <i class="bi bi-person-lines-fill"></i> Fiche étudiant
        </a>
        <a href="{{ route('enseignant.annulation') }}"
           class="sidebar-link {{ request()->routeIs('enseignant.annulation*') ? 'active' : '' }}">
            <i class="bi bi-x-circle"></i> Annuler une absence
        </a>
        <a href="{{ route('enseignant.demandes') }}"
           class="sidebar-link {{ request()->routeIs('enseignant.demandes*') ? 'active' : '' }}">
            <i class="bi bi-envelope"></i> Demandes de permission
        </a>

    @elseif(session('role') === 'etudiant')
        <div class="sidebar-section">Étudiant</div>
        <a href="{{ route('etudiant.fiche') }}"
           class="sidebar-link {{ request()->routeIs('etudiant.fiche*') ? 'active' : '' }}">
            <i class="bi bi-calendar3"></i> Mes absences
        </a>
        <a href="{{ route('etudiant.justification') }}"
           class="sidebar-link {{ request()->routeIs('etudiant.justification*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-check"></i> Justifications
        </a>
        <a href="{{ route('etudiant.reclamation') }}"
           class="sidebar-link {{ request()->routeIs('etudiant.reclamation*') ? 'active' : '' }}">
            <i class="bi bi-chat-left-text"></i> Réclamations
        </a>
        <a href="{{ route('etudiant.demande') }}"
           class="sidebar-link {{ request()->routeIs('etudiant.demande*') ? 'active' : '' }}">
            <i class="bi bi-send"></i> Demande de permission
        </a>
        <a href="{{ route('etudiant.profil') }}"
           class="sidebar-link {{ request()->routeIs('etudiant.profil*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> Mon profil
        </a>
    @endif

    <div class="sidebar-bottom">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-link"
                    style="width:100%; background:none; border:none; text-align:left; cursor:pointer;">
                <i class="bi bi-box-arrow-left"></i> Déconnexion
            </button>
        </form>
    </div>
</div>

<!-- ===== MAIN ===== -->
<div class="main-wrapper">

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="topbar-left">
            <h5>@yield('page_title', 'Tableau de bord')</h5>
        </div>
        <div class="topbar-right">

            <!-- Notifications -->
            <a href="#" class="topbar-icon-btn">
                <i class="bi bi-bell"></i>
                <span class="notif-dot"></span>
            </a>

            <!-- User dropdown -->
            <div class="dropdown">
                <div class="d-flex align-items-center gap-2 px-3 py-2"
                     style="border:1px solid var(--border); border-radius:10px; cursor:pointer;"
                     data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar">
                        {{ strtoupper(substr(session('role', 'U'), 0, 1)) }}
                    </div>
                    <div class="user-info-text">
                        <div class="name">{{ ucfirst(session('role', 'Utilisateur')) }}</div>
                        <div class="role">Connecté</div>
                    </div>
                    <i class="bi bi-chevron-down ms-1" style="font-size:0.75rem; color:var(--text-muted)"></i>
                </div>

                <ul class="dropdown-menu dropdown-menu-end mt-2">
                    <li>
                        <div style="padding:12px 16px; border-bottom:1px solid var(--border); margin-bottom:4px">
                            <div style="font-weight:600; font-size:0.875rem; color:var(--text-main)">
                                {{ ucfirst(session('role', 'Utilisateur')) }}
                            </div>
                            <div style="font-size:0.75rem; color:var(--text-muted)">Session active</div>
                        </div>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item" style="color:#991b1b;">
                                <i class="bi bi-box-arrow-left"></i> Déconnexion
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    <!-- CONTENT -->
    <div class="content-wrapper">

        @if(session('success'))
        <div class="app-alert success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="app-alert error">
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