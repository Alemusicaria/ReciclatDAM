# 📋 TUTORIAL COMPLET DE VERIFICACIÓ - ReciclatDAM

## ⚠️ IMPORTANT: Verificar TOT un a un en aquest ordre exacte

---

## PART 1: PREPARACIÓ DEL SERVIDOR (5 min)

### 1.1 Iniciar el servidor Laravel
```bash
php artisan serve
```
**Espera:** Haig de veure `Server running on [http://127.0.0.1:8000]`

### 1.2 Obrir el navegador a:
```
http://localhost:8000
```

### 1.3 Obrir la Consola del Navegador
- **Windows/Linux:** `F12`
- **Mac:** `Cmd + Option + I`
- Vés a la pestanya `Console`
- **Neteja els missatges anteriors:** `console.clear()`

---

## PART 2: VERIFICACIÓ DE MODALS (10 min)

### 2.1 Verificar Modal de Detalls (Dashboard Admin)
**Accés:** 
1. Inicia sessió com admin
2. Vés a `Admin → Dashboard`

**Accions a provar:**
- [ ] Clica sobre una **alerta de punt de recollida** en la taula
- **Espera:** Haig de veure el modal Bootstrap 5 obrir-se sense salts
- **Consola:** Cap error marcat en vermell
- Clica el botó **X** per tancar
- [ ] El modal ha de tancar-se suavément

**Consola - Haig de veure:**
```
✓ Cap error relacionat amb modals
✓ Cap message "undefined is not a function"
```

### 2.2 Verificar Modal de Dinàmics (Activity Modal)
**Accions a provar:**
- [ ] A la secció **Activitat Recents**, clica sobre una fila
- **Espera:** Haig de veure els detalls en modal
- **Consola:** Cap error
- [ ] Tanca el modal amb **X** o clickant fora

### 2.3 Verificar Modal de Ranking
**Accions a provar:**
- [ ] A la secció **Ranking**, clica sobre un usuari
- **Espera:** Haig de veure els detalls de l'usuari
- **Consola:** Cap error

---

## PART 3: VERIFICACIÓ DE JSON PARSING (15 min)

### 3.1 Test de Resposta Error en Admin (Intentar enviar formulari buit)

**Accions:**
1. Vés a `Admin → Codis`
2. Clica **Afegir Codi**
3. Deixa els camps **BUITS**
4. Clica **Guardar**

**Espera:**
- [ ] Ha de mostrar error en **Alert/Modal de validació**
- [ ] La **Consola** ha de mostrar error descriptiu (NO "SyntaxError")
- **Consola - Haig de veure:**
```
Error: [missatge específic de validació]
```
- **NO haig de veure:**
```
SyntaxError: Unexpected token '<'
```

### 3.2 Test de Resposta Correcta en Admin

**Accions:**
1. Omple els camps correctament
2. Clica **Guardar**

**Espera:**
- [ ] Haig de veure **confirmació de success**
- [ ] La nova fila apareix a la taula
- [ ] **Consola:** Cap error
- **Consola - Haig de veure:**
```
✓ 1 element creat correctament
```

### 3.3 Test de Pujada de Foto d'Usuari

**Accions:**
1. Vés a **Perfil d'Usuari** (menú dalt dreta → Perfil)
2. Busca la secció **Pujada de Foto**
3. Selecciona una imatge
4. Clica **Pujar**

**Espera:**
- [ ] Haig de veure la foto actualitzada al perfil
- [ ] **Consola:** Cap error
- [ ] Si acceptes una imatge **inválida** (ex: .txt):
  - Haig de veure error descriptiu
  - **NO** "SyntaxError: Unexpected token"

### 3.4 Test de Registre en Event

**Accions:**
1. Vés a **Events**
2. Clica sobre un event disponible
3. Clica **Registrar-me**

**Espera:**
- [ ] Haig de veure confirmació de registre
- [ ] **Consola:** Cap error
- [ ] Si hi ha error (ex: ja registrat):
  - Haig de veure missatge d'error clara
  - **NO** "SyntaxError"

