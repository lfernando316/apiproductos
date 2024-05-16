# API de Gestión de Productos

Este proyecto consiste en una API para gestionar productos. A continuación se detallan los pasos para configurar y utilizar la API:

## Clonar Repositorio del Frontend

Primero, clone el repositorio del frontend desde el siguiente enlace:

[Repositorio Frontend](https://github.com/lfernando316/frontendApiProductos)

## Clonar Repositorio del Backend

Una vez clonado el repositorio del frontend, clone este repositorio del backend en una carpeta separada llamada apiproductos:

git clone https://github.com/lfernando316/apiproductos

# Configuración de la Base de Datos
Asegúrese de tener configurado el servidor de base de datos MySQL. Luego, vaya a la carpeta config y abra el archivo config.php. Asegúrese de configurar los datos de conexión a la base de datos como se muestra a continuación:

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'admin');
// Deje el nombre de la base de datos como está en el archivo

# Crear las Tablas de la Base de Datos
Una vez configurada la conexión a la base de datos, desde la raíz del proyecto, ejecute el siguiente comando para crear las tablas necesarias en la base de datos:
php migrations\create_tables.php

#Enlistar Rutas y Métodos de la API
La API proporciona las siguientes rutas y métodos para gestionar los productos:

GET: http://localhost/apiproductos/routes/routes.php?route=list_products - Lista todos los productos.
POST: http://localhost/apiproductos/routes/routes.php?route=create_product - Crea un nuevo producto. Se espera un body JSON con la siguiente información:
{
  "code": "1253",
  "name": "producto 2",
  "category_id": 1,
  "price": 100
}

PATCH: http://localhost/apiproductos/routes/routes.php?route=update_product/$id - Actualiza un producto existente. Se espera un body JSON similar al anterior.

DELETE: http://localhost/apiproductos/routes/routes.php?route=delete_product/$id - Elimina un producto existente.
La API valida si el código del producto ya existe en la base de datos debido a su unicidad.

¡Listo! Ahora puedes utilizar la API para gestionar tus productos.
