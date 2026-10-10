# GUÍA UI/UX — Blade + Tailwind CSS

## Layout base
- Componente `<x-app-layout>` con:
  - Sidebar fijo a la izquierda (colapsable en móvil).
  - Navbar superior con nombre de usuario + logout.
  - Área de contenido con padding consistente.
  - Slot de título `<x-slot name="header">`.

## Paleta de colores
- Primario: `indigo-600` (botones principales).
- Éxito: `green-600` (estados Activos).
- Peligro: `red-600` (Eliminar, Rechazado).
- Advertencia: `yellow-500` (Pendiente).
- Info: `blue-500` (En Ruta).
- Neutro: `gray-50` a `gray-900`.

## Componentes reutilizables
- `<x-card>` — contenedor blanco con sombra.
- `<x-button>` — botones con variantes (primary, danger, secondary).
- `<x-alert>` — mensajes flash (success, error, warning, info).
- `<x-input>` — input con label y `@error`.
- `<x-select>` — select con opciones dinámicas.
- `<x-badge>` — estados con color.

## Tablas de datos
- Encabezados con fondo `gray-100`.
- Filas alternas (`even:bg-gray-50`).
- Paginación con `{{ $items->links() }}`.
- Botones de acción: Ver (ojo), Editar (lápiz), Eliminar (basura).
- Estados con `<x-badge>` de color.

## Formularios
- Grid de 2 columnas en desktop, 1 en móvil.
- Inputs con `focus:ring-indigo-500`.
- `@error` visible bajo cada campo en rojo.
- Botones "Guardar" y "Cancelar" al final.

## Mensajes al usuario
- Success: "Registro creado correctamente".
- Error: "No se pudo guardar. Revisa los campos".
- Warning: "El stock está por agotarse".
- Confirmación antes de eliminar con `onsubmit="return confirm(...)"`.