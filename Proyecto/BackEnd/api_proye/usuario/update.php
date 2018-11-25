<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/usuario.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare product object
$product = new Usuario($db);

// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));

//contador de cantidad de parametros
$cont=0;

// set ID property of product to be edited
if($data->id!=NULL)
$product->id = $data->id;

// set product property values
if($data->nombre!=NULL){
  $product->nombre = $data->nombre;
  $cont++;
}
if($data->apellido!=NULL){
$product->apellido = $data->apellido;
$cont++;
}
if($data->edad!=NULL){
$product->edad = $data->edad;
$cont++;
}
if($data->email!=NULL){
$product->email = $data->email;
$cont++;
}
if($data->password!=NULL){
$product->password = $data->password;
$cont++;
}
if($data->nroTel!=NULL){
$product->nroTel = $data->nroTel;
$cont++;
}
if($data->esCel!=NULL){
$product->esCel = $data->esCel;
$cont++;
}
if($data->IDGoogle!=NULL){
$product->IDGoogle = $data->IDGoogle;
$cont++;
}
// update the product
if($product->update($cont)){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "los datos del usuario fueron actualizados."));
}

// if unable to update the product, tell the user
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "no se puede actualizar este elemento."));
}
?>
