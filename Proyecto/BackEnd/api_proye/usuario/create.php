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

//constructor de la base de datos y obtencion de la conexion
$database = new Database();
$db = $database->getConnection();

//se crea el objeto del tipo usuario
$product = new Usuario($db);

// obtener datos ingresados
$data = json_decode(file_get_contents("php://input"));

// asegurarse que los campos no esten vacios
if(
    !empty($data->nombre) &&
    !empty($data->apellido) &&
    !empty($data->edad) &&
    !empty($data->email) &&
    !empty($data->password) &&
    !empty($data->nroTel)  &&
    !empty($data->esCel)
){

    //se setean los atributos
    $product->nombre = $data->nombre;
    $product->apellido = $data->apellido;
    $product->edad = $data->edad;
    $product->email = $data->email;
    $product->password = $data->password;
    $product->nroTel=$data->nroTel;
    $product->esCel=$data->esCel;

    // se crea el restaurant
    if($product->create()){

        // setear el codigo de respuesta - 201 created
        http_response_code(201);

        // aviso al usuario
        echo json_encode(array("message" => "el usuario fue creado exitosamente."));
    }

    // si no fue posible insertar
    else{

        // codigo de respuesta- 503 service unavailable
        http_response_code(503);

        // aviso al usuario
        echo json_encode(array("message" => "no se pudo crear el usuario"));
    }
}

// si los datos son insuficientes
else{

    // codigo de respuesta- 400 bad request
    http_response_code(400);

    // aviso al usuario
    echo json_encode(array("message" => "datos insuficientes para crear usuario."));
}
?>
