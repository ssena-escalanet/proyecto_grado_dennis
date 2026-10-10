# FLUJO DE DESARROLLO POR CAPAS

## Principio rector
Se construye de adentro hacia afuera, respetando dependencias relacionales.
Nunca se migra una tabla que dependa de otra que no existe.

## Estrategia por fases

### FASE 0 — Setup inicial
Entregable: Proyecto Laravel + Breeze + Tailwind + MySQL + Git.
NO se crean migraciones ni modelos.

### FASE 1 — Capa Maestra (Independientes)
Se migran primero porque no tienen FK:
1. roles
2. categoria_producto
3. clientes
4. vehiculos
5. distribuidores

Cada módulo entrega:
- Migración
- Modelo Eloquent con relaciones
- Controlador Resource
- FormRequest (Store + Update)
- Vistas Blade: index, create, edit, show
- Rutas en `routes/web.php`
- Seeder opcional con datos demo

### FASE 2 — Capa Dependiente (con FK a Capa 1)
Se migran después de que Capa 1 esté probada:
1. usuarios (FK roles)
2. productos (FK categoria_producto)
3. pedidos (FK clientes)
4. hoja_despacho (FK vehiculos, distribuidores)
5. bitacora_acciones (FK usuarios)

Cada módulo entrega lo mismo que Fase 1, pero con `<select>` dinámicos
que traen datos de las tablas padre.

### FASE 3 — Capa Detalle/Pivote
Se migran al final:
1. detalle_pedido (une pedidos + productos)
2. detalle_despacho (une hoja_despacho + detalle_pedido)

Aquí las vistas son compuestas (maestro-detalle) y requieren JavaScript
para agregar filas dinámicamente.

### FASE 4 — Reportes y Dashboard
- KPIs, gráficos con Chart.js, exportación PDF/Excel.

### FASE 5 — Pruebas y despliegue
- Feature tests, seeders demo, configuración de producción.

## Regla de avance entre fases
No se avanza a la siguiente fase hasta que:
1. Todas las migraciones corren sin error (`php artisan migrate:fresh`).
2. Los seeders cargan sin error (`php artisan db:seed`).
3. Los CRUD funcionan en el navegador.
4. No hay errores en `storage/logs/laravel.log`.