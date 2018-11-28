<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, Accept");

// se incluye la base de datos
include_once '../config/database.php';

// se incluyen los objetos
include_once '../objects/usuario.php';
// se incluyen los objetos
include_once '../objects/restaurant.php';

//constructor de la base de datos y obtencion de la conexion
$database = new Database();
$db = $database->getConnection();

//se crea el objeto del tipo usuario
$product = new Usuario($db);

// obtener datos ingresados
$data = json_decode(file_get_contents("php://input"));

// asegurarse que los campos no esten vacios
if(
    !empty($data->id) &&
    !empty($data->IDR) &&
    !empty($data->calidad) &&
    !empty($data->velocidad) &&
    !empty($data->limpieza) &&
    !empty($data->precio)
){

    //se setean los atributos
    $product->id = $data->id;

    $IDR=$data->IDR;
    $calidad=$data->calidad;
    $velocidad=$data->velocidad;
    $precio=$data->precio;
    $limpieza=$data->limpieza;

    // se crea el restaurant
    if($product->calificar($IDR,$calidad,$velocidad,$precio,$limpieza)){


        // setear el codigo de respuesta - 201 created
        http_response_code(201);

        // aviso al usuario
        echo json_encode(array("message" => "se pudo calificar"));

    }

    // si no fue posible insertar
    else{

        // codigo de respuesta- 503 service unavailable
        http_response_code(503);

        // aviso al usuario
        echo json_encode(array("message" => "no se pudo calificar"));
    }
}

// si los datos son insuficientes
else{

    // codigo de respuesta- 400 bad request
    http_response_code(400);

    // aviso al usuario
    echo json_encode(array("message" => "datos insuficientes"));
}
?>
