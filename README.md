# ReciclatDAM

Aplicacio web de reciclatge gamificat feta amb Laravel.

Inclou:

- Registre/login tradicional i login amb Google
- Escaneig de codis
- Sistema de punts i premis
- Mapa de punts de recollida i alertes
- Esdeveniments
- Panell d'administracio
- Multiidioma (`ca`, `es`, `en`)

## 1) Estat actual (funcionalitat i accessibilitat)

Revisio tecnica feta:

- Rutes netejades i unificades
- Fixes aplicats a JS admin per evitar URLs trencades en edicio i eliminacio
- Millora de seguretat en links externs (`rel="noopener noreferrer"`)
- Carga correcta de `admin.js` tambe en rutes localitzades (`/ca/admin`, `/es/admin`, ...)
- Tests existents en verd (`2/2`)

Notes importants:

- El projecte te base responsive (viewport + media queries + Bootstrap).
- La validacio 100% visual en tots els dispositius requereix prova manual al navegador (veure seccio 7).

## 2) Requisits

- PHP 8.2+
- Composer
- Node.js 18+ i npm
- MySQL o MariaDB
- Extensio PHP `pdo_mysql` activa

## 3) Instal.lacio pas a pas (clonant des de GitHub)

### 3.1 Clonar i preparar projecte

```bash
git clone <URL_DEL_REPO>
cd ReciclatDAM
composer install
npm install
```

### 3.2 Configurar entorn

```bash
cp .env.example .env
php artisan key:generate
```

Edita `.env` i posa les teves dades de BD:

```env
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=reciclat_bbdd
DB_USERNAME=root
DB_PASSWORD=
```

## 4) Base de dades completa (totes les taules + dades default)

Ara el projecte es pot inicialitzar de dues maneres:

### Opcio recomanada: migracions + seeders

El repo inclou una migracio que recrea l'esquema de la base de dades i un seeder que carrega dades ficticies i coherents per defecte.

Executa:

```bash
php artisan migrate --seed
```

Per defecte, aquest flux carrega el mode `snapshot`.

Si vols un mode `demo` amb factories i mes varietat de dades, executa per exemple a PowerShell:

```powershell
$env:SEED_MODE='demo'; php artisan migrate --seed
```

Aquesta opcio:

- Crea totes les taules
- Crea les relacions i claus foranes
- Introdueix dades d'exemple netes i sense correus reals

### Opcio alternativa: importar el dump complet

El repo tambe inclou el dump complet:

- `database-reciclatdam.sql`

I un importador automatic:

- `tools/import_sql_dump.php`
- script Composer: `db:import`

Executa:

```bash
composer run-script db:import
```

Que fa:

- Llegeix `.env`
- Connecta a MySQL
- Importa `database-reciclatdam.sql` (estructura + dades originals del dump)

Si falla la connexio:

- Revisa `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- Assegura que la BD existeix

## 5) Arrencar l'aplicacio

Terminal 1:

```bash
npm run dev
```

Terminal 2:

```bash
php artisan serve
```

URL local:

- `http://localhost:8000`

## 6) Com funciona (manual funcional)

### 6.1 Usuari final

1. Registrar-se o iniciar sessio (`/register`, `/login`)
2. Accedir al dashboard principal
3. Escanejar codis (`/scanner`) i acumular punts
4. Consultar punts i perfil
5. Participar en events i consultar premis
6. Reportar alertes de punts de recollida

### 6.2 Administracio

1. Entrar a `/admin` (o `/{locale}/admin`)
2. Gestionar contingut des de modals i detall:
- usuaris
- productes
- codis
- punts de recollida
- tipus d'alerta
- alerts de punts
- tipus d'event
- events
- premis
- premis reclamats
3. Aprovar/rebutjar premis reclamats
4. Consultar estadistiques de navegacio

## 7) Validacio mobile / tablet / desktop (checklist recomanada)

Fer prova manual en DevTools:

- 360x640 (mobil petit)
- 390x844 (mobil modern)
- 768x1024 (tablet)
- 1024x1366 (tablet gran)
- 1366x768 (laptop)
- 1920x1080 (desktop)

Pantalles a validar:

- Home
- Login/Register/Forgot/Reset
- Scanner
- Perfil usuari
- Admin dashboard
- Taules admin (scroll horitzontal, botons, modal detall/edició)
- Formularis CRUD (errors, focus, teclat)

Criteris minims:

- Sense solapaments
- Sense text tallat
- Botons clicables
- Menus navegables amb teclat
- Taules usables en pantalles petites

## 8) Comandes utils

```bash
# tests
php artisan test

# auditoria i18n
composer run-script i18n:audit

# crear esquema i dades d'exemple netes
php artisan migrate --seed

# mode demo amb factories
$env:SEED_MODE='demo'; php artisan migrate --seed

# importar base de dades completa
composer run-script db:import
```

## 9) Resolucio de problemes frequents

### Mapa static a la cerca (Google + fallback gratis)

La miniatura del mapa funciona amb aquest ordre:

1. Google Static Maps (nomes si esta habilitat)
2. Proveidors OSM (gratis)
3. Fallback SVG intern (sempre disponible)

Per activar Google Maps quan el teu projecte Google Cloud ho permeti:

```env
GOOGLE_MAPS_ENABLED=true
GOOGLE_MAPS_API_KEY=la_teva_key
```

Requisits de Google:

- Static Maps API habilitada
- Billing actiu al projecte
- Restriccions d'API key ben configurades

Si no vols dependre de Google, deixa:

```env
GOOGLE_MAPS_ENABLED=false
```

I el sistema continuara amb OSM/fallback automticament.

### Error: "could not find driver"

- Activa `pdo_mysql` a `php.ini`
- Reinicia terminal/servei PHP

### Error OAuth Google (redirect_uri_mismatch)

- Revisa URL exacta de callback al provider
- Revisa `APP_URL` i claus Google a `.env`

### Admin no carrega be en URL localitzada

- Ja corregit al projecte: es carrega `admin.js` per `/admin` i `/{locale}/admin`

## 10) Estructura rellevant del repo

- `routes/web.php`: rutes principals i admin
- `app/Http/Controllers/PageAndApiController.php`: endpoints de pagina/API simples
- `public/js/admin.js`: logica del panell admin
- `resources/views/`: vistes Blade
- `database-reciclatdam.sql`: esquema + dades default
- `tools/import_sql_dump.php`: import automatic de BD

## 11) Llicencia

Projecte academic basat en Laravel.
