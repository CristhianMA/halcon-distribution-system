# Elección y Justificación de la Base de Datos

## 1. Motor Seleccionado: MySQL (Relacional / SQL)

Para el desarrollo del sistema web de la distribuidora "Halcón", se selecciona **MySQL** como motor de base de datos relacional (RDBMS), integrándose de forma nativa con **Laravel Eloquent ORM**.

### Justificación Técnica:
* **Integridad Transaccional (ACID):** El negocio maneja folios correlativos de factura, control estricto de inventario y cambios de estatus. Un motor relacional asegura consistencia en las transacciones sin pérdida de datos.
* **Control de Borrado Lógico (Soft Delete):** Permite auditoría con marcas de tiempo (`deleted_at`, `is_deleted`) para pedidos cancelados sin eliminarlos de la base de datos.
* **Manejo Eficiente de Evidencias:** Las imágenes de carga y entrega se almacenan en el sistema de archivos del servidor, guardando únicamente rutas relativas (`VARCHAR`) en la base de datos.

---

## 2. Entidades y Relaciones

1. **`roles`:** Define los departamentos internos (`Admin`, `Ventas`, `Compras`, `Almacén`, `Ruta`).
   * Relación: Un rol se asigna a muchos usuarios (1 a N con `users`).
2. **`users`:** Personal interno que accede al Dashboard administrativo.
   * Relación: Un usuario de Ventas registra pedidos (1 a N con `orders`).
3. **`customers`:** Clientes de Halcón con su número identificador, razón social y datos fiscales.
   * Relación: Un cliente puede tener múltiples pedidos asociados (1 a N con `orders`).
4. **`materials`:** Catálogo de materiales de construcción con código único, descripción, precio y existencia actual en almacén (`stock`).
   * Relación: Un material puede aparecer en múltiples renglones de pedidos (1 a N con `order_details`).
5. **`orders`:** Entidad principal que almacena el folio de factura, estatus del ciclo de vida, dirección de entrega, notas y rutas de fotografías de evidencia.
   * Relación: Un pedido agrupa uno o más detalles de pedido (1 a N con `order_details`).
6. **`order_details`:** Tabla intermedia que desglosa los materiales solicitados, la cantidad y el precio unitario pactado para cada orden.
   * Relación: Pertenece a un pedido específico y referencia a un material del catálogo.

---

## 3. Diagrama Entidad-Relación (DER)
El diagrama actualizado se encuentra almacenado en la ruta:
`docs/diagrams/Diagrama Entidad-Relación (DER).png`