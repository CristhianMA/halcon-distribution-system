# Distribuidora Halcón - Sistema de Gestión y Rastreo de Pedidos

Plataforma web para la automatización de procesos internos, control logístico y seguimiento de pedidos en tiempo real para clientes y personal operativo.

---

## Información del Proyecto
* **Desarrollador:** Maximus Cristian Hernandez Garcia[cite: 13]
* **Rol:** Análisis de Requerimientos, Arquitectura de Software, Modelado de Datos y Desarrollo Full Stack[cite: 13]

---

## Alcance del Sistema
* **Portal Público de Clientes:** Rastreo de pedidos mediante número de cliente y folio de factura[cite: 13].
* **Control de Acceso Basado en Roles (RBAC):** Módulos administrativos para Ventas, Compras, Almacén, Ruta y Administración[cite: 13].
* **Ciclo de Vida del Pedido:** Flujo secuencial guiado (*Ordered* ➔ *In process* ➔ *In route* ➔ *Delivered*)[cite: 13].
* **Gestión de Evidencias en Ruta:** Registro fotográfico de unidad cargada y comprobante de entrega en destino[cite: 13].
* **Auditoría y Seguridad:** Borrado lógico (*soft delete*) y pantalla de restauración de pedidos[cite: 13].

---

## Diagrama Entidad-Relación (DER)

A continuación se presenta el modelo relacional implementado en la base de datos MySQL mediante migraciones de Laravel[cite: 11, 21]:

![Diagrama Entidad-Relación](docs/diagrams/Diagrama%20Entidad-Relación%20(DER).png)

---

## Flujo de Trabajo en Git (GitFlow)
* `main`: Rama de producción con versiones estables[cite: 13].
* `develop`: Rama de integración principal[cite: 13].
* `feature/<nombre>`: Ramas por funcionalidad específica (ej. `feature/auth-rbac`, `feature/order-tracking`)[cite: 13].

### Convención de Commits (Conventional Commits)
* `feat:` Nueva funcionalidad para el usuario[cite: 13].
* `fix:` Corrección de errores[cite: 13].
* `docs:` Cambios o adición de documentación y diagramas[cite: 13].
* `style:` Ajustes visuales o de formato sin alterar lógica[cite: 13].
* `refactor:` Optimización de código sin alterar comportamiento[cite: 13].

---

## Estructura del Repositorio
* `/docs`: Especificación de requerimientos y diagramas del sistema (BPMN, UML, DER)[cite: 13].
* `/src`: Código fuente de la solución desarrollado en Laravel[cite: 13].