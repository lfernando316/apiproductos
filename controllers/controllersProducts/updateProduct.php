<?php

require_once '../models/Product.php';

class UpdateProductController
{
    public function __construct()
    {
    }

    public function update($id, $data)
    {
        // Verificamos si el nuevo código ya existe en la base de datos
        $newCode = $data['code'];
        $existingProduct = Product::getByCode($newCode);

        if ($existingProduct && $existingProduct->id != $id) {
            // El código ya existe y pertenece a otro producto
            http_response_code(400);
            echo json_encode(array("error" => "El código del producto ya está en uso."));
            return;
        }
        // Actualizamos el producto con el ID proporcionado y los datos nuevos
        $result = Product::update($id, $data);

        if ($result) {
            http_response_code(200);
            echo json_encode(array("message" => "Producto actualizado correctamente."));
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "No se pudo actualizar el producto."));
        }
    }
}

