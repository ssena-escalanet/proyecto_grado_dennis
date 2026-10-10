# 06 — PROMPTS FASE 1 (Capa Maestra Independiente)
## Sistema Chocolates Princesa

---

## 🎯 OBJETIVO DE LA FASE 1

Construir las **5 tablas maestras independientes** (sin FK). Al terminar:

- ✅ 5 migraciones ejecutadas.
- ✅ 5 modelos Eloquent con relaciones declaradas.
- ✅ 5 controladores resource.
- ✅ Vistas Blade (index, create, edit, show).
- ✅ Rutas en `routes/web.php`.
- ✅ Seeders con datos demo.
- ✅ Todo probado en navegador.

**NO avanzar a FASE 2 hasta completar el 100%.**

---

## 🧱 STACK TECNOLÓGICO (INMUTABLE)

| Capa | Tecnología |
|:---|:---|
| Backend | Laravel 11 (PHP 8.2+) |
| Frontend | Blade + Tailwind CSS + Alpine.js |
| Base de datos | MySQL 8.0 |
| Autenticación | Laravel Breeze (Blade) |
| PDF | barryvdh/laravel-dompdf |
| Excel | maatwebsite/excel |
| Gráficos | Chart.js |
| Control de versiones | Git + GitHub |

**PROHIBIDO:** Livewire, Inertia, React, Vue, SQL crudo innecesario.

---

## 📋 TABLAS A CONSTRUIR (orden obligatorio)

| Orden | Tabla | Propósito |
|:---:|:---|:---|
| 1 | `roles` | Perfiles de usuario |
| 2 | `categoria_producto` | Clasificación de chocolates |
| 3 | `clientes` | Compradores con geolocalización |
| 4 | `vehiculos` | Flota de transporte |
| 5 | `distribuidores` | Personal de reparto |

---

## 🗄️ ESQUEMA DETALLADO

### 1. `roles`
| Columna | Tipo | Restricción |
|:---|:---|:---|
| id_rol | bigint unsigned | PK, autoincrement |
| nombre_rol | varchar(40) | UNIQUE, NOT NULL |
| descripcion | varchar(100) | NULL |
| timestamps | - | created_at, updated_at |

**Modelo:** `Rol` → `hasMany(Usuario::class)`

### 2. `categoria_producto`
| Columna | Tipo | Restricción |
|:---|:---|:---|
| id_categoria | bigint unsigned | PK, autoincrement |
| nombre_categoria | varchar(50) | UNIQUE, NOT NULL |
| descripcion | varchar(150) | NULL |
| timestamps | - | - |

**Modelo:** `CategoriaProducto` → `hasMany(Producto::class)`

### 3. `clientes`
| Columna | Tipo | Restricción |
|:---|:---|:---|
| id_cliente | bigint unsigned | PK, autoincrement |
| nombre_negocio | varchar(100) | NOT NULL |
| representante | varchar(100) | NOT NULL |
| nit_ci | varchar(25) | UNIQUE, NOT NULL |
| telefono | varchar(20) | NULL |
| direccion | varchar(150) | NOT NULL |
| coordenada_lat | decimal(10,7) | NULL |
| coordenada_lon | decimal(10,7) | NULL |
| estado | varchar(20) | DEFAULT 'Activo' |
| timestamps | - | - |
| deleted_at | timestamp | NULL (SoftDeletes) |

**Modelo:** `Cliente` → `hasMany(Pedido::class)` + `SoftDeletes`

### 4. `vehiculos`
| Columna | Tipo | Restricción |
|:---|:---|:---|
| id_vehiculo | bigint unsigned | PK, autoincrement |
| placa | varchar(15) | UNIQUE, NOT NULL |
| marca | varchar(40) | NOT NULL |
| modelo | varchar(40) | NOT NULL |
| capacidad_carga_kg | decimal(8,2) | NOT NULL, > 0 |
| estado | varchar(20) | DEFAULT 'Disponible' |
| timestamps | - | - |

**Modelo:** `Vehiculo` → `hasMany(HojaDespacho::class)`

