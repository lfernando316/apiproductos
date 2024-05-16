<?php

require_once 'config/config.php';

// Conexión a la base de datos sin seleccionar base de datos especifica
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS);


// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consultam SQL para crear la base de datos si no existe
$sql_create_db = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;

// Ejecutamos la consulta SQL para crear la base de datos
if ($conn->query($sql_create_db) === TRUE) {
    echo "Base de datos creada exitosamente ";
} else {
    echo "Error al crear la base de datos: " . $conn->error . "<br>";
}

// Cerrar conexión
$conn->close();

// Conexión a la base de datos ahora con la base de datos especifica
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta SQL para verificar si la tabla categories ya existe
$sql_check = "SHOW TABLES LIKE 'categories'";

// Ejecutar la consulta SQL
$result = $conn->query($sql_check);

// Verificar si la tabla existe
if ($result->num_rows == 0) {
    // si a tabla no existe, la creamos
    $sql_create = "CREATE TABLE categories (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL
    )";

    // Ejecutar la consulta SQL para crear la tabla
    if ($conn->query($sql_create) === TRUE) {
        echo "Tabla categories creada exitosamente";

        // Consultas SQL para insertar los primeros registros en la tabla categories
        $sql_insert_categories = "INSERT INTO categories (name,created_at, updated_at) VALUES 
        ('Aseo', NOW(), NOW()),
        ('Electrodomésticos', NOW(), NOW()),
        ('Herramientas', NOW(), NOW())";

        // Ejecutar las consultas SQL para insertar los registros
        if ($conn->query($sql_insert_categories) === TRUE) {
            echo "Registros insertados exitosamente en la tabla categories";
        } else {
            echo "Error al insertar registros en la tabla categories: " . $conn->error;
        }

    } else {
        echo "Error al crear la tabla: " . $conn->error;
    }
} else {
    echo "La tabla categories ya existe, no es necesario crearla.";
}

// crear products
// Consulta SQL para verificar si la tabla products ya existe
$sql_check_products = "SHOW TABLES LIKE 'products'";

// Ejecutar la consulta SQL para verificar si la tabla products ya existe
$result_products = $conn->query($sql_check_products);

// Verificar si la tabla products existe
if ($result_products->num_rows == 0) {
    // La tabla products no existe, entonces la creamos
    $sql_create_products = "CREATE TABLE products (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        code VARCHAR(255) UNIQUE NOT NULL,
        name VARCHAR(255) NOT NULL,
        category_id INT(11) NOT NULL,
        price FLOAT NOT NULL,
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL,
        FOREIGN KEY (category_id) REFERENCES categories(id)
    )";

    // Ejecutar la consulta SQL para crear la tabla products
    if ($conn->query($sql_create_products) === TRUE) {
        echo "Tabla products creada exitosamente<br>";
    } else {
        echo "Error al crear la tabla products: " . $conn->error . "<br>";
    }
} else {
    echo "La tabla products ya existe, no es necesario crearla.<br>";
}

// Cerrar conexión
$conn->close();