### 3.5 Test de Canvi de Premis

**Accions:**
1. Vés a **Premis**
2. Clica sobre un premi que pots canjear
3. Clica **Canjear**
4. Confirma l'acció

**Espera:**
- [ ] Haig de veure confirmació de canvi
- [ ] Els punts es deducten correctament
- [ ] **Consola:** Cap error

---

## PART 4: VERIFICACIÓ DE FORMULARIS (20 min)

### 4.1 Test CRUD en Admin - Codis

**Accions:**

#### CREATE:
- [ ] Vés a `Codis` → `Afegir`
- [ ] Omple: Nom = "TEST_COD_001", Punts = "100"
- [ ] Clica Guardar
- **Espera:** Codi apareix a la taula
- **Consola:** Cap error

#### READ:
- [ ] Clica sobre el codi creat
- [ ] Haig de veure els detalls en modal
- **Consola:** Cap error

#### UPDATE:
- [ ] Al modal, edita el valor de punts a "150"
- [ ] Clica Guardar
- **Espera:** Les dades s'actualitzen a la taula
- **Consola:** Cap error

#### DELETE:
- [ ] Clica el botó eliminar (icona paperera)
- [ ] Confirma l'eliminació
- **Espera:** La fila desapareix
- **Consola:** Cap error

**Repetir per a:**
- [ ] Events
- [ ] Premis
- [ ] Productes
- [ ] Punts de Recollida

### 4.2 Test de Validacions

**Accions per cada formulari:**
1. Deixa camps obligatoris buits
2. Intenta guardar
3. **Espera:** Haig de veure errors de validació
4. **Consola:** Els errors han de ser descriptius

**Camps a testar:**
- [ ] Nome/títol en blanc
- [ ] Valor negatiu on no s'esperava
- [ ] Duplicat (si aplica)

---

## PART 5: OPERACIONS D'ACCIÓ AMB ESTADO (15 min)

### 5.1 Test d'Aprovar Elements (PremiReclamats)

**Accions:**
1. Vés a `Admin → Premis Reclamats`
2. Busca una reclamació amb status "Pendent"
3. Clica el botó **Aprovar**

**Espera:**
- [ ] El status cambia a "Aprovat"
- [ ] **Consola:** Cap error
- [ ] La fila es pinta amb color de success

### 5.2 Test de Rebutjar Elements

**Accions:**
1. Busca una altra reclamació amb status "Pendent"
2. Clica el botó **Rebutjar**

**Espera:**
- [ ] El status cambia a "Rebutjat"
- [ ] **Consola:** Cap error

### 5.3 Test d'Aprovar Tots (Bulk Action)

**Accions:**
1. A la taula de PremiReclamats
2. Selecciona múltiples elements amb la checkbox
3. Clica **Aprovar Tot**

**Espera:**
- [ ] Tots els elements seleccionats canvien a "Aprovat"
- [ ] **Consola:** Cap error
- [ ] Els mostres confirmació de quants van ser aprovats

---

## PART 6: OPERACIONS DE NAVEGACIÓ I FINS (10 min)

### 6.1 Test de Geolocalització (Alertes)

**Accions:**
1. Vés a `Alertes de Punts de Recollida → Afegir`
2. Permet la geolocalització quan es demani
3. Clica el botó **Trobar Punts Propers**

**Espera:**
- [ ] Els punts propers es carreguen en la taula
- [ ] **Consola:** Cap error
- [ ] El marcador HTML mostrada correctament

**Si rebutjes geolocalització:**
- [ ] Ha de permetre introduir coordenades manuals
- [ ] **Consola:** Cap error

### 6.2 Test de Tema (Theme Switcher)

**Accions:**
1. Clica el botó de **Tema** (lluna/sol)
2. Cambia entre tema clar/fosc

**Espera:**
- [ ] Els colors canvien correctament
- [ ] La preferència es guarda (refresca i haig de veure el tema seleccionat)
- [ ] **Consola:** Cap error

