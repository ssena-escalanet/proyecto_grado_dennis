# 08 — PROMPTS FASE 3 (Capa Detalle/Pivote)
## Sistema Chocolates Princesa

---

## 🎯 OBJETIVO DE LA FASE 3

Construir las **2 tablas pivote/detalle** que representan la ejecución final
del negocio: pedidos con múltiples productos y despachos con múltiples entregas.

Al terminar, debes tener:
- ✅ 2 migraciones nuevas.
- ✅ 2 modelos con relaciones completas.
- ✅ Servicios `PedidoService` y `DespachoService`.
- ✅ Vistas Blade con filas dinámicas (Alpine.js).
- ✅ Lógica de transacciones DB.
- ✅ Descuento de stock y actualización de saldos.

**Es la fase más crítica. Máxima atención.**

---

## ⚠️ REQUISITO PREVIO

FASE 1 y FASE 2 completadas. Verifica que existan las tablas:
`pedidos`, `productos`, `hoja_despacho`, `clientes`, `vehiculos`, `distribuidores`.

---

## 🧱 STACK TECNOLÓGICO (INMUTABLE)

| Capa | Tecnología |
|:---|:---|
| Backend | Laravel 11 (PHP 8.2+) |
| Frontend | Blade + Tailwind CSS + Alpine.js |
| Base de datos | MySQL 8.0 |

**PROHIBIDO:** Livewire, Inertia, React, Vue.

---

## 📋 TABLAS A CONSTRUIR (orden obligatorio)

| Orden | Tabla | Une |
|:---:|:---|:---|
| 1 | `detalle_pedido` | `pedidos` + `productos` |
| 2 | `detalle_despacho` | `hoja_despacho` + `detalle_pedido` |

---

## 🗄️ ESQUEMA DETALLADO

### 1. `detalle_pedido`
| Columna | Tipo | Restricción |
|:---|:---|:---|
| id_detalle_pedido | bigint unsigned | PK, autoincrement |
| id_pedido | bigint unsigned | FK → pedidos.id_pedido (ON DELETE CASCADE) |
| id_producto | bigint unsigned | FK → productos.id_producto |
| cantidad | int | NOT NULL, > 0 |
| precio_venta | decimal(10,2) | NOT NULL, > 0 |
| subtotal | decimal(10,2) | NOT NULL, > 0 |
| timestamps | - | - |

**Modelo:** `DetallePedido`
- `belongsTo(Pedido::class)`
- `belongsTo(Producto::class)`
- `hasMany(DetalleDespacho::class)`
- `$casts`: cantidad (int), precio_venta (decimal:2), subtotal (decimal:2)

### 2. `detalle_despacho`
| Columna | Tipo | Restricción |
|:---|:---|:---|
| id_detalle_despacho | bigint unsigned | PK, autoincrement |
| id_despacho | bigint unsigned | FK → hoja_despacho.id_despacho (ON DELETE CASCADE) |
| id_detalle_pedido | bigint unsigned | FK → detalle_pedido.id_detalle_pedido |
| orden_visita | int | NOT NULL, >= 1 |
| hora_entrega | time | NULL |
| estado_entrega | varchar(30) | DEFAULT 'Pendiente' |
| motivo_rechazo | varchar(150) | NULL (obligatorio si estado = Rechazado) |
| monto_cobrado | decimal(10,2) | DEFAULT 0 |
| observaciones | varchar(200) | NULL |
| timestamps | - | - |

**Modelo:** `DetalleDespacho`
- `belongsTo(HojaDespacho::class)`
- `belongsTo(DetallePedido::class)`
- `$casts`: monto_cobrado (decimal:2)

## ⚠️ DECISIÓN CRÍTICA DE DISEÑO
`detalle_despacho` apunta a `detalle_pedido` (NO a `pedidos`).
Razón: permitir entregas parciales y rechazo por producto individual.

---

## 📜 REGLAS DE NEGOCIO APLICABLES

