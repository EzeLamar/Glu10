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
    public $imagen;

    // constructor, se le pasa un objeto de tipo database
    public function __construct($db){
        $this->conn = $db;
    }

      // leer restaurants
    function read(){

        //consulta a la base de datos: seleccionar todos los restaurantes
        $query = "SELECT
                    r.IDR, r.nombre, r.longitud, r.latitud, r.descripcion, r.tieneMenuCel, r.calificacion, r.imagen
                FROM
                    " . $this->table_name . " r NATURAL JOIN estaubicado WHERE CP= ? ";

        // preparar la consulta
        $stmt = $this->conn->prepare($query);

        // se pasa a formato html
        $num=8000;
        $cp=htmlspecialchars(strip_tags($num));

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
                    IDR=:id, nombre=:nombre, longitud=:longitud, latitud=:latitud, tieneMenuCel=:tieneMenuCel, calificacion=:calificacion, descripcion=:descripcion, imagen=:imagen";

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
        $this->imagen=htmlspecialchars(strip_tags($this->imagen));

        $cp=htmlspecialchars(strip_tags($cp));

        // se ligan los valores de parametros
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":longitud", $this->longitud);
        $stmt->bindParam(":latitud", $this->latitud);
        $stmt->bindParam(":tieneMenuCel", $this->tieneMenuCel);
        $stmt->bindParam(":calificacion", $this->calificacion);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":imagen", $this->imagen);

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

        $query3 = "DELETE FROM califico WHERE IDR = ?";
        // preparar la consulta
        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($query2);
        $stmt3 = $this->conn->prepare($query3);
        // se pasan los valores a formato html
        $this->id=htmlspecialchars(strip_tags($this->id));

        // se enlaza el parametro de id
        $stmt->bindParam(1, $this->id);
        $stmt2->bindParam(1, $this->id);
        $stmt3->bindParam(1, $this->id);
        // ejecutar la consulta
        if($stmt2->execute() && $stmt3->execute()){
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
    function update($cont){
      $stringConsulta = " ";

      if($this->nombre!=NULL){
         $stringConsulta = $stringConsulta . " nombre=:nombre";
         if($cont>1){
           $cont--;
           $stringConsulta = $stringConsulta . ",";
         }
       }
      if($this->latitud!=NULL){
         $stringConsulta = $stringConsulta . " latitud=:latitud";
         if($cont>1){
           $cont--;
           $stringConsulta = $stringConsulta . ",";
         }
      }
      if($this->longitud!=NULL){
         $stringConsulta = $stringConsulta . " longitud=:longitud";
         if($cont>1){
           $cont--;
           $stringConsulta = $stringConsulta . ",";
         }
      }
      if($this->tieneMenuCel!=NULL){
         $stringConsulta = $stringConsulta . " tieneMenuCel=:tieneMenuCel";
         if($cont>1){
           $cont--;
           $stringConsulta = $stringConsulta . ",";
         }
      }
      if($this->calificacion!=NULL){
         $stringConsulta = $stringConsulta . " calificacion=:calificacion";
         if($cont>1){
           $cont--;
           $stringConsulta = $stringConsulta . ",";
         }
       }
      if($this->descripcion!=NULL){
         $stringConsulta = $stringConsulta . " descripcion=:descripcion";
         if($cont>1){
           $cont--;
           $stringConsulta = $stringConsulta . ",";
         }
      }
      if($this->imagen!=NULL){
          $stringConsulta = $stringConsulta . " imagen=:imagen";
          if($cont>1){
            $cont--;
          }
      }

        // consulta de actualizacion
        $query = "UPDATE
                    restaurant
                SET
                  "  . $stringConsulta . "
                WHERE
                    IDR =:id";

        // preparar la consulta
        $stmt = $this->conn->prepare($query);

        // pasar a formato html y se enlazan los nuevos valores
        if($this->nombre!=NULL){
          $stmt->bindParam(":nombre", $this->nombre);
          $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        }
        if($this->latitud!=NULL){
        $this->latitud=htmlspecialchars(strip_tags($this->latitud));
        $stmt->bindParam(":latitud", $this->latitud);

      }
        if($this->longitud!=NULL){
          $this->longitud=htmlspecialchars(strip_tags($this->longitud));
          $stmt->bindParam(":longitud", $this->longitud);
      }
        if($this->tieneMenuCel!=NULL){
          $this->tieneMenuCel=htmlspecialchars(strip_tags($this->tieneMenuCel));
          $stmt->bindParam(":tieneMenuCel", $this->tieneMenuCel);
      }

        $this->id=htmlspecialchars(strip_tags($this->id));

        if($this->calificacion!=NULL){
          $this->calificacion=htmlspecialchars(strip_tags($this->calificacion));
          $stmt->bindParam(":calificacion", $this->calificacion);
      }
        if($this->descripcion!=NULL){
          $this->descripcion=htmlspecialchars(strip_tags($this->descripcion));
          $stmt->bindParam(":descripcion", $this->descripcion);
      }
        if($this->imagen!=NULL){
          $this->imagen=htmlspecialchars(strip_tags($this->imagen));
          $stmt->bindParam(":imagen", $this->imagen);
        }








        $stmt->bindParam(":id", $this->id);

        // ejecutar la consulta
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    function actualizarCalif($id){

      $ret= false;
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

    function actualizarPuesto($id){

      //seleccionar el codigo postal del restaurante pasado por parametro
      $query = "SELECT
                  CP
              FROM
                  estaubicado WHERE IDR= ? ";
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
                  "cp" => $CP
              );


          }

          //seleccionar todos los restaurantes de la ciudad ordenados por calificacion descendientemente
          $query2 = "SELECT
                      IDR
                  from
                      estaubicado NATURAL JOIN restaurant
                  WHERE
                      CP =:cp
                  ORDER BY calificacion DESC";

          // preparar la consulta
          $stmt2 = $this->conn->prepare($query2);

          // pasar a formato html

          $cp=htmlspecialchars(strip_tags($restaurant_item["cp"]));

          // se enlazan los nuevos valores
          $stmt2->bindParam(":cp", $cp);


          // ejecutar la consulta
          if($stmt2->execute()){
              //update de los puestos de cada restaurante de la ciudad
              $num = $stmt2->rowCount();
              echo " " . $num;
              // si se hallo alguna fila (numero filas >0)
              if($num>0){

                  $cont=1;
                  // arreglo de restaurant
                  $restaurant_arr=array();
                  //en esta componente se almacena la informacion
                  $restaurant_arr["records"]=array();

                  // obtener los contenidos de las tablas
                  while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
                      // extraer fila

                      extract($row);
                      // esto asigna fila['nombre'] a la variable $nombre, igual con el resto de campos
                      $restaurant_item=array(
                          "id" => $IDR
                      );
                      // consulta de actualizacion
                      $query3 = "UPDATE
                                  estaubicado
                              SET
                                  puesto =:puesto
                              WHERE
                                  IDR =:id";

                      // preparar la consulta
                      $stmt3 = $this->conn->prepare($query3);

                      echo " " . $restaurant_item["id"];
                      // pasar a formato html
                      $aux=$cont;
                      $aux=htmlspecialchars(strip_tags($aux));
                      $auxID=htmlspecialchars(strip_tags($restaurant_item["id"]));

                      // se enlazan los nuevos valores
                      $stmt3->bindParam(":puesto", $aux);
                      $stmt3->bindParam(":id", $auxID);

                      //actualizo valor de contador
                      $cont++;

                      // ejecutar la consulta
                      if($stmt3->execute()){
                          $ret=true;
                      }
                  }
              }
          }
      }
      return $ret;
    }
}
