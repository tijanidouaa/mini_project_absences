<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>ENSAH — @yield('title', 'Gestion des Absences')</title>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
:root {
    --navy: #0f1e3d; --blue: #1a3a6b; --accent: #2d7dd2;
    --gold: #f0a500;  --light: #f4f7fb; --sidebar-w: 260px;
    --radius: 14px;
}
* { font-family: 'Sora', sans-serif; box-sizing: border-box; }
body { background: var(--light); margin: 0; }

/* ─── Sidebar ─── */
.sidebar {
    position: fixed; top: 0; left: 0; bottom: 0;
    width: var(--sidebar-w);
    background: var(--navy);
    display: flex; flex-direction: column;
    z-index: 200; transition: transform .3s;
    overflow-y: auto;
}
.sidebar-logo {
    padding: 22px 18px;
    border-bottom: 1px solid rgba(255,255,255,.08);
    display: flex; align-items: center; gap: 12px;
}
.logo-icon {
    width: 42px; height: 42px; border-radius: 11px; flex-shrink: 0;
    background: linear-gradient(135deg, var(--accent), var(--blue));
    display: flex; align-items: center; justify-content: center; font-size: 20px;
}
.logo-text { color: white; font-weight: 700; font-size: .95rem; line-height: 1.3; }
.logo-text small { color: rgba(255,255,255,.4); font-size: .68rem; display: block; }
.nav-section {
    padding: 16px 16px 6px;
    color: rgba(255,255,255,.3);
    font-size: .65rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase;
}
.nav-link-item {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 14px; margin: 2px 8px; border-radius: 10px;
    color: rgba(255,255,255,.6);
    text-decoration: none; font-size: .855rem; font-weight: 500;
    transition: all .2s;
}
.nav-link-item:hover { background: rgba(45,125,210,.2); color: white; }
.nav-link-item.active { background: var(--accent); color: white; }
.nav-icon { width: 20px; text-align: center; font-size: 15px; flex-shrink: 0; }
.sidebar-footer {
    margin-top: auto; padding: 14px;
    border-top: 1px solid rgba(255,255,255,.08);
}
.user-card {
    background: rgba(255,255,255,.06); border-radius: 11px;
    padding: 11px; display: flex; align-items: center; gap: 10px;
}
.user-avatar {
    width: 34px; height: 34px; border-radius: 50%;
    background: var(--accent); color: white;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 13px; flex-shrink: 0;
}
.user-name  { color: white; font-size: .82rem; font-weight: 600; }
.user-role  { color: rgba(255,255,255,.4); font-size: .68rem; text-transform: capitalize; }

/* ─── Main ─── */
.main-wrap { margin-left: var(--sidebar-w); min-height: 100vh; }
.topbar {
    background: white; padding: 14px 28px;
    border-bottom: 1px solid #e9edf3;
    display: flex; align-items: center; justify-content: space-between;
    position: sticky; top: 0; z-index: 100;
}
.topbar-title { font-weight: 700; color: var(--navy); font-size: 1.05rem; }
.main-content { padding: 28px; }

