# Metodología de Trabajo: Scrum Adaptado (Sprints individuales)

## 1. Justificación
Para este proyecto individual se elige una adaptación ágil de **Scrum**. 

* **Alcance escolar y entregas progresivas:** Al trabajar con Laravel, el desarrollo se divide de forma natural en capas (migraciones/modelos, controladores y vistas Blade).
* **Ciclos de trabajo (Sprints):** Permite organizar las tareas en bloques pequeños y alcanzables sin saturarse:
  1. Base de datos y autenticación con roles.
  2. Registro y consulta de pedidos.
  3. Módulo de logística (carga de fotos y cambios de estado).

---

## 2. Planificación de Sprints

* **Sprint 1: Modelado y Acceso Base**
  * Creación de migraciones y modelos en Laravel.
  * Autenticación básica con control de roles (Admin, Ventas, Compras, Almacén, Ruta).
  * Pantalla pública para que los clientes consulten su estatus con su número y factura.

* **Sprint 2: Flujo Operativo y Pedidos**
  * Formulario para que Ventas capture los pedidos (datos fiscales, folio, dirección).
  * Dashboard para que Almacén cambie el estatus a "In process" o reporte faltantes a Compras.
  * Pantalla de listado con filtros (folio, cliente, estatus).

* **Sprint 3: Ruta y Auditoría**
  * Vista exclusiva de Ruta con subida de imágenes (carga y comprobante de entrega).
  * Cambio de estatus a "In route" y "Delivered".
  * Implementación del borrado lógico (`SoftDeletes` de Laravel) y pantalla de restauración.