<?php
// required header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// se inluye la base de datos y los objetos necesarios
include_once '../config/database.php';
include_once '../objects/restaurant.php';

// inicializacion de la base de datos
$database = new Database();
$db = $database->getConnection();

// inicializacion del objeto restaurant
$restaurant = new Restaurant($db);

//se obtiene el cp pasado por json
$data = json_decode(file_get_contents("php://input"));


// consulta a restaurant
$stmt = $restaurant->read();
$num = $stmt->rowCount();

// si se hallo alguna fila (numero filas >0)
if($num>0){

    // arreglo de restaurant
    $restaurant_arr=array();
    //en esta componente se almacena la informacion
    $restaurant_arr["records"]=array();

    // obtener los contenidos de las tablas
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extraer fila

        extract($row);
        // esto asigna fila['nombre'] a la variable $nombre, igual con el resto de campos
        $restaurant_item=array(
            "id" => $IDR,
            "nombre" => $nombre,
            "descripcion" => html_entity_decode($descripcion),
            "calificacion" => $calificacion,
            "tieneMenuCel" => $tieneMenuCel,
            "longitud" => $longitud,
            "latitud"=> $latitud,
            "imagen"=> html_entity_decode($imagen)

        );

        array_push($restaurant_arr["records"], $restaurant_item);
    }

    // codigo de respuesta correcta - 200 OK
    http_response_code(200);

    // muestra los datos del restaurant en formato json
    echo json_encode($restaurant_arr);
}

else{

    // codigo de respuesta no encontrada - 404 Not found
    http_response_code(404);

    // se le dice al cliente uqe no se encontraron entradas
    echo json_encode(
        array("message" => "No se encontraron restaurantes.")
    );
}
?>
