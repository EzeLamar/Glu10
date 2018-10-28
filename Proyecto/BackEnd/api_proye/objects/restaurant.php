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
    function read($cp){

        //consulta a la base de datos: seleccionar todos los restaurantes
        $query = "SELECT
                    r.IDR, r.nombre, r.longitud, r.latitud, r.descripcion, r.tieneMenuCel, r.calificacion
                FROM
                    " . $this->table_name . " r NATURAL JOIN estaubicado WHERE CP= ? ";

        // preparar la consulta
        $stmt = $this->conn->prepare($query);

        // se pasa a formato html
        $cp=htmlspecialchars(strip_tags($cp));

        //SE VINCULAN LOS PARAMETROS
        $stmt->bindParam(1, $cp);

        // ejecutar la consulta
        $stmt->execute();

        return $stmt;
    }

    // insertar un restaurant
    function create($cp){

        // consulta a la base de datos para insertar un registro
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    IDR=:id, nombre=:nombre, longitud=:longitud, latitud=:latitud, tieneMenuCel=:tieneMenuCel, calificacion=:calificacion, descripcion=:descripcion";

        $query2 = "INSERT INTO
                    estaubicado
                SET
                    IDR=:id, CP =:cp";
        // preparar la consulta
        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($query2);

        // se pasan los atributos a formato html
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->longitud=htmlspecialchars(strip_tags($this->longitud));
        $this->latitud=htmlspecialchars(strip_tags($this->latitud));
        $this->tieneMenuCel=htmlspecialchars(strip_tags($this->tieneMenuCel));
        $this->calificacion=htmlspecialchars(strip_tags($this->calificacion));
        $this->descripcion=htmlspecialchars(strip_tags($this->descripcion));

        $cp=htmlspecialchars(strip_tags($cp));

        // se ligan los valores de parametros
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":longitud", $this->longitud);
        $stmt->bindParam(":latitud", $this->latitud);
        $stmt->bindParam(":tieneMenuCel", $this->tieneMenuCel);
        $stmt->bindParam(":calificacion", $this->calificacion);
        $stmt->bindParam(":descripcion", $this->descripcion);

        $stmt2->bindParam(":id", $this->id);
        $stmt2->bindParam(":cp", $cp);

        // ejecutar la consulta: puede fallar o ser exitosa
        if($stmt->execute() && $stmt2->execute()){
            return true;
        }

        return false;

    }
    //funcion de borrado
    function delete(){

        // consulta de eliminacion
        $query = "DELETE FROM " . $this->table_name . " WHERE IDR = ?";

        $query2 = "DELETE FROM estaubicado WHERE IDR = ?";
        // preparar la consulta
        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($query2);
        // se pasan los valores a formato html
        $this->id=htmlspecialchars(strip_tags($this->id));

        // se enlaza el parametro de id
        $stmt->bindParam(1, $this->id);
        $stmt2->bindParam(1, $this->id);
        // ejecutar la consulta
        if($stmt2->execute()){
          if($stmt->execute())
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
                    restaurant
                SET
                    nombre =:nombre,
                    latitud =:latitud,
                    longitud =:longitud,
                    descripcion =:descripcion,
                    calificacion =:calificacion,
                    tieneMenuCel =:tieneMenuCel
                WHERE
                    IDR =:id";

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
        $stmt->bindParam(":id", $this->id);

        // ejecutar la consulta
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    function actualizarCalif($id){

      echo "  " . $id;
      //regreso a 0 el valor de calificacion
      $this->calificacion=0;
      //consulta a la base de datos: seleccionar todos los restaurantes
      $query = "SELECT
                  IDR, calidadServicio, atencion, precio, higiene
              FROM
                  restaurant NATURAL JOIN califico WHERE IDR= ? ";

      // preparar la consulta
      $stmt = $this->conn->prepare($query);



      //SE VINCULAN LOS PARAMETROS
      $stmt->bindParam(1, $id);

      // ejecutar la consulta
      $stmt->execute();

      $num = $stmt->rowCount();
      echo " " . $num;
      // si se hallo alguna fila (numero filas >0)
      if($num>0){

          $cont=0;
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
                  "calidadServicio" => $calidadServicio,
                  "higiene" => $higiene,
                  "atencion" => $atencion,
                  "precio" => $precio
              );
              //si el id es igual al del restaurant
              if($id==$restaurant_item["id"]){
                  $this->calificacion+=($restaurant_item["calidadServicio"]+$restaurant_item["higiene"]+$restaurant_item["atencion"]+$restaurant_item["precio"])/4;
                  $cont+=1;
              }

          }
          $this->calificacion=$this->calificacion/$cont;

          // consulta de actualizacion
          $query2 = "UPDATE
                      restaurant
                  SET
                      calificacion =:calificacion
                  WHERE
                      IDR =:id";

          // preparar la consulta
          $stmt2 = $this->conn->prepare($query2);

          // pasar a formato html
          $this->calificacion=htmlspecialchars(strip_tags($this->calificacion));
          $id=htmlspecialchars(strip_tags($id));

          // se enlazan los nuevos valores
          $stmt2->bindParam(":calificacion", $this->calificacion);
          $stmt2->bindParam(":id", $id);


          // ejecutar la consulta
          if($stmt2->execute()){
              echo " " . $this->calificacion;
              return true;
          }
      }

      return false;

    }

}
