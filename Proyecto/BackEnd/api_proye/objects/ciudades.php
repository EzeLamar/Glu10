<?php
class Ciudad{

    // variable de conexion con la base de datos y nombre de la tabla
    private $conn;
    private $table_name = "ciudad";

    // atributos
    public $cp;
    public $nombre;
    public $canthabit;
    public $canthabitcel;

    // constructor, se le pasa un objeto de tipo database
    public function __construct($db){
        $this->conn = $db;
    }

      // leer restaurants
    function read(){

        //consulta a la base de datos: seleccionar todos los restaurantes
        $query = "SELECT
                    c.CP, c.nombre, c.poblacion, c.poblacionCel
                FROM
                    " . $this->table_name . " c";

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
                    nombre=:nombre, CP=:cp, poblacion=:canthabit, poblacionCel=:canthabitcel";

        // preparar la consulta
        $stmt = $this->conn->prepare($query);

        // se pasan los atributos a formato html
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->cp=htmlspecialchars(strip_tags($this->cp));
        $this->canthabit=htmlspecialchars(strip_tags($this->canthabit));
        $this->canthabitcel=htmlspecialchars(strip_tags($this->canthabitcel));


        // se ligan los valores de parametros
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":cp", $this->cp);
        $stmt->bindParam(":canthabit", $this->canthabit);
        $stmt->bindParam(":canthabitcel", $this->canthabitcel);

        // ejecutar la consulta: puede fallar o ser exitosa
        if($stmt->execute()){
            return true;
        }

        return false;

    }
    //funcion de borrado
    function delete(){

        // consulta de eliminacion
        $query = "DELETE FROM " . $this->table_name . " WHERE  CP = ?";

        // preparar la consulta
        $stmt = $this->conn->prepare($query);

        // se pasan los valores a formato html
        $this->cp=htmlspecialchars(strip_tags($this->cp));

        // se enlaza el parametro de id
        $stmt->bindParam(1, $this->cp);

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
                    " . $this->table_name . " c
                WHERE
                    c.CP = ?";

        // preparar consulta
        $stmt = $this->conn->prepare( $query );

        // enlazar el id como parametro
        $stmt->bindParam(1, $this->cp);

        // ejecutar consulta
        $stmt->execute();

        // obtener la fila
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // setear valores a los atributos
        $this->nombre = $row['nombre'];
        $this->cp = $row['CP'];
        $this->canthabit = $row['poblacion'];
        $this->canthabitcel = $row['poblacionCel'];

    }

    // busca productos que empiecen con
    function search($keywords){

        // consulta de seleccion
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " r
                WHERE
                    r.nombre LIKE ?";

        // preparar la consulta
        $stmt = $this->conn->prepare($query);

        // convertir los datos a html y agregar los simbolos para la operacion like
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        // enlazar los parametros
        $stmt->bindParam(1, $keywords);

        // ejecutar la consulta
        $stmt->execute();

        return $stmt;
    }

    // actualizar los datos del restaurant
    function update($cont){
      //almacena los parametros que seran pasados a la consulta
        $stringConsulta = " ";

        if($this->nombre!=NULL){
           $stringConsulta = $stringConsulta . " nombre=:nombre";
           if($cont>1){
             $cont--;
             $stringConsulta = $stringConsulta . ",";
           }
         }
         if($this->canthabit!=NULL){
            $stringConsulta = $stringConsulta . " poblacion=:canthabit";
            if($cont>1){
              $cont--;
              $stringConsulta = $stringConsulta . ",";
            }
          }
          if($this->canthabitcel!=NULL){
             $stringConsulta = $stringConsulta . " poblacionCel=:canthabitcel";
             if($cont>1){
               $cont--;
             }
           }
           echo $stringConsulta;
        // consulta de actualizacion
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    " . $stringConsulta . "

                WHERE
                    CP =:cp";

       echo $query;
        // preparar la consulta
        $stmt = $this->conn->prepare($query);

        // pasar a formato html y se enlazan los nuevos valores
        if($this->nombre!=NULL){
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $stmt->bindParam(":nombre", $this->nombre);
        }
        if($this->canthabit!=NULL){
        $this->canthabit=htmlspecialchars(strip_tags($this->canthabit));
        $stmt->bindParam(":canthabit", $this->canthabit);
        }
        if($this->canthabitcel!=NULL){
        $this->canthabitcel=htmlspecialchars(strip_tags($this->canthabitcel));
        $stmt->bindParam(":canthabitcel", $this->canthabitcel);
        }

        $this->cp=htmlspecialchars(strip_tags($this->cp));
        $stmt->bindParam(":cp", $this->cp);





        // ejecutar la consulta
        if($stmt->execute()){
            return true;
        }

        return false;
    }

}
