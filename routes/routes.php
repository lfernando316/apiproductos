<?php
require_once '../controllers/controllersProducts/listProduct.php';
require_once '../controllers/controllersProducts/createProduct.php';
require_once '../controllers/controllersProducts/updateProduct.php';
require_once '../controllers/controllersProducts/deleteProduct.php';

// establecer los cors
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

function routeRequest()
{
    $route = isset($_GET['route']) ? $_GET['route'] : '';
    $method = $_SERVER['REQUEST_METHOD'];

    // cuerpo de la solicitud
    $jsonData = file_get_contents('php://input');
    $requestData = json_decode($jsonData, true); // Decodificar el JSON en un array asociativo

    switch ($route) {
        case 'list_products':
            if ($method === 'GET') {
                $controller = new ListProductsController();
                $controller->index();
            } else {
                http_response_code(405); // Método no permitido
                echo json_encode(['error' => 'Method not allowed']);
            }
            break;
        case 'create_product':
            if ($method === 'POST') {
                $controller = new CreateProductController();
                $controller->create($requestData); // Pasar los datos del JSON al controlador
            } else {
                http_response_code(405); // Método no permitido
                echo json_encode(['error' => 'Method not allowed']);
            }
            break;
        case strpos($route, 'update_product/') === 0:
            $parts = explode('/', $route);
            $productId = isset($parts[1]) ? $parts[1] : null;
            if ($method === 'PATCH') {
                $controller = new UpdateProductController();
                $controller->update($productId, $requestData); // Pasar los datos del JSON al controlador
            } else {
                http_response_code(405); // Método no permitido
                echo json_encode(['error' => 'Method not allowed']);
            }
            break;
        case strpos($route, 'delete_product/') === 0:
            $parts = explode('/', $route);
            $productId = isset($parts[1]) ? $parts[1] : null;

            if ($method === 'DELETE') {
                $controller = new DeleteProductController();
                $controller->delete($productId);
            } else {
                http_response_code(405); // Método no permitido
                echo json_encode(['error' => 'Method not allowed']);
            }
            break;
        default:
            http_response_code(404);
            echo json_encode(['error' => 'Route not found']);
            break;
    }
}

routeRequest();

