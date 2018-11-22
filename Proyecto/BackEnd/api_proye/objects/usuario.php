<?php
class Usuario{

    // variable de conexion con la base de datos y nombre de la tabla
    private $conn;
    private $table_name = "usuario";

    // atributos IDU, Nombre, Apellido, Edad, Email, Passwd, NroTelefono, esCeliaco
    public $id;
    public $nombre;
    public $apellido;
    public $edad;
    public $email;
    public $password;
    public $nroTel;
    public $esCel;
    public $IDGoogle;

    // constructor, se le pasa un objeto de tipo database
    public function __construct($db){
        $this->conn = $db;
    }

      // leer usuarios
    function read(){

        //consulta a la base de datos: seleccionar todos los usuarios
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " u";

        // preparar la consulta
        $stmt = $this->conn->prepare($query);

        // ejecutar la consulta
        $stmt->execute();

        return $stmt;
    }

    // insertar un usuario nuevo
    function create($cp,$id){

        // consulta a la base de datos para insertar un registro
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    IDU =:id, nombre =:nombre, apellido =:apellido, edad =:edad, email =:email, password =:password, nroTel =:nroTel, esCel =:esCel, IDGoogle=:IDGoogle";

        // consulta a la base de datos para insertar un registro
        $query2 = "INSERT INTO
                      viveen
                SET
                   CP =:cp, IDU =:id ";


        // preparar la consulta
        $stmt = $this->conn->prepare($query);

        // preparar la consulta
        $stmt2= $this->conn->prepare($query2);

        // se pasan los atributos a formato html
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->apellido=htmlspecialchars(strip_tags($this->apellido));
        $this->edad=htmlspecialchars(strip_tags($this->edad));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->nroTel=htmlspecialchars(strip_tags($this->nroTel));
        $this->esCel=htmlspecialchars(strip_tags($this->esCel));
        $this->IDGoogle=htmlspecialchars(strip_tags($this->IDGoogle));
        // se pasan los atributos a formato html
        $cp=htmlspecialchars(strip_tags($cp));
        $this->id=htmlspecialchars(strip_tags($id));

        // se ligan los valores de parametros
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":edad", $this->edad);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":nroTel", $this->nroTel);
        $stmt->bindParam(":esCel", $this->esCel);
        $stmt->bindParam(":IDGoogle", $this->IDGoogle);

        // se ligan los valores de parametros
        $stmt2->bindParam(":cp", $cp);
        $stmt2->bindParam(":id", $id);

        // ejecutar la consulta: puede fallar o ser exitosa
      if($stmt->execute() && $stmt2->execute()){
            return true;
        }

        return false;

    }


    //funcion de borrado
    function delete(){

        // consulta de eliminacion
        $query = "DELETE FROM " . $this->table_name . " WHERE IDU = ?";

        $query2 ="DELETE FROM viveen WHERE IDU = ?";

        $query3 ="DELETE FROM califico WHERE IDU = ?";
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

    //consultar por un solo usuario
    function readOne(){

        //conuslta de solo un registro
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " u
                WHERE
                    u.IDU = ?";

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
        $this->apellido = $row['apellido'];
        $this->edad = $row['edad'];
        $this->email = $row['email'];
        $this->password = $row['password'];
        $this->nroTel = $row['nroTel'];
        $this->esCel = $row['esCel'];
        $this->id = $row['id'];
    }

    // busca productos que empiecen con
    function search($keywords){

        // consulta de seleccion
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " u
                WHERE
                    u.nombre LIKE ? OR u.apellido LIKE ? OR u.email LIKE ?";

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
      //almacena los parametros que seran pasados a la consulta
        $stringConsulta = " ";

        if($this->nombre!=NULL){
           $stringConsulta = $stringConsulta . " nombre=:nombre";
           if($cont>1){
             $cont--;
             $stringConsulta = $stringConsulta . ",";
           }
         }
         if($this->apellido!=NULL){
            $stringConsulta = $stringConsulta . " apellido=:apellido";
            if($cont>1){
              $cont--;
              $stringConsulta = $stringConsulta . ",";
            }
          }
          if($this->edad!=NULL){
             $stringConsulta = $stringConsulta . " edad=:edad";
             if($cont>1){
               $cont--;
               $stringConsulta = $stringConsulta . ",";
             }
           }
           if($this->email!=NULL){
              $stringConsulta = $stringConsulta . " email=:email";
              if($cont>1){
                $cont--;
                $stringConsulta = $stringConsulta . ",";
              }
            }
            if($this->nroTel!=NULL){
               $stringConsulta = $stringConsulta . " nroTel=:nroTel";
               if($cont>1){
                 $cont--;
                 $stringConsulta = $stringConsulta . ",";
               }
             }
             if($this->password!=NULL){
                $stringConsulta = $stringConsulta . " password=:password";
                if($cont>1){
                  $cont--;
                  $stringConsulta = $stringConsulta . ",";
                }
              }
              if($this->esCel!=NULL){
                 $stringConsulta = $stringConsulta . " esCel=:esCel";
                 if($cont>1){
                   $cont--;
                   $stringConsulta = $stringConsulta . ",";
                 }
               }
               if($this->IDGoogle!=NULL){
                  $stringConsulta = $stringConsulta . " IDGoogle=:IDGoogle";
                  if($cont>1){
                    $cont--;
                  }
                }
        // consulta de actualizacion
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    "  . $stringConsulta . "
                WHERE
                    IDU = :id";

        // preparar la consulta
        $stmt = $this->conn->prepare($query);

        // pasar a formato html y se enlazan los nuevos valores
        if($this->nombre!=NULL){
          $this->nombre=htmlspecialchars(strip_tags($this->nombre));
          $stmt->bindParam(":nombre", $this->nombre);
        }
        if($this->apellido!=NULL){
          $this->apellido=htmlspecialchars(strip_tags($this->apellido));
          $stmt->bindParam(":apellido", $this->apellido);
        }
        if($this->edad!=NULL){
          $this->edad=htmlspecialchars(strip_tags($this->edad));
          $stmt->bindParam(":edad", $this->edad);
        }
        if($this->email!=NULL){
          $this->email=htmlspecialchars(strip_tags($this->email));
          $stmt->bindParam(":email", $this->email);
        }

        $this->id=htmlspecialchars(strip_tags($this->id));

        if($this->nroTel!=NULL){
          $this->nroTel=htmlspecialchars(strip_tags($this->nroTel));
          $stmt->bindParam(":nroTel", $this->nroTel);
        }
        if($this->password!=NULL){
          $this->password=htmlspecialchars(strip_tags($this->password));
          $stmt->bindParam(":password", $this->password);
        }
        if($this->esCel!=NULL){
          $this->esCel=htmlspecialchars(strip_tags($this->esCel));
          $stmt->bindParam(":esCel", $this->esCel);
        }
        if($this->IDGoogle!=NULL){
          $this->IDGoogle=htmlspecialchars(strip_tags($this->IDGoogle));
          $stmt->bindParam(":IDGoogle", $this->IDGoogle);
        }

        $stmt->bindParam(":id", $this->id);


        // ejecutar la consulta
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    function calificar($IDR,$cs,$a,$p,$h){

      $query = "INSERT INTO
                  califico
              SET
                  IDU =:id,IDR=:IDR,calidadServicio=:cs,atencion=:a,higiene=:h,precio=:p";

      // preparar la consulta
      $stmt = $this->conn->prepare($query);

      // pasar a formato html
      $this->id=htmlspecialchars(strip_tags($this->id));
      $IDR=htmlspecialchars(strip_tags($IDR));
      $cs=htmlspecialchars(strip_tags($cs));
      $a=htmlspecialchars(strip_tags($a));
      $p=htmlspecialchars(strip_tags($p));
      $h=htmlspecialchars(strip_tags($h));

      // se enlazan los nuevos valores
      $stmt->bindParam(":id", $this->id);
      $stmt->bindParam(":IDR", $IDR);
      $stmt->bindParam(":cs", $cs);
      $stmt->bindParam(":a", $a);
      $stmt->bindParam(":p", $p);
      $stmt->bindParam(":h", $h);

      // ejecutar la consulta
      if($stmt->execute()){

        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // prepare product object
        $restaurant = new Restaurant($db);
        $restaurant->actualizarCalif($IDR);
        $restaurant->actualizarPuesto($IDR);

          return true;
      }

      return false;
    }
}
