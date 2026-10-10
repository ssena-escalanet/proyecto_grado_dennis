
---

## 📄 ARCHIVO 2: `docs/01_DATABASE_SCHEMA.md`

```markdown
# ESQUEMA DE BASE DE DATOS — 3FN

## Diagrama relacional (Mermaid)

```mermaid
erDiagram
    ROLES ||--o{ USUARIOS : asigna
    USUARIOS ||--o{ BITACORA_ACCIONES : registra
    CATEGORIA_PRODUCTO ||--o{ PRODUCTOS : clasifica
    PRODUCTOS ||--o{ DETALLE_PEDIDO : incluye
    CLIENTES ||--o{ PEDIDOS : realiza
    PEDIDOS ||--o{ DETALLE_PEDIDO : contiene
    VEHICULOS ||--o{ HOJA_DESPACHO : asignado
    DISTRIBUIDORES ||--o{ HOJA_DESPACHO : conduce
    HOJA_DESPACHO ||--o{ DETALLE_DESPACHO : detalla
    DETALLE_PEDIDO ||--o{ DETALLE_DESPACHO : se_entrega