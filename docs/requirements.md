# Especificación de Requerimientos de Software (Distribuidora Halcón)

## 1. Requerimientos Funcionales (RF)

### Módulo Público (Clientes)
* **RF01 - Consulta de Estatus:** El sistema debe permitir a cualquier cliente consultar el estado actual de su pedido ingresando únicamente su **Número de Cliente** y **Folio de Factura**, sin necesidad de iniciar sesión.

### Módulo de Administración y Accesos
* **RF02 - Usuario Administrador por Defecto:** El sistema debe contar con un usuario administrador inicial con permisos para crear nuevos usuarios internos y asignar roles departamentales.
* **RF03 - Control de Acceso por Roles (RBAC):** Se restringe el acceso a la plataforma interna según los siguientes departamentos:
  * **Ventas:** Levantamiento y edición de pedidos.
  * **Almacén:** Preparación de pedidos y coordinación logística.
  * **Compras:** Adquisición de materiales sin stock con proveedores externos.
  * **Ruta:** Consulta de entregas y carga de evidencias fotográficas.

### Módulo de Operación y Pedidos
* **RF04 - Registro de Pedidos:** El departamento de Ventas debe registrar nuevos pedidos capturando: folio correlativo de factura, nombre o razón social, número único de cliente, datos fiscales, fecha y hora, dirección de entrega y notas adicionales.
* **RF05 - Ciclo de Vida del Pedido:** El pedido debe transitar por los siguientes estados:
  1. `Ordered`: Estado asignado por defecto al registrarse el pedido.
  2. `In process`: Asignado por Almacén al comenzar la preparación o solicitar material a Compras.
  3. `In route`: Asignado por Almacén cuando la unidad se encuentra cargada.
  4. `Delivered`: Asignado por Ruta tras descargar el material con el cliente.
* **RF06 - Evidencias Fotográficas:** 
  * El módulo de carga de fotos debe ser visible exclusivamente para el personal de **Ruta**.
  * Se requiere una fotografía al cargar la unidad y una fotografía al descargar el material entregado.
* **RF07 - Filtros y Búsqueda:** La pantalla de pedidos activos debe permitir búsquedas por Número de Factura, Número de Cliente, Fecha y Estatus.
* **RF08 - Borrado Lógico y Restauración:** 
  * Los pedidos cancelados no se eliminan físicamente de la base de datos (*Soft Delete*).
  * El sistema debe contar con una vista específica para consultar, editar y restaurar pedidos dados de baja.

---

## 2. Requerimientos No Funcionales (RNF)

* **RNF01 - Seguridad:** Ningún cliente externo puede registrarse ni acceder al panel administrativo interno.
* **RNF02 - Integridad Transaccional:** El folio de factura y número de cliente deben ser únicos para evitar colisiones operativas.
* **RNF03 - Almacenamiento Eficiente:** Las fotografías de evidencia se gestionan en el sistema de archivos del servidor, guardando únicamente rutas relativas en la base de datos para optimizar consultas.
* **RNF04 - Disponibilidad:** El módulo público de consulta debe ser accesible de forma ligera desde dispositivos móviles o de escritorio.