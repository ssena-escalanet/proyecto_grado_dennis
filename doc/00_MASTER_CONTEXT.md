# MASTER CONTEXT — Sistema Chocolates Princesa

## 1. Identificación del proyecto
- **Nombre:** Sistema de Gestión de Distribución y Despachos
- **Empresa:** CHOCOLATES PRINCESA
- **Tipo:** Aplicación web monolítica
- **Metodología:** Desarrollo por capas de dependencia relacional

## 2. Stack tecnológico (INMUTABLE)
| Capa | Tecnología | Versión |
|:---|:---|:---|
| Backend | Laravel | 11.x |
| Lenguaje | PHP | 8.2+ |
| Frontend | Blade + Tailwind CSS | 3.x |
| JS ligero | Alpine.js | 3.x |
| Base de datos | MySQL | 8.0 |
| Autenticación | Laravel Breeze (Blade) | - |
| PDF | barryvdh/laravel-dompdf | - |
| Excel | maatwebsite/excel | - |
| Gráficos | Chart.js | - |
| Control de versiones | Git + GitHub | - |

## 3. Principios de arquitectura
1. **MVC estricto:** Nada de lógica de negocio en controladores. Usar Services para lógica compleja.
2. **Form Requests:** Toda validación va en `app/Http/Requests/`, nunca en el controlador.
3. **Eloquent primero:** Nada de SQL crudo salvo para reportes complejos.
4. **Transacciones DB:** Toda operación que toque más de una tabla usa `DB::transaction()`.
5. **Soft Deletes:** En `productos`, `clientes`, `usuarios` para preservar historial.
6. **Bitácora automática:** Un middleware registra cada acción CRUD.
7. **Blade components:** Reutilizar `<x-app-layout>`, `<x-alert>`, `<x-card>`, etc.

## 4. Reglas inmutables para el agente IA
❌ NO cambiar el stack tecnológico.
❌ NO crear tablas fuera del esquema definido en `01_DATABASE_SCHEMA.md`.
❌ NO usar Livewire, Inertia, React ni Vue.
❌ NO generar código de fases no solicitadas.
❌ NO inventar reglas de negocio: consultar `02_BUSINESS_RULES.md`.
❌ NO modificar columnas del esquema sin autorización.
❌ NO escribir lógica compleja en controladores.
❌ NO asumir: si algo no está en los docs, PREGUNTAR.

## 5. Formato de respuesta esperado de la IA
Toda respuesta debe seguir este formato:

1. **Explicación breve** (máximo 5 líneas).
2. **Archivos generados**, cada uno con su ruta exacta como título:
   ### app/Models/Producto.php
   ```php
   // código completo