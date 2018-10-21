<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/restaurant.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare product object
$product = new Restaurant($db);

// set ID property of record to read
$product->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of product to be edited
$product->readOne();

if($product->nombre!=null){
    // create array
    $product_arr = array(
        "id" =>  $product->id,
        "nombre" => $product->nombre,
        "latitud" => $product->latitud,
        "longitud" => $product->longitud,
        "descripcion" => $product->descripcion,
        "tieneMenuCel" => $product->tieneMenuCel,
        "calificacion" => $product->calificacion

    );

    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($product_arr);
}

else{
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user product does not exist
    echo json_encode(array("message" => "el restaurante no existe."));
}
?>