/* ─── Cards ─── */
.card-stat {
    background: white; border-radius: var(--radius);
    padding: 22px; border: 1px solid #eaecf2;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
    transition: transform .2s, box-shadow .2s;
}
.card-stat:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.09); }
.stat-icon {
    width: 46px; height: 46px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; margin-bottom: 14px;
}
.stat-val  { font-size: 1.9rem; font-weight: 700; color: var(--navy); line-height: 1; }
.stat-lbl  { color: #6b7a99; font-size: .82rem; margin-top: 4px; }

/* ─── Table card ─── */
.table-card {
    background: white; border-radius: var(--radius);
    border: 1px solid #eaecf2; overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
}
.table-card-header {
    padding: 18px 22px; border-bottom: 1px solid #eef1f6;
    display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;
}
.table-card-header h2 { font-size: .95rem; font-weight: 700; color: var(--navy); margin: 0; }
.table > thead > tr > th {
    background: #f8fafc; color: #6b7a99;
    font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .5px;
    padding: 11px 16px; border-bottom: 1px solid #eef1f6;
}
.table > tbody > tr > td { padding: 13px 16px; vertical-align: middle; font-size: .875rem; }
.table > tbody > tr:hover { background: #fafbfd; }

/* ─── Form card ─── */
.form-card {
    background: white; border-radius: var(--radius);
    padding: 24px; border: 1px solid #eaecf2;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
}
.form-label { font-weight: 600; font-size: .82rem; color: var(--navy); margin-bottom: 6px; }
.form-control, .form-select {
    border-radius: 10px; border: 1.5px solid #e2e8f0;
    padding: 9px 13px; font-family: 'Sora', sans-serif; font-size: .875rem;
    transition: all .2s;
}
.form-control:focus, .form-select:focus {
    border-color: var(--accent); box-shadow: 0 0 0 3px rgba(45,125,210,.15);
}

/* ─── Buttons ─── */
.btn-primary-app {
    background: var(--accent); color: white; border: none;
    padding: 9px 18px; border-radius: 10px; font-family: 'Sora', sans-serif;
    font-weight: 600; font-size: .855rem; cursor: pointer; text-decoration: none;
    display: inline-flex; align-items: center; gap: 7px; transition: all .2s;
}
.btn-primary-app:hover { background: #1a5fa8; color: white; transform: translateY(-1px); }
.btn-sm-edit   { background: #e0f2fe; color: #0369a1; border: none; padding: 6px 12px; border-radius: 8px; font-size: .78rem; font-weight: 600; cursor: pointer; transition: .2s; }
.btn-sm-edit:hover { background: #bae6fd; }
.btn-sm-danger { background: #fee2e2; color: #b91c1c; border: none; padding: 6px 12px; border-radius: 8px; font-size: .78rem; font-weight: 600; cursor: pointer; transition: .2s; }
.btn-sm-danger:hover { background: #fecaca; }
.btn-sm-green  { background: #d1fae5; color: #065f46; border: none; padding: 6px 12px; border-radius: 8px; font-size: .78rem; font-weight: 600; cursor: pointer; transition: .2s; }

/* ─── Badges ─── */
.badge-role { padding: 4px 10px; border-radius: 20px; font-size: .71rem; font-weight: 700; }
.badge-admin       { background: #fef3c7; color: #92400e; }
.badge-enseignant  { background: #dbeafe; color: #1e40af; }
.badge-etudiant    { background: #d1fae5; color: #065f46; }
.badge-active   { background: #d1fae5; color: #065f46; padding: 3px 9px; border-radius: 20px; font-size: .71rem; font-weight: 700; }
.badge-inactive { background: #fee2e2; color: #b91c1c; padding: 3px 9px; border-radius: 20px; font-size: .71rem; font-weight: 700; }

/* ─── Alert ─── */
.alert { border-radius: 11px; font-size: .875rem; }

/* ─── Modal ─── */
.modal-content { border-radius: 16px; border: none; }
.modal-header  { border-bottom: 1px solid #eef1f6; }
.modal-footer  { border-top: 1px solid #eef1f6; }

/* Mobile */
@media(max-width: 768px) {
    .sidebar { transform: translateX(-100%); }
    .sidebar.show { transform: translateX(0); }
    .main-wrap { margin-left: 0; }
}
</style>
@stack('styles')
</head>
<body>

<!-- ─── SIDEBAR ─── -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">🎓</div>
        <div class="logo-text">ENSAH <small>Gestion des Absences</small></div>
    </div>

    @auth
    @if(auth()->user()->isAdmin())
        <div class="nav-section">Principal</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="nav-icon">📊</span> Tableau de bord
        </a>

        <div class="nav-section">Modules</div>
        <a href="{{ route('admin.etudiants.index') }}" class="nav-link-item {{ request()->routeIs('admin.etudiants.*') ? 'active' : '' }}">
            <span class="nav-icon">👥</span> Étudiants
        </a>
        <a href="{{ route('admin.comptes.index') }}" class="nav-link-item {{ request()->routeIs('admin.comptes.*') ? 'active' : '' }}">
            <span class="nav-icon">🔐</span> Comptes
        </a>
        <a href="{{ route('admin.structure.filieres') }}" class="nav-link-item {{ request()->routeIs('admin.structure.*') ? 'active' : '' }}">
            <span class="nav-icon">🏫</span> Structure Pédagogique
        </a>

        <div class="nav-section">Logs</div>
        <a href="{{ route('admin.logs.connexion') }}" class="nav-link-item {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">
            <span class="nav-icon">📋</span> Logs Connexion
        </a>
    @elseif(auth()->user()->isEnseignant())
        <a href="{{ route('enseignant.dashboard') }}" class="nav-link-item active">
            <span class="nav-icon">📊</span> Mon espace
        </a>
    @else
        <a href="{{ route('etudiant.dashboard') }}" class="nav-link-item active">
            <span class="nav-icon">📊</span> Mon espace
        </a>
    @endif

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->login, 0, 2)) }}</div>
            <div>
                <div class="user-name">{{ auth()->user()->login }}</div>
                <div class="user-role">{{ auth()->user()->role }}</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST" style="margin-top:10px">
            @csrf
            <button type="submit" style="width:100%;background:rgba(255,255,255,.06);border:none;
                color:rgba(255,255,255,.5);padding:9px;border-radius:9px;font-size:.82rem;cursor:pointer;
                transition:.2s" onmouseover="this.style.background='rgba(229,62,62,.15)';this.style.color='#fc8181'"
                onmouseout="this.style.background='rgba(255,255,255,.06)';this.style.color='rgba(255,255,255,.5)'">
                🚪 Se déconnecter
            </button>
        </form>
    </div>
    @endauth
</div>

<!-- ─── MAIN ─── -->
<div class="main-wrap">
    <div class="topbar">
        <div style="display:flex;align-items:center;gap:12px">
            <button onclick="document.getElementById('sidebar').classList.toggle('show')"
                class="d-md-none btn btn-sm btn-light">☰</button>
            <span class="topbar-title">@yield('title', 'Tableau de bord')</span>
        </div>
        <small style="color:#9aa4b8">{{ now()->format('d/m/Y') }}</small>
    </div>

    <div class="main-content">

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                {!! session('success') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Auto-dismiss alerts
setTimeout(() => document.querySelectorAll('.alert-dismissible').forEach(a => {
    try { bootstrap.Alert.getOrCreateInstance(a).close(); } catch(e) {}
}), 5000);
</script>
@stack('scripts')
</body>
</html>
