
---

## 📄 ARCHIVO 3: `docs/02_BUSINESS_RULES.md`

Este es **el archivo clave** que le da "inteligencia" al agente. Extraído directamente de tu diagrama.

```markdown
# REGLAS DE NEGOCIO — Sistema Chocolates Princesa

Estas reglas son OBLIGATORIAS. El agente IA debe respetarlas en cada controlador, 
servicio y validación. Si una regla no está clara, PREGUNTAR antes de asumir.

## 1. Reglas de CATEGORÍA DE PRODUCTO
- RN-01: `nombre_categoria` es único (no puede repetirse).
- RN-02: No se puede eliminar una categoría con productos asociados.
- RN-03: Solo se puede desactivar (estado = 'Inactivo').

## 2. Reglas de PRODUCTOS
- RN-04: `precio_unitario` debe ser mayor a 0.
- RN-05: `peso_kg` debe ser mayor a 0.
- RN-06: `stock_disponible` nunca puede ser negativo.
- RN-07: Al crear un `detalle_pedido`, se descuenta stock del producto.
- RN-08: Al cancelar un pedido, se devuelve stock a los productos.
- RN-09: No se puede vender más cantidad que `stock_disponible`.
- RN-10: Producto con stock = 0 pasa a estado 'Sin Stock' (pero no se elimina).

## 3. Reglas de CLIENTES
- RN-11: `nit_ci` es único por cliente.
- RN-12: Si se registran coordenadas, ambas (`lat` y `lon`) deben estar presentes.
- RN-13: No se puede eliminar un cliente con pedidos asociados (solo desactivar).

## 4. Reglas de PEDIDOS
- RN-14: `total_pagar` = SUMA(subtotales de `detalle_pedido`).
- RN-15: `saldo_pendiente` inicia igual a `total_pagar`.
- RN-16: Al registrar un cobro, `saldo_pendiente` disminuye.
- RN-17: Si `saldo_pendiente` = 0, `estado_pedido` pasa a 'Pagado'.
- RN-18: `fecha_entrega_est` debe ser >= `fecha_pedido`.
- RN-19: Estados permitidos: Pendiente, En Despacho, Entregado, Rechazado, Pagado, Cancelado.
- RN-20: Un pedido cancelado no puede tener despachos activos.

## 5. Reglas de DETALLE_PEDIDO
- RN-21: `cantidad` debe ser entero mayor a 0.
- RN-22: `precio_venta` se toma del `precio_unitario` del producto al momento de la venta.
- RN-23: `subtotal` = `cantidad` × `precio_venta`.
- RN-24: No se puede modificar `detalle_pedido` si el pedido ya está 'Entregado' o 'Pagado'.

## 6. Reglas de VEHÍCULOS
- RN-25: `placa` es única.
- RN-26: `capacidad_carga_kg` debe ser mayor a 0.
- RN-27: Estados permitidos: Disponible, En Ruta, Mantenimiento.
- RN-28: No se puede asignar un vehículo en 'Mantenimiento' a un despacho.

## 7. Reglas de DISTRIBUIDORES
- RN-29: `ci` es único.
- RN-30: Estados permitidos: Activo, Inactivo, En Ruta.
- RN-31: No se puede asignar un distribuidor inactivo a un despacho.

## 8. Reglas de HOJA_DESPACHO
- RN-32: `kilometraje_final` >= `kilometraje_inicial`.
- RN-33: `carga_total_kg` no puede exceder `capacidad_carga_kg` del vehículo.
- RN-34: Estados permitidos: Programado, En Ruta, Completado, Cancelado.
- RN-35: No se puede crear un despacho con un vehículo ya asignado a otro despacho activo el mismo día.
- RN-36: Al iniciar la ruta, `hora_salida` se registra y el vehículo pasa a 'En Ruta'.
- RN-37: Al completar la ruta, `hora_llegada` se registra y el vehículo vuelve a 'Disponible'.

## 9. Reglas de DETALLE_DESPACHO
- RN-38: `orden_visita` debe ser único dentro de un mismo despacho.
- RN-39: `estado_entrega` permitidos: Pendiente, Entregado, Rechazado, Parcial.
- RN-40: Si `estado_entrega` = 'Rechazado', `motivo_rechazo` es OBLIGATORIO.
- RN-41: `monto_cobrado` no puede exceder el `saldo_pendiente` del pedido asociado.
- RN-42: Al registrar `monto_cobrado`, se actualiza `saldo_pendiente` del pedido padre.
- RN-43: Al marcar 'Entregado', si el pedido queda con saldo 0, pasa a 'Pagado'.
- RN-44: No se puede marcar 'Entregado' sin `hora_entrega` registrada.

## 10. Reglas de USUARIOS
- RN-45: `username` y `email` son únicos.
- RN-46: `password_hash` se guarda con bcrypt.
- RN-47: No se puede eliminar el último usuario con rol 'Admin'.
- RN-48: Un usuario inactivo no puede iniciar sesión.

## 11. Reglas de BITÁCORA
- RN-49: Toda acción CRUD se registra automáticamente.
- RN-50: La bitácora NO se puede editar ni eliminar.
- RN-51: Se registra: usuario, acción, tabla, fecha_hora, ip_acceso.

## 12. Reglas transversales
- RN-52: Ninguna operación que afecte stock + pedido + despacho se ejecuta sin `DB::transaction()`.
- RN-53: Si falla cualquier paso de una transacción, se hace rollback completo.
- RN-54: Los reportes respetan el principio de "solo lectura": no modifican datos.