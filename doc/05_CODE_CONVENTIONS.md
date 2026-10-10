# CONVENCIONES DE CÓDIGO — Laravel 11

## Modelos
- Ubicación: `app/Models/`
- Nombre: PascalCase singular (`Producto`, `DetallePedido`, `HojaDespacho`)
- Siempre definir:
  - `protected $table` si el nombre plural no sigue convención.
  - `protected $fillable` con columnas editables.
  - `protected $casts` para decimales, fechas y datetime.
  - `use SoftDeletes` cuando aplique.
  - Relaciones: `belongsTo`, `hasMany`, `hasOne`.

## Controladores
- Ubicación: `app/Http/Controllers/`
- Nombre: PascalCase + Controller (`ProductoController`)
- Usar `Resource Controllers` (index, create, store, show, edit, update, destroy).
- Inyectar FormRequests en `store()` y `update()`.
- Usar `DB::transaction()` para operaciones múltiples.

## Form Requests
- Ubicación: `app/Http/Requests/`
- Nombre: `Store{Modelo}Request` y `Update{Modelo}Request`.
- Método `authorize()` retorna `true` (los permisos van en middleware).
- Método `rules()` con todas las validaciones.

## Rutas
- Archivo: `routes/web.php`
- Agrupadas por middleware `auth`.
- Usar `Route::resource()` cuando aplique.
- Nombres en kebab-case plural: `/categorias`, `/hoja-despacho`.

## Vistas Blade
- Ubicación: `resources/views/{modulo}/`
- Archivos: `index.blade.php`, `create.blade.php`, `edit.blade.php`, `show.blade.php`.
- Usar componentes `<x-app-layout>` y `<x-slot name="header">`.
- Tailwind para estilos, Alpine.js para interactividad ligera.

## Migraciones
- Ubicación: `database/migrations/`
- Formato: `YYYY_MM_DD_HHMMSS_create_{tabla}_table.php`
- Orden respetando dependencias FK.

## Seeders
- Ubicación: `database/seeders/`
- Un seeder por tabla maestra.
- `DatabaseSeeder` los llama en orden.

## Idioma
- Código (variables, métodos, clases): inglés.
- Vistas y mensajes al usuario: español.
- Comentarios: español.