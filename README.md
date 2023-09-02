# Prueba Técnica

Se valorarán todas las aclaraciones, comentarios y documentación que considere pertinente para facilitar la corrección de la prueba.

## ~~1. Backend PHP (Parte 1)~~

Implementar la representación del acrónimo CRUD (Create, Read, Update y Delete) para la gestión de nuevos empleados vía un formulario, con los siguientes datos:

- Nombres
- Apellidos
- Edad
- Fecha de Ingreso
- Comentarios

El resultado del punto debe guardarse en una carpeta cuyo nombre sea `backend-php-1`.

> **Nota:** La implementación debe contener código PHP nativo. En esta primera parte, la utilización de código HTML y CSS puede ser básica. Todos los campos son obligatarios salvo "Comentarios" que puede quedar vacío en caso de que el operador así lo desee.  

## ~~2. Frontend~~

Implementar para el punto anterior una librerí­a, como puede ser el caso de [Bootstrap](https://getbootstrap.com/) o la que considere más apropiada, a fin de incorporar mejoras en los componentes visuales de la aplicación. La implementación de <u>la librería frontend no debe alterar el funcionamiento original</u> de la aplicación. El resultado del punto debe guardarse en una carpeta cuyo nombre sea `frontend`. 

## 3. Backend PHP (Parte 2)

Implementar en una prueba de concepto una API utilizando un framework de PHP, como puede ser el caso de [Laravel](https://laravel.com/) o el que considere más apropiado, a fin de poder obtener vía método GET el listado de los empleados dados de alta. La API debería consultar la misma base de datos utilizada en Backend PHP (Parte 1). El resultado del punto debe guardarse en una carpeta cuyo nombre sea `backend-php-2`.

> **Nota:** Se valorará la inclusión de los métodos PUT, POST y DELETE.

## 4. Backend Java

Migrar la API del punto anterior a Java utilizado [Spring Boot](https://spring.io/projects/spring-boot) como framework de desarrollo. El resultado del punto debe guardarse en una carpeta cuyo nombre sea `backend-java`.

## 5. Bases de Datos Relaciones

[Sqlime](https://sqlime.org/) es un playground de SQLite que su *demo database* contiene las siguientes tablas:

```sql
CREATE TABLE employees (
id integer primary key,
name text,
city text,
department text,
salary integer
)

CREATE TABLE expenses (
year integer,
month integer,
income integer,
expense integer
)
```

> **Tip:** Puede ejecutar el query `SELECT sql FROM sqlite_schema;` para obtener la información previa.

Se solicita que migre de SQLite a MySQL la estructura previa, conservando los datos ya existentes, e incorporando:

- Una tabla intermedia `departament` que contenga los campos `id` y `name` en su estructura.
- Que las tablas `employees` y `departament` están relacionadas bajo la forma:
    - Un empleado pertenece a un departamento. Un departamento puede contener varios empleados.
- Que las tablas `department` y `expenses` están relacionadas bajo la forma:
    - Un departamento puede tener varios gastos. Un gasto pertenece a un departamento.

Adicionalmente, incluir un script o consulta SQL según corresponda, para los siguientes puntos:

- Creación e inserción de datos para la base de datos migrada.
- Listado de todos los datos de los empleados del departamento "hr".
- Listado de los 3 (tres) departamentos que más gasto producen.
- Listado de todos los datos del empleado con mayor sueldo.
- Cantidad de empleados con sueldo menor o igual a 1000.

El resultado del punto debe guardarse en una carpeta cuyo nombre sea `bbdd`.

> **Importante:** La entrega de la resolución debe realizarse según las indiciones previas al correo electrónico rafael.delaguerra.gomez@hackaboss.com mediante una carpeta compartida ví­a Drive o repositorio de GitHub compartido ambos de forma privada.
