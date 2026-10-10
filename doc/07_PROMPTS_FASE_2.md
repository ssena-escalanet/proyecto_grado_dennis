# 07 — PROMPTS FASE 2 (Capa Dependiente)
## Sistema Chocolates Princesa

---

## 🎯 OBJETIVO DE LA FASE 2

Construir las **5 tablas dependientes** (con FK hacia Capa 1). Al terminar:

- ✅ 5 migraciones nuevas.
- ✅ 5 modelos con relaciones completas.
- ✅ 5 controladores con selectores dinámicos.
- ✅ Autenticación adaptada a tabla `usuarios` custom.
- ✅ Middleware de bitácora registrando acciones.

**NO avanzar a FASE 3 hasta completar el 100%.**

---

## ⚠️ REQUISITO PREVIO

FASE 1 completada. Verifica que existan las tablas:
`roles`, `categoria_producto`, `clientes`, `vehiculos`, `distribuidores`.

---

## 🧱 STACK TECNOLÓGICO (INMUTABLE)

| Capa | Tecnología |
|:---|:---|
| Backend | Laravel 11 (PHP 8.2+) |
| Frontend | Blade + Tailwind CSS + Alpine.js |
| Base de datos | MySQL 8.0 |
| Autenticación | Laravel Breeze (Blade) |

**PROHIBIDO:** Livewire, Inertia, React, Vue.

---

## 📋 TABLAS A CONSTRUIR (orden obligatorio)

| Orden | Tabla | Depende de |
|:---:|:---|:---|
| 1 | `usuarios` | `roles` |
| 2 | `productos` | `categoria_producto` |
| 3 | `pedidos` | `clientes` |
| 4 | `hoja_despacho` | `vehiculos`, `distribuidores` |
| 5 | `bitacora_acciones` | `usuarios` |

---

## 🗄️ ESQUEMA DETALLADO

### 1. `usuarios`
| Columna | Tipo | Restricción |
|:---|:---|:---|
| id_usuario | bigint unsigned | PK, autoincrement |
| id_rol | bigint unsigned | FK → roles.id_rol |
| username | varchar(50) | UNIQUE, NOT NULL |
| password_hash | varchar(255) | NOT NULL |
| nombres | varchar(60) | NOT NULL |
| apellidos | varchar(60) | NOT NULL |
| email | varchar(100) | UNIQUE, NOT NULL |
| estado | varchar(20) | DEFAULT 'Activo' |
| timestamps | - | - |
| deleted_at | timestamp | NULL (SoftDeletes) |

**Modelo:** `User` (adaptar el default de Breeze)
- `$table = 'usuarios'`
- `$primaryKey = 'id_usuario'`
- `getAuthPassword()` devuelve `password_hash`
- `belongsTo(Rol::class)`, `hasMany(BitacoraAccion::class)`
- `SoftDeletes`

### 2. `productos`
| Columna | Tipo | Restricción |
|:---|:---|:---|
| id_producto | bigint unsigned | PK, autoincrement |
| id_categoria | bigint unsigned | FK → categoria_producto.id_categoria |
| nombre_producto | varchar(80) | NOT NULL |
| precio_unitario | decimal(10,2) | NOT NULL, > 0 |
| peso_kg | decimal(8,3) | NOT NULL, > 0 |
| stock_disponible | int | DEFAULT 0, >= 0 |
| estado | varchar(20) | DEFAULT 'Activo' |
| timestamps | - | - |
| deleted_at | timestamp | NULL (SoftDeletes) |

**Modelo:** `Producto` → `belongsTo(CategoriaProducto)`, `hasMany(DetallePedido)`, `SoftDeletes`

### 3. `pedidos`
| Columna | Tipo | Restricción |
|:---|:---|:---|
| id_pedido | bigint unsigned | PK, autoincrement |
| id_cliente | bigint unsigned | FK → clientes.id_cliente |
| fecha_pedido | datetime | NOT NULL |
| fecha_entrega_est | date | NOT NULL |
| total_pagar | decimal(10,2) | DEFAULT 0 |
| saldo_pendiente | decimal(10,2) | DEFAULT 0 |
| estado_pedido | varchar(25) | DEFAULT 'Pendiente' |
| timestamps | - | - |

**Modelo:** `Pedido` → `belongsTo(Cliente)`, `hasMany(DetallePedido)`

### 4. `hoja_despacho`
| Columna | Tipo | Restricción |
|:---|:---|:---|
| id_despacho | bigint unsigned | PK, autoincrement |
| id_distribuidor | bigint unsigned | FK → distribuidores.id_distribuidor |
| id_vehiculo | bigint unsigned | FK → vehiculos.id_vehiculo |
| fecha_despacho | date | NOT NULL |
| hora_salida | time | NOT NULL |
| hora_llegada | time | NULL |
| kilometraje_inicial | int | NOT NULL, >= 0 |
| kilometraje_final | int | NULL, >= inicial |
| carga_total_kg | decimal(8,2) | DEFAULT 0 |
| estado_despacho | varchar(25) | DEFAULT 'Programado' |
| timestamps | - | - |

