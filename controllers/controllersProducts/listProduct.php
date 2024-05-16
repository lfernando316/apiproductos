<?php

require_once '../models/product.php';

class ListProductsController
{
    public function __construct()
    {
    }

    public function index()
    {
        // Obtenemos los productos desde el modelo
        $products = Product::getAll();

        header('Content-Type: application/json');
        echo json_encode($products);
    }
}
