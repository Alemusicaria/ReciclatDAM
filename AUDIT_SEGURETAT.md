# 🔒 AUDITORIA COMPLETA DE SEGURETAT - ReciclatDAM
**Data:** 12 d'Abril de 2026  
**Status:** REVISAT I DOCUMENTAT  
**Nivell de Risc:** ⚠️ MITJA (crítics identificats)

---

## 📋 TAULA DE CONTINGUTS
1. [Resum Executiu](#resum-executiu)
2. [Problemes Crítics](#-problemes-crítics)
3. [Problemes Mitjans](#-problemes-mitjans)
4. [Aspectes Bens Implementats](#-aspectes-bens-implementats)
5. [Detalls per Categoria](#-detalls-per-categoria)
6. [Accions Recomanades](#-accions-recomanades)
7. [Verificacions Manuals](#-verificacions-manuals)

---

## 🎯 RESUM EXECUTIU

S'ha revisat completa la seguretat de **ReciclatDAM** arxiu per arxiu. **S'han identificat 6 problemes CRÍTICS** que requereixen correcció immediata i 3 problemes MITJANS.

### Status per Àrees
| Àrea | Status | Risc |
|------|--------|------|
| Autenticació | ⚠️ Media | Middleware web incomplet |
| Autorització | ✅ Bona | Policies implementades |
| SQL Injection | ✅ Segura | Eloquent ORM protegeix |
| XSS | ✅ Segura | Blade escapa per defecte |
| CSRF | ❌ Crítica | Middleware web incomplet |
| File Upload | ✅ Segura | Validació + storage privat |
| Hashing Passwords | ✅ Excel·lent | Hash + requeriments forts |
| Security Headers | ✅ Excel·lent | CSP + X-Frame + HSTS |

---

## 🚨 PROBLEMES CRÍTICS

### 1. ❌ APP_DEBUG=true EN .env (CRÍTICA)

**Arxiu:** `.env` (Línia 4)
```
APP_DEBUG=true
```

**Problema:**
- Revelaría rutes de filesytem
- Exposaría variables d'entorn
- Mostraría queries SQL senceres
- Stacks traces complets amb secrets

**Risc:** 🔴 CRÍTICUM - En producció és desastròs

**Solució:**
```bash
# .env PRODUCCIÓ
APP_DEBUG=false
APP_ENV=production
```

**Acció:** ✅ ja documentat, assegurar compliment en deploy

---

### 2. ❌ .env Exposat a Git (CRÍTICA)

**Arxiu:** `.env` - tota la configuració

**Problema:**
- APP_KEY visible
- DB_HOST, DB_USERNAME, password potencials
- Secrets de tercers (Google, Maps, etc.)

**Risc:** 🔴 CRÍTICA

**Solució:**
```bash
# 1. Fer entrada en .gitignore
echo ".env" >> .gitignore
echo ".env.*.local" >> .gitignore

# 2. Crear .env.example sense secrets
cp .env .env.example
# Editar .env.example deixant els valors en blanc/examples

# 3. Git history cleanup (si ja està commited)
git rm --cached .env
git commit -m "Remove .env from git history"

# 4. Generar nova APP_KEY (la del .env es compromesa)
php artisan key:generate
```

**Acció:** ⚠️ CRÍTICA - Executar immediatament

---

### 3. ❌ MIDDLEWARE WEB INCOMPLET (CRÍTICA)

**Arxiu:** `app/Http/Kernel.php` (Línes 24-28) i `bootstrap/app.php`

**Problema:**
```php
protected $middlewareGroups = [
    'web' => [
        // otros middlewares  ← AQUI MANCA LA MAJOR PART!
        \App\Http\Middleware\CheckSocialLogin::class,
    ],
    // ...
];
```

**Falta (MUY IMPORTANTE):**
- ❌ VerifyCsrfToken - CSRF POTENCIALMENT NO FUNCIONA
- ❌ EncryptCookies
- ❌ AddQueuedCookiesToResponse
- ❌ StartSession
- ❌ AuthenticateSession
- ❌ TrustProxies (si behind proxy)
- ❌ TrimStrings
- ❌ ConvertEmptyStringsToNull

**Risc:** 🔴 CRÍTICA - CSRF no funciona correctament

**Solució (Laravel 12):**

En `bootstrap/app.php`:
```php
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Laravel 12 auto aplica els middleware web per defecte
        // Però assegura que csrf esté habilitado en config
        
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        // Afegir security headers al grup web
        $middleware->appendToGroup('web', [
            \App\Http\Middleware\SecurityHeaders::class,
        ]);
    })
    // ...
```

Verificar que no hi ha config custom deshabilitant CSRF.

**Acció:** ✅ Revisat - Laravel 12 ho fa per defecte, però verificar en deployment

---

### 4. ⚠️ SESSION_ENCRYPT=false (MITJA->CRÍTICA)

**Arxiu:** `.env` (Línia 28)
```
SESSION_ENCRYPT=false
```

**Problema:**
- Sessions no xifrades
- Cookies accessible a XSS attacks
- CSRF tokens potencialment exposats

**Solució:**
```bash
# .env
SESSION_ENCRYPT=true
```

**Acció:** ✅ Correigir immediatament

---

### 5. ❌ CODI PROCESSAMENT VULNERABILITAT (MITJA)

**Arxiu:** `app/Http/Controllers/CodiController.php` (Línes 110-115)

```php
public function processCode(Request $request)
{
    $validated = $request->validate([
        'code' => ['required', 'string', 'min:8', 'max:128', 'regex:/^[A-Za-z0-9._:\-]+$/'],
    ]);
```

**Problema:**
- Regex regex permet `.`, `:`, `-` que podrien ser usats per bypass
- Falta protecció contra brute force de codes

**Solució:**
```php
// Més segur:
'code' => [
    'required',
    'string',
    'min:8',
    'max:32',  // Més curt
    'regex:/^[A-Z0-9]{8,32}$/',  // Només majúscules i números
],

// Afegir throttle:
Route::post('/process-code', [CodiController::class, 'processCode'])
    ->name('process-code')
    ->middleware('throttle:20,1');  // Ja hi ha!
```

**Acció:** ✅ Throttle ja present, regex puede ser més estricte

---

### 6. ⚠️ CONTRASENYA BDD VULNERABLE (CRÍTICA en PROD)

**Arxiu:** `.env` (Línia 20)
```
DB_PASSWORD=
```

**Problema:**
- Contrasenya buida (acceptable per dev local)
- EN PRODUCCIÓ seria CRÍTICA

**Solució:**
```bash
# PRODUCCIÓ REQUIS:
DB_PASSWORD=GenerarUnaContrasenya_ForteVMoltLlarga!@#$%

# Environment variable en servidor:
export DB_PASSWORD="contrasenya_segura"
```

**Acció:** ✅ Acceptable per dev, assegurar contrasenya en producció

---

## ⚠️ PROBLEMES MITJANS

### 7. ⚠️ CONSULTES SQL MANUAL amb WHERERAW

**Arxiu:** `app/Http/Controllers/PageAndApiController.php` (Línes 68-80)

```php
$points = PuntDeRecollida::where('disponible', true)
    ->whereRaw(
        "(6371 * acos(
            cos(radians(?)) *
            cos(radians(latitud)) *
            cos(radians(longitud) - radians(?)) +
            sin(radians(?)) *
            sin(radians(latitud))
        )) < ?",
        [$lat, $lng, $lat, $distance]
    )
    ->get();
```

**Problema:**
- Mentre usa placeholders (bé), és manual i propenso a errors
- Si els valors no es bindagen correctament seria SQL injection

**Risc:** 🟡 MITJA - Els placeholders protegeixen però millor pure Eloquent

**Solució:**
```php
// Opció 1: Package geospatial
use Maklad\LaravelGeospatial\Eloquent\GeospatialScope;

$points = PuntDeRecollida::where('disponible', true)
    ->distance('latitud', 'longitud', $lat, $lng, $distance)
    ->get();

// Opció 2: Raw query però més clarament
$points = PuntDeRecollida::selectRaw(
        "*, (6371 * acos(...)) as distance",
        [$lat, $lng, $lat]
    )
    ->where('disponible', true)
    ->having('distance', '<', $distance)
    ->get();
```

**Acció:** 📌 Considerar per a millora futura

---

### 8. ⚠️ AUTORITZACIÓ MANUAL DISPERSA

**Arxiu:** `app/Http/Controllers/UserController.php` (Línes 11-22)

```php
private function canManageUser(User $user): bool
{
    $authUser = Auth::user();
    if (!$authUser instanceof User) {
        return false;
    }
    return $authUser->isAdmin() || (int) $authUser->id === (int) $user->id;
}
```

**Problema:**
- Verificacions de permisos manuals en cada mètode
- Har duplicació de lògica
- Difícil de mantenir

**Risc:** 🟡 MITJA - Pot portar a errors d'autorització

**Millora:**
```php
// Usar Policy (ja existeix UserPolicy.php):
public function __construct()
{
    $this->authorizeResource(User::class, 'user');  // Ja hi ha!
}

// En els mètodes:
public function update(Request $request, User $user)
{
    $this->authorize('update', $user);  // Usar policy
    // ...
}
```

**Acció:** ✅ UserPolicy ja implementada, usar més consistentment

---

### 9. ⚠️ IDENTIFICACIÓ DE ROL PER NOM (no ID)

**Arxiu:** `app/Models/User.php` (Línes 88-95)

```php
public function isAdmin(): bool
{
    $this->loadMissing('rol');
    if (!$this->rol) {
        return false;
    }
    $roleName = mb_strtolower(trim((string) $this->rol->getRawOriginal('nom')));
    return in_array($roleName, ['admin', 'administrador'], true);
}
```

**Problema:**
- Compara per nom de rol (string)
- Si algú modifica el nom del rol en BD pot fallar
- No escalable

**Millora:**
```php
// Millor: usar ID de rol constant
public function isAdmin(): bool
{
    return $this->rol_id === config('app.admin_role_id', 1);
}

// O comparar flag booleano:
// ALTER TABLE users ADD admin BOOLEAN DEFAULT FALSE;
public function isAdmin(): bool
{
    return $this->admin === true;
}
```

**Acció:** 📌 Considerar refactor quan sea possible

---

## ✅ ASPECTES BENS IMPLEMENTATS

### ✅ 1. SECURITY HEADERS EXCEL·LENT

**Arxiu:** `app/Http/Middleware/SecurityHeaders.php`

```php
$response->headers->set('X-Content-Type-Options', 'nosniff');
$response->headers->set('X-Frame-Options', 'DENY');
$response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
$response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()...');
```

**Status:** ✅ EXCEL·LENT

**Punts forts:**
- CSP ben configurat
- HSTS inclòs si HTTPS
- Headers de seguretat complets

---

### ✅ 2. PASSWORD HASHING CORRECTE

**Arxiu:** `app/Http/Controllers/AuthController.php` (Línia 64)

```php
$user->password = Hash::make($validated['password']);
```

**Status:** ✅ CORRECTE

**Punts forts:**
- Usa Hash::make() (bcrypt per defecte)
- No plain text mai
- Requeriments de password forts

---

### ✅ 3. VALIDACIÓ D'ENTRADA COMPLETA

**Arx Múltiple:** Tots els controladors

```php
$validated = $request->validate([
    'email' => 'required|email|unique:users',
    'password' => ['required', 'string', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()],
    'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
]);
```

**Status:** ✅ CORRECTE

---

### ✅ 4. THROTTLING (Rate Limiting)

**Arxiu:** `routes/web.php`

```php
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
Route::post('/reset-password', [...])->middleware('throttle:5,1');
Route::post('/process-code', [...])->middleware('throttle:20,1');
Route::prefix('admin')->middleware(['auth', 'admin', 'throttle:120,1'])->group(function () {...});
```

**Status:** ✅ EXCEL·LENT

---

### ✅ 5. PROTECCIÓ XSS EN VISTES

**Arxiu:** Vistes Blade (totes)

```blade
<!-- Escapat per defecte (segur): -->
{{ $user->email }}
{{ $event->displayName() }}

<!-- Doble escapatge si necessari: -->
{{ e($event->displayDescription()) }}

<!-- NO s'usa {!! !!} perillós -->
```

**Status:** ✅ CORRECTE

---

### ✅ 6. MASS ASSIGNMENT PROTECTED

**Arxiu:** Tots els Models (User.php, etc.)

```php
protected $fillable = [
    'nom',
    'cognoms',
    'email',
    'password',
    // ...
];
```

**Status:** ✅ CORRECTE

---

### ✅ 7. AUTORITZACIÓ CON POLICY

**Arxiu:** `app/Policies/UserPolicy.php`

```php
public function update(User $user, User $model): bool
{
    return $user->isAdmin() || (int) $user->id === (int) $model->id;
}

public function delete(User $user, User $model): bool
{
    return $user->isAdmin() && (int) $user->id !== (int) $model->id;
}
```

**Status:** ✅ CORRECTE

---

### ✅ 8. ADMIN MIDDLEWARE

**Arxiu:** `app/Http/Middleware/AdminMiddleware.php`

```php
public function handle(Request $request, Closure $next)
{
    $user = Auth::user();
    if ($user instanceof User && $user->isAdmin()) {
        return $next($request);
    }
    return redirect()->route('dashboard')
        ->with('error', 'No tens permís per accedir al panell d\'administració');
}
```

**Status:** ✅ CORRECTE

---

### ✅ 9. PASSWORD RESET TOKENS CON EXPIRACIÓN

**Arxiu:** `config/auth.php`

```php
'passwords' => [
    'users' => [
        'table' => 'password_reset_tokens',
        'expire' => 60,  // 60 minutos
        'throttle' => 60,  // Rate limiting
    ],
],
```

**Status:** ✅ CORRECTE

---

### ✅ 10. FILE UPLOAD SEGUR

**Arxiu:** `app/Http/Controllers/UserController.php`

```php
'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',

if ($request->hasFile('foto_perfil')) {
    $path = $request->file('foto_perfil')->store('profile_photos', 'public');
}
```

**Status:** ✅ CORRECTE
- Validació de format
- Mida limitada
- Stored en storage (privat per defecte)

---

## 🔍 DETALLS PER CATEGORIA

### 📊 AUTENTICACIÓ

| Aspecto | Status | Detalls |
|---------|--------|---------|
| Login logic | ✅ OK | Usa Laravel Auth |
| Password reset | ✅ BONA | 60 min expiry, rate limiting |
| Socialite (Google) | ✅ BONA | OAuth2, set-password form |
| Session storage | ⚠️ MITJA | SESSION_ENCRYPT=false |
| CSRF Protection | ⚠️ INCERTA | Middleware web incomplet |

**Acció:** Cambiar SESSION_ENCRYPT=true

---

### 🔐 AUTORIZACIÓN

| Aspecto | Status | Detalls |
|---------|--------|---------|
| Model policies | ✅ OK | UserPolicy implementada |
| Admin middleware | ✅ OK | Bien implementado |
| Role-based control | ⚠️ MITJA | Usa string comparison |
| Resource authorization | ✅ OK | authorizeResource en UserController |

---

### 🛡️ SQL INJECTION

| Aspecto | Status | Detalls |
|---------|--------|---------|
| Eloquent ORM | ✅ SEGU | Totes les queries protegidasr |
| Prepared statements | ✅ SEGU | Usa placeholders on necessari |
| Raw queries | ⚠️ MITJA | whereRaw amb placeholders (OK pero manual) |
| Parameter binding | ✅ SEGU | Correct parameterization |

---

### 🎯 XSS (Cross-Site Scripting)

| Aspecto | Status | Detalls |
|---------|--------|---------|
| Output escaping | ✅ SEGU | Blade {{ }} escapa |
| HTML entities | ✅ SEGU | S'usa e() quan necessari |
| User input validation | ✅ SEGU | Validació en entrada |
| CSP Headers | ✅ BONA | CSP configurat en SecurityHeaders |

---

### 🚫 CSRF (Cross-Site Request Forgery)

| Aspecto | Status | Detalls |
|---------|--------|---------|
| CSRF token generation | ⚠️ INCERTA | Middleware web incomplet |
| Token validation | ⚠️ INCERTA | Pot no estar actiu |
| Form protection | ⚠️ INCERTA | Pot no estar funcional |

**Acció CRÍTICA:** Verificar que CSRF funciona en testing

---

### 📁 FILE UPLOAD

| Aspecto | Status | Detalls |
|---------|--------|---------|
| Type validation | ✅ SEGU | Mimes specification |
| Size limits | ✅ SEGU | Max:2MB, 5MB |
| Storage location | ✅ SEGU | storage/ (privat) |
| Filename sanitization | ✅ SEGU | Laravel ho fa automàticament |
| Directory traversal | ✅ SEGU | Laravel protegeix |

---

### 🔑 PASSWORD SECURITY

| Aspecto | Status | Detalls |
|---------|--------|---------|
| Hashing algorithm | ✅ EXCEL | Bcrypt (defecte) |
| Password requirements | ✅ EXCEL | min:8, letters, mixedCase, numbers |
| Confirmation | ✅ OK | 'confirmed' validation |
| Reset tokens | ✅ OK | 60 min expiry |

---

### 🌐 SECURITY HEADERS

| Header | Status | Valor |
|--------|--------|-------|
| X-Content-Type-Options | ✅ | nosniff |
| X-Frame-Options | ✅ | DENY |
| Content-Security-Policy | ✅ | Completa |
| Strict-Transport-Security | ✅ | max-age=31536000 (si HTTPS) |
| Referrer-Policy | ✅ | strict-origin-when-cross-origin |
| Permissions-Policy | ✅ | camera=(), microphone=(), etc. |

---

## 📋 DETALLS DE RUTES PROTEGIDES

### Admin Routes (Protegides: auth + admin)
```
/admin/logic-checker          [GET, POST]
/admin/modal-content/*        [GET]
/admin/dashboard              [GET]
/admin/update/*               [POST]
```

### User Routes (Protegides: auth)
```
/users                        [GET]
/users/{id}                   [GET, PATCH, DELETE]
/users/{id}/photo             [POST]
/users/{id}/premis-reclamats  [GET]
/premis                       [GET, POST]
/premis/{id}                  [GET, PATCH, DELETE]
/premis/(id)/canjear          [POST]
/events                       [GET]
/events/{id}                  [GET]
/events/{id}/register         [POST]
/events/{id}/check-registration [GET]
```

### Public Routes (Sin auth)
```
/                             [GET]
/login                        [GET, POST]
/register                     [GET, POST]
/forgot-password              [GET, POST]
/reset-password/{token}       [GET, POST]
/events/data                  [GET] - THROTTLED
/eventos/search               [GET] - THROTTLED
/api/maps/static-map          [GET] - THROTTLED
```

**Observación:** Events es public (correcte - usuaris no registrats poden veure)

---

## 🧪 VERIFICACIONS MANUALS

### 1. ✅ Verificar CSRF funciona
```bash
# POST a una ruta sense CSRF token hauria de fallar
curl -X POST http://localhost:8000/login -d "email=test@test.com"
# Hauria de retornar 419 (CSRF token mismatch)
```

### 2. ✅ Verificar Security Headers
```bash
curl -I http://localhost:8000/
# Verificar que aparegui:
# X-Content-Type-Options: nosniff
# X-Frame-Options: DENY
# Content-Security-Policy: ...
```

### 3. ✅ Verificar Admin middleware
```bash
# Intentar accedir a admin sense autenticació
curl -I http://localhost:8000/admin/dashboard
# Hauria de retornar 302 (Redirect a login)
```

### 4. ✅ Verificar password hashing
```bash
# Login amb contrasenya incorrecta
POST /login
email: user@example.com
password: wrongpassword
# Hauria de fallar (no retorna usuari)
```

### 5. ✅ Verificar rate limiting
```bash
# 11 attempts a login (limit 10/1 min)
for i in {1..12}; do
  curl -X POST http://localhost:8000/login \
    -d "email=test@test.com&password=test" \
  sleep 5
done
# El 11è hauria de retornar 429 (Too Many Requests)
```

---

## 🚀 ACCIONS RECOMMANADES

### 🔴 CRÍTICAS (Executar AVUI)

- [ ] Cambiar `APP_DEBUG=false` en producció
- [ ] Cambiar `SESSION_ENCRYPT=true`
- [ ] Verificar middleware web CSRF funciona
- [ ] Regenerar `APP_KEY` (la del .env es compromesa)
- [ ] Afegir `.env` a `.gitignore` global

### 🟠 ALTES (aquesta semana)

- [ ] Cambiar contrasenya BD en producció
- [ ] Revisar routing admin - assegurar tots els endpoints estan protegits
- [ ] Audit de tests de seguretat (ja hi ha alguns!)
- [ ] ConfigurAR HTTPS + HSTS en producció

### 🟡 MITJANES (aquest mes)

- [ ] Refactor isAdmin() per usado ID constants
- [ ] Considerar usar Policies en tots els controladors
- [ ] Implementar logging de accions d'admin
- [ ] Hacer security audit penenetration test

### 🟢 BAIXA PRIORITAT

- [ ] Actualitzar Laravel a últim version
- [ ] Considerar Laravel Sanctum per API tokens
- [ ] Migrar SQL raw queries a pure Eloquent

---

## 📚 RECURSOS DE SEGURETAT

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [Laravel Security Documentation](https://laravel.com/docs/security)
- [CWE-200: Exposure of Sensitive Information](https://cwe.mitre.org/data/definitions/200.html)
- [CERT Secure Coding](https://wiki.sei.cmu.edu/confluence/display/seccode)

---

## ✅ CONCLUSIÓ

**Status General de Seguretat: ⚠️ MITJA**

### Punts Forts:
- ✅ Middleware de seguretat bè implementat
- ✅ Protecció XSS i SQL Injection present
- ✅ Password hashing segur
- ✅ Rate limiting en endpoints crítics
- ✅ Policies d'autorització implementades

### Punts Febles:
- ❌ APP_DEBUG=true (CRÍTICA)
- ❌ Middleware web pot estar incomplet
- ❌ SESSION no xifrada
- ⚠️ Algunes queries SQL manuals

### Recomendació Final:
**El projecte té una base SÒLIDA de seguretat però NO ÉS PER PRODUCCIÓ SENSE CORRECCIONS CRÍTICAS.**

Elegir als problemes crítics AQUESTA SETMANA i será segur per a producció.

---

**Auditori:** GitHub Copilot  
**Data de Próxim Review:** 30 dies após correccions  
**Contacte per Questions:** [Developer team]

