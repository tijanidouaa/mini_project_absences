<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — ENSAH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            min-height: 100vh;
            display: flex;
            font-family: 'Segoe UI', sans-serif;
            background: #f0f4ff;
        }

        /* ===== PANNEAU GAUCHE ===== */
        .left-panel {
            width: 45%;
            background: linear-gradient(135deg, #4f6ef7 0%, #3b5bdb 40%, #2f4ac7 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 50px 40px;
            position: relative;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            width: 350px; height: 350px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
            top: -80px; left: -80px;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            width: 250px; height: 250px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
            bottom: -60px; right: -60px;
        }
        .left-panel .circle-deco {
            position: absolute;
            width: 180px; height: 180px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            top: 50%; left: 60%;
            transform: translate(-50%, -50%);
        }
        .logo-box {
            width: 110px; height: 110px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 28px;
            border: 1px solid rgba(255,255,255,0.2);
            position: relative;
            z-index: 1;
        }
        .logo-box img {
            width: 65px;
            height: 65px;
            object-fit: contain;
        }
        .logo-box i {
            font-size: 3rem;
            color: white;
        }
        .left-panel h1 {
            color: white;
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }
        .left-panel p {
            color: rgba(255,255,255,0.8);
            font-size: 0.95rem;
            text-align: center;
            max-width: 280px;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }
        .platform-badge {
            margin-top: 35px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 30px;
            padding: 10px 22px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: white;
            font-size: 0.875rem;
            font-weight: 500;
            position: relative;
            z-index: 1;
        }
        .platform-badge i { font-size: 1rem; }

        /* ===== PANNEAU DROIT ===== */
        .right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 60px;
            background: white;
        }
        .login-box {
            width: 100%;
            max-width: 420px;
        }
        .login-box h2 {
            font-size: 1.8rem;
            font-weight: 800;
            color: #1a1a2e;
            margin-bottom: 6px;
        }
        .login-box .subtitle {
            color: #94a3b8;
            font-size: 0.9rem;
            margin-bottom: 35px;
        }

        /* Error box */
        .error-box {
            background: #fff0f0;
            border: 1px solid #fecaca;
            border-radius: 12px;
            padding: 13px 16px;
            color: #991b1b;
            font-size: 0.85rem;
            margin-bottom: 22px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        /* Form fields */
        .field-group { margin-bottom: 20px; }
        .field-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
            display: block;
        }
        .field-input-wrap { position: relative; }
        .field-input-wrap i.left-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
        }
        .field-input-wrap input {
            width: 100%;
            padding: 14px 16px 14px 44px;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            font-size: 0.95rem;
            color: #1a1a2e;
            outline: none;
            transition: all 0.2s;
        }
        .field-input-wrap input::placeholder { color: #b0bec5; }
        .field-input-wrap input:focus {
            border-color: #4f6ef7;
            background: white;
            box-shadow: 0 0 0 4px rgba(79,110,247,0.08);
        }
        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            font-size: 1rem;
            background: none;
            border: none;
            padding: 0;
        }
        .toggle-password:hover { color: #4f6ef7; }

        /* Remember me */
        .remember-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
        }
        .remember-row input[type=checkbox] {
            width: 18px; height: 18px;
            border-radius: 5px;
            accent-color: #4f6ef7;
            cursor: pointer;
        }
        .remember-row label {
            font-size: 0.875rem;
            color: #64748b;
            cursor: pointer;
        }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #4f6ef7, #3b5bdb);
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            letter-spacing: 0.3px;
        }
        .btn-submit:hover {
            background: linear-gradient(135deg, #3b5bdb, #2f4ac7);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79,110,247,0.35);
        }
        .btn-submit:active { transform: translateY(0); }

        /* Footer links */
        .footer-links {
            margin-top: 25px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }
        .footer-links a {
            color: #4f6ef7;
            font-size: 0.875rem;
            text-decoration: none;
            font-weight: 500;
        }
        .footer-links a:hover { text-decoration: underline; }

        /* Responsive */
        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { padding: 30px 25px; }
        }
    </style>
</head>
<body>

<!-- PANNEAU GAUCHE -->
<div class="left-panel">
    <div class="circle-deco"></div>

    <div class="logo-box">
        <i class="bi bi-mortarboard-fill"></i>
    </div>

    <h1>ENSAH</h1>
    <p>École Nationale des Sciences Appliquées d'Al Hoceima</p>

    <div class="platform-badge">
        <i class="bi bi-grid-3x3-gap-fill"></i>
        Plateforme eServices
    </div>
</div>

<!-- PANNEAU DROIT -->
<div class="right-panel">
    <div class="login-box">

        <h2>Plateforme eServices</h2>
        <p class="subtitle">Connectez-vous pour accéder à votre espace</p>

        @if($errors->any())
        <div class="error-box">
            <i class="bi bi-exclamation-triangle-fill" style="margin-top:2px; flex-shrink:0"></i>
            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <!-- Identifiant -->
            <div class="field-group">
                <label class="field-label">Identifiant (Massar / Login)</label>
                <div class="field-input-wrap">
                    <i class="bi bi-person left-icon"></i>
                    <input type="text"
                           name="login"
                           value="{{ old('login') }}"
                           placeholder="ex: K138454336"
                           required>
                </div>
            </div>

            <!-- Mot de passe -->
            <div class="field-group">
                <label class="field-label">Mot de passe</label>
                <div class="field-input-wrap">
                    <i class="bi bi-lock left-icon"></i>
                    <input type="password"
                           name="password"
                           id="passwordInput"
                           placeholder="••••••••••••••••"
                           required>
                    <button type="button" class="toggle-password" onclick="togglePassword()">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Se rappeler -->
            <div class="remember-row">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Se rappeler de moi</label>
            </div>

            <!-- Bouton -->
            <button type="submit" class="btn-submit">
                Se connecter
            </button>

        </form>

        <div class="footer-links">
            <a href="#">Mot de passe oublié ?</a>
            <a href="#">Questions ?</a>
        </div>

    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
</script>

</body>
</html>