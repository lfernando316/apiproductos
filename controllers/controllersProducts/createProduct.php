<?php

require_once '../models/Product.php';

class CreateProductController
{
    public function __construct()
    {
    }

    public function create($data)
    {
        $newCode = $data['code'];
        $existingProduct = Product::getByCode($newCode);

        if ($existingProduct) {
            // validamos que el codigo no exista en la base de datos
            http_response_code(400); // Bad Request
            echo json_encode(array("error" => "El código del producto ya está en uso."));
            return;
        }

        // Creamos un nuevo producto con los datos proporcionados
        $result = Product::create($data);

        if ($result) {
            http_response_code(201);
            echo json_encode(array("message" => "Producto creado correctamente."));
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "No se pudo crear el producto."));
        }
    }
}

