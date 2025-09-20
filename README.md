# 📌 Proyecto Gestión de Departamentos

Este proyecto implementa un sistema de gestión de departamentos utilizando **Laravel 12**.  
La solución se ha diseñado siguiendo principios de arquitectura en capas, un modelo de base de datos jerárquico y la integración de **Swagger** para documentar los endpoints de la API.

---

## ⚙️ Elección de Arquitectura

Se optó por una **arquitectura en capas**, separando las responsabilidades de la aplicación en distintos bloques funcionales:

- **Controladores (Controllers):** Manejan las solicitudes HTTP y orquestan el flujo hacia los servicios.
- **Servicios (Services):** Contienen la lógica de negocio, permitiendo mantener controladores ligeros.
- **Repositorios (Repositories):** Encapsulan el acceso a datos, interactuando directamente con Eloquent y la base de datos.
- **DTOs (Data Transfer Objects):** Aseguran el transporte de datos entre capas de manera clara y validada.
- **Modelos (Models):** Representan las entidades persistidas en la base de datos.

Este enfoque promueve **mantenibilidad, escalabilidad y testabilidad**, alineándose con buenas prácticas en aplicaciones empresariales.

---

## 🗄️ Modelo de Base de Datos

El modelo principal es la entidad **DEPARTAMENTO**, que implementa un **enfoque de relación jerárquica** mediante una **auto-relación** con la columna `departamento_superior_id`.  

### Tabla `departamento`

| Campo                  | Tipo        | Restricciones                                      | Descripción                                   |
|------------------------|-------------|---------------------------------------------------|-----------------------------------------------|
| `id`                   | int (PK)    | Auto-increment                                    | Identificador único                           |
| `nombre`               | varchar(45) | UK, no nulo                                       | Nombre único del departamento                 |
| `nivel`                | int         | >= 0                                              | Nivel jerárquico                              |
| `cantidad_empleados`   | int         | >= 0                                              | Número de empleados                           |
| `departamento_superior_id` | int (FK) | Nullable, referencia a `departamento.id`          | Relación jerárquica (departamento superior)   |
| `embajador_nombres`    | varchar(100)| Nullable                                          | Nombre del embajador                          |
| `embajador_apellidos`  | varchar(100)| Nullable                                          | Apellidos del embajador                       |
| `created_at`           | timestamp   | Default now                                       | Fecha de creación                             |
| `updated_at`           | timestamp   | Auto-update                                       | Fecha de actualización                        |
| `activo`               | boolean     | Default true                                      | Estado activo/inactivo                        |

### Relación jerárquica

- Un departamento puede tener **0 o 1 departamento superior**.
- Un departamento puede ser **padre de múltiples departamentos**.
- Esto permite modelar estructuras organizacionales en forma de **árbol**.

---

## 📖 Documentación con Swagger

Se integró **Swagger** (OpenAPI) para la documentación de la API, lo que permite:

- Visualizar y probar los endpoints disponibles.
- Consultar ejemplos de request/response.
- Mejorar la comunicación entre backend y frontend.
- Garantizar la trazabilidad de cambios en la API.

La documentación se genera a través de **anotaciones en los controladores**, y se expone en la ruta:

