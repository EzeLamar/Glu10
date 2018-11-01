<?php
class Restaurant{

    // variable de conexion con la base de datos y nombre de la tabla
    private $conn;
    private $table_name = "restaurant";

    // atributos
    public $id;
    public $nombre;
    public $longitud;
    public $latitud;
    public $tieneMenuCel;
    public $calificacion;
    public $descripcion;

    // constructor, se le pasa un objeto de tipo database
    public function __construct($db){
        $this->conn = $db;
    }

      // leer restaurants
    function read(){

        //consulta a la base de datos: seleccionar todos los restaurantes
        $query = "SELECT
                    r.IDR, r.nombre, r.longitud, r.latitud, r.descripcion, r.tieneMenuCel, r.calificacion
                FROM
                    " . $this->table_name . " r";

        // preparar la consulta
        $stmt = $this->conn->prepare($query);

        // ejecutar la consulta
        $stmt->execute();

        return $stmt;
    }

    // insertar un restaurant
    function create(){

        // consulta a la base de datos para insertar un registro
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    nombre=:nombre, longitud=:longitud, latitud=:latitud, tieneMenuCel=:tieneMenuCel, calificacion=:calificacion, descripcion=:descripcion";

        // preparar la consulta
        $stmt = $this->conn->prepare($query);

        // se pasan los atributos a formato html
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->longitud=htmlspecialchars(strip_tags($this->longitud));
        $this->latitud=htmlspecialchars(strip_tags($this->latitud));
        $this->tieneMenuCel=htmlspecialchars(strip_tags($this->tineMenuCel));
        $this->calificacion=htmlspecialchars(strip_tags($this->calificacion));
        $this->descripcion=htmlspecialchars(strip_tags($this->descripcion));

        // se ligan los valores de parametros
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":longitud", $this->longitud);
        $stmt->bindParam(":latitud", $this->latitud);
        $stmt->bindParam(":tieneMenuCel", $this->tieneMenuCel);
        $stmt->bindParam(":calificacion", $this->calificacion);
        $stmt->bindParam(":descripcion", $this->descripcion);

        // ejecutar la consulta: puede fallar o ser exitosa
        if($stmt->execute()){
            return true;
        }

        return false;

    }
    //funcion de borrado
    function delete(){

        // consulta de eliminacion
        $query = "DELETE FROM " . $this->table_name . " WHERE IDR = ?";

        // preparar la consulta
        $stmt = $this->conn->prepare($query);

        // se pasan los valores a formato html
        $this->id=htmlspecialchars(strip_tags($this->id));

        // se enlaza el parametro de id
        $stmt->bindParam(1, $this->id);

        // ejecutar la consulta
        if($stmt->execute()){
            return true;
        }

        return false;

    }

    //consultar por un solo restaurante
    function readOne(){

        //conuslta de solo un registro
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " r
                WHERE
                    r.IDR = ?";

        // preparar consulta
        $stmt = $this->conn->prepare( $query );

        // enlazar el id como parametro
        $stmt->bindParam(1, $this->id);

        // ejecutar consulta
        $stmt->execute();

        // obtener la fila
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // setear valores a los atributos
        $this->nombre = $row['nombre'];
        $this->latitud = $row['latitud'];
        $this->longitud = $row['longitud'];
        $this->descripcion = $row['descripcion'];
        $this->tieneMenuCel = $row['tieneMenuCel'];
        $this->calificacion = $row['calificacion'];
        $this->id = $row['id'];
    }

    // busca productos que empiecen con
    function search($keywords){

        // consulta de seleccion
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " r
                WHERE
                    r.nombre LIKE ? OR r.descripcion LIKE ? OR r.tieneMenuCel LIKE ?";

        // preparar la consulta
        $stmt = $this->conn->prepare($query);

        // convertir los datos a html y agregar los simbolos para la operacion like
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        // enlazar los parametros
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);

        // ejecutar la consulta
        $stmt->execute();

        return $stmt;
    }

    // actualizar los datos del restaurant
    function update(){

        // consulta de actualizacion
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    nombre = :nombre,
                    latitud = :latitud,
                    longitud = :longitud,
                    descripcion = :descripcion,
                    calificacion = :calificacion,
                    tieneMenuCel = :tieneMenuCel
                WHERE
                    IDR = :id";

        // preparar la consulta
        $stmt = $this->conn->prepare($query);

        // pasar a formato html
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->latitud=htmlspecialchars(strip_tags($this->latitud));
        $this->longitud=htmlspecialchars(strip_tags($this->longitud));
        $this->tieneMenuCel=htmlspecialchars(strip_tags($this->tieneMenuCel));
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->calificacion=htmlspecialchars(strip_tags($this->calificacion));
        $this->descripcion=htmlspecialchars(strip_tags($this->descripcion));

        // se enlazan los nuevos valores
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":longitud", $this->longitud);
        $stmt->bindParam(":latitud", $this->latitud);
        $stmt->bindParam(":tieneMenuCel", $this->tieneMenuCel);
        $stmt->bindParam(":calificacion", $this->calificacion);
        $stmt->bindParam(":descripcion", $this->descripcion);


        // ejecutar la consulta
        if($stmt->execute()){
            return true;
        }

        return false;
    }

}