### 5. `distribuidores`
| Columna | Tipo | Restricción |
|:---|:---|:---|
| id_distribuidor | bigint unsigned | PK, autoincrement |
| nombres | varchar(60) | NOT NULL |
| apellidos | varchar(60) | NOT NULL |
| ci | varchar(20) | UNIQUE, NOT NULL |
| licencia_conducir | varchar(20) | NOT NULL |
| telefono | varchar(20) | NULL |
| estado | varchar(20) | DEFAULT 'Activo' |
| timestamps | - | - |

**Modelo:** `Distribuidor` → `hasMany(HojaDespacho::class)`

---

## 📜 REGLAS DE NEGOCIO APLICABLES

### Categoría de Producto
- **RN-01:** `nombre_categoria` es único.
- **RN-02:** No eliminar categoría con productos asociados.
- **RN-03:** Solo desactivar (estado = 'Inactivo').

### Clientes
- **RN-11:** `nit_ci` es único.
- **RN-12:** Si se registran coordenadas, ambas (lat y lon) obligatorias.
- **RN-13:** No eliminar cliente con pedidos (solo desactivar).

### Vehículos
- **RN-25:** `placa` única.
- **RN-26:** `capacidad_carga_kg` > 0.
- **RN-27:** Estados: Disponible, En Ruta, Mantenimiento.
- **RN-28:** No asignar vehículo en 'Mantenimiento' a un despacho.

### Distribuidores
- **RN-29:** `ci` único.
- **RN-30:** Estados: Activo, Inactivo, En Ruta.
- **RN-31:** No asignar distribuidor inactivo a un despacho.

---

## 🎨 REGLAS UI/UX (Tailwind)

- **Layout:** `<x-app-layout>` con sidebar y navbar.
- **Paleta:** indigo-600 (primario), green-600 (éxito), red-600 (peligro), yellow-500 (advertencia), blue-500 (info).
- **Componentes:** `<x-card>`, `<x-button>`, `<x-alert>`, `<x-input>`, `<x-select>`, `<x-badge>`.
- **Tablas:** encabezado `bg-gray-100`, filas alternas, paginación `{{ $items->links() }}`.
- **Badges de estado:**
  - Activo / Disponible → verde
  - Inactivo → rojo
  - En Ruta → azul
  - Mantenimiento → amarillo
- **Formularios:** grid 2 columnas, `@error` visible, botones "Guardar" y "Cancelar".

---

## 📐 CONVENCIONES DE CÓDIGO

- **Modelos:** PascalCase singular (`Rol`, `CategoriaProducto`).
- **Tablas:** snake_case plural (`roles`, `categoria_producto`).
- **Controladores:** PascalCase + Controller (`RolController`).
- **FormRequests:** `Store{Modelo}Request`, `Update{Modelo}Request`.
- **Rutas:** `Route::resource()` con kebab-case (`/categorias`, `/vehiculos`).
- **Vistas:** `resources/views/{modulo}/{accion}.blade.php`.
- **Migraciones:** `YYYY_MM_DD_HHMMSS_create_{tabla}_table.php`.
- **Idioma:** código en inglés, vistas y mensajes en español.

---

## 🚫 RESTRICCIONES ESTRICTAS

❌ NO crear tablas de FASE 2 ni FASE 3.
❌ NO tocar la tabla `users` default de Laravel.
❌ NO instalar paquetes nuevos sin autorización.
❌ NO usar Livewire, Inertia, React ni Vue.
❌ NO escribir lógica compleja en controladores.
❌ NO asumir reglas: si algo no está aquí, PREGUNTAR.
❌ NO avanzar de módulo hasta probar el anterior.

---

## 📝 FORMATO DE RESPUESTA ESPERADO

1. **Explicación breve** (máx. 5 líneas).
2. **Archivos generados** con ruta exacta como título:
   ### app/Models/Rol.php
   ```php
   // código completo
   ```
3. **Comandos a ejecutar** (Artisan, Composer, NPM).
4. **Instrucciones de prueba**.
5. **Pregunta de confirmación** antes del siguiente módulo.

---

## 📦 ENTREGABLES POR MÓDULO

