# 09 — CONTEXTO TAILADMIN (Específico del template base)

Este archivo complementa los docs 00-08 con reglas específicas del template
TailAdmin Laravel que usamos como base visual del proyecto.

---

## 1. STACK REAL DEL PROYECTO (ACTUALIZADO)

| Capa | Tecnología | Versión |
|:---|:---|:---|
| Backend | Laravel | 12.69.2 |
| Lenguaje | PHP | 8.2+ |
| Frontend base | TailAdmin Laravel | - |
| Estilos | Tailwind CSS | v4 |
| JS ligero | Alpine.js | 3.x |
| Gráficos | ApexCharts (incluido en TailAdmin) | - |
| Base de datos | MySQL | 8.0 |
| Autenticación | Laravel Breeze (solo backend) | - |
| PDF | barryvdh/laravel-dompdf | - |
| Excel | maatwebsite/excel | - |
| Control de versiones | Git + GitHub | - |

### ⚠️ NOTAS CRÍTICAS:
- **Laravel 12** (NO 11).
- **Tailwind v4**: la configuración va en `resources/css/app.css` con `@theme`. 
  NO existe `tailwind.config.js`.
- **TailAdmin ya trae**: layout, sidebar, header, dark mode, dashboard, 
  componentes UI (cards, botones, inputs, tablas, modales, alertas, charts).
- **REUTILIZAR SIEMPRE** los componentes de TailAdmin. NO reinventar.
- **Breeze está instalado SOLO para el backend**. Las vistas de auth se adaptan 
  al diseño de TailAdmin.
- **Las vistas de Breeze en `resources/views/auth/` fueron eliminadas** 
  intencionalmente. La autenticación usará las vistas de TailAdmin:
  `resources/views/pages/auth/signin.blade.php` y `signup.blade.php`.

---

## 2. ESTRUCTURA DE VISTAS DE TAILADMIN

```
resources/views/
├── layouts/              # Layouts base de TailAdmin
│   ├── app.blade.php
│   ├── app-header.blade.php
│   ├── backdrop.blade.php
│   ├── fullscreen-layout.blade.php
│   └── sidebar.blade.php
├── partials/             # Sidebar, header, footer (si aplica)
├── components/           # Componentes Blade reutilizables
└── pages/
    ├── auth/             # signin.blade.php, signup.blade.php (visuales)
    ├── dashboard/        # Dashboard principal de TailAdmin
    └── {ejemplos}/       # Páginas demo de TailAdmin (calendar, profile, forms, etc.)
```

### Reglas obligatorias para las vistas nuevas:
1. **Toda vista nueva** debe extender del layout existente de TailAdmin.
   Ejemplo: `@extends('layouts.app')` (confirmar nombre exacto antes).
2. **Ubicación de vistas nuevas**: `resources/views/pages/{modulo}/`
   - Ejemplo: `resources/views/pages/roles/index.blade.php`
   - Ejemplo: `resources/views/pages/categorias/create.blade.php`
3. **Reutilizar componentes** existentes de TailAdmin:
   - Si TailAdmin tiene un `<x-card>`, usarlo.
   - Si tiene un `<x-input>`, usarlo.
   - NO crear componentes nuevos si ya existen.
4. **Respetar dark mode**: usar clases `dark:` cuando aplique.
5. **NO crear un layout nuevo.** Extender siempre del layout existente.

---

## 3. REGLAS DE TAILWIND CSS v4

- **NO crear** `tailwind.config.js`.
- **Configuración en** `resources/css/app.css` usando `@theme`:
  ```css
  @import "tailwindcss";

  @theme {
      --color-primary: #465fff;
      --color-success: #12b76a;
      --color-danger: #f04438;
      --color-warning: #f79009;
      --color-info: #0ba5ec;
  }
  ```
- Usar clases utilitarias estándar de Tailwind.
- Si necesitas un color personalizado, definirlo en `@theme`, no en config JS.

---

## 4. REGLAS DE ALPINE.JS

- Alpine.js ya está integrado en TailAdmin.
- Usar `x-data`, `x-show`, `x-model`, `x-on:click`, `x-for`, `x-if`.
- NO instalar Vue, React, Livewire ni Inertia.
- Para interactividad compleja (carrito, filas dinámicas en FASE 3), 
  usar Alpine.js.

---

## 5. REGLAS DE BREEZE (Auth)

- Breeze está instalado **solo para el backend**:
  - Controladores: `app/Http/Controllers/Auth/`
  - Rutas: `routes/auth.php`
  - Requests: `app/Http/Requests/Auth/`
  - Middleware: `auth`, `guest`, `verified`
- **Las vistas de Breeze NO se usan.** Se usan las de TailAdmin:
  - `resources/views/pages/auth/signin.blade.php`
  - `resources/views/pages/auth/signup.blade.php`