### Detalle Pedido
- **RN-21:** `cantidad` entero > 0.
- **RN-22:** `precio_venta` se toma del `precio_unitario` al momento de la venta.
- **RN-23:** `subtotal` = cantidad × precio_venta.
- **RN-24:** No modificar detalle si el pedido está 'Entregado' o 'Pagado'.

### Detalle Despacho
- **RN-38:** `orden_visita` único dentro del mismo despacho.
- **RN-39:** `estado_entrega`: Pendiente, Entregado, Rechazado, Parcial.
- **RN-40:** Si estado = 'Rechazado', `motivo_rechazo` OBLIGATORIO.
- **RN-41:** `monto_cobrado` no excede `saldo_pendiente` del pedido.
- **RN-42:** Al registrar `monto_cobrado`, actualizar `saldo_pendiente`.
- **RN-43:** Al marcar 'Entregado' con saldo 0, pedido pasa a 'Pagado'.
- **RN-44:** No marcar 'Entregado' sin `hora_entrega`.

### Transversales
- **RN-52:** Operaciones múltiples siempre con `DB::transaction()`.
- **RN-53:** Si falla un paso, rollback completo.
- **RN-54:** Reportes solo lectura.

### Stock (aplicables aquí)
- **RN-07:** Al crear un `detalle_pedido`, se descuenta stock.
- **RN-08:** Al cancelar un pedido, se devuelve stock.
- **RN-09:** No vender más que `stock_disponible`.
- **RN-10:** Producto con stock = 0 → estado 'Sin Stock'.

---

## 🎨 REGLAS UI/UX (Tailwind)

- **Layout:** `<x-app-layout>`.
- **Paleta:** indigo-600, green-600, red-600, yellow-500, blue-500.
- **Componentes:** `<x-card>`, `<x-button>`, `<x-alert>`, `<x-input>`, `<x-select>`, `<x-badge>`.
- **Tabla dinámica (carrito):**
  - Botón "Agregar producto" → añade fila.
  - Cada fila: select producto, cantidad, precio (auto), subtotal (auto), botón eliminar.
  - Pie: total general calculado en JS.
  - Botón "Guardar pedido" → envía array JSON.
- **Pantalla de liquidación:**
  - Estado: Entregado / Rechazado / Parcial.
  - Hora de entrega.
  - Monto cobrado.
  - Motivo rechazo (visible solo si estado = Rechazado).
  - Observaciones.
  - Muestra `saldo_pendiente` del pedido antes de guardar.
- **Badges:** Pendiente → amarillo; Entregado → verde; Rechazado → rojo; Parcial → naranja.

---

## 📐 CONVENCIONES DE CÓDIGO

- **Modelos:** `DetallePedido`, `DetalleDespacho`.
- **Tablas:** `detalle_pedido`, `detalle_despacho`.
- **Controladores:** `DetallePedidoController`, `DetalleDespachoController`.
- **Servicios:** `PedidoService`, `DespachoService` en `app/Services/`.
- **Rutas:** anidadas (`/pedidos/{pedido}/detalles`, `/despachos/{despacho}/detalles`).
- **Idioma:** código en inglés, vistas en español.

---

## 🚫 RESTRICCIONES ESTRICTAS

❌ NO crear nuevas tablas fuera del esquema.
❌ NO modificar columnas de FASE 1 ni FASE 2.
❌ NO usar Livewire, Inertia, React ni Vue.
❌ NO permitir modificar detalles de pedidos 'Entregado' o 'Pagado'.
❌ NO permitir eliminar un detalle ya entregado.
❌ `motivo_rechazo` OBLIGATORIO si estado = 'Rechazado'.
❌ `monto_cobrado` nunca mayor al `saldo_pendiente` del pedido.
❌ `DB::transaction()` OBLIGATORIO en operaciones múltiples.
❌ NO asumir reglas: si algo no está aquí, PREGUNTAR.

---

## 📝 FORMATO DE RESPUESTA ESPERADO