### 6.3 Test de Seleció d'Idioma

**Accions:**
1. Clica el botó de **Idioma**
2. Selecciona un idioma diferent (ex: Anglès)

**Espera:**
- [ ] Tota la pàgina es tradueix correctament
- [ ] Les dades en la BD es mostren en l'idioma correcte (si aplica)
- [ ] **Consola:** Cap error

---

## PART 7: VERIFICACIÓ DE CONSOLA AVANÇADA (10 min)

### 7.1 Neteja de Consola
- [ ] `console.clear()`

### 7.2 Test de Tots els Warnings
Navega per tota l'aplicació:
- [ ] Admin Dashboard
- [ ] Administració (Codis, Events, Premis, etc.)
- [ ] Events
- [ ] Premis
- [ ] Alertes
- [ ] Perfil d'Usuari

**Haig de veure:**
- ✅ Cap error en vermell
- ✅ Cap "undefined is not a function"
- ✅ Cap "Cannot read property"
- ✅ Cap "Unexpected token '<'"
- ⚠️ Warnings estàndard són OK (ex: deprecations de Bootstrap)

### 7.3 Nivell de Filtering de Consola
1. Clica el **filter dropdown** a la consola
2. **Selecciona "Errors"**
3. **Haig de veure:** 0 errors

---

## PART 8: VERIFICACIÓ DE TESTS UNITARIS (5 min)

### 8.1 Executar Tots els Tests
```bash
php artisan test
```

**Espera:**
- ✅ Tots els tests verds
- ✅ 0 fallides
- ✅ 0 errors

### 8.2 Verificar Tests Específics de Funcionalitat
```bash
php artisan test tests/Feature/EventRegistrationTest.php
php artisan test tests/Feature/UserPhotoUpdateTest.php
php artisan test tests/Feature/AdminPremiReclamatFlowTest.php
```

**Espera:**
- ✅ Cada test passa individualment
- ✅ 0 errors

---

## PART 9: VERIFICACIÓ DE RENDIMENT (5 min)

### 9.1 Obrir Developer Tools - Network

**Accions:**
1. Obri `F12` → pestanya `Network`
2. Filtra per `Fetch/XHR`
3. Realitza una acció (ex: guardar un codi)

**Espera:**
- [ ] La petició apareix a la llista
- [ ] **Status:** 200, 201, 422 (validació) - cap 500
- [ ] **Response:** Contorna JSON vàlid (NO HTML error)
- [ ] **Time:** < 500ms

### 9.2 Verificar Múltiples Peticions Concurrent

**Accions:**
1. Clica múltiples botons d'acció ràpidament
2. Observa les peticions a Network

**Espera:**
- [ ] Totes les peticions es completen correctament
- [ ] Cap race condition aparent
- [ ] Els resultats son coherents

---

## PART 10: CASOS EXTREMS (15 min)

### 10.1 Test de Connexió Perduda

**Accions:**
1. Obri Developer Tools → Network
2. Clica el botó **"Offline"** a la pestanya Network
3. Intenta guardar una forma
4. Vés novament en **"Online"**

**Espera:**
- [ ] Haig de veure error descriptiu quan estigui offline
- [ ] **Consola:** No "SyntaxError"
- [ ] Quan torne online, la forma pot intentar-se novament

### 10.2 Test de Resposta HTML en lloc de JSON

**Accions:**
1. Obri Developer Tools → Application/Storage
2. Localitza les cookies (`XSRF-TOKEN`, `laravel_session`)
3. **Elimina la cookie `laravel_session`**
4. Intenta guardar una forma

**Espera:**
- [ ] Haig de veure redirecciona a login
- [ ] **Consola:** Error descriptiu (NO "SyntaxError: Unexpected token '<'")
- [ ] Pots iniciar sessió novament

### 10.3 Test de Timeout

**Accions:**
1. A DevTools → Network, habilita throttling (`Slow 3G`)
2. Intenta una operació lenta
3. Espera a que es completi

