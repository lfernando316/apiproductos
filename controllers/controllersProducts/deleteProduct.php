<?php

require_once '../models/Product.php';

class DeleteProductController
{
    public function __construct()
    {
    }

    public function delete($id)
    {
        // Eliminamos el producto con el ID proporcionado
        $result = Product::delete($id);

        if ($result) {
            http_response_code(200);
            echo json_encode(array("message" => "Producto eliminado correctamente."));
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Producto no encontrado."));
        }
    }
}