1. Explicación breve (máx. 5 líneas).
2. Archivos con ruta exacta como título.
3. Comandos a ejecutar.
4. Instrucciones de prueba.
5. Pregunta de confirmación.

---

## 📦 ENTREGABLES

### Módulo 3.1 — Detalle Pedido
1. Migración `detalle_pedido`.
2. Modelo `DetallePedido` con relaciones.
3. Servicio `PedidoService::guardarConDetalle()`.
4. `DetallePedidoController` (store, destroy).
5. Vista `pedidos/create.blade.php` modificada con tabla dinámica Alpine.js.
6. Vista `pedidos/show.blade.php` con detalles.
7. Rutas anidadas.

### Módulo 3.2 — Detalle Despacho
1. Migración `detalle_despacho`.
2. Modelo `DetalleDespacho` con relaciones.
3. Servicio `DespachoService::cargarPedidos()` y `liquidarEntrega()`.
4. `DetalleDespachoController` (index, create, store, edit, update, destroy).
5. Vistas Blade para carga y liquidación.
6. Rutas anidadas.

---

## ✅ CRITERIO DE CIERRE DE FASE 3

Prueba end-to-end obligatoria:

1. Crear cliente.
2. Crear 3 productos con stock.
3. Crear pedido con 2 productos → verificar descuento de stock.
4. Crear vehículo y distribuidor.
5. Crear hoja de despacho.
6. Cargar el pedido a la hoja.
7. Liquidar: 1 producto Entregado, 1 Rechazado.
8. Verificar:
   - [ ] Stock descontado correctamente.
   - [ ] Saldo pendiente actualizado.
   - [ ] Bitácora registró todas las acciones.
   - [ ] Sin errores en logs.

---

## 🎬 PROMPTS DE EJECUCIÓN

### PROMPT 3.1 — Detalle Pedido (Carrito interno)
```
Ejecuta la FASE 3.1: Módulo Detalle de Pedido.

Esta es tabla pivote que une PEDIDOS con PRODUCTOS.
UI funciona como carrito interno con filas dinámicas.

Entrega:
1. Migración create_detalle_pedido_table
   - FK id_pedido → pedidos (CASCADE)
   - FK id_producto → productos
2. Modelo DetallePedido:
   - belongsTo Pedido, Producto
   - hasMany DetalleDespacho
   - $casts: cantidad (int), precio_venta (decimal:2), subtotal (decimal:2)
3. Servicio PedidoService::guardarConDetalle(Pedido $pedido, array $detalles):
   - DB::transaction()
   - Por cada detalle:
     * Validar stock suficiente
     * Calcular subtotal = cantidad × precio_venta
     * Crear DetallePedido
     * Descontar stock del producto
   - Calcular total_pagar = SUMA(subtotales)
   - Actualizar saldo_pendiente = total_pagar
   - Si producto queda sin stock, estado → 'Sin Stock'
4. DetallePedidoController:
   - store: recibe array de detalles
   - destroy: elimina un detalle y devuelve stock
5. Vista pedidos/create.blade.php modificada:
   - Cabecera (cliente, fecha)
   - Tabla dinámica Alpine.js:
     * Botón "Agregar producto"
     * Por fila: select producto, cantidad, precio (auto), subtotal
     * Botón eliminar
   - Pie: total general en JS
   - Envío en array JSON
6. Vista pedidos/show.blade.php:
   - Cabecera + tabla detalles
   - Botón "Agregar productos" si estado = 'Pendiente'
   - Botón "Confirmar pedido" → estado = 'En Despacho'
7. Rutas:
   - POST /pedidos/{pedido}/detalles
   - DELETE /pedidos/{pedido}/detalles/{detalle}
   - GET /pedidos/{pedido}/confirmar

Reglas: RN-21 a RN-24, RN-07 a RN-10, RN-14 a RN-17.
Restricciones:
- DB::transaction() obligatorio.
- NO modificar detalles si pedido 'Entregado' o 'Pagado'.
Al final, dime cómo probarlo con un pedido de 3 productos.
```