- En la **FASE 2.1** adaptaremos el modelo `User` a la tabla `usuarios` 
  custom del sistema.

---

## 6. REGLAS DE RESPUESTA DE LA IA (además de las del doc 00)

Cuando generes vistas Blade:
1. Extiende del layout existente de TailAdmin.
2. Ubica las vistas en `resources/views/pages/{modulo}/`.
3. Reutiliza componentes de TailAdmin.
4. NO crees un layout nuevo.
5. NO instales otro framework CSS.
6. NO modifiques la configuración de Tailwind v4.
7. Usa Alpine.js para interactividad.
8. Respeta el dark mode.

Cuando generes código que afecte al frontend:
- Si no sabes cómo se llama el layout de TailAdmin, PREGUNTA.
- Si no sabes qué componentes existen, PREGUNTA.
- NO asumas nombres ni rutas de archivos del template.

---

## 7. CÓMO ADAPTAR LOS PROMPTS DE FASE

Al pegar un prompt de cualquier fase en Gemini, agrega al inicio este bloque:

```
CONTEXTO UI: Usamos TailAdmin Laravel como base.
- Extiende todas las vistas del layout existente de TailAdmin.
- Reutiliza componentes (cards, botones, inputs, tablas) del template.
- Usa Tailwind v4 (configuración en resources/css/app.css con @theme).
- Usa Alpine.js para interactividad.
- Las vistas van en resources/views/pages/{modulo}/.
- NO crees un layout nuevo. NO instales otro framework CSS.
- Respeta el diseño y dark mode del template.
- Breeze está instalado solo para el backend de auth.
```

---

## 8. PRIMER PASO ANTES DE LA FASE 1

Antes de empezar a generar código en la FASE 1, es necesario inspeccionar
el layout de TailAdmin para saber:
1. El nombre exacto del layout base (`layouts.app` u otro).
2. Qué componentes Blade existen (`resources/views/components/`).
3. Cómo se estructura el sidebar y el header.
4. Cómo TailAdmin maneja el título de página y las migas de pan.

Esto se hará con un prompt de inspección inicial antes del MÓDULO 1.1.

---

## 9. ESTRUCTURA REAL DEL TEMPLATE (Confirmada)

### Layout base
- **Nombre:** `layouts.app`
- **Uso:** `@extends('layouts.app')`
- **Sección de contenido:** `@section('content') ... @endsection`
- **Título de página:** Se pasa como variable desde la ruta: `view('pages.x', ['title' => 'X'])`

### Vistas de ejemplo
- **Ubicación:** `resources/views/pages/{categoria}/`
- **Ejemplos:** `pages/dashboard/ecommerce.blade.php`, `pages/ui-elements/alerts.blade.php`

### Componentes disponibles (por carpeta)

**`resources/views/components/common/`**
- Cards, shape grids, elementos compartidos

**`resources/views/components/ui/`**
- Alerts, badges, buttons, avatars, modals

**`resources/views/components/form/`**
- Inputs, datepickers, checkboxes, switches, selects

**`resources/views/components/tables/`**
- Tablas con distintos estilos (basic-table, etc.)

**`resources/views/components/header/`**
- notification-dropdown, user-dropdown

**`resources/views/components/ecommerce/`**
- Widgets del dashboard (métricas, gráficos)

**`resources/views/components/profile/`**
- Cards de perfil de usuario

### Rutas de TailAdmin existentes
- `/dashboard` → `pages.dashboard.ecommerce`
- `/calendar` → `pages.calender`
- `/profile` → `pages.profile`
- `/form-elements` → `pages.form.form-elements`
- `/alerts`, `/avatars`, `/badges`, `/buttons`, `/modals`, etc. → `pages.ui-elements.*`

### Sidebar dinámico
- Se alimenta de `MenuHelper::getMenuGroups()`
- **Debemos añadir nuestros módulos aquí** para que aparezcan en el menú

### Tailwind v4
- **NO hay** `tailwind.config.js`
- Configuración en `resources/css/app.css` con `@theme`
- Variables disponibles: `--color-brand-500`, `--color-success-500`, `--color-gray-900`, etc.
- Colores custom: `text-brand-500`, `bg-success-500`
- Breakpoints: `--breakpoint-2xsm: 375px`, `--breakpoint-xsm: 425px`
- **Dark mode:** `@custom-variant dark (&:is(.dark *))`
- **Alpine stores:** `$store.theme`, `$store.sidebar`

### Grid system
- Usar `grid grid-cols-12 gap-4 md:gap-6` como contenedor principal
- Columnas: `col-span-12`, `col-span-6`, etc.