1. Migración (`database/migrations/`)
2. Modelo Eloquent con `$fillable`, `$casts`, relaciones, SoftDeletes.
3. Controlador Resource (7 métodos).
4. Form Requests Store + Update.
5. Vistas Blade: index, create, edit, show.
6. Rutas en `routes/web.php`.
7. Seeder con datos demo.
8. Prueba funcional en navegador.

---

## ✅ CRITERIO DE CIERRE DE FASE 1

- [ ] `php artisan migrate:fresh --seed` corre sin error.
- [ ] Los 5 módulos funcionan (crear, ver, editar, eliminar).
- [ ] Seeders cargaron datos demo.
- [ ] Sin errores en `storage/logs/laravel.log`.
- [ ] Layout `<x-app-layout>` consistente.
- [ ] Validaciones muestran `@error`.

---

## 🎬 PROMPTS DE EJECUCIÓN

### PROMPT 1.1 — Roles
```
Ejecuta la FASE 1.1: Módulo Roles según docs/06_PROMPTS_FASE_1.md.

Entrega:
1. Migración create_roles_table
2. Modelo Rol (hasMany Usuario)
3. RolController (resource completo)
4. StoreRolRequest + UpdateRolRequest
5. Vistas: index, create, edit, show
6. Rutas en web.php
7. RolSeeder: Admin, Supervisor, Vendedor, Distribuidor

Reglas: RN-01 a RN-03.
Respeta el formato de respuesta de este archivo.
Al final, dime cómo probarlo.
```

### PROMPT 1.2 — Categoría Producto
```
Ejecuta la FASE 1.2: Módulo Categoría de Producto.

Entrega:
1. Migración create_categoria_producto_table
2. Modelo CategoriaProducto (hasMany Producto)
3. CategoriaProductoController (resource)
4. Store + Update FormRequests
5. Vistas: index, create, edit, show
6. Rutas
7. Seeder: Chocolates Negros, Blancos, Rellenos, Bombones, Trufas.

Reglas: RN-01 a RN-03.
Al final, dime cómo probarlo.
```

### PROMPT 1.3 — Clientes
```
Ejecuta la FASE 1.3: Módulo Clientes.

Entrega:
1. Migración create_clientes_table (softDeletes)
2. Modelo Cliente (hasMany Pedido, SoftDeletes)
3. ClienteController (resource)
4. Store + Update FormRequests (nit_ci único)
5. Vistas: index, create, edit, show con inputs lat/lon
6. Rutas
7. Seeder con 5 clientes demo con coordenadas.

Reglas: RN-11 a RN-13.
Al final, dime cómo probarlo.
```

### PROMPT 1.4 — Vehículos
```
Ejecuta la FASE 1.4: Módulo Vehículos.

Entrega:
1. Migración create_vehiculos_table
2. Modelo Vehiculo (hasMany HojaDespacho)
3. VehiculoController (resource)
4. Store + Update FormRequests (placa única, capacidad > 0)
5. Vistas: index con filtro por estado, create, edit, show
6. Rutas
7. Seeder con 3 vehículos demo.

Reglas: RN-25 a RN-28.
Al final, dime cómo probarlo.
```

### PROMPT 1.5 — Distribuidores
```
Ejecuta la FASE 1.5: Módulo Distribuidores.

Entrega:
1. Migración create_distribuidores_table
2. Modelo Distribuidor (hasMany HojaDespacho)
3. DistribuidorController (resource)
4. Store + Update FormRequests (ci único)
5. Vistas: index con filtro por estado, create, edit, show
6. Rutas
7. Seeder con 3 distribuidores demo.

Reglas: RN-29 a RN-31.
Al final, dime cómo probarlo.
```

### PROMPT DE CIERRE
```
FASE 1 completada. Verifica:
1. php artisan migrate:fresh --seed corre sin error.
2. Los 5 módulos funcionan en el navegador.
3. Sin errores en storage/logs/laravel.log.

Genera resumen con: archivos creados, rutas disponibles, pendientes para FASE 2.
Guárdalo como docs/FASE_1_RESUMEN.md
```