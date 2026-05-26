<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>ENSAH — Connexion</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:'Nunito',sans-serif; }

body {
    min-height: 100vh;
    background: #4a6cf7;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    display: flex;
    width: 100%;
    max-width: 1000px;
    min-height: 560px;
    box-shadow: 0 30px 80px rgba(0,0,0,0.25);
    animation: fadeUp .5s ease both;
}
@keyframes fadeUp {
    from { opacity:0; transform:translateY(24px); }
    to   { opacity:1; transform:none; }
}

/* ── LEFT: image/branding ── */
.card-left {
    flex: 1.1;
    background: linear-gradient(160deg, #3a56d4 0%, #5b8dee 60%, #4a6cf7 100%);
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 400px;
}
.card-left::before {
    content:'';
    position:absolute; inset:0;
    background:
        radial-gradient(ellipse at 30% 60%, rgba(255,255,255,.12) 0%, transparent 60%),
        radial-gradient(ellipse at 80% 20%, rgba(255,255,255,.08) 0%, transparent 50%);
}
/* Decorative circles */
.circle {
    position:absolute; border-radius:50%;
    background: rgba(255,255,255,.07);
}
.c1 { width:320px; height:320px; bottom:-80px; left:-80px; }
.c2 { width:180px; height:180px; top:-40px; right:-40px; }
.c3 { width:100px; height:100px; top:40%; right:15%; }

.brand {
    position: relative; z-index:2;
    text-align: center;
    padding: 40px;
}
.brand-logo {
    width: 120px; height: 120px;
    background: rgba(255,255,255,.18);
    border-radius: 28px;
    display: flex; align-items:center; justify-content:center;
    margin: 0 auto 24px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,.25);
    box-shadow: 0 8px 32px rgba(0,0,0,.15);
}
.brand-logo span { font-size: 54px; line-height:1; }
.brand h1 {
    color: white;
    font-size: 1.6rem;
    font-weight: 800;
    letter-spacing: -.5px;
    margin-bottom: 8px;
}
.brand p {
    color: rgba(255,255,255,.75);
    font-size: .9rem;
    line-height: 1.5;
    max-width: 220px;
    margin: 0 auto;
}
.brand-badge {
    margin-top: 28px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 50px;
    padding: 8px 18px;
    color: white;
    font-size: .8rem;
    font-weight: 700;
    backdrop-filter: blur(8px);
}