### Convenciones de vistas TailAdmin
1. Extender de `@extends('layouts.app')`
2. Usar `@section('content')` para el contenido
3. Contenedor principal: `<div class="grid grid-cols-12 gap-4 md:gap-6">`
4. Reutilizar componentes Blade existentes (`<x-ui.*>`, `<x-form.*>`, `<x-tables.*>`)
5. NO usar HTML espagueti. Crear componentes Blade si es necesario.
6. Ubicar vistas nuevas en: `resources/views/pages/{modulo}/`
7. Crear componentes nuevos en: `resources/views/components/{modulo}/`

### Reglas críticas
- **NO** crear `tailwind.config.js`
- **NO** romper el layout `layouts.app`
- **NO** modificar el sidebar directamente; usar `MenuHelper`
- **SÍ** respetar dark mode (clases `dark:`)
- **SÍ** usar Alpine.js para interactividad



---

## 10. ESTRUCTURA REAL DE COMPONENTES (Confirmada)

### Layout base
- **Nombre:** `layouts.app`
- **Uso:** `@extends('layouts.app')`
- **Sección de contenido:** `@section('content')`
- **Variable de título:** Se pasa desde la ruta: `view('pages.x', ['title' => 'X'])`

### Componente Card (obligatorio para envolver contenido)
**Ubicación:** `resources/views/components/common/component-card.blade.php`

**Uso:**
```blade
<x-common.component-card title="Título del Card" desc="Descripción opcional">
    {{-- Aquí va la tabla o formulario --}}
</x-common.component-card>
```

**Props:**
- `title` (obligatorio)
- `desc` (opcional)

**Acepta `$attributes->merge()`** → se pueden agregar clases custom.

### Estructura de tabla (copiar de `basic-tables-one.blade.php`)

⚠️ **IMPORTANTE:** El componente de tabla de TailAdmin usa Alpine.js con datos simulados.
Para nuestro proyecto, **copiamos la estructura HTML** y usamos `@foreach` de Blade.

**Estructura base:**
```blade
<div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="max-w-full overflow-x-auto custom-scrollbar">
        <table class="w-full min-w-[1102px]">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    <th class="px-5 py-3 text-start sm:px-6">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                            NOMBRE COLUMNA
                        </p>
                    </th>
                    {{-- más th --}}
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="px-5 py-4 sm:px-6">
                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                {{ $item->campo }}
                            </p>
                        </td>
                        {{-- más td --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
```

### Patrón de vista completo (obligatorio)
```blade
@extends('layouts.app')

@section('content')
  <div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12">
      <x-common.component-card title="..." desc="...">
        {{-- Tabla o formulario --}}
      </x-common.component-card>
    </div>
  </div>
@endsection
```

### MenuHelper (para agregar módulos al sidebar)
**Ubicación:** `app/Helpers/MenuHelper.php`

**Método:** `getMainNavItems()`

**Formato de item simple:**
```php
[
    'icon' => 'user-profile', // reutilizar íconos existentes
    'name' => 'Roles',
    'path' => '/roles',
],
```

**Formato de item con submenú:**
```php
[
    'name' => 'Catálogo',
    'icon' => 'tables',
    'subItems' => [
        ['name' => 'Categorías', 'path' => '/categorias', 'pro' => false],
        ['name' => 'Productos', 'path' => '/productos', 'pro' => false],
    ],
],
```

**Íconos disponibles para reutilizar:**
- `dashboard`, `calendar`, `user-profile`, `forms`, `tables`, `pages`, `charts`, `ui-elements`, `authentication`

### Paleta de colores TailAdmin v4
- **Marca:** `text-brand-500`, `bg-brand-500` (#465fff)
- **Éxito:** `text-success-500`, `bg-success-500` (#12b76a)
- **Texto tema:** `text-theme-sm`, `text-theme-xs`
- **Fondos:** `bg-white dark:bg-gray-900`, `dark:bg-white/[0.03]`
- **Bordes:** `border-gray-200 dark:border-gray-800`
- **Texto:** `text-gray-800 dark:text-white/90`, `text-gray-500 dark:text-gray-400`

### Convenciones de vistas nuevas
1. Extender de `@extends('layouts.app')`
2. Usar `@section('content')`
3. Contenedor: `<div class="grid grid-cols-12 gap-4 md:gap-6">`
4. Envolver todo en `<x-common.component-card title="..." desc="...">`
5. Ubicación: `resources/views/pages/{modulo}/`
6. Rutas en `routes/web.php` con `['title' => 'X']`
7. Agregar al `MenuHelper::getMainNavItems()`

### Reglas críticas
- **NO** crear `tailwind.config.js`
- **NO** romper el layout `layouts.app`
- **NO** modificar el sidebar directamente; usar `MenuHelper`
- **SÍ** respetar dark mode (`dark:` clases)
- **SÍ** usar Alpine.js para interactividad
- **NO** usar HTML espagueti. Reutilizar componentes y clases de TailAdmin.