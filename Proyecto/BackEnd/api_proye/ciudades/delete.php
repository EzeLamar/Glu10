<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// se incluye la base de datos y los objetos necesarios
include_once '../config/database.php';
include_once '../objects/ciudades.php';

// se obtiene la conexion con la base de datos
$database = new Database();
$db = $database->getConnection();

// se crea el objeto tipo restaurant
$product = new Ciudad($db);

// se obtiene el id del restaurant a eliminar
$data = json_decode(file_get_contents("php://input"));

// se setea el id a eliminar
$product->cp = $data->cp;

// se borra el producto de ser posible
if($product->delete()){

    // codigo de respuesta - 200 ok
    http_response_code(200);

    // aviso al usuario
    echo json_encode(array("message" => "la ciudad fue borrada con exito."));
}

// si no es posible
else{

    // codigo de respuesta - 503 service unavailable
    http_response_code(503);

    // aviso al usuario
    echo json_encode(array("message" => "ciudad inexistente."));
}
?>
