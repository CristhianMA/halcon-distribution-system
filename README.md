# Distribuidora Halcón - Sistema de Gestión y Rastreo de Pedidos

Plataforma web para la automatización de procesos internos, control logístico y seguimiento de pedidos en tiempo real para clientes y personal operativo.

---

## Información del Proyecto
* **Desarrollador:** Maximus Cristian Hernandez Garcia
* **Rol:** Análisis de Requerimientos, Arquitectura de Software, Modelado de Datos y Desarrollo Full Stack

---

## Alcance del Sistema
* **Portal Público de Clientes:** Rastreo de pedidos mediante número de cliente y folio de factura.
* **Control de Acceso Basado en Roles (RBAC):** Módulos administrativos para Ventas, Compras, Almacén, Ruta y Administración.
* **Ciclo de Vida del Pedido:** Flujo secuencial guiado (*Ordered* ➔ *In process* ➔ *In route* ➔ *Delivered*).
* **Gestión de Evidencias en Ruta:** Registro fotográfico de unidad cargada y comprobante de entrega en destino.
* **Auditoría y Seguridad:** Borrado lógico (*soft delete*) y pantalla de restauración de pedidos.

---

## Diagrama Entidad-Relación (DER)

A continuación se presenta el modelo relacional implementado en la base de datos MySQL mediante migraciones de Laravel:

![Diagrama Entidad-Relación](docs/diagrams/Diagrama%20Entidad-Relación%20(DER).png)

---

## Documentación de la API (Evidencia 2)

### Endpoints Implementados

| Método | Endpoint | Controlador / Acción | Descripción |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/users` | `UserController@index` | Listado paginado de usuarios |
| `POST` | `/api/users` | `UserController@store` | Registro de usuario con validación y asignación de rol |
| `GET` | `/api/users/{id}` | `UserController@show` | Consulta de usuario por ID con relación de rol |
| `PUT` | `/api/users/{id}` | `UserController@update` | Actualización de datos de usuario |
| `DELETE` | `/api/users/{id}` | `UserController@destroy` | Eliminación de usuario |
| `GET` | `/api/orders` | `OrderController@index` | Listado general de órdenes paginado |
| `POST` | `/api/orders` | `OrderController@store` | Creación de orden asociada a cliente y usuario |
| `GET` | `/api/orders/{id}` | `OrderController@show` | Consulta de orden por ID cargando relaciones (`customer`, `user`) |
| `GET` | `/api/orders/invoice/{invoice}` | `OrderController@searchByInvoice` | Búsqueda directa por folio de factura |
| `PUT` | `/api/orders/{id}` | `OrderController@update` | Modificación de estatus (`In route`, etc.) y datos de entrega |
| `DELETE` | `/api/orders/{id}` | `OrderController@destroy` | Borrado lógico (*soft delete*) de la orden |
| `GET` | `/api/orders/archived` | `OrderController@archived` | Consulta del histórico de órdenes archivadas |

### Flujo de Pruebas en Postman
1. **POST `/api/users`:** Registro de operador (`Operador Entrega`), asignándole `role_id: 1` y obteniendo el `id: 5`[cite: 7].
2. **POST `/api/orders`:** Creación de orden asignada al nuevo usuario (`user_id: 5`), con folio `"99901"`, estatus `"Ordered"` y generación del `id: 51`[cite: 10, 12].
3. **GET `/api/orders/51`:** Consulta individual verificando persistencia y relaciones con cliente y operador[cite: 13].
4. **GET `/api/orders/invoice/99901`:** Búsqueda y validación por folio de factura[cite: 10].
5. **PUT `/api/orders/51`:** Actualización de estatus a `"In route"` y cambio de dirección de entrega[cite: 14].
6. **GET `/api/orders/51`:** Verificación de cambios reflejados en base de datos[cite: 15].
7. **DELETE `/api/orders/51`:** Ejecución de borrado lógico (*soft delete*) mediante Eloquent[cite: 16].
8. **GET `/api/orders/archived`:** Comprobación de la orden `51` archivada con marca temporal en `deleted_at`[cite: 18].

---

## Autenticación de Empleados y Control por Roles (Actividad 13)

El registro público (`/register`) se encuentra deshabilitado (`404 Not Found`) para impedir el alta de usuarios externos. El acceso al portal administrativo es exclusivo para personal registrado mediante `/login`.

### Credenciales de Prueba (`php artisan migrate --seed`)

| Rol | Nombre | Correo Corporativo | Contraseña |
| :--- | :--- | :--- | :--- |
| **Admin** | Carlos Administrador | `admin@halcon.com` | `password123` |
| **Ruta** | Route | `ruta@halcon.com` | `password123` |

### Rutas Web Protegidas

| Método | Ruta | Middleware | Descripción |
| :--- | :--- | :--- | :--- |
| `GET` | `/` | Público | Pantalla de rastreo de órdenes para clientes |
| `GET` | `/login` | `guest` | Formulario de inicio de sesión para empleados |
| `GET` | `/dashboard` | `auth` | Panel administrativo dinámico según el rol asignado |
| `GET` | `/admin/users` | `auth`, `role:Admin` | Gestión completa (CRUD) de empleados y asignación de roles |
## Flujo de Trabajo en Git (GitFlow)
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

## Estructura del Repositorio
* `/docs`: Especificación de requerimientos y diagramas del sistema (BPMN, UML, DER).
* `/src`: Código fuente de la solución desarrollado en Laravel.
