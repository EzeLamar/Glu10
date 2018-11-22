<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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
    !empty($data->cs) &&
    !empty($data->h) &&
    !empty($data->a) &&
    !empty($data->p)
){

    //se setean los atributos
    $product->id = $data->id;

    $IDR=$data->IDR;
    $cs=$data->cs;
    $h=$data->h;
    $p=$data->p;
    $a=$data->a;

    // se crea el restaurant
    if($product->calificar($IDR,$cs,$a,$p,$h)){


        // setear el codigo de respuesta - 201 created
        http_response_code(201);

        // aviso al usuario
        echo json_encode(array("message" => "se califico exitosamente."));

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
    echo json_encode(array("message" => "datos insuficientes."));
}
?>