**Espera:**
- [ ] L'operació es completa correctament (pot ser lenta)
- [ ] **Consola:** Missatges informat del progres (si aplica)

---

## PART 11: VALIDACIÓ DE CODI (10 min)

### 11.1 Verificar la Funció Helper parseJsonResponse

**Accions:**
1. Obri `Ctrl+Shift+F` (Global Find)
2. Busca: `parseJsonResponse`

**Espera:**
- ✅ Apareix en tots els fitxers amb fetch:
  - `public/js/admin.js` (línia ~4)
  - `resources/views/admin/dashboard.blade.php` (línia ~900)
  - `resources/views/admin/logic-checker.blade.php` (línia ~11)
  - `resources/views/layouts/main.blade.php` (línia ~75)
  - `resources/views/alertes_punts_de_recollida/create.blade.php` (línia ~89)
  - `resources/views/sections/premis.blade.php` (línia ~299)
  - `resources/views/sections/events.blade.php` (línia ~62)
  - `resources/views/users/show.blade.php` (línia ~1256)

### 11.2 Verificar que NO hi ha parseJsonResponse duplicats

**Accions:**
```bash
grep -r "const parseJsonResponse" public/js/*.js resources/views/**/*.blade.php
```

**Espera:**
- ✅ 8 resultats exactes (1 per fitxer)
- ✅ Cap duplicat dins del mateix fitxer

### 11.3 Verificar Modals Bootstrap 5

**Accions:**
```bash
grep -r "bootstrap.Modal.getOrCreateInstance" resources/views/**/*.blade.php
```

**Espera:**
- ✅ Almenys 2 resultats en dashboard.blade.php
- ✅ Cap `.classList.add('show')`

---

## PART 12: SIGN-OFF FINAL (5 min)

### Checklist de Verificació Final:

- [ ] **Modals:** Tots obren/tanquen correctament sense errors
- [ ] **JSON Parsing:** Zero `SyntaxError: Unexpected token '<'`
- [ ] **CRUD Admin:** Crear, llegir, actualitzar, eliminar funciona per tots els tipus
- [ ] **Validacions:** Els errors es mostren correctament
- [ ] **Accions en Massa:** Aprovar-tot, rebutjar-tot funciona
- [ ] **Navegació:** Els temes i idiomes canvien sense errors
- [ ] **Consola:** Filtra per "Errors" → 0 resultats
- [ ] **Tests:** `php artisan test` → 100% verts
- [ ] **Network:** Cap HTML error en respostes 4xx/5xx
- [ ] **Casos Extrems:** Offline/timeout/perdida sessió manejats correctament

---

## 🎉 QUAN TOTES LES VERIFICACIONS SIGUIN ✅

La part funcional està acabada i llesta per a:
1. **Commit i Push** al repositori
2. **Merge** a main branch
3. **Deploy** a producció

---

## 📝 NOTES IMPORTANTS

- **Neteja la Consola** regularment (console.clear()) per veure només els errors nous
- **Si veus error:** Anota el pas exacte i el missatge de consola
- **Repeteix 3 vegades:** Cada flow crític (per a race conditions)
- **Prova amb navegadors diferents:** Chrome, Firefox, Edge

---

## ❌ ERRORS QUE NO HAURIEN D'EXISTIR:

```
❌ SyntaxError: Unexpected token '<'
❌ TypeError: Cannot read property 'message' of undefined
❌ ReferenceError: parseJsonResponse is not defined
❌ response.json is not a function
❌ Uncaught (in promise) SyntaxError
```

---

## ✅ ERRORS QUE SÓN NORMALS:

```
⚠️ Deprecation warnings de Bootstrap 5
⚠️ CSP warnings (si teniu CSP headers)
⚠️ Font not found desde servidors externs
⚠️ User denied geolocation permission
```

---

**TEMPS TOTAL ESTIMAT: ~2 hores**

**Status: 🔄 A punt de verificació completa**
