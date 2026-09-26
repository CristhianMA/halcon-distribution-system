#  Distribuidora Halcón - Sistema de Gestión y Rastreo de Pedidos

Plataforma web para la automatización de procesos internos, control logístico y seguimiento de pedidos en tiempo real para clientes y personal operativo.

---

##  Información del Proyecto
* **Desarrollador:** Maximus Cristian Hernandez Garcia
* **Rol:** Análisis de Requerimientos, Arquitectura de Software, Modelado de Datos y Desarrollo Full Stack

---

##  Alcance del Sistema
* **Portal Público de Clientes:** Rastreo de pedidos mediante número de cliente y folio de factura.
* **Control de Acceso Basado en Roles (RBAC):** Módulos administrativos para Ventas, Compras, Almacén, Ruta y Administración.
* **Ciclo de Vida del Pedido:** Flujo secuencial guiado (*Ordered* ➔ *In process* ➔ *In route* ➔ *Delivered*).
* **Gestión de Evidencias en Ruta:** Registro fotográfico de unidad cargada y comprobante de entrega en destino.
* **Auditoría y Seguridad:** Borrado lógico (*soft delete*) y pantalla de restauración de pedidos.

---

##  Flujo de Trabajo en Git (GitFlow)
* `main`: Rama de producción con versiones estables.
* `develop`: Rama de integración principal.
* `feature/<nombre>`: Ramas por funcionalidad específica (ej. `feature/auth-rbac`, `feature/order-tracking`).

### Convención de Commits (Conventional Commits)
* `feat:` Nueva funcionalidad para el usuario.
* `fix:` Corrección de errores.
* `docs:` Cambios o adición de documentación y diagramas.
* `style:` Ajustes visuales o de formato sin alterar lógica.
* `refactor:` Optimización de código sin alterar comportamiento.

---

##  Estructura del Repositorio
* `/docs`: Especificación de requerimientos y diagramas del sistema (BPMN, UML, DER).
* `/src`: Código fuente de la solución.