/* ── RIGHT: form ── */
.card-right {
    flex: 1;
    padding: 56px 52px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.form-title {
    font-size: 1.55rem;
    font-weight: 800;
    color: #1a2340;
    margin-bottom: 6px;
}
.form-subtitle {
    color: #8a94a6;
    font-size: .875rem;
    margin-bottom: 36px;
}

/* Alert */
.alert-err {
    background: #fff5f5;
    border: 1.5px solid #fed7d7;
    border-radius: 12px;
    padding: 12px 16px;
    color: #c53030;
    font-size: .85rem;
    margin-bottom: 22px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.alert-ok {
    background: #f0fff4;
    border: 1.5px solid #c6f6d5;
    border-radius: 12px;
    padding: 12px 16px;
    color: #276749;
    font-size: .85rem;
    margin-bottom: 22px;
}

/* Inputs */
.field { margin-bottom: 18px; }
.field label {
    display: block;
    font-size: .78rem;
    font-weight: 700;
    color: #4a5568;
    letter-spacing: .4px;
    text-transform: uppercase;
    margin-bottom: 8px;
}
.field input {
    width: 100%;
    padding: 14px 18px;
    background: #f0f4ff;
    border: 1.5px solid transparent;
    border-radius: 50px;
    font-family: 'Nunito', sans-serif;
    font-size: .95rem;
    color: #1a2340;
    outline: none;
    transition: all .25s;
}
.field input:focus {
    border-color: #4a6cf7;
    background: white;
    box-shadow: 0 0 0 4px rgba(74,108,247,.12);
}
.field input::placeholder { color: #a0aec0; }

/* Remember me */
.remember {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 26px;
}
.remember input[type=checkbox] {
    width: 16px; height: 16px;
    accent-color: #4a6cf7;
    cursor: pointer;
}
.remember label {
    font-size: .875rem;
    color: #4a5568;
    cursor: pointer;
    user-select: none;
}

/* Button */
.btn-login {
    width: 100%;
    padding: 15px;
    background: #4a6cf7;
    color: white;
    border: none;
    border-radius: 50px;
    font-family: 'Nunito', sans-serif;
    font-size: 1rem;
    font-weight: 800;
    cursor: pointer;
    transition: all .25s;
    box-shadow: 0 6px 20px rgba(74,108,247,.4);
    letter-spacing: .3px;
}
.btn-login:hover {
    background: #3a56d4;
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(74,108,247,.5);
}
.btn-login:active {
    transform: translateY(0);
    box-shadow: 0 4px 12px rgba(74,108,247,.3);
}
.btn-login:disabled {
    opacity: .7; cursor:not-allowed; transform:none;
}

/* Divider + links */
.divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
    margin: 24px 0;
}
.links {
    text-align: center;
}
.links a {
    color: #4a6cf7;
    font-size: .875rem;
    font-weight: 600;
    text-decoration: none;
    display: block;
    margin-bottom: 6px;
    transition: color .2s;
}
.links a:hover { color: #3a56d4; text-decoration: underline; }

.copyright {
    text-align: center;
    margin-top: 28px;
    color: #a0aec0;
    font-size: .75rem;
}

/* Eye toggle */
.input-wrap { position: relative; }
.eye-btn {
    position: absolute; right: 18px; top: 50%;
    transform: translateY(-50%);
    background: none; border: none;
    color: #a0aec0; cursor: pointer;
    font-size: 16px; padding: 0; line-height:1;
}
.eye-btn:hover { color: #4a6cf7; }

/* Responsive */
@media(max-width: 680px) {
    .card { flex-direction: column; }
    .card-left { min-height: 200px; flex: none; }
    .card-right { padding: 36px 28px; }
}
</style>
</head>
<body>

<div class="card">

    <!-- LEFT -->
    <div class="card-left">
        <div class="circle c1"></div>
        <div class="circle c2"></div>
        <div class="circle c3"></div>
        <div class="brand">
            <div class="brand-logo">
                <span>🎓</span>
            </div>
            <h1>ENSAH</h1>
            <p>École Nationale des Sciences Appliquées d'Al Hoceima</p>
            <div class="brand-badge">
                <span>🏫</span> Plateforme eServices
            </div>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="card-right">
        <div class="form-title">Plateforme eServices</div>
        <div class="form-subtitle">Connectez-vous pour accéder à votre espace</div>

        {{-- Erreurs --}}
        @if($errors->any())
            <div class="alert-err">
                ⚠️ {{ $errors->first() }}
            </div>
        @endif

        {{-- Succès (ex: déconnexion) --}}
        @if(session('success'))
            <div class="alert-ok">✅ {{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" id="loginForm">
            @csrf

            <div class="field">
                <label>Identifiant (Massar / Login)</label>
                <input
                    type="text"
                    name="login"
                    value="{{ old('login') }}"
                    placeholder="ex: K138454336"
                    autocomplete="username"
                    required
                    autofocus
                >
            </div>

            <div class="field">
                <label>Mot de passe</label>
                <div class="input-wrap">
                    <input
                        type="password"
                        name="password"
                        id="passInput"
                        placeholder="••••••••••••••••"
                        autocomplete="current-password"
                        required
                    >
                    <button type="button" class="eye-btn" onclick="togglePass()" title="Afficher/Masquer">
                        👁
                    </button>
                </div>
            </div>

            <div class="remember">
                <input type="checkbox" name="remember" id="remember" value="1">
                <label for="remember">Se rappeler de moi</label>
            </div>

            <button type="submit" class="btn-login" id="submitBtn">
                Se connecter
            </button>
        </form>

        <div class="divider"></div>

        <div class="links">
            <a href="#">Mot de passe oublié ?</a>
            <a href="#">Questions ?</a>
        </div>

        <div class="copyright">
            Copyright &copy; {{ date('Y') }} — Tous droits réservés
        </div>
    </div>

</div>

<script>
function togglePass() {
    const p = document.getElementById('passInput');
    p.type = p.type === 'password' ? 'text' : 'password';
}

// Feedback visuel lors du submit
document.getElementById('loginForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.textContent = 'Connexion en cours...';
    btn.disabled = true;
});
</script>

</body>
</html>
