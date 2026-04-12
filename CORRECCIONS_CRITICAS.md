# 🔧 GUIA DE CORRECCIONS - PROBLEMES CRÍTICS

## Problemes a Corregir AQUEST MES

---

## 1️⃣ CAMBIAR APP_DEBUG I APP_ENV

### Acció Ràpida:

```bash
# .env (Development)
APP_DEBUG=true
APP_ENV=local

# .env.production (o setup en servidor)
APP_DEBUG=false
APP_ENV=production
```

### Verificació:
```bash
# Teste que APP_DEBUG és false:
php artisan tinker
>>> config('app.debug')
# Hauria de retornar: false
```

---

## 2️⃣ SESSION ENCRYPT

### Acció Ràpida:

```bash
# .env
SESSION_ENCRYPT=true
```

### Verificació:
```bash
# Clear sessions si hay actives
php artisan session:clear

# Test que sessions es xifren
php artisan tinker
>>> config('session.encrypt')
# Hauria de retornar: true
```

---

## 3️⃣ REGENERAR APP_KEY

### Acció Ràpida:

```bash
# Executar
php artisan key:generate

# Verificar
cat .env | grep APP_KEY
# Hauria de mostrar una clau nova
```

### ⚠️ IMPORTANT:
- Tots els sessions del usuari s'invalidaran
- Tots els tokens encrypted amb la vella clau es invaliden
- EN PRODUCCIÓ: Executar during MAINTENANCE WINDOW

---

## 4️⃣ AFEGIR .env A .gitignore

### Acció Ràpida:

```bash
# 1. Agregar .env al .gitignore
echo ".env" >> .gitignore
echo ".env.*.local" >> .gitignore

# 2. Remover del git history (si ja està)
git rm --cached .env
git commit -m "🔐 Remove sensitive .env file from git history"

# 3. Crear .env.example (sense secrets)
cp .env .env.example

# Editar .env.example:
# - Deixar $APP_KEY en blanc
# - Deixar DB_PASSWORD en blanc
# - Deixar MAIL credencials en blanc
```

### .env.example Template:
```bash
APP_NAME="Reciclat DAM"
APP_ENV=local
APP_KEY=
APP_DEBUG=false
APP_URL=http://localhost:8000

BCRYPT_ROUNDS=12

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=reclicat_bbdd
DB_USERNAME=root
DB_PASSWORD=

SESSION_ENCRYPT=true

# Sense ses otros...
```

---

## 5️⃣ VERIFICAR MIDDLEWARE WEB

### Acció Ràpida:

En `bootstrap/app.php`:

```php
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Laravel 12 applica els middleware web per defecte:
        // - EncryptCookies
        // - AddQueuedCookiesToResponse
        // - StartSession
        // - AuthenticateSession
        // - TrustProxies (si needed)
        // - VerifyCsrfToken  ← IMPORTANTE
        // - TrimStrings
        // - ConvertEmptyStringsToNull
        // - SubstituteBindings
        
        // Alias personalitzats:
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        // Afegir security headers:
        $middleware->appendToGroup('web', [
            \App\Http\Middleware\SecurityHeaders::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
```

### Verificació que CSRF funciona:

```bash
# Test sense CSRF token:
curl -X POST http://localhost:8000/login \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "email=test@test.com&password=test"

# Hauria de retornar:
# HTTP 419 (CSRF token mismatch)
```

---

## 6️⃣ CREAR CONFIG CONSTANTS PER ROLS

### Acció Ràpida:

Editar `config/app.php`:

```php
return [
    'name' => env('APP_NAME', 'Laravel'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'locale' => 'ca',
    'fallback_locale' => 'ca',
    'faker_locale' => 'ca_ES',
    
    // Afegir constants de rols:
    'roles' => [
        'admin' => 1,
        'gestor' => 2,
        'usuari' => 3,
    ],
];
```

### Usar en Model User:

```php  
public function isAdmin(): bool
{
    return $this->rol_id === config('app.roles.admin', 1);
}

public function isGestor(): bool
{
    return $this->rol_id === config('app.roles.gestor', 2);
}
```

---

## 🧪 TESTING DE SEGURETAT

### Crear Test Suite:

`tests/Feature/SecurityTest.php`:

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Rol;
use App\Models\Nivell;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    public function test_app_debug_is_false_in_production(): void
    {
        $this->assertFalse(
            config('app.debug'),
            'APP_DEBUG must be false in production'
        );
    }

    public function test_session_encryption_enabled(): void
    {
        $this->assertTrue(
            config('session.encrypt'),
            'SESSION_ENCRYPT must be true'
        );
    }

    public function test_csrf_token_required_on_post(): void
    {
        $response = $this->post('/login', [
            'email' => 'test@test.com',
            'password' => 'password',
        ]);

        $this->assertEquals(419, $response->status(),
            'POST requests without CSRF token must return 419');
    }

    public function test_password_not_in_user_response(): void
    {
        $admin = $this->createAdmin();
        $response = $this->actingAs($admin)->get('/api/users');
        
        $this->assertFalse(
            isset($response->json()[0]['password']),
            'Password field must be hidden in API responses'
        );
    }

    public function test_admin_routes_protected(): void
    {
        $response = $this->get('/admin/dashboard');
        $this->assertEquals(302, $response->status());
    }

    protected function createAdmin(): User
    {
        $rol = Rol::firstOrCreate(['nom' => 'admin']);
        $nivell = Nivell::firstOrCreate(
            ['id' => 1],
            ['nom' => 'Inicial', 'punts_requerits' => 0, 'color' => '#000000']
        );

        return User::factory()->create([
            'rol_id' => $rol->id,
            'nivell_id' => $nivell->id,
        ]);
    }
}
```

### Ejecutar tests:

```bash
php artisan test tests/Feature/SecurityTest.php
```

---

## 📝 CHECKLIST DE CUMPLIMIENTO

### Antes de PRODUCCIÓN:

- [ ] APP_DEBUG=false en .env producció
- [ ] APP_ENV=production en .env producción
- [ ] SESSION_ENCRYPT=true
- [ ] .env NO esté en Git
- [ ] .env.example existe sense secrets
- [ ] APP_KEY regenerada
- [ ] DB_PASSWORD es contrasenya forta
- [ ] HTTPS habilitado + HSTS headers
- [ ] CSRF token funciona (test 419 response)
- [ ] Admin middleware funciona
- [ ] Rate limiting actiu en endpoints crítics
- [ ] Security headers retornados correctament
- [ ] Logs configured correctament
- [ ] Email configuration (MAIL_* variables)
- [ ] Database backups configured

---

## 🔄 CICLO DE DEPLOYEMENT

### Dev → Staging → Production

```bash
# 1. Development (.env local)
APP_DEBUG=true
APP_ENV=local
SESSION_ENCRYPT=false  # Opcional en dev

# 2. Staging (.env.staging)
APP_DEBUG=true  # Puede ser true para debugging
APP_ENV=staging
SESSION_ENCRYPT=true
DB_HOST=staging-db-host
DB_PASSWORD=staging_password

# 3. Production (.env.production)
APP_DEBUG=false        # ← CRÍTICA
APP_ENV=production     # ← CRÍTICA
SESSION_ENCRYPT=true
DB_HOST=prod-db-host
DB_PASSWORD=prod_strong_password_here
```

---

## 📞 SUPPORT

Si tins preguntes sobre aquestes correccions:
1. Revisar `/AUDIT_SEGURETAT.md` per més détalls
2. Revisar Laravel documentation oficial
3. Contactar amb admin del projecte

---

**Última actualització:** 12/04/2026
**Status:** PRONTO PARA APLICAR