**Modelo:** `HojaDespacho` → `belongsTo(Distribuidor)`, `belongsTo(Vehiculo)`, `hasMany(DetalleDespacho)`

### 5. `bitacora_acciones`
| Columna | Tipo | Restricción |
|:---|:---|:---|
| id_bitacora | bigint unsigned | PK, autoincrement |
| id_usuario | bigint unsigned | FK → usuarios.id_usuario |
| accion | varchar(100) | NOT NULL |
| tabla_afectada | varchar(50) | NOT NULL |
| fecha_hora | datetime | NOT NULL |
| ip_acceso | varchar(45) | NOT NULL |
| timestamps | - | - |

**Modelo:** `BitacoraAccion` → `belongsTo(User)`

---

## 📜 REGLAS DE NEGOCIO APLICABLES

### Productos
- **RN-04:** `precio_unitario` > 0.
- **RN-05:** `peso_kg` > 0.
- **RN-06:** `stock_disponible` nunca negativo.
- **RN-09:** No vender más que `stock_disponible`.
- **RN-10:** Producto con stock = 0 → estado 'Sin Stock'.

### Pedidos
- **RN-14:** `total_pagar` = SUMA(subtotales detalle_pedido).
- **RN-15:** `saldo_pendiente` inicia igual a `total_pagar`.
- **RN-18:** `fecha_entrega_est` >= `fecha_pedido`.
- **RN-19:** Estados: Pendiente, En Despacho, Entregado, Rechazado, Pagado, Cancelado.
- **RN-20:** Pedido cancelado no puede tener despachos activos.

### Hoja de Despacho
- **RN-32:** `kilometraje_final` >= `kilometraje_inicial`.
- **RN-33:** `carga_total_kg` no excede capacidad del vehículo.
- **RN-34:** Estados: Programado, En Ruta, Completado, Cancelado.
- **RN-35:** No crear despacho con vehículo ya asignado el mismo día.
- **RN-36:** Al iniciar ruta, registrar `hora_salida`, vehículo → 'En Ruta'.
- **RN-37:** Al completar ruta, registrar `hora_llegada`, vehículo → 'Disponible'.

### Usuarios
- **RN-45:** `username` y `email` únicos.
- **RN-46:** `password_hash` con bcrypt.
- **RN-47:** No eliminar el último Admin.
- **RN-48:** Usuario inactivo no puede iniciar sesión.

### Bitácora
- **RN-49:** Toda acción CRUD se registra automáticamente.
- **RN-50:** No se edita ni elimina.
- **RN-51:** Registra: usuario, acción, tabla, fecha_hora, ip_acceso.

---

## 🎨 REGLAS UI/UX (Tailwind)

- **Layout:** `<x-app-layout>` con sidebar y navbar.
- **Paleta:** indigo-600, green-600, red-600, yellow-500, blue-500.
- **Componentes:** `<x-card>`, `<x-button>`, `<x-alert>`, `<x-input>`, `<x-select>`, `<x-badge>`.
- **Badges:** Activo/Pagado/Completado → verde; Inactivo/Cancelado → rojo; Pendiente → amarillo; En Despacho/En Ruta/Programado → azul.
- **Selectores dinámicos:** los `<select>` cargan datos de tablas padre vía `compact()` desde el controlador.
- **Formularios:** grid 2 columnas, `@error` visible.

---

## 📐 CONVENCIONES DE CÓDIGO

- **Modelos:** PascalCase singular (`Producto`, `HojaDespacho`).
- **Tablas:** snake_case plural (`productos`, `hoja_despacho`).
- **Controladores:** `{Modelo}Controller`.
- **FormRequests:** `Store{Modelo}Request`, `Update{Modelo}Request`.
- **Rutas:** `Route::resource()` con middleware `auth`.
- **Idioma:** código en inglés, vistas en español.

---

## 🚫 RESTRICCIONES ESTRICTAS

❌ NO crear tablas de FASE 3 (`detalle_pedido`, `detalle_despacho`).
❌ NO modificar columnas de FASE 1.
❌ NO tocar la lógica de login/registro de Breeze.
❌ NO usar Livewire, Inertia, React ni Vue.
❌ NO asumir reglas: si algo no está aquí, PREGUNTAR.
❌ NO avanzar de módulo sin probar el anterior.

---

## 📝 FORMATO DE RESPUESTA ESPERADO

1. Explicación breve (máx. 5 líneas).
2. Archivos con ruta exacta como título.
3. Comandos a ejecutar.
4. Instrucciones de prueba.
5. Pregunta de confirmación.

---

## 📦 ENTREGABLES POR MÓDULO

1. Migración.
2. Modelo Eloquent con `$fillable`, `$casts`, relaciones, SoftDeletes cuando aplique.
3. Controlador Resource (7 métodos).
4. Form Requests Store + Update.
5. Vistas Blade con selectores dinámicos.
6. Rutas.
7. Seeder con datos demo.
8. Prueba funcional.

---