### PROMPT 3.2 — Detalle Despacho (Liquidación de rutas)
```
Ejecuta la FASE 3.2: Módulo Detalle de Despacho.

Tabla pivote que une HOJA_DESPACHO con DETALLE_PEDIDO.
Permite liquidar entregas (Entregado / Rechazado / Parcial).

Entrega:
1. Migración create_detalle_despacho_table
   - FK id_despacho → hoja_despacho (CASCADE)
   - FK id_detalle_pedido → detalle_pedido
   - Campo orden_visita (int)
2. Modelo DetalleDespacho:
   - belongsTo HojaDespacho, DetallePedido
   - $casts: monto_cobrado (decimal:2)
3. Servicio DespachoService:
   - cargarPedidos(HojaDespacho $despacho, array $idsDetallePedido):
     * Validar que detalles pertenezcan a pedidos pendientes
     * Validar capacidad del vehículo
     * Crear DetalleDespacho con orden_visita incremental
     * Actualizar carga_total_kg del despacho
   - liquidarEntrega(DetalleDespacho $detalle, array $datos):
     * DB::transaction()
     * Registrar hora_entrega
     * Cambiar estado_entrega
     * Si Rechazado: motivo_rechazo obligatorio
     * Registrar monto_cobrado (validar <= saldo_pendiente)
     * Actualizar saldo_pendiente del pedido padre
     * Si saldo = 0, estado_pedido → 'Pagado'
     * Si es última entrega, despacho → 'Completado'
4. DetalleDespachoController:
   - index: lista de detalles de un despacho
   - create: pantalla para agregar pedidos pendientes
   - store: usa DespachoService::cargarPedidos
   - edit: pantalla de liquidación por detalle
   - update: usa DespachoService::liquidarEntrega
   - destroy: quita detalle (solo si no se ha entregado)
5. Vistas:
   - despachos/detalles/index.blade.php: lista de paradas con orden_visita
   - despachos/detalles/create.blade.php:
     * Lista de detalles de pedidos pendientes (checkboxes)
     * Selector de orden (input numérico)
     * Validación visual de capacidad del vehículo
   - despachos/detalles/edit.blade.php:
     * Formulario liquidación:
       - Estado: Entregado / Rechazado / Parcial
       - Hora de entrega
       - Monto cobrado
       - Motivo rechazo (visible solo si Rechazado)
       - Observaciones
     * Muestra saldo_pendiente del pedido antes de guardar
6. Rutas:
   - GET /despachos/{despacho}/detalles
   - GET /despachos/{despacho}/detalles/create
   - POST /despachos/{despacho}/detalles
   - GET /despachos/{despacho}/detalles/{detalle}/edit
   - PUT /despachos/{despacho}/detalles/{detalle}
   - DELETE /despachos/{despacho}/detalles/{detalle}

Reglas: RN-38 a RN-44.
Restricciones:
- DB::transaction() obligatorio.
- No eliminar detalle ya entregado.
- motivo_rechazo obligatorio si estado = 'Rechazado'.
- monto_cobrado nunca mayor al saldo_pendiente.
Al final, dime cómo probarlo:
1. Crear despacho.
2. Cargar 2 pedidos pendientes.
3. Liquidar uno Entregado y otro Rechazado.
4. Verificar actualización de saldos.
```

### PROMPT DE CIERRE
```
FASE 3 completada. Prueba end-to-end:

1. Crear cliente.
2. Crear 3 productos con stock.
3. Crear pedido con 2 productos → verificar descuento de stock.
4. Crear vehículo y distribuidor.
5. Crear hoja de despacho.
6. Cargar pedido a la hoja.
7. Liquidar: 1 Entregado, 1 Rechazado.
8. Verificar:
   - Stock descontado.
   - Saldo pendiente actualizado.
   - Bitácora registró todo.
   - Sin errores en logs.

Genera resumen y guárdalo como docs/FASE_3_RESUMEN.md
```