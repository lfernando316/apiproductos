<?php
require_once '../config/config.php';

// conexion a la base de datos
class Database
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // if (!$this->conn->connect_error) {
        //     echo "conexion exitosa a la base de datos";
        // } else {
        //     die("Connection failed: " . $this->conn->connect_error);
        // }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}