## ✅ CRITERIO DE CIERRE DE FASE 2

- [ ] `php artisan migrate:fresh --seed` corre sin error.
- [ ] Los 5 módulos funcionan en navegador.
- [ ] Login funciona con tabla `usuarios` custom.
- [ ] Selectores dinámicos cargan datos correctamente.
- [ ] Middleware de bitácora registra cada acción CRUD.
- [ ] Sin errores en `storage/logs/laravel.log`.

---

## 🎬 PROMPTS DE EJECUCIÓN

### PROMPT 2.1 — Usuarios + Autenticación
```
Ejecuta la FASE 2.1: Módulo Usuarios y adaptación de autenticación.

Contexto: Breeze instalado en FASE 0. El modelo User default debe
adaptarse a nuestra tabla `usuarios`.

Entrega:
1. Migración modify_users_to_usuarios que:
   - Renombra tabla a `usuarios`
   - Renombra PK a id_usuario
   - Agrega id_rol (FK), username, password_hash
   - Renombra name → nombres, agrega apellidos
   - Agrega estado, softDeletes
2. Modelo User adaptado:
   - protected $table = 'usuarios'
   - protected $primaryKey = 'id_usuario'
   - getAuthPassword() → password_hash
   - belongsTo(Rol::class)
3. UsuarioController (resource)
4. StoreUsuarioRequest + UpdateUsuarioRequest
5. Vistas: index, create, edit, show con select de rol
6. Rutas protegidas con auth middleware
7. UsuarioAdminSeeder: admin / admin@princesa.com / password

Reglas: RN-45 a RN-48.
Restricciones: NO tocar la lógica de login/registro de Breeze.
Al final, dime cómo probar el login con el admin.
```

### PROMPT 2.2 — Productos
```
Ejecuta la FASE 2.2: Módulo Productos.

Entrega:
1. Migración create_productos_table (softDeletes)
2. Modelo Producto (belongsTo CategoriaProducto, hasMany DetallePedido)
3. ProductoController (resource)
4. Store + Update FormRequests:
   - precio_unitario > 0
   - peso_kg > 0
   - stock_disponible >= 0
   - id_categoria exists:categoria_producto,id_categoria
5. Vistas: index con filtro por categoría y estado, create, edit, show
6. Rutas
7. Seeder con 10 productos demo en las 5 categorías.

Reglas: RN-04 a RN-10.
Al final, dime cómo probarlo.
```

### PROMPT 2.3 — Pedidos (Cabecera)
```
Ejecuta la FASE 2.3: Módulo Pedidos — SOLO CABECERA.

IMPORTANTE: NO crear detalle_pedido (va en FASE 3).

Entrega:
1. Migración create_pedidos_table
2. Modelo Pedido (belongsTo Cliente, hasMany DetallePedido declarada)
3. PedidoController (resource)
4. Store + Update FormRequests:
   - id_cliente exists
   - fecha_entrega_est >= fecha_pedido
5. Vistas: index con filtro por estado, create con select de cliente, show
6. Rutas

Reglas: RN-14 a RN-20 (aplicables a cabecera).
Nota: total_pagar y saldo_pendiente se calculan en FASE 3.
Al final, dime cómo probarlo.
```

### PROMPT 2.4 — Hoja de Despacho (Cabecera)
```
Ejecuta la FASE 2.4: Módulo Hoja de Despacho — SOLO CABECERA.

Entrega:
1. Migración create_hoja_despacho_table
2. Modelo HojaDespacho (belongsTo Distribuidor, Vehiculo; hasMany DetalleDespacho)
3. HojaDespachoController (resource)
4. Store + Update FormRequests:
   - id_distribuidor exists
   - id_vehiculo exists
   - kilometraje_inicial >= 0
   - hora_salida required
5. Vistas: index con filtro por estado, create con selectores, show
6. Rutas

Reglas: RN-32 a RN-37 (aplicables a cabecera).
Al final, dime cómo probarlo.
```

### PROMPT 2.5 — Bitácora
```
Ejecuta la FASE 2.5: Módulo Bitácora de Acciones.

Entrega:
1. Migración create_bitacora_acciones_table
2. Modelo BitacoraAccion (belongsTo User)
3. Middleware RegistrarBitacora:
   - Se ejecuta después de requests que modifiquen datos.
   - Captura: usuario autenticado, acción (crear/editar/eliminar),
     tabla afectada, ip.
4. BitacoraController (solo index y show)
5. Vista index con filtros por usuario, tabla y fecha
6. Rutas

Reglas: RN-49 a RN-51.
Restricciones: NO permitir editar ni eliminar bitácora.
Al final, dime cómo probarlo creando un producto y verificando el registro.
```

### PROMPT DE CIERRE
```
FASE 2 completada. Verifica:
1. php artisan migrate:fresh --seed corre sin error.
2. Los 5 módulos funcionan en el navegador.
3. Login funciona con tabla usuarios custom.
4. Middleware de bitácora registra acciones.

Genera resumen y guárdalo como docs/FASE_2_RESUMEN.md
```