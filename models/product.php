<?php
require_once '../config/db.php';
class Product
{
    public $id;
    public $code;
    public $name;
    public $category_id;
    public $price;
    public $createdAt;
    public $updatedAt;

    public function __construct($code, $name, $category, $price)
    {
        $this->code = $code;
        $this->name = $name;
        $this->category_id = $category;
        $this->price = $price;
        $this->createdAt = date('Y-m-d H:i:s');
        $this->updatedAt = date('Y-m-d H:i:s');
    }
    public static function create($data)
    {
        $db = new Database();
        $conn = $db->getConnection();
        // Obtenemos los datos del array $data
        $code = $data['code'];
        $name = $data['name'];
        $category = $data['category_id'];
        $price = $data['price'];

        // Creamos la consulta SQL para insertar un nuevo producto
        $query = "INSERT INTO products (code, name, category_id, price, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        // Asignar valores a los parámetros y ejecutar consulta
        $stmt->bind_param("ssssss", $code, $name, $category, $price, $createdAt, $updatedAt);
        $createdAt = date('Y-m-d H:i:s');
        $updatedAt = date('Y-m-d H:i:s');
        $stmt->execute();

        // Verificar si se insertó correctamente 
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    public static function getAll()
    {
        $db = new Database();
        $conn = $db->getConnection();

        if ($conn) {
            $query = "SELECT * FROM products";
            $result = $conn->query($query);

            if ($result) {
                $products = [];

                while ($row = $result->fetch_assoc()) {
                    $product = new Product($row['code'], $row['name'], $row['category_id'], $row['price']);
                    $product->id = $row['id'];
                    $product->createdAt = $row['created_at'];
                    $product->updatedAt = $row['updated_at'];
                    $products[] = $product;
                }

                return $products;
            } else {
                // si falla
                return [];
            }
        } else {
            // si falla para no enviar error servidor
            return [];
        }
    }
    public static function update($id, $data)
    {

        $db = new Database();
        $conn = $db->getConnection();

        // Obtener los datos del array $data
        $code = $data['code'];
        $name = $data['name'];
        $category = $data['category_id'];
        $price = $data['price'];

        // actualizar el producto
        $query = "UPDATE products SET code=?, name=?, category_id=?, price=?, updated_at=? WHERE id=?";
        $stmt = $conn->prepare($query);

        // Asignar valores a los parámetros y ejecutar la consulta
        $stmt->bind_param("sssssi", $code, $name, $category, $price, $updatedAt, $id);
        $updatedAt = date('Y-m-d H:i:s');
        $stmt->execute();

        // Verificar si se actualizo
        return $stmt->affected_rows > 0;
    }

    public static function delete($id)
    {
        $db = new Database();
        $conn = $db->getConnection();

        // consulta SQL para eliminar el producto
        $query = "DELETE FROM products WHERE id=?";
        $stmt = $conn->prepare($query);

        // Asignar valor al parámetro 
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public static function getByCode($code)
    {
        $db = new Database();
        $conn = $db->getConnection();

        // Crear la consulta SQL para obtener el producto por su código
        $query = "SELECT * FROM products WHERE code=?";
        $stmt = $conn->prepare($query);

        // Asignar valor al parámetro y ejecutar la consulta
        $stmt->bind_param("s", $code);
        $stmt->execute();

        // resultado de la consulta
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Crear un objeto Product y devolverlo si se encontró un producto con el código especificado
            $row = $result->fetch_assoc();
            $product = new Product($row['code'], $row['name'], $row['category_id'], $row['price']);
            $product->id = $row['id'];
            $product->createdAt = $row['created_at'];
            $product->updatedAt = $row['updated_at'];
            return $product;
        } else {
            return null;
        }
    }
}
