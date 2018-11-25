<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, Accept");

// se incluye la base de datos
include_once '../config/database.php';

// se incluyen los objetos
include_once '../objects/usuario.php';

//constructor de la base de datos y obtencion de la conexion
$database = new Database();
$db = $database->getConnection();

//se crea el objeto del tipo restaurant
$product = new Usuario($db);

// obtener datos ingresados
$data = json_decode(file_get_contents("php://input"));

// asegurarse que los campos no esten vacios
if(
    !empty($data->email)

){

    //se setean los atributos
    $product->email = $data->email;

    // se crea el restaurant
    $rta= $product->verificarAdmin();

      if($product->email!=null){
          // create array
          $product_arr = array(
              "respuesta" =>  $rta

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
          echo json_encode(array("message" => "."));
      }
    }
?>
