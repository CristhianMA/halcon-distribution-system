# 💭 Reflexión Personal sobre el Análisis y Modelado del Proyecto "Halcón"

**Estudiante:** Maximus Cristian Hernandez Garcia  
**Proyecto:** Sistema de Gestión y Rastreo de Pedidos - Distribuidora Halcón  

---

## 1. Importancia del Análisis Previo y el Modelado Visual
El análisis del caso "Halcón" me permitió entender que el desarrollo de software no comienza escribiendo código, sino comprendiendo a fondo el flujo operativo de la empresa. Al inicio parecía un flujo básico de pedidos; sin embargo, al diseñar los diagramas de actividades y BPMN se hicieron evidentes dependencias críticas entre departamentos: qué ocurre cuando no hay stock en almacén, cómo interviene compras con proveedores externos y en qué momentos exactos se debe restringir o permitir la captura de evidencias fotográficas en ruta.

El uso de PlantUML permitió plasmar estas reglas de negocio de manera clara y estructurada, evitando retrabajos durante la fase de desarrollo.

---

## 2. Decisiones Arquitectónicas y de Seguridad
Durante el diseño se definieron decisiones clave para la arquitectura de la solución:
* **Control de Acceso Basado en Roles (RBAC):** La decisión de limitar el acceso a clientes únicamente a una pantalla pública de rastreo protege la integridad del panel administrativo, evitando registros innecesarios y garantizando la confidencialidad de la información.
* **Integridad de Datos y Borrado Lógico (*Soft Delete*):** En un entorno de distribución, eliminar registros de raíz genera inconsistencias contables y operativas. Incluir soporte para borrado lógico en la entidad de pedidos garantiza auditoría y la posibilidad de restaurar registros cancelados por error.
* **Manejo Eficiente de Multimedia:** Guardar las evidencias de entrega en el almacenamiento del servidor y registrar únicamente la ruta relativa en MySQL asegura un rendimiento óptimo de la base de datos sin sobrecargar las consultas.

---

## 3. Conclusión
Afrontar este proyecto de manera individual me exigió asumir los roles de analista, arquitecto de software y desarrollador. Adoptar una metodología ágil adaptada por sprints me brinda una guía clara para construir la aplicación de forma ordenada, asegurando que cada componente cumpla con las necesidades reales del negocio.