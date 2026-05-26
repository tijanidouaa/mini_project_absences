<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
&&&&&&&&&&&&&&&&&&&&&















# 🎓 ENSAH — Application de Gestion des Absences (Laravel)
## Partie 1 : Modules 1, 2, 3, 4

---

## 📁 Structure des fichiers générés

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php         ← Module 2 : Authentification
│   │   ├── EtudiantController.php     ← Module 1 : Gestion étudiants
│   │   ├── CompteController.php       ← Module 4 : Gestion comptes
│   │   ├── StructureController.php    ← Module 3 : Structure pédagogique
│   │   └── AdminController.php        ← Dashboard admin
│   └── Middleware/
│       ├── CheckRole.php              ← Vérification des rôles
│       └── LogUserAction.php          ← Log des pages visitées
├── Models/
│   ├── Utilisateur.php
│   ├── Etudiant.php
│   ├── Enseignant.php
│   ├── Filiere.php
│   ├── Niveau.php
│   ├── ModulePeda.php
│   ├── Element.php
│   ├── HistoriqueModification.php
│   ├── LogConnexion.php
│   └── LogAction.php
database/
├── migrations/                        ← Toutes les tables
└── seeders/DatabaseSeeder.php         ← Données de départ
resources/views/
├── layouts/app.blade.php              ← Layout principal
├── auth/login.blade.php
├── admin/dashboard.blade.php
├── etudiants/{index, create, edit, trashed, historique, _form}.blade.php
├── comptes/index.blade.php
└── structure/filieres.blade.php
routes/web.php                         ← Toutes les routes
```

---

## 🚀 Installation — Étape par étape

### 1. Créer le projet Laravel

```bash
composer create-project laravel/laravel gestion-absences
cd gestion-absences
```

### 2. Copier les fichiers

Copie chaque fichier dans son dossier correspondant :

| Fichier généré | Destination dans le projet |
|---|---|
| `models/Utilisateur.php` | `app/Models/Utilisateur.php` |
| `models/Etudiant.php` | `app/Models/Etudiant.php` |
| `models/Enseignant.php` | `app/Models/Enseignant.php` |
| `models/Filiere.php` | `app/Models/Filiere.php` |
| `models/Niveau.php` | `app/Models/Niveau.php` |
| `models/ModulePeda.php` | `app/Models/ModulePeda.php` |
| `models/Element.php` | `app/Models/Element.php` |
| `models/HistoriqueModification.php` | `app/Models/HistoriqueModification.php` |
| `models/LogConnexion.php` | `app/Models/LogConnexion.php` |
| `models/LogAction.php` | `app/Models/LogAction.php` |
| `controllers/AuthController.php` | `app/Http/Controllers/AuthController.php` |
| `controllers/EtudiantController.php` | `app/Http/Controllers/EtudiantController.php` |
| `controllers/CompteController.php` | `app/Http/Controllers/CompteController.php` |
| `controllers/StructureController.php` | `app/Http/Controllers/StructureController.php` |
| `controllers/AdminController.php` | `app/Http/Controllers/AdminController.php` |
| `middleware/CheckRole.php` | `app/Http/Middleware/CheckRole.php` |
| `middleware/LogUserAction.php` | `app/Http/Middleware/LogUserAction.php` |
| `migrations/*.php` | `database/migrations/` |
| `seeders/DatabaseSeeder.php` | `database/seeders/DatabaseSeeder.php` |
| `routes/web.php` | `routes/web.php` |
| `views/layouts/app.blade.php` | `resources/views/layouts/app.blade.php` |
| `views/auth/login.blade.php` | `resources/views/auth/login.blade.php` |
| `views/admin/dashboard.blade.php` | `resources/views/admin/dashboard.blade.php` |
| `views/etudiants/*.blade.php` | `resources/views/etudiants/` |
| `views/comptes/*.blade.php` | `resources/views/comptes/` |
| `views/structure/*.blade.php` | `resources/views/structure/` |

### 3. Configurer .env

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_absences
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Enregistrer le modèle Utilisateur comme Auth User

Dans `config/auth.php` :

```php
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model'  => App\Models\Utilisateur::class,  // ← Changer ici
    ],
],
```

### 5. Enregistrer les middlewares

Dans `bootstrap/app.php` (Laravel 11) :

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role'       => \App\Http\Middleware\CheckRole::class,
        'log.action' => \App\Http\Middleware\LogUserAction::class,
    ]);
})
```

### 6. Lancer les migrations + seeder

```bash
php artisan migrate
php artisan db:seed
```

### 7. Démarrer le serveur

```bash
php artisan serve
```

Ouvre : **http://localhost:8000**

---

## 🔑 Comptes de test

| Rôle | Login | Mot de passe |
|---|---|---|
| Administrateur | `admin` | `Admin@1234` |
| Enseignant | `ahmedbenali` | `enseignant123` |
| Étudiant | `nadirmohamedanouar` | `etudiant123` |

---

## ✅ Fonctionnalités couvertes (Partie 1)

### Module 1 — Étudiants
- [x] Liste avec pagination et recherche (nom, massar, CIN)
- [x] Filtre par niveau
- [x] Ajouter / Modifier / Supprimer
- [x] Suppression douce (soft delete) — récupérable
- [x] Corbeille avec restauration
- [x] Traçabilité : historique "qui a modifié quoi"
- [x] Export CSV (avec BOM UTF-8 pour Excel)
- [x] Impression

### Module 2 — Authentification
- [x] Login/Logout avec sessions Laravel
- [x] Blocage après 5 tentatives (compte verrouillé)
- [x] Gestion des rôles (admin / enseignant / étudiant)
- [x] Compte désactivé / verrouillé
- [x] Log des connexions (IP + date)
- [x] Redirection automatique selon le rôle

### Module 3 — Structure Pédagogique
- [x] CRUD Filières (avec coordonnateur)
- [x] CRUD Niveaux
- [x] CRUD Modules pédagogiques
- [x] CRUD Éléments (matières)
- [x] Import CSV

### Module 4 — Comptes
- [x] Créer un compte (recherche par Massar/CIN)
- [x] Login auto-généré (prénom+nom, avec déduplication)
- [x] Mot de passe aléatoire affiché puis haché
- [x] Activer / Désactiver un compte
- [x] Verrouiller / Déverrouiller
- [x] Réinitialiser le mot de passe
- [x] Changer le rôle
- [x] Voir les logs (connexions + pages visitées)
